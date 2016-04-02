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

/*
	up_item and down_item assumes tables with an id and pos field, 
	prefixed by some string.
*/

// Moves an item up in the table
function up_item($table, $condition, $prefix, $id)
{

	$id_field = $prefix . "_id";
	$pos_field = $prefix . "_pos";
	
	// Fetch an pos ordered array of id's
	$sql = "SELECT " . $id_field . ", " . $pos_field . " FROM " . $table; 
	if ($condition) $sql .= " WHERE " . $condition;
	$sql .= " ORDER BY " . $pos_field;

//	error($sql);
	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	$cur_id = null;
	$cur_pos = null;

	// grab the id and pos of the current/previous item 
	while ($cur_id != $id && $row = mysql_fetch_array($query)) {

		$prev_id = $cur_id;
		$prev_pos = $cur_pos;
		$cur_id = $row[0];
		$cur_pos = $row[1];

	}

	// no point on doing nothing if this is the first item 
	if (!$prev_id) return TRUE;

	// update the database
	$sql = "UPDATE " . $table . " SET " .  $pos_field . " = '" . $prev_pos . "' WHERE " . $id_field . " = '" . $cur_id . "'";
	$query = mysql_query($sql);

//	error($sql);
	if (!$query) {


		error(mysql_error());
		return FALSE;

	} 

	$sql = "UPDATE " . $table . " SET " . $pos_field . " = '" . $cur_pos . "' WHERE " . $id_field . " = '" . $prev_id . "'";
	$query = mysql_query($sql);	

//	error($sql);
	if (!$query) {

		error(mysql_error());
		return false;
	}

	return true;	

}

function down_item($table, $condition, $prefix, $id)
{

	$id_field = $prefix . "_id";
	$pos_field = $prefix . "_pos";

	// fetch an pos ordered array of id's
	$sql = "SELECT " . $id_field . ", " . $pos_field . " FROM " . $table;
	if ($condition) $sql .= " WHERE " . $condition;
	$sql .= " ORDER BY " . $pos_field;
	$query = mysql_query($sql);

//	error($sql);
	if (!$query) {

		error(mysql_error());
		return FALSE;

	}

	$cur_id = NULL;
	$cur_pos = NULL;

	// Grab the position of the current item 
	while ($cur_id != $id && $row = mysql_fetch_array($query)) {
		
		$cur_id = $row[0];
		$cur_pos = $row[1];

	}

	// No point on doing nothing if this is the last item
	if (!$row = mysql_fetch_array($query)) return TRUE;

	$next_id = $row[0];
	$next_pos = $row[1];

	// update the database
	$sql = "UPDATE " . $table . " SET " .  $pos_field . " = '" . $next_pos . "' WHERE " . $id_field . " = '" . $cur_id . "'";
	$query = mysql_query($sql);

//	error($sql);
	if (!$query) {

		error(mysql_error());
		return FALSE;

	} 

	$sql = "UPDATE " . $table . " SET " . $pos_field . " = '" . $cur_pos . "' WHERE " . $id_field . " = '" . $next_id . "'";
	$query = mysql_query($sql);	

//	error($sql);
	if (!$query) {

		error(mysql_error());
		return FALSE;
	}

	return TRUE;	

}

?>
