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

define("TPREFIX","thumb_");
define("SPREFIX","sized_");

function get_folder_path($folder)
{

	global $HOME, $UPLOAD, $PICS;

	return $HOME . "/" . $UPLOAD . "/" . $PICS . "/" . $folder;

}

function get_pic_path($name, $folder)
{

	global $HOME, $UPLOAD, $PICS;

	return $HOME . "/" . $UPLOAD . "/" . $PICS . "/" . $folder . "/" . $name;

}

function get_thumb_path($name, $folder)
{

	global $HOME, $UPLOAD, $PICS;


	return $HOME . "/" . $UPLOAD . "/" . $PICS . "/" . $folder . "/" . TPREFIX . $name;
}

function get_sized_path($name, $folder)
{

	global $HOME, $UPLOAD, $PICS;


	return $HOME . "/" . $UPLOAD . "/" . $PICS . "/" . $folder . "/" . SPREFIX . $name;
}

function get_thumb_url($name, $folder)
{

	global $UPLOAD, $PICS;

	return "../" . $UPLOAD . "/" . $PICS . "/" . $folder . "/" . TPREFIX . $name;

}

function get_sized_url($name, $folder)
{

	global $UPLOAD, $PICS;

	return $UPLOAD . "/" . $PICS . "/" . $folder . "/" . SPREFIX . $name;

}


// Check if a supplied folder already exists
function exists_folder($folder) 
{

	$path = get_folder_path($folder);

	if (file_exists($path)) return TRUE;

	else return FALSE;
}

// Creates a new picture folder
function create_folder($folder)
{

	$path = get_folder_path($folder);

	if (file_exists($path)) return FALSE;

	return @mkdir($path);
}

// Removes an existing picture folder
function delete_folder($folder)
{

	$path = get_folder_path($folder);

	if (!file_exists($path)) return FALSE;
	return @rmdir($path);

}

// Renames an existing picture folder
function rename_folder($oldfolder, $newfolder)
{

	$oldpath = get_folder_path($oldfolder);
	$newpath = get_folder_path($newfolder);

	if (!file_exists($oldpath) || file_exists($newpath)) return FALSE;
	return @rename($oldpath, $newpath);

}

// Returns an array of existing picture folders
function get_folders()
{

	global $HOME, $UPLOAD, $PICS;

	$path = $HOME . "/" . $UPLOAD . "/" . $PICS;

	// Check if pictures folder exists
	if (!$dir = @opendir($path)) {

		error("Could not read upload path!!");
		exit();

	}

	// Read sub-directories into array
	while ($file = readdir($dir)) 
		if (is_dir($path . "/" . $file) && 
				$file != ".." && $file != "." ) 
			$folders[] = $file;

	return $folders;

}

function exists_thumb($folder, $file)
{

	$thumb = get_thumb_path($file, $folder);

	if (file_exists($thumb)) return TRUE;
	else return FALSE;

}

function get_filesize($folder, $file)
{

	$path = get_pic_path($file, $folder);

	return @filesize($path);

}

function move_file($userfile, $path)
{
	if (!$userfile['size'] > get_config("max file size")) {

		error("File too big!");
		return FALSE;

	}

	if (@move_uploaded_file($userfile['tmp_name'], $path)) {

		return TRUE;

	} else {

		error("Could not move file!");
		return FALSE;

	}

}


?>
