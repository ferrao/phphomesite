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

if (!$gals) {
	
	error("Could not find any galleries!");
	exit();
}

if (!get_config("default img width")) set_config("default img width",200);
if (!get_config("default img height")) set_config("default img height",200);

if ($pic = get_pic_details($_GET['id'])) {

	echo("<form method=POST action=$PHP_SELF?ln=5&option=gsubmit&action=submit&id=" . $_GET['id'] . ">");
	echo("<br><img border=1 src=" . get_thumb_url($pic[p_name], $pic[p_folder]) . "><br><br><br>");

	echo("<table border=0><tr>");
	echo("<td><h3>Gallery :</h3><br><select name=gid ");

	foreach ($gals as $i)
		echo("<option value=" . get_gallery_id($i) . ">$i");

	echo("</select><br><br></td>");

	echo("<td><h3>Link image to :</h3><br><select name=lid>");
	echo("<option value=>Don't Link");

	if ($links) {
	
		foreach ($links as $i) echo("<option value=" . get_link_id($i['l_name']) . ">" . $i['l_name']);

	}

	echo("</select><br><br></td></tr>");

	echo("<td><h3>Width :</h3><br><input type=text size=2 value=");
	echo(get_config("default img width") . " name=width class=formitem></td>");
	echo("<td><h3>Height :</h3><br><input type=text size=2 value=");
	echo(get_config("default img height") . " name=height class=formitem></td></tr>");
	echo("<tr><td colspan=2><br><h3>Caption :</h3><br>");
	echo("<input type=text size=50 name=caption class=formitem>");
	echo("</tr></table><br><br><input type=submit value='Send Gallery' class=formitem>");
	echo("</form>");
} else error("Could not retreive picture details!");

?>
