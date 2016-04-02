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

echo("<form method=POST action=$PHP_SELF?ln=1&option=global&action=submit>");
echo("<table cellpadding=10>");

echo("<tr><td><h3>Header Link :</h3></td><td><input type=text size=50 name=headerlink value='");
echo(get_config("header link") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Header Text :</h3></td><td><input type=text size=50 name=headertext value='");
echo(get_config("header text") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Footer Link :</h3></td><td><input type=text size=50 name=footerlink value='");
echo(get_config("footer link") . "' class=formitem></td></tr>");

echo("<tr><td><h3>Footer Text :</h3></td><td><input type=text size=50 name=footertext value='");
echo(get_config("footer text") . "' class=formitem><br><br></td></tr>");


echo("<tr><td align=left colspan=2><table cellpadding=0 cellspacing=0 border=0><tr><td><h3>Thumb width :  &nbsp;</h3></td><td><input type=text size=3 name=thumbwidth value='");
echo(get_config("thumb width") . "' class=formitem></td>");

echo("<td><h3>&nbsp;  Thumb height :  &nbsp;</h3></td><td><input type=text size=3 name=thumbheight value='");
echo(get_config("thumb height") . "' class=formitem></td>");

echo("<td><h3>&nbsp;  Max Upload Size :  &nbsp;</h3></td><td><input type=text size=6 name=maxfilesize value='");
echo(get_config("max file size") . "' class=formitem></td></tr></table></td></tr>");

echo("</table><br><br>");
echo("<input type=submit value=Submit class=formitem>");
echo("</form>");

?>
