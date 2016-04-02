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

require "../config.php";
require "../include/db.php";
require "../include/error.php";
require "../include/gfx.php";
require "../include/defaults.php";
require "../include/links.php";
require "../include/files.php";
require "../include/gal.php";
require "../include/auth.php";

// Connect to the database
connect_database();

// Perform some basic checking on the configuration
check_config();


// Get username & hashed password from database
if (!$username = get_config("username")) {

	error("Admin username not in database!");
	exit();

}

if (!$hash = get_config("password")) {

	error("Admin password not in database!");
	exit();

}

// Match it against user input
get_auth ($username, $hash); 

// Output the page header
include "header.php";

// Output Menus
include "menu.php";

// Output Content
include "content.php";

// Output the page footer
include "footer.php";

?>
