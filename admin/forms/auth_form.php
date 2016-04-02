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

// Let's get username if not defined yet so we chan show it on the form.
if (!$username) $username = get_config("username");

echo("<form method=POST action=$PHP_SELF?ln=1&option=auth&action=submit>");
echo("<h3>Username :</h3><br>");
echo("<p><input type=text name=username value=$username class=formitem></p>");
echo("<h3>Password :</h3><br>");
echo("<p><input type=password name=password class=formitem></p>");
echo("<p><input type=submit value=Update class=formitem></p>");
echo("</form>")

?>
