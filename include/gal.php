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

// Returns array with list of existing gallery pages
function get_gallery_name_list()
{

	$query = mysql_query ("SELECT g_name FROM gallery");

	if (!$query) {

		error (mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC))
		$gals[] = stripslashes($result["g_name"]);

	return $gals;

}

// Returns gallery id for a given name
function get_gallery_id($name)
{

	$query = mysql_query ("SELECT g_id FROM gallery WHERE g_name = '$name'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query, g_id));

}

// Returns gallery name for a given id
function get_gallery_name($id)
{

	$query = mysql_query ("SELECT g_name FROM gallery WHERE g_id = '$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query, g_name));

}


// Creates an image and inserts it into an existing gallery page
function insert_image($pic_id, $gal_id, $caption, $width, $height, $link_id)
{

	if (!get_magic_quotes_gpc()) $caption = addslashes($caption);	

	$pos = count_table("image") + 1;

	$sql = "INSERT INTO image (g_id, i_pos, p_id, l_id, i_width, i_height, i_caption) 
		VALUES ('$gal_id', '$pos', '$pic_id', '$link_id', '$width', '$height', '$caption')";

	//		  error($sql);
	$query = mysql_query($sql);		  

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

// Removes an image from the database
function remove_image($id)
{

	if (!$id) {

		error("NULL image id!");
		return FALSE;

	}

	$sql = "SELECT p_id FROM image WHERE i_id ='$id'";

	$query = mysql_query($sql);

	if (!$query) {
		
		error(mysql_error());
		return FALSE;

	}

	$picture = get_pic_details(mysql_result($query,p_id));

	$query = mysql_query("DELETE FROM image WHERE i_id='$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else 
	
	@unlink(get_sized_path($picture[p_name], $picture[p_folder]));
	return TRUE;

}

function up_image($id, $gid)
{

	return up_item("image", "g_id='$gid'", "i", $id);

}

function down_image($id, $gid)
{

	return down_item("image", "g_id='$gid'", "i", $id);

}

// Returns an bi-dimensional array with a list of existing images and respective data
function get_images($gal_id, $limit)
{

	if (!$gal_id) {

		error("NULL gallery id");

	}

	$sql = "SELECT i_id, p_name, p_folder, i_width, i_height, i_caption, l_id 
		FROM image, picture WHERE g_id = '$gal_id' AND image.p_id = picture.p_id ORDER BY i_pos";

	if ($limit) $sql .= " LIMIT $limit"; 

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) 
		$images[] = $result;

	return $images;

}

// Return an array with gallery details
function get_gallery_item($id)
{
	if (!$id) {

		error("NULL ID!");
		return FALSE;

	}

	$query = mysql_query("SELECT g_name, g_rows, g_cols, g_text FROM gallery WHERE g_id = '$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return mysql_fetch_array($query, MYSQL_ASSOC);

}


// Returns an bi-dimensional array with a list of existing galleries and respective data
function get_gallery()
{

	$query = mysql_query("SELECT g_id, g_name, g_rows, g_cols, g_text
			FROM gallery");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) 
		$galleries[] = $result;

	return $galleries;

}

// Creates a new gallery 
function insert_gallery_item($name, $rows, $cols, $text)
{

	// Escape user input if needed
	if (!get_magic_quotes_gpc()) {

		$name = addslashes($name);
		$text = addslashes($text);

	}

	$text = nl2br($text);

	$query = mysql_query("INSERT INTO gallery (g_name, g_rows, g_cols, g_text)
			VALUES ('$name', '$rows', '$cols', '$text')");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;
}

// Deletes an existing gallery
function remove_gallery_item($id)
{

	$query = mysql_query("SELECT COUNT(*) FROM image WHERE g_id='$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else if (mysql_result($query,'count(*)')) {

		error("Gallery is in use, delete images first!");
		return TRUE;

	}

	$query = mysql_query("DELETE FROM gallery WHERE g_id='$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

function update_gallery_item($id, $name, $cols, $rows, $text)
{
	// Escape user input if needed
	if (!get_magic_quotes_gpc()) {

		$name = addslashes($name);
		$text = addslashes($text);

	}

	$text = nl2br($text);

	$query = mysql_query("UPDATE gallery SET g_name='$name', g_cols='$cols', g_rows='$rows', g_text='$text'
			WHERE g_id='$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

?>
