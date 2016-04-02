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


// Output Left Menu
echo("<div id=navLeft>");
echo("<a href=$PHP_SELF?ln=1&option=config>General</a><br>");
echo("<a href=$PHP_SELF?ln=2&option=lnav>Menus</a><br>");
echo("<a href=$PHP_SELF?ln=3&option=blog>Blog</a><br>");
echo("<a href=$PHP_SELF?ln=4&option=gb>Guestbook</a><br>");
echo("<a href=$PHP_SELF?ln=5&option=gal>Gallery</a><br>");
echo("<a href=$PHP_SELF?ln=6&option=pic>Pictures</a><br>");
echo("<a href=$PHP_SELF?ln=7&option=html>HTML Files</a><br>");
echo("<a href=$PHP_SELF?ln=8&option=link>Links</a><br>");
echo("<a href=$PHP_SELF?ln=9&option=about>About</a><br>");
echo("</div>");

// The base URL of the site does not have ln_id (left nav id) defined, 
// let's set it to one.
if (!$ln_id = $HTTP_GET_VARS["ln"]) $ln_id = 1;

switch ($ln_id) {

	case '1' :

		echo("<div id=navRight>");
		echo("<a href=$PHP_SELF?ln=1&option=auth>Authentication</a><br>");
		echo("<a href=$PHP_SELF?ln=1&option=style>Stylesheet</a><br>");
		echo("<a href=$PHP_SELF?ln=1&option=global>Global Configuration</a><br>");
		echo("<a href=$PHP_SELF?ln=1&option=bconf>Blog Configuration</a><br>");
		echo("<a href=$PHP_SELF?ln=1&option=gbconf>Guestbook Configuration</a><br>");
		echo("<a href=$PHP_SELF?ln=1&option=galconf>Gallery Configuration</a><br>");
		echo("</div>");

		break;

	case '2' :

		if ($_GET['option'] == "lnav") {

			$menu = "lnav";
			$ln_id = "";

		} else if ($_GET['option'] == "rnav") {

			$ln_id = $_GET['id'];
			$menu = "rnav";

			// We are coming from a right menu link
		} else { 

			$menu = $_GET['menu'];
			$ln_id = $_GET['id'];

		}

		echo("<div id=navRight>");

		echo("<a href=$PHP_SELF?ln=2&option=addb&menu=$menu");
		if ($ln_id) echo("&id=$ln_id");
		echo(">Add Blog</a><br>");

		echo("<a href=$PHP_SELF?ln=2&option=addg&menu=$menu");
		if ($ln_id) echo("&id=$ln_id");	
		echo(">Add GuestBook</a><br>");

		echo("<a href=$PHP_SELF?ln=2&option=addi&menu=$menu");
		if ($ln_id) echo("&id=$ln_id");
		echo(">Add Gallery</a><br>");

		echo("<a href=$PHP_SELF?ln=2&option=addh&menu=$menu");
		if ($ln_id) echo("&id=$ln_id");
		echo(">Add HTML</a><br>");

		echo("<a href=$PHP_SELF?ln=2&option=addu&menu=$menu");
		if ($ln_id) echo("&id=$ln_id");
		echo(">Add URL</a><br>");

		echo("</div>");
		break;

	case '3' :
		echo("<div id=navRight>");
		echo("<a href=$PHP_SELF?ln=3&option=blog&action=resize>Resize images</a><br>");
		echo("</div>");


		break;

	case '4' :
		break;

	case '5' :

		echo("<div id=navRight>");
		echo("<a href=$PHP_SELF?ln=5&option=gcreate>Create Gallery</a><br>");

		$gals = get_gallery_name_list();

		if ($gals) {

			echo("<br>");

			foreach ($gals as $i) {

				echo("<a href=$PHP_SELF?ln=5&option=gview&gid=");
				echo(get_gallery_id($i) . ">Gallery $i</a><br>");

			}

		}

		echo("</div>");

		break;

	case '6' :

		echo("<div id=navRight>");
		echo("<a href=$PHP_SELF?ln=6&option=fcreate>Create Folder</a><br>");
		echo("<a href=$PHP_SELF?ln=6&option=fdelete>Delete Folder</a><br>");
		echo("<a href=$PHP_SELF?ln=6&option=frename>Rename Folder</a><br>");

		$folders = get_folders();

		if ($folders) {

			echo("<br>");

			foreach ($folders as $i) echo("<a href=$PHP_SELF?ln=6&option=fpreview&folder=$i>$i</a><br>");

		}

		echo("</div>");

		break;

	case '7' :
		break;

	case '8' :

		echo("<div id=navRight>");
		echo("<a href=$PHP_SELF?ln=8&option=lcreate>Create Link Group</a><br>");
		echo("<a href=$PHP_SELF?ln=8&option=ldelete>Delete Link Group</a><br>");
		echo("<a href=$PHP_SELF?ln=8&option=lrename>Rename Link Group</a><br>");

		$lgroups = get_lgroups();

		if ($lgroups) {

			echo("<br>");

			foreach ($lgroups as $i) {
				
				echo("<a href=$PHP_SELF?ln=8&option=lview&lgid=");
				echo($i[lg_id] . ">" . $i[lg_name] . "</a><br>");

			}

		}
				
		echo("</div>");

		break;
}

?>
