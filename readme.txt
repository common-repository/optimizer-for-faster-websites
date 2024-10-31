=== Optimizer For Faster Websites ===
Contributors: tobias_.MerZ
Donate link: 
Tags: Caching, Browser Caching, SEO, GZIP, GZIP Compression, Compression, PageSpeed, Page Speed, faster website
Requires at least: 3.0.1
Tested up to: 4.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Optimizer For Faster Websites will make your Website faster by caching and compressing files.

== Description ==
With this Plugin you can activate Browser Caching and GZIP Compression on your Apache Webserver.
With Browser Caching you can tell Browsers when your files usually change, e.g. every month, every week, etc. This will speed up your website because Browser will only make requests to your Server after the declared time. PageSpeed is a Google Ranking Factor so it is important to have a fast website. 
There a several ways to enable Browser Caching. This Plugin uses Expires. The following code will be added to your .htaccess file:
ExpiresActive On

ExpiresByType text/css "access plus 1 month"

ExpiresByType text/javascript "access plus 1 month"

ExpiresByType text/html "access plus 1 month"

ExpiresByType application/javascript "access plus 1 month"

ExpiresByType application/x-javascript "access plus 1 month"

ExpiresByType application/xhtml-xml "access plus 1 month"

ExpiresByType image/gif "access plus 1 month"

ExpiresByType image/jpeg "access plus 1 month"

ExpiresByType image/png "access plus 1 month"

ExpiresByType image/x-icon "access plus 1 month"

With GZIP Compression your files will be compressed before they get sent to the client. This also makes your Website faster. The following code will be added to your .htaccess file:
<IfModule mod_deflate.c>

<IfModule mod_headers.c>

Header append Vary User-Agent env=!dont-vary

</IfModule>

<IfModule mod_filter.c>

AddOutputFilterByType DEFLATE text/css text/x-component application/x-javascript application/javascript text/javascript text/x-js text/html text/richtext image/svg+xml text/plain text/xsd text/xsl text/xml image/x-icon application/json

<IfModule mod_mime.c>

# DEFLATE by extension

AddOutputFilter DEFLATE js css htm html xml

</IfModule>

</IfModule>

</IfModule>

== Installation ==
1. Upload the plugin directory 'pso_pagespeed_optimize' to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Tools' in the Dashboard Sidebarand look for 'PageSpeed Optimize'.

== Frequently Asked Questions ==

== Screenshots ==
1. 'General Tab' where you can activate Browser Caching and GZIP Compression with default settings.
2. 'Browser Caching Tab' where you can modify the expiration time and check the impact of your .htaccess file.
3. Modification Form of Browser Caching.
4. The impact of the .htaccess file after you activated Browser Caching and GZIP Compression.
5. Error message if you are already using Browser Caching and try to activate it again.

== Changelog ==