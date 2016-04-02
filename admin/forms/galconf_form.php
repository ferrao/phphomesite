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

echo("<form method=POST action=$PHP_SELF?ln=1&option=galconf&action=submit>");
echo("<table cellpadding=10>");

echo("<tr><td><h3>Default image width :</h3></td><td><input type=text size=3 name=defimgwidth value='");
echo(get_config("default img width") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Default image height :</h3></td><td><input type=text size=3 name=defimgheight value='");
echo(get_config("default img height") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Default gallery columns :</h3></td><td><input type=text size=3 name=defgalcols value='");
echo(get_config("default gal cols") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Default gallery rows :</h3></td><td><input type=text size=3 name=defgalrows value='");
echo(get_config("default gal rows") . "' class=formitem></td></tr>");

echo("</table><br><br>");
echo("<input type=submit value=Submit class=formitem>");
echo("</form>");

?>
