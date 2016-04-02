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

define("NOLIMIT", 0);
define("NOLGROUP", 0);

require "../include/pictures.php";
require "../include/pos.php";
require "../include/html.php";
require "../include/navigation.php";
require "../include/guestbook.php";
require "../include/blog.php";
require "../include/config.php";

echo("<div class=content>");

// Let's set the Base Admin Page to global configuration
if (!$option = $HTTP_GET_VARS["option"]) $option = "config";

switch ($option) {

	/*
		GLOBAL CONFIGURATION
	 */
	case 'config' :

		echo("<h1>Admin Interface</h1>");
		echo("<h2>Development version</h2>");
		echo("<p>Some of the functionality is not present or not working properly yet!</p><br><br>");
		break;

	case 'global' :

		echo("<h1>Global Configuration</h1>");
		echo("<h2></h2>");

		if ($_GET['action'] == "submit") {

			if (global_config(&$_POST)) {

				echo("<p>Configuration Saved</p>");


			}

		}

		include "forms/globalconf_form.php";


		break;

	case 'bconf' :

		echo("<h1>Blog Configuration</h1>");
		echo("<h2></h2>");

		if ($_GET['action'] == "submit") {

			if (blog_config(&$_POST)) {

				echo("<p>Configuration Saved</p>");

			}

		}

		include "forms/blogconf_form.php";

		break;

	case 'gbconf' :

		echo("<h1>Guestbook Configuration</h1>");
		echo("<h2></h2>");

		if ($_GET['action'] == "submit") {

			if (gb_config(&$_POST)) {

				echo("<p>Configuration Saved</p>");

			}

		}

		include "forms/gbconf_form.php";

		break;

	case 'galconf' :

		echo("<h1>Gallery Configuration</h1>");
		echo("<h2></h2>");

		if ($_GET['action'] == "submit") {

			if (gal_config(&$_POST)) {

				echo("<p>Configuration Saved</p>");

			}

		}

		include "forms/galconf_form.php";



		break;

		/*
			AUTHENTICATION
		 */
	case 'auth' :

		echo("<h1>Authentication</h1>");
		echo("<h2>Username & Password</h2>");
		echo("<p>Use this form to change your administration user and password.<br>");
		echo("If not using <i>HTTPS</i> the password is sent in clear text through network!!</p>");

		// Authentication form was submitted
		if ($_GET['action'] == "submit") {

			// Let's set global username and has variables and store them in database
			if ($username = $_POST['username']) set_config ("username",$username);

			if ($_POST['password']) {
				$hash = md5($_POST['password']);
				set_config ("password",$hash);
			}

			echo("<h3>Password submitted!</h3>");	
			echo("<p>You may have to close your browser and login again!</p>");

			// Output authentication form requesting new username and password;
		} else include "forms/auth_form.php";

		break;

	case 'style' :

		echo("<h1>Style Configuration</h1>");
		echo("<h2>Configure your home page look & feel</h2>");
		echo("<br><h3>Not implemented, edit style.css instead!</h3><br>");
		echo("<br><br>");

		break;

		/*
			MENU - LEFT NAVIGATION
		 */
	case 'lnav' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Left Navigation</h2>");
		echo("<h3>Use right menu to create entries</h3><br>");

		switch($_GET['action']) {

			case 'up' :

				if (!up_menu($_GET['id'], "", $_GET['option'])) {

					error("Could not move menu item up!");

				}

				break;

			case 'down' :

				if (!down_menu($_GET['id'], "", $_GET['option'])) {

					error("Could not move menu item!");

				}

				break;

			case 'del' :

				if (!remove_menu($_GET['id'], $_GET['option'])) {

					error("Could not delete menu item!");

				}

				break;
		}

		$lnav = get_left_content(0);

		if ($lnav) {

			// Used on a litle hack to get alternating row color on tables
			$c = "color2";

			echo("<table><tr class=color1><th>&nbsp;Type&nbsp;</th><th>&nbsp;Name&nbsp;</th>");
			echo("<th>&nbsp;Up&nbsp;</th><th>&nbsp;Down&nbsp;</th><th>&nbsp;Del&nbsp;</th>");
			echo("<th>&nbsp;Rnav&nbsp;</th></tr>");

			foreach ($lnav as $i) {

				echo("<tr class=$c><td>" . $i['c_type'] . "</td>");
				echo("<td width=200>&nbsp;" . $i['c_name'] . "&nbsp;</td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=lnav&action=up&id=");
				echo($i['ln_id'] . "><img border=0 vpsace=7 src=icons/up-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=lnav&action=down&id=");
				echo($i['ln_id'] . "><img border=0 vpsace=7 src=icons/down-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=lnav&action=del&id=");
				echo($i['ln_id'] . "><img border=0 vpsace=7 src=icons/delete-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=rnav&id=");
				echo($i['ln_id'] . "><img border=0 vpsace=7 src=icons/right-icon.png></a></td></tr>");

				// Here is the hack.
				if ($c == "color2") $c = "color1"; else $c = "color2";
			}

			echo("</table>");

		} else {

			echo("<br><h3>No left navigations found, please create them using right menu.</h3><br>");

		}

		break;

		/*
			MENU - RIGHT NAVIGATION
		 */
	case 'rnav' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Right Navigation</h2>");

		switch($_GET['action']) {

			case 'up' :

				if (!up_menu($_GET['rn'], $_GET['id'], "rnav")) {

					error("Could not move menu item!");

				}

				break;

			case 'down' :

				if (!down_menu($_GET['rn'], $_GET['id'], "rnav")) {

					error("Could not move menu item!");

				}

				break;

			case 'del' :

				if (!remove_menu($_GET['rn'], "rnav")) {

					error("Could not delete menu item!");

				}

				break;
		}

		$rnav = get_right_content($_GET['id'],0);

		if ($rnav) {

			// Used on a litle hack to get alternating row color on tables
			$c = "color2";

			echo("<table><tr class=color1><th>&nbsp;Type&nbsp;</th><th>&nbsp;Name&nbsp;</th>");
			echo("<th>&nbsp;Up&nbsp;</th><th>&nbsp;Down&nbsp;</th><th>&nbsp;Del&nbsp;</th></tr>");

			foreach ($rnav as $i) {

				echo("<tr class=$c><td>" . $i['c_type'] . "</td>");
				echo("<td width=200>&nbsp;" . $i['c_name'] . "&nbsp;</td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=rnav&action=up&id=" . $_GET['id'] . "&rn=");
				echo($i['rn_id'] . "><img border=0 vpsace=7 src=icons/up-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=rnav&action=down&id=" . $_GET['id'] . "&rn=");
				echo($i['rn_id'] . "><img border=0 vpsace=7 src=icons/down-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=2&option=rnav&action=del&id=" . $_GET['id'] . "&rn=");
				echo($i['rn_id'] . "><img border=0 vpsace=7 src=icons/delete-icon.png></a></td></tr>");

				// Here is the hack.
				if ($c == "color2") $c = "color1"; else $c = "color2";
			}

			echo("</table><br>");

		} else {

			echo("<br><h3>No right navigations found, please create them using right menu.</h3><br>");

		}

		echo("<a href=$PHP_SELF?ln=2&option=lnav><< Return left navigation</a>");

		break;

		/*
			MENU - ADD BLOG
		 */
	case 'addb' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Add a Blog to your home page</h2>");

		if ($_GET['action'] == "submit") {

			if (!$_POST['name']) {

				error("Blog name can not be empty!");

			} else if (!add_content($_POST['name'], $_GET['menu'], $_GET['id'], "B", "")) {

				error("Error adding blog!");

			} else {

				echo("<br><h3>Blog added!</h3><br>");

			}

			echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu']);
			if ($_GET['menu'] == "rnav") echo("&id=" . $_GET['id']); 
			echo("><< Return </a>"); 

		} else {

			if (!exists_content("B")) {    

				include "forms/addb_form.php";

			} else {

				error("You already have a Blog in your homepage!");
				echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu'] . "&id=" . $_GET['id'] . " ><< Return </a>");
			}

		}

		break;

		/*
			MENU - ADD GUESTBOOK
		 */
	case 'addg' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Add a GuestBook to your home page</h2");

		if ($_GET['action'] == "submit") {

			if (!$_POST['name']) {

				error("GuestBook name can not be empty!");
				echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu'] . "><< Return </a>"); 

			} else if (!add_content($_POST['name'], $_GET['menu'], $_GET['id'], "G", "")) {

				error("Could not add GuestBook!");

			} else {

				echo("<br><h3>GuestBook added!</h4><br>");

			}

			echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu']);
			if ($_GET['menu'] == "rnav") echo("&id=" . $_GET['id']); 
			echo("><< Return </a>"); 

		} else {

			if (!exists_content("G")) {    

				include "forms/addg_form.php";

			} else {

				error("You already have a guestbook in your homepage!");
				echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu'] . "&id=" . $_GET['id'] . " ><< Return </a>");
			}

		}

		break;

		/*
			MENU - ADD GALLERY
		 */
	case 'addi' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Add a Gallery to your homepage</h2>");

		if ($_GET['action'] == "submit") {

			if (!$gal_id = get_gallery_id($_POST['gal'])) {

				error("Could not retreive gallery id");
				echo("<a href=$PHP_SELF?ln=2&option=addi><< Return to menu management</a>");

			} else if (!add_content($_POST['name'], $_GET['menu'], $_GET['id'], "I", $gal_id)) {

				error("Could not add gallery content to menu!");

			} else {

				echo("<br><h3>Gallery content added!</h3><br>");

			}

			echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu']);
			if ($_GET['menu'] == "rnav") echo("&id=" . $_GET['id']); 
			echo("><< Return </a>"); 

		} else {

			if ($gals = get_gallery_name_list()) {

				include "forms/addi_form.php";

			} else {

				echo("<h3>No Galleries found!</h3>");
				echo("<h3>Please create some.</h3><br>");

			}

		}
		break;

		/*
			MENU - ADD HTML
		 */
	case 'addh' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Add HTML content to your home page</h2");

		if ($_GET['action'] == "submit") {

			if (!$html_id = get_html_id($_POST['file'])) {

				error("Could not retreive html id");
				echo("<a href=$PHP_SELF?ln=2&option=addh><< Return to menu management</a>");

			} else if (!add_content($_POST['name'], $_GET['menu'], $_GET['id'], "H", $html_id)) {

				error("Could not add HTML content to menu!");

			} else {

				echo("<br><h3>HTML content added!</h3><br>");

			}

			echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu']);
			if ($_GET['menu'] == "rnav") echo("&id=" . $_GET['id']); 
			echo("><< Return </a>"); 


		} else {

			if ($files = get_html_files()) {

				include "forms/addh_form.php";

			} else {

				echo("<h3>No HTML content found!</h3>");
				echo("<h3>Please upload some.</h3><br>");

			}

		}

		break;

		/* 
			MENU - ADD URL
		 */
	case 'addu' :

		echo("<h1>Menu Configuration</h1>");
		echo("<h2>Add an external link to your home page</h2>");

		if ($_GET['action'] == "submit") {

			if (!$link_id = get_link_id($_POST['link'])) {

				error("Could not retreive link id");

			} else if (!add_content($_POST['link'], $_GET['menu'], $_GET['id'], "U", $link_id)) {

				error("Could not add Link to menu!");

			} else {

				echo("<br><h3>Link added!</h3><br>");

			}

			echo("<a href=$PHP_SELF?ln=2&option=" . $_GET['menu']);
			if ($_GET['menu'] == "rnav") echo("&id=" . $_GET['id']); 
			echo("><< Return </a>"); 

		} else {

			$links = get_links(NOLGROUP);
		
			if ($links) {
				
				include "forms/addu_form.php";

			} else {

				echo("<br><h3>Your have not created any links!!</h3>");
				echo("<p>Use the Links menu to add some!<p><br>");
				echo("<a href=$PHP_SELF?ln=8&option=link><< Add Links</a>");

			}

		}

		break;

		/*
			BLOG CONFIGURATION
		 */	
	case 'blog' :

		echo("<h1>Blog Configuration</h1>");
		echo("<h2>Manage your Blog entries</h2>");

		if ($_GET['action'] == "resize") {

			resize_blog();

		} else if ($_GET['action'] == "del" && $_GET['id']) {

			delete_blog($_GET['id']);

		} else if ($_GET['action'] == "submit") {

			if (!$_POST['text']) {

				error("Text can not be empty!");

			} else {

				//										  error($_FILES['userfile']['name']);

				if (!insert_blog($_POST['text'], $_FILES['userfile'], $_POST['popup'])) {

					error("Failure to insert blog!");

				}

			}

		}

		include "forms/blog_form.php";

		$blog = get_blog(NOLIMIT);

		if ($blog) {

			$c = "color2";
			echo("<table><tr class=color1><th>Post Date</th>");
			echo("<th>Text<th>Preview</th><th>Edit</th><th>Del</th></tr>");

			foreach ($blog as $i) {

				echo("<tr class=$c><td>&nbsp;" . stripslashes($i['b_date']) . "&nbsp;</td>");
				echo("<td width=350>&nbsp;" . stripslashes($i['b_text']) . "&nbsp;</td>");
				echo("<td>");

				if ($i['b_picture']) {

					echo ("<img border=1 src=../" . get_bthumb_url($i['b_picture']) . ">");

				} else echo("-");

				echo("</td>");
				echo("<td>&nbsp;<a href=$PHP_SELF?ln=3&option=bedit");
				echo("&id=" . $i['b_id'] . ">");
				echo("<img border=0 src=icons/edit-icon.png></a>&nbsp;</td>");
				echo("<td>&nbsp;<a href=$PHP_SELF?ln=3&option=blog&action=del");
				echo("&id=" . $i['b_id'] . ">");
				echo("<img border=0 src=icons/delete-icon.png></a>&nbsp;</td></tr>");

				// Here is the hack.
				if ($c == "color2") $c = "color3"; else $c = "color2";
			}

			echo("</table>");

		} else {

			echo("<br><h3>Your Blog is still empty!</h3><br>");

		}

		break;

		/*
			BLOG EDIT
		 */	
	case 'bedit' :

		echo("<h1>Blog Configuration</h1>");
		echo("<h2>Edit Blog</h2>");

		if ($_GET['action'] == "submit") {

			if (!update_blog_item($_GET['id'], $_POST['text'], $_FILES['userfile'], $_POST['popup'])) {

				error("Failure to update blog");

			}

		} 

		$blog_item = get_blog_item($_GET['id']);

		if ($blog_item['b_picture']) 

			echo ("<img border=1 src=../" . get_bthumb_url($blog_item['b_picture']) . "><br><br><br>");

		include "forms/bedit_form.php";

		echo("<a href=$PHP_SELF?ln=3&option=blog><< Return to blog management</a>");

		break;


		/*
			GUESTBOOK CONFIGURATION
		 */
	case 'gb' :

		echo("<h1>GuestBook Configuration</h1>");
		echo("<h2>Manage your GuestBook entries</h2>");

		if ($_GET['action'] == "del" && $_GET['id']) {

			delete_guestbook($_GET['id']);

		}

		$guestbook = get_guestbook(NOLIMIT);

		if ($guestbook) {

			$c = "color2";

			echo("<table><tr class=color1><th width=64>Poster</th>");
			echo("<th>Post Date<th>Text</th><th>Del</th></tr>");

			foreach ($guestbook as $i) {

				echo("<tr class=$c><td>&nbsp;" . stripslashes($i['gb_name']) . "&nbsp;</td>");
				echo("<td>&nbsp;" . $i['gb_date'] . "&nbsp;</td>");
				echo("<td width=350>" . stripslashes($i['gb_text']) . "</td>");
				echo("<td>&nbsp;<a href=$PHP_SELF?ln=4&option=gb&action=del");
				echo("&id=" . $i['gb_id'] . ">");
				echo("<img border=0 src=icons/delete-icon.png></a>&nbsp;</td></tr>");

				// Here is the hack.
				if ($c == "color2") $c = "color3"; else $c = "color2";
			}

			echo("</table>");

		} else {

			echo("<br><h3>Your GuestBook is still empty!</h3><br>");
			echo("<br><br>");

		}

		break;

		/*
			GALLERY 
		 */
	case 'gal' :

		echo("<h1>Gallery</h1>");
		echo("<h2>Manage your Gallery pages</h2>");

		if ($_GET['action']) {

			if (!remove_gallery_item($_GET['id'])) {

				error("Could not delete Gallery!");

			}

		}

		$galleries = get_gallery();

		if ($galleries) {

			// Used on a litle hack to get alternating row color on tables
			$c = "color2";

			foreach ($galleries as $i) {

				$img = get_images($i['g_id'], 1);
				$file = get_thumb_url($img[0]['p_name'], $img[0]['p_folder']);

				echo("<table><tr class=$c><td width=" . get_config("thumb width") . ">");
				echo("<img border=0 vspace=7 src=$file"); 
				echo(" width=" . get_config("thumb width") . "></td>");
				echo("<td width=350><b>" . $i['g_name'] . "</b></td>");
				echo("<td width=65>" . $i['g_cols'] . "x" . $i['g_rows'] . "</td>");
				echo("<td>&nbsp;<a href=$PHP_SELF?ln=5&option=gedit");
				echo("&id=" . $i['g_id'] . ">");
				echo("<img border=0 src=icons/edit-icon.png></a>&nbsp;</td>");
				echo("<td>&nbsp;<a href=$PHP_SELF?ln=5&option=gal&action=del");
				echo("&id=" . $i['g_id'] . ">");
				echo("<img border=0 src=icons/delete-icon.png></a>&nbsp;</td></tr>");

				if ($i['g_text'])
					echo("<tr class=$c><td colspan=5>" . $i['g_text'] . "</td></tr>");

				echo("</table><br>");

				// Here is the hack.
				if ($c == "color2") $c = "color3"; else $c = "color2";
			}

		} else {

			echo("<h2>No Galleries found!</h2>");
			echo("<br><h3>Please select create gallery from the right menu.</h3><br><br>");

		}

		break;

		/* 
			GALLERY - GEDIT
		 */
	case 'gedit' :

		echo("<h1>Gallery</h1>");
		echo("<h2>Edit Gallery</h2>");

		if ($_GET['action'] == "submit") {

			// Validate user input
			if (!$_POST['name']) {

				error("Gallery must have a name!");
				echo("<a href=$PHP_SELF?ln=5&option=gedit&id=" . $_GET['id'] . "><< Retry</a>");

			} else if (!is_digits($_POST['cols']) || !is_digits($_POST['height'])) {

				error("Only digits allowed for cols and rows!");
				echo("<a href=$PHP_SELF?ln=5&option=gedit&id=" . $_GET['id'] . "><< Retry</a>");

			} else if (!$_POST['cols'] || !$_POST['rows']) {

				error("Width and Height can not be left blank!");
				echo("<a href=$PHP_SELF?ln=5&option=gedit&id=" . $_GET['id'] . "><< Retry</a>");

				// Update the gallery with the new validated values
			} else if (!update_gallery_item($_GET['id'], $_POST['name'], $_POST['cols'], 
						$_POST['rows'], $_POST['text'])) {

				error("Failed to update gallery!");
				echo("<a href=$PHP_SELF?ln=5&option=gal><< Return </a>");

			} else {

				echo("<br><h3>Gallery updated.</h3><br><br>");
				echo("<a href=$PHP_SELF?ln=5&option=gal><< Return </a>");

			}

		} else if ($gallery = get_gallery_item($_GET['id'])) {

			include "forms/gedit_form.php";	

		} else {

			error("Could not retreive gallery!");

		}

		break;

		/*
			GALLERY - CREATE
		 */
	case 'gcreate' :

		echo("<h1>Gallery</h1>");
		echo("<h2>Create a new Gallery page</h2>");

		if ($_GET['action'] == "submit") {

			// Validate user input
			if (!$_POST['name']) {

				error("Gallery must have a name!");
				echo("<a href=$PHP_SELF?ln=5&option=gcreate><< Retry</a>");

			} else if (!is_digits($_POST['cols']) || !is_digits($_POST['height'])) {

				error("Only digits allowed for cols and rows!");
				echo("<a href=$PHP_SELF?ln=5&option=gcreate><< Retry</a>");

			} else if (!$_POST['cols'] || !$_POST['rows']) {

				error("Width and Height can not be left blank!");
				echo("<a href=$PHP_SELF?ln=5&option=gcreate><< Retry</a>");

				// Insert the new gallery with the validated values
			} else if (!insert_gallery_item($_POST['name'], $_POST['cols'], $_POST['rows'], $_POST['text'])) {

				error("Failure to create a new gallery!");
				echo("<a href=$PHP_SELF?ln=5&option=gcreate><< Retry</a>");

			} else {

				echo("<br><br><h3>New Gallery created!</h3><br><br>");
				echo("<a href=$PHP_SELF?ln=5&option=gcreate><< Create Another</a>");

			}

		} else {

			include "forms/gcreate_form.php";

		}

		break;

		/*
			GALLERY - VIEW PICTURES
		 */
	case 'gview' :

		echo("<h1>Gallery</h1>");
		$gal = get_gallery_name($_GET['gid']);
		echo("<h2>$gal</h2>");

		switch($_GET['action']) {

			case 'up' :

				if (!up_image($_GET['id'], $_GET['gid'])) {

					error("Could not move image!");

				}

				break;

			case 'down' :

				if (!down_image($_GET['id'], $_GET['gid'])) {

					error("Could not move image!");

				}

				break;

			case 'del' :

				if (!remove_image($_GET['id'])) {

					error("Could not delete image!");

				}

				break;
		}

		// Retreives all images and respective details as a bi-dimensional array
		$images = get_images($_GET['gid'], 0);	

		if ($images) {

			// Used on a litle hack to get alternating row color on tables
			$c = "color1";

			foreach ($images as $i) {

				echo("<table>");

				if ($i['i_caption']) 
					echo("<tr class=$c><td colspan=6><b>" . $i['i_caption'] . "</b></td></tr>");

				// If thumbnail does not exists, let's create it now!
				if (!exists_thumb($i['p_folder'], $i['p_name']))
					thumb_picture($i['p_folder'], $i['p_name']);	

				$thumb = get_thumb_url($i['p_name'], $i['p_folder']);
				echo("<tr class=$c><td width=". get_config("thumb width") . "><img vspace=7 src=$thumb");
				echo(" width=" . get_config("thumb width") . "></td>");
				echo("<td width=250>" . $i['p_name'] . "</td>");
				echo("<td width=65>" . $i['i_width'] . "x" . $i['i_height'] . "</td>");
				echo("<td><a href=$PHP_SELF?ln=5&option=gview&action=up&gid=");
				echo($_GET['gid'] . "&id=" . $i['i_id'] . ">");
				echo("<img border=0 src=icons/up-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=5&option=gview&action=down&gid=");
				echo($_GET['gid'] . "&id=" . $i['i_id'] . ">");
				echo("<img border=0 src=icons/down-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=5&option=gview&action=del&gid=");
				echo($_GET['gid'] . "&id=" . $i['i_id'] . ">");
				echo("<img border=0 src=icons/delete-icon.png></a></td></tr>");

				if ($i['l_id']) {

					echo("<tr class=$c><td colspan=6>Linked to ");
					echo(get_link_name($i['l_id']) . "</td></tr>");

				}

				// Here is the hack.
				if ($c == "color2") $c = "color1"; else $c = "color2";

				echo("</table><br>");

			}

			echo("<br>");
			echo("<a href=$PHP_SELF?ln=5&option=gal><< Return Gallery</a>");

		} else {

			echo("<h3>This Gallery is empty, please add pictures.</h3><br><br>");
			echo("<a href=$PHP_SELF?ln=6&option=pic><< Picture Management</a>");

		}

		break;

		/*
			GALLERY - PICTURE SUBMISSION
		 */
	case 'gsubmit' :

		echo("<h1>Gallery</h1>");

		if ($_GET['action'] == "submit") {

			// Validate user input
			if (!is_digits($_POST['width']) || !is_digits($_POST['height'])) {

				error("Only digits allowed for width and height!");
				echo("<a href=$PHP_SELF?ln=5&option=gsubmit&id=" . $_GET['id'] . "><< Retry</a>");

			} else if (!$_POST['width'] || !$_POST['height']) {

				error("Width and Height can not be left blank!");
				echo("<a href=$PHP_SELF?ln=5&option=gsubmit&id=" . $_GET['id'] . "><< Retry</a>");

			} else {

				// Call insert_image in gal.php
				if (!insert_image($_GET['id'], $_POST['gid'], $_POST['caption'], 
							$_POST['width'], $_POST['height'], $_POST['lid'])) {

					error("Failure to insert image!");

				} else {

					echo("<br><br><h3>Image inserted!</h3><br><br>");

				}

				echo("<a href=$PHP_SELF?ln=6&option=pic><< Return to Pictures</a>");

			}

		} else {

			$gals = get_gallery_name_list();
			$links = get_links(NOLGROUP);

			// If we have at least one gallery item present, print add to gallery form
			if ($gals && $_GET['id']) {

				echo("<h2>Insert image details!</h2>");
				include "forms/img_form.php";

			} else {

				// If no, print apropriate message
				echo("<h2>Please create one Gallery menu item first!</h2>");
				echo("<br><br><a href=$PHP_SELF?ln=6&option=pic>");
				echo("<< Return to Pictures</a><br><br>");
			}
		}

		break;

		/*
			PICTURE MANAGEMENT - Upload Pictures
		 */
	case 'pic' :

		echo("<h1>Picture Management</h1>");
		echo("<h2>Select Folder and Upload pictures</h2><br>");

		// Upload picture form was submitted
		if ($_GET['action'] == "submit" && $_FILES['userfile']['size']) {

			// Test if we are able to move image file, create thumb and insert into database.
			if (insert_picture($_FILES['userfile'],$_POST[folder])) {
				echo("<br><h3>File Upload Successufull!</h3><br>");
			}

			echo("<a href=$PHP_SELF?ln=6&option=pic><< Upload Another</a>");

		} else if (!$folders = get_folders()) 

			echo("<br><h3>You must create at least one folder before you can upload files!</h3><br>");

		else include "forms/pic_form.php";

		break;

		/*
			PICTURE MANAGEMENT - Create Folder
		 */
	case 'fcreate' :

		echo("<h1>Picture Management</h1>");
		echo("<h2>Create Folder</h2>");

		if ($_GET['action'] == "submit" && $_POST['folder']) {

			// For security purposes let's stick to letters and digits
			if (!is_lettersdigits($_POST['folder'])) {

				error("Only letters and digits allowed!");
				echo("<a href=$PHP_SELF?ln=6&option=fcreate><< Go Back</a>");

			} else if (exists_folder($_POST['folder'])) {

				error("Folder already exists!");
				echo("<a href=$PHP_SELF?ln=6&option=fcreate><< Go Back</a>");

			} else if (!create_folder($_POST['folder'])) {

				error("Unable to create folder!"); 
				echo("<a href=$PHP_SELF?ln=6&option=fcreate><< Go Back</a>");

			} else { 

				echo("<br><h3>Folder Created!</h3><br>");
				echo("<a href=$PHP_SELF?ln=6&option=fcreate><< Create Another</a>");

			}

		} else include "forms/fcreate_form.php";

		break;

		/*
			PICTURE MANAGEMENT - Delete Folder
		 */
	case 'fdelete' :

		echo("<h1>Picture Management</h1>");
		echo("<h2>Delete Folder</h2>");

		if ($_GET['action'] == "submit") {

			if (!delete_folder($_POST['folder'])) {

				error("Unable to delete folder, remove all pictures first!");
				echo("<a href=$PHP_SELF?ln=6&option=fdelete><< Go Back</a>");

			} else {

				echo("<br><h3>Folder Deleted!</h3><br>");
				echo("<a href=$PHP_SELF?ln=6&option=fdelete><< Delete Another</a>");

			}

		} else if (!$folders = get_folders()) {

			echo("<br><h3>There are no folders to delete.</h3><br>");
			echo("<a href=$PHP_SELF?ln=6&option=pic><< Go Back</a>");

		} else include "forms/fdelete_form.php";

		break;

		/*
			PICTURE MANAGEMENT - Rename Folder
		 */
	case 'frename' :

		echo("<h1>Picture Management</h1>");
		echo("<h2>Rename Folder</h2>");

		if ($_GET['action'] == "submit") {

			if (!rename_folder($_POST['oldfolder'],$_POST['newfolder'])) {

				error("Unable to rename folder!");
				echo("<a href=$PHP_SELF?ln=6&option=frename><< Go Back</a>");

			} else {

				echo("<br><h3>Folder Renamed!</h3><br>");
				echo("<a href=$PHP_SELF?ln=6&option=frename><< Rename Another</a>");

			}

		} else if (!$folders = get_folders()) {

			echo("<br><h3>There are no folders to rename.</h3><br>");
			echo("<a href=$PHP_SELF?ln=6&option=pic><< Go Back</a>");

		} else include "forms/frename_form.php";

		break;

		/*
			PICTURE MANAGEMENT - Folder Preview
		 */
	case 'fpreview' :

		echo("<h1>Picture Management</h1>");
		$folder = $_GET['folder'];
		echo("<h2>Folder $folder</h2>"); 

		if ($_GET['action'] == "del") remove_picture($_GET['id']);	

		// Gets all files excluding dirs and thumbs on folder
		$pictures = get_pictures($folder);

		if ($pictures) {

			echo("<h3>Click on the gallery icons to create image pages</h3><br><br>");
			echo("<table><tr class=color1><th>&nbsp;Thumbnail&nbsp;</th><th>&nbsp;");
			echo("File Name&nbsp;</th><th>&nbsp;File Size&nbsp;</th><th>&nbsp;");
			echo("Delete&nbsp;</th><th>&nbsp;Add Gallery&nbsp;</th></tr>");

			// Used on a litle hack to get alternating row color on tables
			$c = "color2";

			foreach ($pictures as $i) {

				// If thumbnail does not exist, let's create it now!
				if (!exists_thumb($folder, $i)) thumb_picture($folder, $i);

				$thumb = get_thumb_url($i, $folder);
				echo("<tr class=$c><td><img vspace=7 src=$thumb></td><td width=250>$i</td>");

				// Here is the hack.
				if ($c == "color2") $c = "color1"; else $c = "color2";

				// Filesize looks better if expressed in Kbytes
				echo("<td>" . ceil(get_filesize($folder, $i)/1024) . "k</td>");
				echo("<td><a href=$PHP_SELF?ln=6&option=fpreview&folder=$folder");
				echo("&action=del&id=" . get_pictureid($folder, $i) . ">");
				echo("<img border=0 src=icons/delete-icon.png></a></td>");
				echo("<td><a href=$PHP_SELF?ln=5&option=gsubmit");
				echo("&id=" . get_pictureid($folder, $i) . ">");
				echo("<img border=0 src=icons/gallery-icon.png></a></td></tr>");

			}

			echo("</table<br><br>");
			echo("<a href=$PHP_SELF?ln=6&option=pic><< Upload Pictures</a>");

		} else {

			echo("<h3>This folder is empty.</h3><br><br>");
			echo("<a href=$PHP_SELF?ln=6&option=pic><< Upload Pictures</a>");

		}

		break;

		/*
			HTML
		 */
	case 'html' :

		echo("<h1>HTML Management</h1>");
		echo("<h2>Upload, edit and delete HTML files</h2>");

		// Upload form was submitted
		if ($_GET['action'] == "submit" && $_FILES['userfile']['size']) {

			if (!exists_html_file($_FILES['userfile']['name'])) {	

				// Test if we are able to move html file
				if (move_file($_FILES['userfile'], get_html_path($_FILES['userfile']['name']))) {

					if (add_html_file($_FILES['userfile']['name'])) {

						echo("<br><h3>File Upload Successufull!</h3><br><br>");

					}

				} 

			} else {

				echo("<h3>HTML file with same name already exists!</h3>");
				echo("<h3>Erase it before uploading another with same name.</h3><br><br>");

			}

			echo("<a href=$PHP_SELF?ln=7&option=html><< Return HTML management</a>");

		} else { 

			if ($_GET['action'] == "del" && $_GET['file']) {

				delete_html($_GET['file']);

			}

			include "forms/html_form.php";

			$html = get_html_files();

			if ($html) {

				echo("<table border=0><tr class=color1><th>&nbsp;File Name&nbsp;</th>");
				echo("<th>&nbsp;Size (Bytes)&nbsp;</th><th>&nbsp;Edit&nbsp;</th>");
				echo("<th>&nbsp;Delete&nbsp;</th></tr>");

				// Used on a litle hack to get alternating row color on tables
				$c = "color2";

				foreach ($html as $i) {

					$size = @filesize(get_html_path($i));

					echo("<tr class=$c><td>&nbsp;$i&nbsp;</td>");
					echo("<td>&nbsp;$size&nbsp;</td>");
					echo("<td>&nbsp;<a href=$PHP_SELF?ln=7&option=hedit&file=$i>");
					echo("<img border=0 vspace=7 src=icons/edit-icon.png></a>&nbsp;</td>");
					echo("<td>&nbsp;<a href=$PHP_SELF?ln=7&option=html&action=del&file=$i>");
					echo("<img border=0 vspace=7 src=icons/delete-icon.png></a>&nbsp;</td></tr>");

					// Here is the hack.
					if ($c == "color2") $c = "color3"; else $c = "color2";

				}

				echo("</table>");

			} 


		}

		break;

		/*
			HTML - EDIT
		 */
	case 'hedit' :

		echo("<h1>HTML Management</h1>");
		echo("<h2>Edit HTML </h2>");

		if ($_GET['action'] == "submit") {

			write_html_content($_GET['file'],$_POST['text']);

		}

		$text = get_html_content($_GET['file']);	

		include "forms/hedit_form.php";
		echo("<a href=$PHP_SELF?option=html>< Return to HTML management</a>");

		break;

	case 'link' :

		echo("<h1>Link Management</h1>");
		echo("<h2>Configure your links here</h2>");

		if ($_GET['action'] == "submit" && $_POST['lname'] && $_POST['lurl']) {

			if (insert_link($_POST['lgid'], $_POST['lname'], $_POST['lurl'])) {

				echo("<h3>Link inserted!</h3><br><br>");

			} else {

				error("Could not insert links!");

			}

			echo("<a href=$PHP_SELF?ln=8&option=link><< Insert Another</a>");

		} else if (!$lgroups = get_lgroups()) {

			echo("<br><h3>You must create at least one link group before you can insert links!</h3><br><br>");

		} else {

			include "forms/addl_form.php";

		}

		break;

	case 'lview' :

		echo("<h1>Link Management</h1>");
		$lgroup = get_lgname($_GET['lgid']);
		echo("<h2>Group $lgroup</h2>"); 

		if ($_GET['action'] == "del") remove_link($_GET['id']);	

		$links = get_links($_GET['lgid']);

		if ($links) {

			echo("<table><tr class=color1><th>&nbsp;Name&nbsp;</th><th>&nbsp;");
			echo("URL&nbsp;</th><th>&nbsp;Delete&nbsp;</th></tr>");

			// Used on a litle hack to get alternating row color on tables
			$c = "color2";

			foreach ($links as $i) {

				echo("<tr class=$c><td>&nbsp;" . $i['l_name']);
				echo("&nbsp;</td><td>&nbsp;" . $i['l_url'] . "&nbsp;</td>");

				// Here is the hack.
				if ($c == "color2") $c = "color1"; else $c = "color2";

				echo("<td><a href=$PHP_SELF?ln=8&option=lview&id=" . $i['l_id']);
				echo("&action=del&lgid=" . $_GET['lgid'] . ">");
				echo("<img border=0 src=icons/delete-icon.png></a></td>");

			}

			echo("</table<br><br>");
			echo("<a href=$PHP_SELF?ln=8&option=link><< Create Links </a>");

		} else {

			echo("<h3>This link group is empty.</h3><br><br>");
			echo("<a href=$PHP_SELF?ln=8&option=link><< Insert Links</a>");

		}

		break;

	case 'lcreate' :

		echo("<h1>Link Management</h1>");
		echo("<h2>Create Link Group</h2>");

		if ($_GET['action'] == "submit" && $_POST['lgroup']) {

			if (insert_lgroup($_POST['lgroup'])) {

				echo("<br><h3>Link group created!</h3><br>");

			} else error("Could not create link group!");

			echo("<a href=$PHP_SELF?ln=8&option=lcreate><< Create Another</a>");

		} else {

			include "forms/lcreate_form.php";

		}

		break;

	case 'ldelete' : 

		echo("<h1>Link Management</h1>");
		echo("<h2>Delete Link Group</h2>");

		if ($_GET['action'] == "submit") {

			if (exist_links($_POST['lgid'])) {

				error("Unable to delete link group, delete all links first!");
				echo("<a href=$PHP_SELF?ln=8&option=ldelete><< Go Back</a>");

			} else if (!delete_lgroup($_POST['lgid'])) {

				error("Unable to delete link group!");
				echo("<a href=$PHP_SELF?ln=8&option=ldelete><< Go Back</a>");

			} else {

				echo("<br><h3>Link Group Deleted!</h3><br>");
				echo("<a href=$PHP_SELF?ln=8&option=ldelete><< Delete Another</a>");

			}

		} else if (!$lgroups = get_lgroups()) {

			echo("<br><h3>There are no link groups to delete.</h3><br>");
			echo("<a href=$PHP_SELF?ln=8&option=link><< Go Back</a>");

		} else include "forms/ldelete_form.php";

		break;

	case 'lrename' :

		echo("<h1>Link Management</h1>");
		echo("<h2>Rename Link Group</h2>");

		if ($_GET['action'] == "submit") {

			if (!rename_lgroup($_POST['lgid'],$_POST['newlgroup'])) {

				error("Unable to rename link group!");
				echo("<a href=$PHP_SELF?ln=8&option=lrename><< Go Back</a>");

			} else {

				echo("<br><h3>Link Group Renamed!</h3><br>");
				echo("<a href=$PHP_SELF?ln=8&option=lrename><< Rename Another</a>");

			}

		} else if (!$lgroups = get_lgroups()) {

			echo("<br><h3>There are no link groups to rename.</h3><br>");
			echo("<a href=$PHP_SELF?ln=8&option=link><< Go Back</a>");

		} else include "forms/lrename_form.php";

		break;

		/*
			ABOUT PHPHOMESITE
		 */
	case 'about' :

		echo("<p>&nbsp;</p>");
		echo("<h1>PHP Home Site " . get_config("version") . "</h1><br>");
		echo("<h2>" . get_config("project copyright") . "</h2>");
		echo("<h3>A graphical icon of some sort would be pretty here..</h3>");
		echo("<br><br>");

		break;

}

echo("</div>");

?>
