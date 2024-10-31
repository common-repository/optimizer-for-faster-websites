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


/* ------------------------------------------------------------------------ *
 * Stylesheet
 * ------------------------------------------------------------------------ */
// get styles
function pso_load_admin_style() {
	wp_enqueue_style(
			'admin_caching_style',
			plugins_url('css/style.css', dirname(__FILE__)));
}
// load stylesheet
add_action ('init', 'pso_load_admin_style');

/* ------------------------------------------------------------------------ *
 * JavaScript
* ------------------------------------------------------------------------ */
function pso_load_javascript_fkt() {
	wp_enqueue_script(
			'admin_caching_script',
			plugins_url( 'js/function.js', dirname(__FILE__)),
			array( 'jquery' )
	);
}
add_action( 'init', 'pso_load_javascript_fkt' );



class PSPO_PageSpeed_Optimize {
	
	
	/*
	 * Declaration of keys
	 */
	private $all_settings_key = 'all_settings';
	private $browser_caching_settings_key = 'browser_caching_settings';
	private $pagespeed_options_key = 'pagespeed_options';
	private $plugin_settings_tabs = array();
	
	/*
	 * Add actions
	 */
	function __construct() {
		add_action( 'init', array( &$this, 'pso_load_settings' ) );
		add_action( 'admin_init', array( &$this, 'pso_register_all_settings' ) );
		add_action( 'admin_init', array( &$this, 'pso_register_browser_caching_settings' ) );
		add_action( 'admin_menu', array( &$this, 'pso_add_admin_menus' ) );
	}

	/*
	 * Load settings and merges the values with defaults if thei are missing
	 */
	function pso_load_settings() {
		$this->all_settings = (array) get_option( $this->all_settings_key );
		$this->browser_caching_settings = (array) get_option( $this->browser_caching_settings_key );
		
		// Merge with defaults
		$this->all_settings = array_merge( array(
				'all_settings_option' => 'all settings value'
		), $this->all_settings );
		
		$this->browser_caching_settings = array_merge( array(
			'broswer_caching_option' => 'Browser Caching value'
		), $this->browser_caching_settings );
	}
	
	/*
	 * Register All Settings Tab
	 */
	function pso_register_all_settings() {
		$this->plugin_settings_tabs[$this->all_settings_key] = 'General';
		
		register_setting( $this->all_settings_key, $this->all_settings_key);
		
		// Instructions
		add_settings_section( 'section_all_settings_instr', 'Instructions', array( &$this, 'pso_section_all_settings_instructions' ), $this->all_settings_key );
		
		// Form field
		add_settings_section( 'section_all_settings_choice', 'PageSpeed Options', array( &$this, 'pso_section_all_settings_general' ), $this->all_settings_key );
		
		// load function
		add_settings_section( 'all_settings_option', '', array( &$this, 'pso_load_general_fkt' ), $this->all_settings_key );
	}
	
	/*
	 * Register Browser Caching settings
	 */
	function pso_register_browser_caching_settings() {
		$this->plugin_settings_tabs[$this->browser_caching_settings_key] = 'Browser Caching';
		
		register_setting( $this->browser_caching_settings_key, $this->browser_caching_settings_key );
		// Load varibales and call fucntions
		add_settings_section( 'browser_caching_option', '', array( &$this, 'pso_field_browser_caching_option' ), $this->browser_caching_settings_key );
		
		// Modification field
		add_settings_section( 'section_browser_caching_mod', 'Modify Expires', array( &$this, 'pso_section_browser_caching_modify' ), $this->browser_caching_settings_key );
		
		// Activate without modification
		add_settings_section( 'section_browser_caching_non', 'Check your .htacceess file...', array( &$this, 'pso_activate_browser_caching' ), $this->browser_caching_settings_key );
		
			
	}
		
	/*
	 * START GENERAL TAB
	 * 
	 * Description
	 */
	function pso_section_all_settings_instructions() {
		echo '
				<p>If you easily want to activate Browser Caching and GZIP Compression check the checkboxes below and save the settings.</p>
				<p>You may also want to <b>modiy the expiration time</b> of Browser Caching. Go to the Browser Caching tab to modify the Expires.</p>
				';
	}
	/*
	 * Form field
	 */
	function pso_section_all_settings_general() {
		echo '
				<form id="general" method="post" action="">
					<input type="hidden" name="general_hidden_pso" value="Y">
						<p>
							<b>Browser Caching &nbsp; &nbsp; &nbsp;</b>
								<input type="checkbox" name="caching" value="caching" >
						</p>
						<p>
							<b>GZIP Compression &nbsp; &nbsp;</b>
								<input type="checkbox" name="gzip" value="gzip">
						</p>
				<br>
					<p>
						<input class="button button-primary" type="submit" name="submit6" id="modified_cach_submit" value="save settings" />
			</form>
				';
	}
	
	/*
	 * Load general function
	 */
	function pso_load_general_fkt() {
		require_once( plugin_dir_path(__FILE__) . 'pso_general.php' );
	}
	/*
	 * END GENERAL TAB
	 */
	
	/*
	 * START BROWSER CACHING TAB
	 * 
	 */
	
	/*
	 * Modifications field
	 */
	function pso_section_browser_caching_modify() {
		
		echo '
	<p>Click the button below to modify the time spans of the caching.</p>
	<h4>Note:</h4>
	<p>If you already have activated Browser Caching before you can not change the time spans here!</p>
	<p>Read the FAQ section for more Info.</p>
	<input class="button button-primary" type="submit" name="modify" id="modify_button" value="modify Expires" />
	<div id="modify_form" class="mod">
		<form id="modify" method="post" action="">
			<input type="hidden" name="modified_hidden_pso" value="Y">
			<p>
				<b>CSS:</b> &nbsp;ExpiresByType text/css "access plus <input type="number" name="css_number" min="1" max="9" required>
					<input type="radio" name="css_time" value="week" checked>Week
					<input type="radio" name="css_time" value="month">Month
			"</p>
			<p>
				<b>JacaScript:</b> &nbsp;ExpiresByType text/javascript "access plus <input type="number" name="js_number" min="1" max="9" required>
					<input type="radio" name="js_time" value="week">Week
					<input type="radio" name="js_time" value="month" checked>Month
			"</p>
			<p>
				<b>HTML:</b> &nbsp;ExpiresByType text/html "access plus <input type="number" name="html_number" min="1" max="9" required>
					<input type="radio" name="html_time" value="week" >Week
					<input type="radio" name="html_time" value="month" checked>Month
			"</p>
			<p>
				<b>JPEG:</b> &nbsp;ExpiresByType image/jpeg "access plus <input type="number" name="jpeg_number" min="1" max="9" required>
					<input type="radio" name="jpeg_time" value="week" >Week
					<input type="radio" name="jpeg_time" value="month" checked>Month
			"</p>
			<p>
				<b>PNG:</b> &nbsp;ExpiresByType image/png "access plus <input type="number" name="png_number" min="1" max="9" required>
					<input type="radio" name="png_time" value="week" >Week
					<input type="radio" name="png_time" value="month" checked>Month
			"</p>
				<input class="button button-primary" type="submit" name="submit3" id="modified_cach_submit" value="activate modified Browser Caching" />
		</form>
		<h4>NOTE:</h4>
			<p>If you already activated Browser Caching before, you can not modify the values here!</p>
			<p>Before modifying the values you have to delete the hole Browser Caching block from your .htaccess.</p>
				<hr class="line"></hr>
	</div><br><br><br>
				';
	}
	
	/*
	 * Check .htaccess
	 */
	function pso_activate_browser_caching() {
		echo '
			<form id="open_form" method="post" action="">
				<div class="submit">
					<input class="button button-primary" type="submit" name="submit2" id="cach_submit" value="check .htaccess file" />
				</div>
			</form>
				';
		/*
		 * CALL PSO_OPEN FUNCTION
		 */
		if ( isset($_POST ['submit2']) ) {
			echo "<h3>The Code below shows the actual impact of your .htaccess file</h3>";
			$do = pso_open();
			if($do){
				echo "Can not open file!";
				exit();
			}
		}
	}

	/*
	 * Load variables and call fuctions
	 */
	function pso_field_browser_caching_option() {
		require_once(plugin_dir_path(__FILE__) . 'pso_browser_caching_variables.php');
	}
	/*
	 * END BROWSER CACHING TAB
	 */
	
	/*
	 * Submenu Page
	 */
	function pso_add_admin_menus() {
		add_submenu_page( 'tools.php', 'PageSpeed Optimize', 'PageSpeed Optimize', 'manage_options', $this->pagespeed_options_key, array( &$this, 'plugin_options_page' ) );
	
	}
	
	/*
	 * Plugins Option Page
	 */
	function plugin_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->all_settings_key;
		?>
		<div class="wrap">
			<?php $this->plugin_options_tabs(); ?>
			
				<?php wp_nonce_field( 'update-options' ); ?>
				<?php settings_fields( $tab ); ?>
				<?php do_settings_sections( $tab ); ?>
		</div>
		<?php
		
	}
	
	/*
	 * Current tab
	 */
	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->all_settings_key;

		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->pagespeed_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
		}
		echo '</h2>';
	}
};

// Initialize the plugin
add_action( 'plugins_loaded', create_function( '', '$pspo_pagespeed_optimize = new PSPO_PageSpeed_Optimize;' ) );?>