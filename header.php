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

// HTML header
echo('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">');
echo('<html><head><meta name="author" content="Rui Ferrao"><meta name="copyright" content="Eixo Digital">');
echo('<meta name="description" content="Simple Home Page CMS System"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
echo('<link href="css/style.css" type="text/css" rel="Stylesheet">');

// JavaScript for blog popup's
echo('<SCRIPT LANGUAGE="JavaScript">');
echo('<!-- hide from old browsers');
printf("\n"); // LF Needed for hidding to work
echo('var subWindow;');
echo('function popup(URL, WIDTH, HEIGHT) {');
echo('subWindow=window.open(URL,"phphomesite",');
echo('"titlebar=no,toolbar=no,width=" + WIDTH + ",height=" + HEIGHT + "');
echo(',status=no,scrollbars=no,resize=no,menubar=no");');
echo('}');
printf("\n");
echo('// end script hiding -->');
echo('</SCRIPT>');

// HTML title
$title = get_config ('title');
if (!$title) $title = "phpHomeSite - A Simple Home Page CMS System";
echo ("<title>$title</title></head>");

// Start of HTML Body
echo('<body><div id=Header>');
if ($header_link=get_config ("header link")) echo ("<a href=$header_link>" . get_config ("header text") . "</a></div>");
else echo (get_config ("header text") . "</div>");
?>
