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

define ("BPREFIX", "blog_");

function get_blog_path($name)
{

	global $HOME, $UPLOAD, $BLOG;

	return $HOME . "/" . $UPLOAD . "/" . $BLOG . "/" . $name;

}

function get_blog_url($name)
{

	global $UPLOAD, $BLOG;

	return $UPLOAD . "/" . $BLOG . "/" . $name;

}


function get_bthumb_path($name)
{

	global $HOME, $UPLOAD, $BLOG;

	return $HOME . "/" . $UPLOAD . "/" . $BLOG . "/" . BPREFIX . $name;

}

function get_bthumb_url($name)
{

	global $UPLOAD, $BLOG;

	return $UPLOAD . "/" . $BLOG . "/" . BPREFIX . $name;

}

function resize_blog()
{

	$blog = get_blog("NOLIMIT");

	foreach ($blog as $row) {

		if ($row[b_picture]) {	

			$bimagepath = get_blog_path($row[b_picture]);
			$bthumbpath = get_bthumb_path($row[b_picture]);

			@unlink($bthumbpath);
			create_thumb($bimagepath, $bthumbpath, get_config("blog width"), get_config("blog height"));

		}

	}

}

function get_blog($lim)
{
	$sql = "SELECT b_id, b_date, b_text, b_picture, b_popup FROM blog ORDER BY b_date DESC";
	if ($limit) $sql .= " LIMIT $limit";

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) 
		$blog[] = $result;

	return $blog;

}

function get_blog_item($id)
{

	if (!$id) {

		error("NULL BLOG id!");
		return FALSE;

	}

	$sql = "SELECT b_text, b_picture, b_popup FROM blog WHERE b_id = '$id'";
	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return mysql_fetch_array($query, MYSQL_ASSOC);
}

function insert_blog($text, $userfile, $popup) 
{

	if ($userfile['size']) {

		$bimagename = $userfile['name'];
		$bimagepath = get_blog_path($bimagename);
		$bthumbpath = get_bthumb_path($bimagename);

		move_file($_FILES['userfile'], $bimagepath);
		create_thumb($bimagepath, $bthumbpath, get_config("blog width"), get_config("blog height"));
	}

	$posted = getdatetime();
	if (!get_magic_quotes_gpc()) $text = addslashes($text);
	$text = nl2br($text);

	$sql = "INSERT INTO blog (b_date, b_text, b_picture, b_popup) VALUES ('$posted' , '$text', '$bimagename', '$popup')";

	if (!$result = mysql_query($sql)) {

		error(mysql_error());
		return FALSE;

	}

	return TRUE;

}

function delete_blog($id)
{

	if (!$id) {

		error("Can not delete null id!");
		return FALSE;

	}

	$bitem = get_blog_item($id);
	@unlink(get_blog_path($bitem[b_picture]));
	@unlink(get_bthumb_path($bitem[b_picture]));	

	$query = mysql_query("DELETE FROM blog WHERE b_id = '$id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} 

	return TRUE;

}

function update_blog_item($id, $text, $userfile, $popup)
{

	if (!$id || !$text) return FALSE;

	if ($userfile['size']) {

		$bimagename = $userfile['name'];
		$bimagepath = get_blog_path($bimagename);
		$bthumbpath = get_bthumb_path($bimagename);

		move_file($_FILES['userfile'], $bimagepath);
		create_thumb($bimagepath, $bthumbpath, get_config("blog width"), get_config("blog height"));
	}

	if (!get_magic_quotes_gpc()) $text = addslashes($text);
	$text = nl2br($text);

	$sql = "UPDATE blog SET b_text = '$text'";
	if ($bimagename) $sql .= ", b_picture = '$bimagename'";
	$sql .= ", b_popup = '$popup' WHERE b_id = '$id'";

	//error($sql);

	if (!$result = mysql_query($sql)) {

		error(mysql_error());
		return FALSE;

	}

	return TRUE;

}

function get_blog_name()
{

	$sql = "SELECT c_name FROM content WHERE c_type = 'B'";
	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSe;

	} else return mysql_result($query,c_name);

}

?>

