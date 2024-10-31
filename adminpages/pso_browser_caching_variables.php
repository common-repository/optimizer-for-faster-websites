<?php 
/*
 * Optimizer For Faster Websites
 * Copyright (C) 2015  Tobias Merz

 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/*
 * MODIFIED VALUES
 */
if( @$_POST['modified_hidden_pso'] == 'Y') {
	// CSS
	// number at css field
	$css_number = $_POST['css_number'];
	update_option('css_number', $css_number);
	// month or week at css field
	$css_time = $_POST['css_time'];
	update_option('css_time', $css_time);
	// JAVASCRIPT
	// number at js field
	$js_number = $_POST['js_number'];
	update_option('js_number', $js_number);
	// month or week at js field
	$js_time = $_POST['js_time'];
	update_option('js_time', $js_time);
	// HTML
	// number at html field
	$html_number = $_POST['html_number'];
	update_option('html_number', $html_number);
	// month or week at html field
	$html_time = $_POST['html_time'];
	update_option('html_time', $html_time);
	// JPEG
	// number at jpeg field
	$jpeg_number = $_POST['jpeg_number'];
	update_option('jpeg_number', $jpeg_number);
	//month or week at jpeg field
	$jpeg_time = $_POST['jpeg_time'];
	update_option('jpeg_time', $jpeg_time);
	// PNG
	// number at png field
	$png_number = $_POST['png_number'];
	update_option('png_number', $png_number);
	// month or week at png field
	$png_time = $_POST['png_time'];
	update_option('png_time', $png_time);
}

/*
 * CALL PSO_MODIFIED_CACHING FUNCTION
 */
if ( isset($_POST ['submit3']) ) {
	$do = pso_modified_caching();
}
?>