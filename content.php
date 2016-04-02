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

include "include/html.php";
include "include/navigation.php";
include "include/blog.php";
include "include/guestbook.php";
include "include/gal.php";
include "include/files.php";
include "include/pictures.php";


echo("<div class=content>");

// Check if this is the base URL
if (!$_GET["mod"]) {

	// Fetch the first entry of the menu
	if ($start_content = get_left_content(1)) {

		$_GET['mod'] = $start_content[0]['c_type']; // Set the HTTP GET mod variable to the proper content type

	} else $_GET['mod'] = "N";

	if ($start_content[0]['c_type'] == 'H') {

		$_GET['id'] = $start_content[0]['c_id'];

	} else if ($start_content[0]['c_type'] == 'I') {

			if (!$_GET['id'] = get_table_id($start_content[0]['c_id'])) {

				error("Could not get gallery info!");

			}

	}

}

switch ($_GET["mod"]) {

	// Blog Module Output
	case 'B' :

		if (!$blogname = get_config("blog name")) {  

			$blogname = get_blog_name();
			set_config("blog name", $blogname);

		} 

		echo("<h1>$blogname</h1>");

		// Set number of blog items per page to unlimited if not defined before
		if (!$blimit = get_config("blog limit")) set_config("blog limit", NOLIMIT);

		// Spliting blog through several pages should go here
		if (!$blog = get_blog($blimit)) {

			error("Could not get blog content!");
			break;

		}

		foreach ($blog as $row) {

			echo("<p>&nbsp;</p>");
			echo("<p>" . $row[b_date] . "</p>");
			echo("<table><tr><td>");

			if ($row[b_picture]) {

				if ($row[b_popup] == "y") {

					if ($size = get_size(get_blog_path($row[b_picture]))) {

						echo("<a href=\"javascript:popup('");
						echo(get_blog_url($row[b_picture])); 
						echo("'," . $size[x] . "," . $size[y] . ");\">");
						echo("<img class=blog border=0 src=" . get_bthumb_url($row[b_picture]) . "></a>");

					} else echo("<img class=blog border=0 src=" . get_bthumb_url($row[b_picture]) . ">");

				} else echo("<img class=blog border=0 src=" . get_bthumb_url($row[b_picture]) . ">");

			}

			echo("</td>");
			echo("<td class=blog>" . stripslashes($row[b_text]) . "</td></tr></table><hr width='60%'>");

		}

		break;

		// GestBook Module Output
	case 'G' :

		if (!$gbname = get_config("guestbook name")) {

			$gbname = get_guestbook_name();
			set_config("guestbook name", $gbname);

		} 

		echo("<h1>$gbname</h1>");

		if ($_GET['option'] == "submit" && $_POST['poster'] && $_POST['text']) {

			if (!insert_guestbook($_POST['poster'], $_POST['text'])) {

				error("Unable to insert your comments!");

			} else {

				echo("<h3>Thanks for submitting!</h3>");

			}

		} 

		// Set number of guestbook items per page to unlimited if not defined before
		if (!$gblimit = get_config("guestbook limit")) set_config("guestbook limit", NOLIMIT);

		$guestbook = get_guestbook($gblimit);

		if ($guestbook) foreach ($guestbook as $row) {

			echo("<p>&nbsp;</p>");
			echo("<p><h3> .: " . stripslashes($row[gb_name]) . " :. </h3>Date : " . $row[gb_date] . "</p>");
			echo("<p>&nbsp;<div id=commentdiv>");
			echo(stripslashes($row[gb_text]));
			echo("</div></p><p>&nbsp;</p><hr width=60%>");

		}

		include "forms/gb_form.php";

		break;

		// Gallery Module Output
	case 'I' :

		if (!$gal = get_gallery_item($_GET['id'])) {

			error("Could not get gallery details!"); 
			break;

		} 

		echo("<h1>" . $gal['g_name'] . "</h1>");
		echo("<h2>" . $gal['g_text'] . "</h2>");

		if (!$images = get_images($_GET['id'],NOLIMIT)) {

			error("Could not get gallery content!");
			break;

		}

		$col = 0;
		echo("<table cellpadding=10 cellspacing=10 border=0><tr>");

		foreach ($images as $row) {

			if (!file_exists(get_sized_path($row['p_name'], $row['p_folder']))) {

			// Create picture according to size
			 create_sized_picture($row['p_folder'], $row['p_name'], $row['i_width'], $row['i_height']);

			}

			$href = get_link_url($row['l_id']);

			echo("<td height=100% align=center valign=top>");
			echo("<table id=gallery border=0><tr><td align=center>");
			if ($href) echo("<a href=$href>");
			echo("<img border=0 src=" . get_sized_url($row['p_name'], $row['p_folder']) . "></td></tr>");
			if ($href) echo("</a>");
			echo("<tr><td valign=bottom align=center>" . stripslashes($row['i_caption']) . "</td></tr></table></td>");

			if (++$col == $gal['g_cols']) {

				echo("</tr><tr>");
				$col = 0;

			}

		}

		echo("</tr></table>");

		break;

		// HTML file Output
	case 'H' :

		$text = render_html($_GET['id']);

		if ($text == FALSE) {

			error("Could not render HTML!");

		} else echo $text;

		break;

	case 'N' :

		echo("<h1>Content</h1>");
		echo("<h2>Content area empty</h2>");
		echo("<h3>Click <a href=admin>here</a> to access the admin interface.</h3>");

		break;

		// Default Output
	default :

		echo("<h1>Content</h1>");
		echo("<h3>External Link is configured as 1st menu option</h3>");
		echo("<p>The first menu option is used to display homepage content<br>");
		echo("For that reason, having an external link configured as your homepage<br>");
		echo("does not seem to be a good idea.</p>");

}

echo("<br><br><p><a title=\"\" href=$url>&lt; Return to Home</a></p>");

echo("</div>");

?>
