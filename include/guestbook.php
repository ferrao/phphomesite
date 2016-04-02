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

function get_guestbook_name()
{

	$sql = "SELECT c_name FROM content WHERE c_type = 'G'";
	$query = mysql_query($sql);

	if (!$query) {

		error(mysql_error());
		return FALSe;

	} else return mysql_result($query,c_name);

}

// Return array with guestbook data  
function get_guestbook($limit)
{

	$sql = "SELECT gb_id, gb_name, gb_date, gb_text FROM guestbook ORDER BY gb_date DESC";
	if ($limit) $sql .= " LIMIT $limit";

		  $query = mysql_query($sql);

		  if (!$query) {

					 error(mysql_error());
					 return FALSE;

		  } else while ($result = mysql_fetch_array($query, MYSQL_ASSOC)) 
					 $gb[] = $result;

		  return $gb;

}

function delete_guestbook($id)
{

		  if (!$id) {

					 error("Can not delete null id!");
					 return FALSE;

		  }

		  $query = mysql_query("DELETE FROM guestbook WHERE gb_id = '$id'");

		  if (!$query) {

					 error(mysql_error());
					 return FALSE;

		  } 

		  return TRUE;

}

function insert_guestbook($poster, $text)
{

	$poster = addslashes($poster);
	$text = nl2br(addslashes($text));
	$datetime = getdatetime();

	$sql = "INSERT INTO guestbook (gb_name, gb_date, gb_text) VALUES ('$poster' , '$datetime' , '$text')";

	if (!$result = mysql_query($sql)) {

		error(mysql_error());
		return FALSE;

	} else return TRUE;

}

?>
