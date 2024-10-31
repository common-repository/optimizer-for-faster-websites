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

require_once( plugin_dir_path(__FILE__) . 'pso_general.php' );
if( @$_POST['general_hidden_pso'] == 'Y') {
	$caching = isset($_POST['caching']) ? $_POST['caching'] : '';
	update_option('caching', $caching);
	$gzip = isset($_POST['gzip']) ? $_POST['gzip'] : '';
	update_option('gzip', $gzip);
	
}

if ( isset($_POST ['submit6']) ) {
	$do = pso_general_settings_fkt();
}