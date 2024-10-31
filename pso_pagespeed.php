<?php 
/*
 * Plugin Name: Optimizer For Faster Websites
 * Description: Optimizer For Faster Websites will make your Website faster by caching and compressing files.
 * Author: 		Tobias Merz
 * Version:		1.0
 * License: 	GPLv2 or later
 */
?>
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
?>
<?php
 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
 * Browser Caching files
 */
require_once(plugin_dir_path(__FILE__) . 'adminpages/pso_admin.php');
require_once(plugin_dir_path(__FILE__) . 'pso_caching.php');  
require_once(plugin_dir_path(__FILE__) . 'pso_open_htaccess.php');
require_once(plugin_dir_path(__FILE__) . 'pso_caching_modified.php');

/*
 * General files
 */
require_once(plugin_dir_path(__FILE__) . 'adminpages/pso_gen_fct.php');
require_once(plugin_dir_path(__FILE__) . 'adminpages/pso_general.php');
?>