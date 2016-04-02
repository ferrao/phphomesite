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

function getdatetime()
{

	// Returns proper formated mysql datetime variable
	return date("Y-m-d H:i:s");

}


function connect_database() {

	global $DBHOST, $DBUSER, $DBPASS, $DBNAME;

	// If database name is defined, let's connect to database
	if (!$DBNAME) {

		error("Database name not defined!");
		exit();

	} else if (@!mysql_connect($DBHOST, $DBUSER, $DBPASS)) {

		error(mysql_error());
		exit();

	}

	// Let's try to use the database
	if (!mysql_select_db($DBNAME)) {

		error(mysql_error());
		exit();

	}

}

function count_table($table)
{

	if (!$table) {

		error("Can not count empty table!");
		return FALSE;

	}

	$query = mysql_query("SELECT COUNT(*) FROM $table");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return mysql_result($query,'COUNT(*)'); 

}

function get_max_pos($table, $prefix)
{

	if ($prefix) $field = $prefix . "_pos";
	else $field = "pos"; 

	$sql = "SELECT MAX($field) FROM $table"; 

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return mysql_result($query, $field); 

}

?>
