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

/*
        Function checkgd()
        checks the version of gd, and returns "yes" when it's higher than 2
*/
function checkgd(){

        $gd2="";
        ob_start();
        phpinfo(8);
        $phpinfo=ob_get_contents();
        ob_end_clean();
        $phpinfo=strip_tags($phpinfo);
        $phpinfo=stristr($phpinfo,"gd version");
        $phpinfo=stristr($phpinfo,"version");
        preg_match('/\d/',$phpinfo,$gd);

        if ($gd[0]=='2'){$gd2="yes";}

        return $gd2;

}

function get_size($path)
{

	$split = explode(".",$path);
	$ext = array_pop($split);

	if (preg_match("/jpg|jpeg/i",$ext)) @$img = imagecreatefromjpeg($path);		
	else if (preg_match("/png/i",$ext)) @$img = imagecreatefrompng($path);

	if (!$img) return FALSE;

	return array("x" => imageSX($img), "y" => imageSY($img));

}

/*
	Creates thumbnail from jpg or png file mantaining aspect ratio

	image_path - Full path to image file
	thumb_path - Full path to generated thumbnail
	tx - Maximum thumb width
	ty - Maximum thumb height
*/
function create_thumb($image_path,$thumb_path,$tx,$ty)
{

	$split = explode(".",$image_path);
	$ext = array_pop($split);

	if (preg_match("/jpg|jpeg/i",$ext)) {

		@$src_img=imagecreatefromjpeg($image_path);

		if (!$src_img) {

			error("Failure creating thumbnail from jpeg file!");
			return FALSE;

		}

	} else if (preg_match("/png/i",$ext)) {

		@$src_img=imagecreatefrompng($image_path);

		if (!$src_img) {

			error("Failure creating thumbnail from png!");
			return FALSE;

		}

	} else {

		error("Incorrect image path!!");
		return FALSE; // If file is not jpg / png let's get out of here

	}	

	$old_x = imageSX($src_img);
	$old_y = imageSY($src_img);

	// Let's calculate the new width / height in order not to loose aspect ratio.
	if ($old_x > $old_y) {

		$new_w = $tx;
		$new_h = $old_y * ($ty / $old_x);

	}

	if ($old_x < $old_y) {

		$new_h = $ty;
		$new_w = $old_x * ($tx / $old_y);

	}

	if ($old_x == $old_y) {

		$new_h = $ty;
		$new_w = $tx;

	}

	if ($gd2="") {

		$dst_img=ImageCreate($new_w,$new_h);
		ImageCopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,$old_x,$old_y);

	} else {

		$dst_img=ImageCreateTrueColor($new_w,$new_h);
		ImageCopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,$old_x,$old_y);

	}

	if (preg_match("/png/i",$split[1]))
		imagepng($dst_img, $thumb_path);
	else imagejpeg($dst_img, $thumb_path);

	imagedestroy($src_img);
	imagedestroy($dst_img);
	
	return TRUE;
}


?>
