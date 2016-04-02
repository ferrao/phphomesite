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

function get_table_id($navid)
{

	if (!$navid) {

		error("NULL navigation id!");
		return FALSE;

	}

	$sql = "SELECT table_id FROM content WHERE c_id = '$navid'";

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	if (mysql_num_rows($query)) return mysql_result($query,table_id);
	else return FALSE;

}

function get_left_content($limit)
{

	$sql = "SELECT ln_id , ln_pos, content.c_id, c_type, c_name FROM content, lnav WHERE content.c_id = lnav.c_id ORDER BY ln_pos";
	if ($limit) $sql .= " LIMIT $limit";

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {

		$lnav[] = $result;

	}

	return $lnav;

}

function get_right_content($ln_id, $limit)
{
	if (!$ln_id) {

		error("Null id on get right content!");
		return FALSE;

	}

	$sql = "SELECT rn_id, c_type, c_name, rn_pos FROM content, rnav WHERE content.c_id = rnav.c_id AND ln_id=$ln_id ORDER BY rn_pos";
	if ($limit) $sql .= " LIMIT $limit";

	$query = mysql_query($sql);

	if (!$query) {

		error (mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {

		$rnav[] = $result;

	}

	return $rnav;

}

function exists_content($ctype) {

	$query = mysql_query("SELECT COUNT(*) FROM content WHERE c_type = '$ctype'");

	if (!$query) {

		error(mysql_error());
		exit();

	} 

	if (mysql_num_rows($query)) return mysql_result($query,'COUNT(*)');

}

/*
	Gets the content id of recently inserted content
	For blog or guestbook type, no table id needed.
 */
function get_max_id($ctype)
{

	$sql = "SELECT MAX(c_id) FROM content WHERE c_type = '$ctype'";

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	if (mysql_num_rows($query)) return mysql_result($query,'MAX(c_id)');

}

/*
	Inserts a new content table element

	$name - Name to be shown on the menu
	$nav	- lnav / rnav
	$ln_id - lnav id, if menu is of type rnav
	$ctype - content type 
	$table_id - id of the content

 */
function add_content($name, $nav, $ln_id, $ctype, $table_id) 
{
	if ($nav == "rnav" && !$ln_id) {

		error("Right menu requires left menu id!");
		return FALSE;

	}

	if ($ctype != "B" && $ctype != "G" && !$table_id) {

		error("Table id required to add content!");
		return FALSE;

	}

	$sql = "INSERT INTO content (c_name, c_type, table_id) VALUES ('$name', '$ctype', '$table_id')";
	$query = mysql_query($sql);

//	    error($sql);
	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	if ($c_id = get_max_id($ctype)) {

		if ($nav == "lnav") {

			$pos = get_max_pos("lnav", "ln") + 1;
			$sql = "INSERT INTO lnav (c_id, ln_pos) VALUES ('$c_id', '$pos')";

		} else {

			$pos = get_max_pos("rnav", "rn") + 1;
			$sql = "INSERT INTO rnav (ln_id, c_id, rn_pos) VALUES ('$ln_id', '$c_id', '$pos')";

		}

		//	error($sql);
		if ($query = mysql_query($sql)) return TRUE;
		else return FALSE;


	} else {

		return FALSE;

	}

}

/* 
	Returns the id on the content table of
	a given menu element.
 */
function get_cid_fromnav($id, $nav)
{
	if (!$id) {

		error("Navigation id null!");
		return FALSE;

	}

	if ($nav == "lnav") {

		$sql = "SELECT c_id FROM lnav WHERE ln_id = '$id'";

	} else if ($nav == "rnav") {

		$sql = "SELECT c_id FROM rnav WHERE rn_id = '$id'";

	} else {

		error("Invalid navigation!");
		return FALSE;

	}

	$query = mysql_query($sql);

	if (mysql_num_rows($query)) return mysql_result($query,'c_id');

}

/* Do NOT FORGET to change these ones!!, must receive ln_id as well, and
use as a condition upon calling up/down_item */
function up_menu($id, $lnid, $nav)
{

	if ($nav == "lnav") $prefix = "ln";
	else if ($nav == "rnav") $prefix = "rn";
	else {

		error("Invalid navigation!");
		return FALSE;

	}

	if (!$id) {

		error("Navigation id NULL");
		return FALSE;

	} else if ($nav == "rnav" && !$lnid) {

		error("Left id NULL");
		return FALSE;

	}

	if ($nav == "rnav") $cond = "ln_id='$lnid'"; else $cond = "";

	if (!up_item($nav, $cond, $prefix, $id)) return FALSE;
	else return TRUE;

}

function down_menu($id, $lnid, $nav)
{

	if ($nav == "lnav") $prefix = "ln";
	else if ($nav == "rnav") $prefix = "rn";
	else {

		error("Invalid navigation!");
		return FALSE;

	}

	if (!$id) {

		error("Navigation id NULL");
		return FALSE;

	} else if ($nav == "rnav" && !$lnid) {

		error("Left id NULL");
		return FALSE;

	}

	if ($nav == "rnav") $cond = "ln_id='$lnid'"; else $cond = "";

	if (!down_item($nav, $cond, $prefix, $id)) return FALSE;
	else return TRUE;


}

function remove_menu($id, $nav)
{

	// Check that we dont remove left menu before removing 
	// the corresponding right menu entries
	if ($nav == "lnav" && $id) {

		$query = mysql_query("SELECT COUNT(*) FROM rnav WHERE ln_id = '$id'");

		if (!$query) {

			error(mysql_error());
			return FALSE;

		}

		if (mysql_result($query,'COUNT(*)')) {

			error("Please erase right menu entries first!");
			return TRUE;

		}

	}

	if (!$c_id = get_cid_fromnav($id, $nav)) {

		error("Can not remove menu!");
		return FALSE;

	}

	$query = mysql_query("DELETE FROM content WHERE c_id = '$c_id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} 

	$query = mysql_query("DELETE from $nav WHERE c_id = '$c_id'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

?>
