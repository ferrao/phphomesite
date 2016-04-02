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

if (!$max_file_size = get_config("max file size")) $max_file_size = set_config("max file size",2000000);

if (!get_config("blog width")) set_config("blog width",150);
if (!get_config("blog height")) set_config("blog height",150);

echo("<form enctype=multipart/form-data method=POST action=$PHP_SELF?ln=3&option=bedit&action=submit&id=");
echo($_GET['id'] . ">");
echo("<input type=hidden name=MAX_FILE_SIZE value=$max_file_size class=formitem>");
echo("<textarea rows=5 cols=80 wrap name=text class=formitem>" 
	. htmlspecialchars(remove_br(stripslashes($blog_item['b_text']))) . "</textarea>");
echo("<td><table border=0><tr><td><h3>Pop Up :</h3></td>");
echo("<br><br><td><h3>Change image if desired : </h3></td></tr>");
echo("<tr><td width=100><select name=popup><option value=no>No</option>");
echo("<option value=yes>Yes</option></select></td>");
echo("<td><input name=userfile type=file size=40 class=formitem></td></tr></table>");

echo("<br><br><input type=submit value=\"Save Changes\" class=formitem>");
echo("</form>");

?>
