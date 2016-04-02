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

function get_pictures($folder)
{
	$query = mysql_query ("SELECT p_name FROM picture WHERE p_folder='$folder'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result =  mysql_fetch_array($query,MYSQL_ASSOC))
			$pictures[] = stripslashes($result["p_name"]);

	return $pictures;

}

/*
	Receives id of picture
	Returns array with folder and file name 
*/
function get_pic_details($id)
{
	$query = mysql_query ("SELECT p_name, p_folder FROM picture WHERE p_id='$id'");

	if (!$query) {

		error (mysql_error());
		return FALSE;

	}

	if (!$result = mysql_fetch_array($query,MYSQL_ASSOC)) return FALSE;
	else {

		$result['p_name'] = stripslashes($result['p_name']);
		$result['p_folder'] = stripslashes($result['p_folder']);

		return $result;
	
	}

}

function get_pictureid($folder, $name)
{

	$query = mysql_query ("SELECT p_id FROM picture WHERE p_folder=\"$folder\"
				AND p_name=\"$name\"");
	
	if (!$query) {

		error (mysql_error());
		return FALSE;

	} else if (mysql_num_rows($query)) return mysql_result($query,p_id); 

}

function insert_picture($userfile, $folder)
{
	if (!$userfile['size'] > get_config("max file size")) {

		error("File too big!");
		return FALSE;

	}

	$imagename = $userfile['name'];
	$imagepath = get_pic_path($imagename, $folder);

	// Let's not allow insertion of same file twice
	if (file_exists($imagepath)) {

		error("File already exists!");
		return FALSE;

	}

	if (@move_uploaded_file($userfile['tmp_name'], $imagepath)) {

		// Create database entrie
		$query = mysql_query ("INSERT INTO picture (p_name, p_folder)
				     VALUES ('$imagename' , '$folder')");

		if (!$query) { 

			error (mysql_error());
			return FALSE;

		} else return TRUE;

	} else {

		error("Error inserting file!");
		return FALSE;

	}

}

function remove_picture($id)
{
	
	// Check if picture is used in gallery
	$query = mysql_query ("SELECT COUNT(*) FROM image WHERE p_id='$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else if (mysql_result($query,'count(*)')) {

		error("Picture is in use, delete from gallery first!");
		return FALSE;

	}

	// Get folder and file name in array
	$details = get_pic_details($id);	

	$query = mysql_query ("DELETE FROM picture WHERE p_id='$id'");

	if (!$query) {

		error (mysql_error());
		return FALSE;

	}

	if ($details) {

		@unlink(get_pic_path($details[p_name], $details[p_folder]));
		@unlink(get_thumb_path($details[p_name], $details[p_folder]));

	} else return FALSE;

	return TRUE;
}

function create_sized_picture($folder, $file, $width, $height)
{

	$file_path = get_pic_path($file, $folder);
	$sized_path = get_sized_path($file, $folder);

	if (create_thumb($file_path, $sized_path, $width, $height)) return TRUE;
	else return FALSE;

}

function thumb_picture($folder, $file)
{
	$thumb_path = get_thumb_path($file, $folder);
	$file_path = get_pic_path($file, $folder);

	if (!$width = get_config("thumb width")) {

		$width = 50;
		set_config("thumb width", 50);

	}

	if (!$height = get_config("thumb height")) {

		$height = 50;
		set_config("thumb height", 50);

	}	

	if (create_thumb($file_path, $thumb_path, $width, $height)) return TRUE;
	else return FALSE;

}

?>
