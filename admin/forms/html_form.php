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

// If we are not able to determine maxium upload file size from database, lets set it to 200k
if (!$max_file_size = get_config("max file size")) $max_file_size = set_config("max file size",2000000);

echo("<br><h3>Upload an HTML file : </h3><br>");
echo("<form enctype=multipart/form-data action=$PHP_SELF?ln=7&option=html&action=submit method=POST>");
echo("<input type=hidden name=MAX_FILE_SIZE value=$max_file_size class=formitem>");
echo("<input name=userfile type=file size=40 class=formitem>");
echo("<br><br>");
echo("<input type=submit value=Send File class=formitem>");
echo("</form>");

?>
