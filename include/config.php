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

function global_config($post)
{

	set_config("header link", $post['headerlink']);
	set_config("header text", $post['headertext']);
	set_config("footer link", $post['footerlink']);
	set_config("footer text", $post['footertext']);
	if (is_digits($post['thumbwidth'])) set_config("thumb width", $post['thumbwidth']);
	if (is_digits($post['thumbheight'])) set_config("thumb height", $post['thumbheight']);
	if (is_digits($post['thumbheight'])) set_config("max file size", $post['maxfilesize']);

}

function blog_config($post)
{

	set_config("blog name", $post['blogname']);
	if (is_digits($post['blogwidth'])) set_config("blog width", $post['blogwidth']);
	if (is_digits($post['blogheight'])) set_config("blog height", $post['blogheight']);

}

function gb_config($post)
{

	set_config("guestbook name", $post['gbname']);
	set_config("guestbook greeting", $post['gbgreeting']);

}

function gal_config($post)
{

	if (is_digits($post['defimgwidth'])) set_config("default img width", $post['defimgwidth']);
	if (is_digits($post['defimgheight'])) set_config("default img height", $post['defimgheight']);
	if (is_digits($post['defgalcols'])) set_config("default gal cols", $post['defgalcols']);
	if (is_digits($post['defgalrows'])) set_config("default gal rows", $post['defgalrows']);

}



?>
