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

// Prints properly HTML formated error message 
function error($string) {

	echo("<br><p><b><font color=RED>ERROR:</font> $string</b></p><br>");

}

// Checks if supplied string is composed only of letters and digits
function is_lettersdigits($string) 
{

	return !preg_match ("/[^a-z0-9A-Z]/", $string);

}

// Checks if supplied string is composed only of digits
function is_digits($string)
{

	return !preg_match ("/[^0-9]/", $string);

}

?>
