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

if (!$files) {

    error("Could not find any html files!");
    exit();

}

echo("<form method=POST action=$PHP_SELF?ln=2&option=addh&menu=" . $_GET['menu']);
echo("&id=" . $_GET['id'] . "&action=submit>");
echo("<h3>Insert content name :</h3><br><input type=text size=50 name=name class=formitem><br><br>");
echo("<h3>Select content file :</h3><br>");

echo("<select name=file>");

foreach ($files as $i) {

    echo("<option value='" . $i . "'>" . $i);

}

echo("</select><br><br>");

echo("<br><br><input type=submit value=Submit class=formitem>");
echo("</form>");

?>
