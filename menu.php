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

require "include/links.php";

// Outputs one menu row linked to index.php and passing the variables :
//
// ln	- Id of the Left Navigation item ( necessary to choose wich right menu to output )
// mod	- Content module to be used for output 
// id	- Id of the specific content type to be generated
//
function proc_menu(&$row,$positioning) 
{
	global $ln_id;

	$name = stripslashes($row[c_name]);

	// If this is a right menu, ln is always constant and equal id of left navigation.
	if ($positioning == "left") $nav_id = $row[ln_id]; else $nav_id = $ln_id;

	switch ($row[c_type]) {

		// Blog Module
		case 'B' :

			echo("<a href=index.php?ln=$nav_id&mod=B>$row[c_name]</a>");

			break;

			// GuestBook Module
		case 'G' :

			echo("<a href=index.php?ln=$nav_id&mod=G>$row[c_name]</a>");

			break;

			// Gallery Module
		case 'I' :

			echo("<a href=index.php?ln=$nav_id&mod=I&id=$row[table_id]>$row[c_name]</a>");

			break;

			// External URL
		case 'U' :

			if ($url = get_link_url($row[table_id]))

				echo("<a href=$url>$row[c_name]</a>");

			break;

			// HTML file
		case 'H' :

			echo("<a href=index.php?ln=$nav_id&mod=H&id=$row[table_id]>$row[c_name]</a>");

			break;
	}

	echo ("<br>");

}

echo("<div id=navLeft>");

// Grab left menu entries from the database
$query = mysql_query ("	SELECT c_type, c_name, table_id , ln_id
		FROM content, lnav WHERE lnav.c_id = content.c_id 
		ORDER BY ln_pos");

// Output left menu
if (!$query) error (mysql_error());
else {

	if (!mysql_num_rows($query)) error("Empty left Menu");
	else while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) proc_menu($row,"left"); 

}

echo("</div>");


// The base URL of the site does not have ln_id (left nav id) defined, 
// let's get it from the first menu entry in the database
if (!$ln_id = $HTTP_GET_VARS["ln"]) {

	$query = mysql_query ("SELECT ln_id FROM lnav ORDER BY ln_pos LIMIT 1");

	if (mysql_num_rows($query)) $ln_id = mysql_result($query,ln_id);

}

if ($ln_id) {

	// Grab right menu entries from the database
	$query = mysql_query ("	SELECT c_type, c_name, table_id
			FROM content, rnav 
			WHERE rnav.c_id = content.c_id AND rnav.ln_id = $ln_id  
			ORDER BY rn_pos");

	if (!$query) error (mysql_error());
	else {

		// Output right menu if defined for the current left menu selection
		if (mysql_num_rows($query)) {

			echo("<div id=navRight>");

			while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) proc_menu($row,"right");

			echo("</div>");

		}
	}
}


?>
