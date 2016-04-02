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

function get_auth ($user, $pass)
{
	if (!isset($_SERVER['PHP_AUTH_USER'])) {

		header("WWW-Authenticate: Basic realm=\"$URL\"");
		header("HTTP/1.0 401 Unauthorized");
		error("You don't seem to have permissions for acessing this page!");
		exit();

	} else {

		if ($_SERVER['PHP_AUTH_USER'] != $user ||
				md5($_SERVER['PHP_AUTH_PW']) != $pass) {

			error("WRONG USERNAME AND/OR PASSWORD!!!");
			exit();

		}

	}

}

?>
