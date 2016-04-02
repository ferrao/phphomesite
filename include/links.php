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

function get_link_url($id) 
{

	$query = mysql_query ("SELECT l_url FROM links WHERE l_id='$id'");

	if (!$query) error (mysql_error());
	else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query,l_url));

}

function get_link_name($id) 
{

	$query = mysql_query ("SELECT l_name FROM links WHERE l_id='$id'");

	if (!$query) error (mysql_error());
	else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query,l_name));

}


function get_link_id($name)
{

	if (!$name) {

		error("NULL link name!");
		return FALSE;

	}

	$query = mysql_query ("SELECT l_id FROM links WHERE l_name = '$name'");

	if (!$query) {

		error (mysql_error());
		return FALSE;

	} else if (mysql_num_rows ($query)) return stripslashes (mysql_result($query,l_id));
	else {

		error("Link not found!");
		return FALSE;

	}

}



// Returns array with list of existing gallery pages
function get_links($lgid)
{

	$sql = "SELECT l_id, l_name, l_url, lg_id  FROM links";
	if ($lgid) $sql .= " WHERE lg_id='$lgid'";
	$sql .= " ORDER BY lg_id, l_name";

	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {

		$result['l_name'] = stripslashes($result['l_name']);
		$links[] = $result;

	}

	return $links;

}

function get_lgname($lgid)
{

	if (!$lgid) {

		error("NULL link group id!");
		return FALSE;

	}

	$query = mysql_query("SELECT lg_name FROM lgroup WHERE lg_id = '$lgid'");

	if (!$query) {
	
		error(mysql_error());
		return FALSE;

	} else if (mysql_num_rows($query)) return stripslashes(mysql_result($query,lg_name));

}


function get_lgroups()
{

	$query = mysql_query("SELECT lg_id, lg_name FROM lgroup");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) {

		$result['lg_name'] = stripslashes($result['lg_name']);
		$lgroups[] = $result;

	}

	return $lgroups;

}

function delete_lgroup($lgid)
{
	
	if (!$lgid) {

		error("NULL link group id!");
		return FALSE;

	} 

	$query = mysql_query("DELETE FROM lgroup WHERE lg_id = '$lgid'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} 

	return TRUE;

}

function insert_lgroup($lgroup)
{

	if (!$lgroup) {

		error("NULL link group");
		return FALSE;

	}

	if (!get_magic_quotes_gpc()) $lgroup = addslashes($lgroup);

	$query = mysql_query("INSERT INTO lgroup (lg_name) VALUES ('$lgroup')");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} 
	
	return TRUE; 

}

function rename_lgroup($lgid, $nlgroup)
{

	if ((!$lgid) || (!$nlgroup)) {

		error("NULL lgroup parameters received!");
		return FALSE;

	}


	if (!get_magic_quotes_gpc()) $nlgroup = addslashes($lgroup);

	$query = mysql_query("UPDATE lgroup SET lg_name='$nlgroup' WHERE lg_id='$lgid'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	return TRUE;

}

function insert_link($lgid, $name, $url)
{

	if ((!$lgid) || (!$name) || (!$url)) {

		error("NULL link parameters received");
		return FALSE;

	}

	if (!get_magic_quotes_gpc()) {

		$name = addslashes($name);
		$url = addslashes($url);

	}

	$query = mysql_query("INSERT INTO links (l_name, l_url, lg_id) VALUES ('$name', '$url', '$lgid')");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	return TRUE;

}

function remove_link($lid) {

	if (!$lid) {

		error("NULL link id!");
		return FALSE;

	}

	$query = mysql_query("DELETE FROM links WHERE l_id = '$lid'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

function exist_links($lgid)
{

	if (!$lgid) {

		error("NULL link group id!");

	}

	$query = mysql_query("SELECT COUNT(*) FROM links WHERE lg_id = '$lgid'");

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	return mysql_result($query,'count(*)');
}

?>
