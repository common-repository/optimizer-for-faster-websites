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

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function pso_general_settings_fkt() {
	
	$file = ABSPATH .'.htaccess';
	$caching = get_option('caching');
	$gzip = get_option('gzip');

	/*
	 * Only GZIP
	 */
	if ($gzip === 'gzip' && $caching != 'caching' ) {
		
		$entry  = '' . "\n";
		$entry .= '# START GZIP COMPRESSION' . "\n";
		$entry .= '<IfModule mod_deflate.c>' . "\n";
		$entry .= '<IfModule mod_headers.c>' . "\n";
		$entry .= 'Header append Vary User-Agent env=!dont-vary' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '<IfModule mod_filter.c>' . "\n";
		$entry .= 'AddOutputFilterByType DEFLATE text/css text/x-component application/x-javascript application/javascript text/javascript text/x-js text/html text/richtext image/svg+xml text/plain text/xsd text/xsl text/xml image/x-icon application/json' . "\n";
		$entry .= '<IfModule mod_mime.c>' . "\n";
		$entry .= '# DEFLATE by extension' . "\n";
		$entry .= 'AddOutputFilter DEFLATE js css htm html xml' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '# END GZIP COMPRESSION' . "\n";
		$entry .= '' . "\n";
		
		/*
		 * Check if you are already using gzip compression
		 */
		$gzip_string = 'AddOutputFilterByType';
		$handle = fopen($file, 'r');
		$valid = false; // init as false
		while (($buffer = fgets($handle)) !== false) {
			if (strpos($buffer, $gzip_string) !== false) {
				$valid = TRUE;
				break; // Once you find the string, you should break out the loop.
			}
		}
		fclose($handle);
		if ($valid) {
			
				echo '<div class="error"><h2 >It seems that you are already using GZIP Compression. Please check you\'re .htaccess file.</h2></div>';
		 
				} else {
		
			/*
			 * WRITING THE INSERTS OF GZIP
			 */
			
				if (file_exists($file)) {
				
					if(is_writable($file)) {
				
						if (!$handle = fopen($file, "a")) {
							echo '<div class="error"><h2>Can not open the file. You have to change file permissions</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
						}
				
						if( !fwrite($handle, $entry)) {
							echo '<div class="error"><h2>Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
						}
				
						echo'
						<div class="updated">
						<h2>PERFECT</h2>
						<h3>You are now using GZIP COMPRESSION!</h3>
						</div>';
						fclose($handle);
					}else {
						echo '<div class="error"><h2 >Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p>
						<p>After you have changed file permissions try again.</p>
						</div>';
					}
				}else {
					echo '<div class="error"><h2 >No .htacces file was found in your root directory. Probably your website does not run on an Apache Server.</h2></div>';
				}
			}
	}	
	/*
	 * Only Caching
	 */
	elseif ($caching === 'caching' && $gzip != 'gzip' ) {
		
		$entry  = "\n";
		$entry .= '# START Browser Caching'. "\n";
		$entry .= '<IfModule mod_expires.c>'. "\n";
		$entry .= 'ExpiresActive On'. "\n";
		$entry .= 'ExpiresByType text/css "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType text/javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType text/html "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/x-javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/xhtml-xml "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/gif "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/jpeg "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/png "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/x-icon "access plus 1 month"'. "\n";
		$entry .= '</IfModule>'. "\n";
		$entry .='# END Caching'. "\n";
		
		/*
		 * Check if you are already using BROWSER CACHING	
		 */
		$bc_string = 'ExpiresByType';
		$handle = fopen($file, 'r');
		$valid = false; // init as false
		while (($buffer = fgets($handle)) !== false) {
			if (strpos($buffer, $bc_string) !== false) {
				$valid = TRUE;
				break; // Once you find the string, you should break out the loop.
			}
		}
		fclose($handle);
		if ($valid) {
				echo '<div class="error"><h2 >It seems that you are already using Browser Caching. Please check you\'re .htaccess file.</h2></div>';
		
				} else {
		
			/*
			 * WRITING THE INSERTS OF BROWSER CACHING
			 */
			
				if (file_exists($file)) {
				
					if(is_writable($file)) {
				
						if (!$handle = fopen($file, "a")) {
							echo '<div class="error"><h2>Can not open the file. You have to change file permissions</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
						}
				
						if( !fwrite($handle, $entry)) {
							echo '<div class="error"><h2>Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
						}
				
						echo'
						<div class="updated">
						<h2>PERFECT</h2>
						<h3>You are now using BROWSER CACHING!</h3>
						</div>';
						fclose($handle);
					}else {
						echo '<div class="error"><h2 >Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p>
						<p>After you have changed file permissions try again.</p>
						</div>';
					}
				}else {
					echo '<div class="error"><h2 >No .htacces file was found in your root directory. Probably your website does not run on an Apache Server.</h2></div>';
				}
			}
	} 
	/*
	 * GZIP and Caching
	 */
	elseif ($caching === 'caching' && $gzip === 'gzip') {
		
		$entry  = '' . "\n";
		$entry .= '# START GZIP COMPRESSION' . "\n";
		$entry .= '<IfModule mod_deflate.c>' . "\n";
		$entry .= '<IfModule mod_headers.c>' . "\n";
		$entry .= 'Header append Vary User-Agent env=!dont-vary' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '<IfModule mod_filter.c>' . "\n";
		$entry .= 'AddOutputFilterByType DEFLATE text/css text/x-component application/x-javascript application/javascript text/javascript text/x-js text/html text/richtext image/svg+xml text/plain text/xsd text/xsl text/xml image/x-icon application/json' . "\n";
		$entry .= '<IfModule mod_mime.c>' . "\n";
		$entry .= '# DEFLATE by extension' . "\n";
		$entry .= 'AddOutputFilter DEFLATE js css htm html xml' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '</IfModule>' . "\n";
		$entry .= '# END GZIP COMPRESSION' . "\n";
		$entry .= '' . "\n";
		$entry .= '# START Browser Caching'. "\n";
		$entry .= '<IfModule mod_expires.c>'. "\n";
		$entry .= 'ExpiresActive On'. "\n";
		$entry .= 'ExpiresByType text/css "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType text/javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType text/html "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/x-javascript "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType application/xhtml-xml "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/gif "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/jpeg "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/png "access plus 1 month"'. "\n";
		$entry .= 'ExpiresByType image/x-icon "access plus 1 month"'. "\n";
		$entry .= '</IfModule>'. "\n";
		$entry .='# END Caching'. "\n";
		
		/*
		 * Check if you are already using browser caching or gzip compression
		 */
		$bc_string = 'ExpiresByType';
		$gzip_string = 'AddOutputFilterByType DEFLATE';
		$handle = fopen($file, 'r');
		$valid_g = false; 
		$valid_b = false;
		while (($buffer = fgets($handle)) !== false) {
			if (strpos($buffer, $bc_string) !== false) {
				$valid_b = 'bc';
				break; 
			} elseif (strpos($buffer, $gzip_string) !== false) {
				$valid_g = 'gzip';
				break; 
			} 
		}
		fclose($handle);
		if ($valid_b == 'bc') {
			echo '<div class="error"><h2 >It seems that you are already using Browser Caching. Please check you\'re .htaccess file.</h2>
					<p>Pleas uncheck the Browser Caching checkbox and try again.</p></div>';
		}
		elseif ($valid_g == 'gzip') {
			echo '<div class="error"><h2 >It seems that you are already using GZIP Comrpession. Please check you\'re .htaccess file.</h2>
					<p>Pleas uncheck the Gzip checkbox and try again.</p></div>';
		} 
		else {
		
			/*
			 * WRITING THE INSERTS OF GZIP
			 */
				
			if (file_exists($file)) {
		
				if(is_writable($file)) {
		
					if (!$handle = fopen($file, "a")) {
						echo '<div class="error"><h2>Can not open the file. You have to change file permissions</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
					}
		
					if( !fwrite($handle, $entry)) {
						echo '<div class="error"><h2>Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p></div>';
					}
		
					echo'
						<div class="updated">
						<h2>PERFECT</h2>
						<h3>You are now using BROWSER CACHING and GZIP COMPRESSION!</h3>
						</div>';
					fclose($handle);
				}else {
					echo '<div class="error"><h2 >Can not write the file. You have to change file permissions.</h2>
						<p>Look how to change file permissions under this <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">WordPress Documentation</a></p>
						<p>After you have changed file permissions try again.</p>
						</div>';
				}
			}else {
				echo '<div class="error"><h2 >No .htacces file was found in your root directory. Probably your website does not run on an Apache Server.</h2></div>';
			}
		}
	}	
}
?>