<?php 

/*
 * Copyright (c) 2005 Rui Ferrao <ferrao@eixodigital.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 */

function get_config($name) 
{

	// No point on escaping the text if already done 
	if (!get_magic_quotes_gpc()) $name = addslashes ($name);

	$query = mysql_query ("SELECT c_value FROM config WHERE c_name='$name'");

	if (!$query) {
	
		error (mysql_error());
		return FALSE;

	} else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query,c_value));

}

function set_config($name, $value)
{

	// No point on escaping the text if already done 
	if (!get_magic_quotes_gpc()) {

		$name = addslashes($name);
		$value = addslashes($value);

	}

	// Let's check if $name exists
	$query = mysql_query("SELECT c_value FROM config WHERE c_name='$name'");

	if (!$query) error(mysql_error());
	else if (mysql_num_rows($query)) 

		// $name exists, let's update it
		$query = mysql_query("UPDATE config SET c_value='$value' WHERE c_name='$name'");	
	else 

		// $name does not exist, let's create it
		$query = mysql_query("INSERT INTO config VALUES ('$name', '$value')");

	// So that we can still use this in assignments of type $var = set_config
	return $value;

}

function check_config()
{

	global $HOME, $URL;

	if (!$HOME) {

		error("Base path not defined!");
		exit();

	}

	if (!$URL) {

		error("Base path not defined!");
		exit();

	}

	if (!get_config ("version")) {

		error("Could not find software version!");
		exit();

	}

	if (!checkgd()) {

		error("GD2 does not seam to be instaled!");
		exit();

	}

}

?>
