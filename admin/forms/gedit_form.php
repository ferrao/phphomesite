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

echo("<form method=POST action=$PHP_SELF?ln=5&option=gedit&action=submit&id=" . $_GET['id'] . ">");
echo("<table border=0><tr>");
echo("<td colspan=2><h3>Gallery Name :</h3><br>");
echo("<input type=text size=50 name=name value=" . $gallery['g_name'] . " class=formitem><br><br></td></tr>");
echo("<td><h3>Num Cols :</h3><br><input type=text size=2 value=" . $gallery['g_cols']);
echo(" name=cols class=formitem></td>");
echo("<td><h3>Rows :</h3><br><input type=text size=2 value=" . $gallery['g_rows']);
echo(" name=rows class=formitem></td></tr>");
echo("<tr><td colspan=2><br><h3>Text :</h3><br>");
echo("<textarea type=textarea rows=5 cols=80 wrap  size=50 name=text class=formitem>");
echo(htmlspecialchars(remove_br($gallery['g_text'])) . "</textarea>");
echo("</tr></table><br><br><input type=submit value=Submit class=formitem>");
echo("</form>");

?>
