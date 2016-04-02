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

echo("<div id=Header align=center>");
if ($footer_link=get_config ("footer link")) echo ("<a href=$footer_link>" 
	. get_config ("footer text") . "</a></div>");
else echo (get_config ("footer text") . "</div>");
echo("<div align=right>Powered by -= <a href=http://sourceforge.net/projects/phphomepage>phpHomeSite " 
	. get_config ("version") . " </a>=-&nbsp;</div>");

// End of HTML body
echo('</body>');

?>
