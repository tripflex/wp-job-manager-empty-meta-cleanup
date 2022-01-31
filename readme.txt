=== Empty Meta Cleanup for WP Job Manager ===
Contributors: tripflex
Tags: wp job manager, meta, cleanup, wpjobmanager
Requires at least: 5.2
Tested up to: 5.9
Requires PHP: 5.6
Stable tag: 1.0.0
Network: true
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Author URI: https://smyl.es
Plugin URI: https://github.com/tripflex/wp-job-manager-empty-meta-cleanup
Text Domain: wp-job-manager-empty-meta-cleanup
Domain Path: /languages

Automatically prune empty meta from being saved to database when using WP Job Manager, WP Job Manager Resumes, Cariera (Companies), Company Manager, Astoundify Company Listings, and MAS Company Manager.

== Description ==

Anytime WP Job Manager or related plugins (WP Job Manager Resumes, Cariera (Companies), Company Manager, Astoundify Company Listings, and MAS Company Manager) saves a listing, it does so for every field configured, even if there is no value to be saved.

This can result in a large amount of empty meta values stored in the database, ultimately causing slower query times, a larger database, and issues with querying for listings based on meta values (when using Search and Filtering for WP Job Manager).

Configuration can be found under the "Meta" tab in the associated Settings page (Job, Resume, or Companies).

You can contribute to this project on GitHub:
https://github.com/tripflex/wp-job-manager-empty-meta-cleanup

It's also STRONGLY recommended that you also install the Index WP MySQL for Speed plugin
https://wordpress.org/plugins/index-wp-mysql-for-speed/

== Frequently Asked Questions ==
= How do I cleanup existing empty meta? =

To cleanup existing empty meta entries in the database, you must be have either the WP Job Manager Field Editor 1.12.2+ or Search and Filtering for WP Job Manager 1.1.9+ plugin installed and activated.  The code that handles that is included in those plugins, and is not something included with this plugin.

= Do I really need this? =

It depends. Does your theme or another plugin add custom fields outside the default WP Job Manager (or associated) fields? Have you changed any of the fields to optional? Are you
using the WP Job Manager Field Editor or Search and Filtering for WP Job Manager addons? If you answered yes to any of these, then yes.

= How does it work? =

Currently the method used to handle this is by looping through all the fields after the core plugin saves the listing, checking if those values were actually submitted when the
listing was saved, and if they are not, it deletes the meta from the database. In an upcoming release the core plugins will be short-circuited when they attempt to save the meta,
but for now we just delete the empty meta value after it's added to the database.

= Can I exclude specific fields? =

Yes you can, please check GitHub project for associated filters that can be used (a UI will be added in a later release for this)

= How else can I speed up my site and database? =

I strongly recommend also using the "Index WP MySQL for Speed" plugin to add indexes to your database:
https://wordpress.org/plugins/index-wp-mysql-for-speed/

== Changelog ==

= 1.0.0 = Initial Release