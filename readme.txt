=== No Comments on Media ===
Contributors: bitwisesoftware
Tags: comments, media, attachments, disable comments, remove comments
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically disable comments on all media attachments. Simple, lightweight, and effective.

== Description ==

**No Comments on Media** is a simple, lightweight WordPress plugin that automatically disables comments on all media attachments. 

Media attachment pages (images, videos, PDFs, etc.) rarely need comments enabled. This plugin helps you:

* **Improve SEO** - Remove unnecessary comment sections that add no value
* **Enhance Security** - Reduce spam and potential security vulnerabilities
* **Clean Up Your Site** - Present a cleaner, more professional appearance
* **Save Resources** - Reduce database queries and page load time

= Features =

* ✅ Automatically disables comments on all media attachments
* ✅ Disables trackbacks and pingbacks on media attachments
* ✅ Removes comment forms from attachment pages
* ✅ Hides existing comments on attachment pages
* ✅ Optional: Permanently delete existing comments on attachments
* ✅ WP-CLI support for developers and system administrators
* ✅ Works with any WordPress theme
* ✅ Simple ON/OFF toggle in Settings → Media
* ✅ Lightweight and fast - no bloat
* ✅ Closes comments on existing attachments during activation

= How It Works =

Once activated, the plugin:

1. Disables the ability to add new comments on media attachments
2. Hides comment forms and existing comments from attachment pages
3. Removes comment support from the attachment post type
4. Provides a simple toggle in Settings → Media to enable/disable the functionality

No configuration needed - it just works!

= Perfect For =

* Photographers and portfolios
* E-commerce sites with product images
* Blogs that don't need comments on media
* Any WordPress site that uses attachments

= Privacy =

This plugin does not collect, store, or transmit any user data. It only modifies comment settings for media attachments on your WordPress site.

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins → Add New
3. Search for "No Comments on Media"
4. Click "Install Now" and then "Activate"
5. That's it! Comments are now disabled on media attachments

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Go to Plugins → Add New → Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Click "Activate Plugin"

= Configuration =

To toggle the plugin functionality:

1. Go to Settings → Media in your WordPress admin
2. Find the "Comments on Media" section
3. Check or uncheck "Disable comments on all media attachments"
4. Click "Save Changes"

The plugin is enabled by default upon activation.

= WP-CLI Commands =

For developers and system administrators, the plugin includes WP-CLI support:

**Check status:**
`wp media-comments status`

**Disable comments:**
`wp media-comments disable`

**Enable comments:**
`wp media-comments enable`

**Delete all comments on media:**
`wp media-comments cleanup`
`wp media-comments cleanup --yes` (skip confirmation)

== Frequently Asked Questions ==

= Does this plugin delete existing comments? =

By default, no. The plugin hides existing comments but doesn't delete them. However, there is an optional setting in Settings → Media that allows you to permanently delete all existing comments on media attachments if you wish.

= Does this disable trackbacks and pingbacks too? =

Yes! The plugin disables both trackbacks and pingbacks on all media attachments, providing complete protection from comment-related spam.

= Will this work with my theme? =

Yes! The plugin is theme-agnostic and works with any WordPress theme, including custom themes, page builders, and block themes.

= Does this affect comments on posts and pages? =

No, this plugin only affects media attachments (images, videos, PDFs, etc.). Comments on regular posts and pages are not affected.

= Can I enable comments on specific attachments? =

Not with this plugin. It applies the setting globally to all media attachments. If you need per-attachment control, you may need a different solution.

= What happens if I deactivate the plugin? =

If you deactivate the plugin, comment functionality will be restored to its default WordPress behavior for attachments.

= Does this plugin slow down my site? =

No, the plugin is extremely lightweight and uses minimal resources. It only adds a few simple filters that run efficiently.

= Is this compatible with caching plugins? =

Yes, the plugin is fully compatible with all major caching plugins like WP Super Cache, W3 Total Cache, and WP Rocket.

= Does this work with Gutenberg? =

Yes, the plugin works seamlessly with both the Classic Editor and the Gutenberg block editor.

= Can I use this plugin via command line? =

Yes! The plugin includes full WP-CLI support. Use commands like `wp media-comments disable`, `wp media-comments status`, and `wp media-comments cleanup` for automated management.

= Is it safe to delete existing comments? =

The deletion option permanently removes comments from the database and cannot be undone. Make sure you have a backup before using this feature. We recommend only using it if you're certain you don't need those comments.

== Screenshots ==

1. Simple settings toggle in Settings → Media
2. Clean attachment page with no comment section
3. Before and after comparison

== Changelog ==

= 1.0.0 - 2025-11-18 =
* Initial release
* Disable comments and pingbacks/trackbacks on media attachments
* Remove comment forms and sections from attachment pages
* Simple ON/OFF toggle in Settings → Media
* Optional: Delete existing comments on attachments
* WP-CLI support (disable, enable, cleanup, status commands)
* Automatic closure of comments on existing attachments during activation

== Upgrade Notice ==

= 1.0.0 =
Initial release of No Comments on Media plugin.

== Support ==

For support, please visit the [plugin support forum](https://wordpress.org/support/plugin/no-comments-on-media/) or [GitHub repository](https://github.com/Bitwise-SoftwarePR/NoCommentsOnMedia).

== Credits ==

Developed by [Bitwise Software](https://github.com/Bitwise-SoftwarePR)
