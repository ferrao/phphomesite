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

echo("<form method=POST action=$PHP_SELF?ln=1&option=bconf&action=submit>");
echo("<table cellpadding=10>");

echo("<tr><td><h3>Blog Name :</h3></td><td><input type=text size=50 name=blogname value='");
echo(get_config("blog name") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Blog image width :</h3></td><td><input type=text size=3 name=blogwidth value='");
echo(get_config("blog width") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Blog image height :</h3></td><td><input type=text size=3 name=blogheight value='");
echo(get_config("blog height") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Items per page:</h3></td><td><input type=text size=4 name=bloglimit value='");
echo(get_config("blog limit") . "' class=formitem></td></tr>");

echo("</table><br><br>");
echo("<input type=submit value=Submit class=formitem>");
echo("</form>");

?>
