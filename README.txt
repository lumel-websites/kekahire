=== KekaHire for WordPress ===
Contributors: kgkrishnalmt,amanslt
Tags: jobs, listing, keka
Requires at least: 5.8.0
Tested up to: 5.8.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a WordPress plugin that connects with the KekaHire job portal to fetch and list jobs open within your organization 

== Description ==

=== What is KekaHire? ===

KekaHire is a Hiring platform that comes equipped with all the tools and features to make your hiring process more streamlined 
and sophisticated at the same time. With integration between Keka recruitment management software and HRMS, you can manage your 
candidates and hiring proceedings all at one go. 

=== What does this plugin do? ===

KekaHire for Wordpress connects with the KekaHire platform to fetch and display job listings from your organization account and displays
them in a theme agnostic layout along with options to filter jobs based on departments and locations. Layout options include:
1. simple listing with static filters
1. smart listing with dynamic filters
1. grid listing with search and filters header

== Installation ==

1. Upload `kekahire-1.1.0.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[kekajobs]` shortcode in your templates


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= v1.1.0 =
* Update: Keka API URLs updated with new endpoints
* Fix: Countries class conflict with Chargebee API
* Fix: Admin Fatal error on fresh plugin installation fixed

= 1.0.0 =
* Initial release.
* Admin setting to specify organization subdomain and exclusion list
* `[kekajobs]` shortcode along with layout and filter parameters
* Shortcode generator with options to select filters and layouts



