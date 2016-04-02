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

if (!$gb_greeting = get_config("Guestbook greeting")) {

	$gb_greeting = "Sign My Guestbook!";
	set_config("Guestbook greeting",$gb_greeting);

}

echo("<h2>$gb_greeting</h2><br>");
echo("<form method=POST action=$PHP_SELF?ln=" . $_GET['ln'] ."&mod=G&option=submit>");
echo("Your Name: <input type=text name=poster class=formitem><p>&nbsp;</p>");
echo("Your Comments: <br>");
echo("<textarea name=text class=formitem rows=4 cols=40></textarea><br><br>");
echo("<input type=submit value=Add My Comments class=formitem>");
echo("<br><br>");


?>
