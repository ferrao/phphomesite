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

function remove_br($text)
{

	return ereg_replace("(<br>|<br />)","",$text);

}

function get_html_path($name)
{

	global $HOME, $UPLOAD, $HTML;

	return $HOME . "/" . $UPLOAD . "/" . $HTML . "/" . $name;

}

function delete_html($name)
{

	if (!@unlink(get_html_path($name))) {

		error("Could not delete file");
		return FALSE;

	} else {

		$query = mysql_query("DELETE FROM html WHERE h_file='$name'");

		if (!$query) {

			error(mysql_error());
			return FALSE;

		} else return TRUE;

	}

}

function get_html_id($name)
{

	if (!$name) {

		error("Empty file name");
		return FALSE;

	} 

	$query = mysql_query("SELECT h_id FROM html WHERE h_file='$name'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else if (mysql_num_rows($query)) return mysql_result($query,h_id);
	else return FALSE;

}

function get_html_name($id)
{

	if (!$id) {

		error("Empty file id");
		return FALSE;

	} 

	$query = mysql_query("SELECT h_file FROM html WHERE h_id='$id'");

	if (!$query) {

		return FALSE;

	} else if (mysql_num_rows($query)) return mysql_result($query,h_file);
	else return FALSE;

}




function get_html_files()
{
	$query = mysql_query("SELECT h_file FROM html");

	if (!$query) {

		error(mysql_result());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {

		$html[] = $result['h_file'];

	}

	return $html;

}

// Obsolete get_html_files from disk. Read from mysql instead.
/*function get_html_files()
  {

  global $HOME, $UPLOAD, $HTML;

  $path = $HOME . "/" . $UPLOAD . "/" . $HTML;

// Check if html folder exists
if (!$dir = @opendir($path)) {

error("Could not read html path!!");
exit();

}

// Read sub-directories into array
while ($file = readdir($dir)) {

if (!is_dir($path . "/" . $file)) $html[] = $file;

}

return $html;

}*/

function get_html_content($file) {

	global $HOME, $UPLOAD, $HTML;

	$path = $HOME . "/" . $UPLOAD . "/" . $HTML . "/" . $file;
	@$handle = fopen($path, "r");

	if (!$handle) {

		error("Could not open file $file");
		return FALSE;

	}

	@$text = fread($handle, filesize($path));

	if (!$text) {

		error("Could not read from file $file");
		return FALSE;

	}

	fclose($handle);
	return $text;

}

function write_html_content($file, $text) {

	global $HOME, $UPLOAD, $HTML;

	$path = $HOME . "/" . $UPLOAD . "/" . $HTML . "/" . $file;
	@$handle = fopen($path, "w");

	if (!$handle) {

		error("Could not open file $file");
		return FALSE;

	}

	if (!@fwrite($handle,stripslashes($text), strlen($text))) {

		error("Could not write to file $file");
		return FALSE;

	}

	return TRUE;

}

function add_html_file($name)
{

	if (!$name) {

		error("Empty file name!");
		return FALSE;

	}

	$query = mysql_query("INSERT INTO html (h_file) VALUES ('$name')");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

function exists_html_file($name)
{

	if (!$name) return FALSE;

	$query = mysql_query("SELECT h_file FROM html WHERE h_file='$name'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	if (mysql_num_rows($query)) return TRUE; 
	else return FALSE;

}

function render_html($id) 
{

	$file = get_html_name($id);

	return get_html_content($file);

}

?>
