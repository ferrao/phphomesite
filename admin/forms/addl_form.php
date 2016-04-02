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

if (!$lgroups) {

    error("Could not find any link groups!");
    exit();

}

echo("<form enctype=multipart/form-data action=$PHP_SELF?ln=8&option=link&action=submit method=POST>");
echo("<h3>Select link group : </h3><br>");

echo("<select name=lgid>");

foreach ($lgroups as $i) {

    echo("<option value=" . $i['lg_id'] . ">" . $i['lg_name']);

}

echo("</select><br><br>");

echo("<h3>Insert link name : </h3><br>");
echo("<input type=text name=lname class=formitem><br><br>"); 
echo("<h3>Insert link URL : </h3><br>");
echo("<input type=text name=lurl size=50 class=formitem>"); 
echo("<br<br><input type=submit value=submit class=formitem>");
echo("</form>");

?>
