=== Manga+Press Comic Manager ===
Contributors: ArdathkSheyna
Donate link: http://www.manga-press.com/
Tags: webcomics, online comics
Requires at least: 4.0
Requires PHP: 5.6.40
Tested up to: 5.5.1
Stable tag: 3.0.1
License: GPLv2

Manga+Press is a webcomic management system for WordPress.

== Description ==

Manga+Press is a webcomic management system for WordPress. Manga+Press uses WordPress posts, pages and categories to help you keep track of your comic posts. Manga+Press also includes its own custom template tags to help make creating themes easier.

== Upgrade Notice ==

This version adds a new option for enabling beta features. Note that these beta features will only be available as separate plugins.

= 3.0.2 =
  * Added beta features option. Will require separate plugins

== Changelog ==
= 3.0 =
   * 3.0.2
      * Added beta features option. Will require separate plugins

   * 3.0.1
      * Fixed issue where templates for Latest Comic page and Comic Archive page weren't loading correctly
      * Corrected CSS positioning for comic navigation wrapper
      * Added support for WordPress 5.5.1

   * 3.0.0
      * Removed child themes
      * Added sorting options for Comic Archive Page
      * Added comic archive calendar template
      * Added comic archive gallery template
      * Removed insert navigation option

= 2.9 =
   * 2.9.3
      * Spanish language updates to embedded themes.
   * 2.9.2
      * Added support for Jetpack Publicize feature.
   * 2.9.1
      * Corrects an issue where Comic posts were not getting assigned to a default Series taxonomy on save.
      * Corrects Comic post 404 error/Missing Comic post issue.
      * Corrects appearance of comic navigation on Latest Comic page

   * 2.9.0
      * Updated navigation CSS
      * Removed "Order By" Option. Now defaults to date.
      * Removed "Use Theme Template" options. Now defaults to using theme templates.
      * Added contextual help tabs
      * Added Calendar template tag for comics
      * Added filter for changing Comic post-type front slug (defaults to `comic`)
      * Fixed missing "No comics" message for Latest Comic page.
      * Corrected issue with Comic Post terms getting updated on post-save.
      * Updated Spanish Language files.
      * Updated child-themes to handle styling for Comic Calendar widget
      * Corrected issues in comic navigation when Group Comics/Group By Parent options are used.
      * Added Manga+Press-specific version of WordPress calendar widget
      * Updated Comic date permalink structure
      * Updated and fixed loading of Spanish Language files
      * Adjusted template hierarchy for Latest Comic and Comic Archive pages to use WordPress' defaults (page-{slug-name}.php and {custom-page-template}.php)
      * Brought default Single Comic template in line with default Latest Comic and Comic Archive template handling
         * Incidently corrects an issue where a Single Comic post might not display correctly due to markup being incompatible with a user's selected theme.

= 2.8 =
   * 2.8.3
      * Correcting blank issue when "Use Theme Template" is selected when used with third-party themes

   * 2.8.2
      * Correcting Latest Comic template error when Latest Comic is used as front page.

   * 2.8.1.1
      * Correcting problem with undefined function error appearing when Latest Comic template in TwentyFourteen theme is used

   * 2.8.1
     * Corrected E_STRICT notice on plugin activation
     * Updated font icons

   * 2.8
      * Added bundled child-themes for TwentyEleven, TwentyTwelve, TwentyThirteen, and TwentyFourteen
      * Corrected 404 issues for custom post-type after activation
      * Updated admin interface to fit WordPress 3.8
      * Adjusted template stack for single comics
      * Added new Media Library popup (eliminating legacy ThickBox dependency)
         * Added WordPress 3.5 Media Library window
      * Code review and cleanup
      * Removed legacy options (Comic Banner)

= 2.7 =
   * 2.7.5
      * Fixed 404 when visiting comic pages after update (ported from upcoming 2.8 release)
      * Fixed undefined index errors caused by checkboxes when settings page is updated
      * Tested works with WordPress 3.8

   * 2.7.4
      * Fixed SQL bugs relating to "Group By Category" option

   * 2.7.3
      * Added "Group By Category" parent option

   * 2.7.2
      * Added Spanish Language support
      * Fixed issues with comic navigation.
      * Addressing query-usage on Latest Comic page.

   * 2.7.1
      * Fixed undefined index notices (WP_DEBUG turned on)

   * 2.7 RC 1
     * Moved partial templates to sub-directory inside templates.
     * Corrected issues in comic-specific conditional functions.
     * Changed Ajax hooks to be admin-specific.

   * 2.7 Beta 3
     * Fixed missing template issues.
     * Fixed issues with "Use theme template" settings.

   * 2.7 Beta 2
     * Corrected issue with framework paths which prevented the Manga+Press Options forms from displaying properly.
     * Added closing PHP tags for servers that have short open tags disabled.

   * 2.7 Beta
     * Eliminated "Insert Banner" and Comic Update codes. These features may return in future versions.
     * Added custom taxonomies, and post thumbnail support.
     * Eliminated TimThumb.


== Installation ==

1. Unpack the .zip file onto your hard drive.

2. Upload the `mangapress` folder to the `/wp-content/plugins/` directory.

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Create two new pages; these pages will be your latest comic and comic archives pages. Label them something like 'Latest Comic'
and 'Past Comics' or whatever, as long as it makes sense to you.

6. Click on the Manga+Press Options tab under Settings and go to Basic Manga+Press Options, and set Latest Comic Page, and Comic
Archive Page to your two newly created pages.


== Frequently Asked Questions ==

*I'm using the bundled theme for TwentyEleven, -Twelve, or -Thirteen but the Custom CSS and/or Insert Navigation options have no effect? Or they add a second navigation bar*

This is because the navigation for the comics is built into the theme. Using a different theme or overriding the default theme's template will allow you to use the options. (however, see [issue #17](https://github.com/jesgs/mangapress/issues/17) for additional issues)

*Does Manga+Press work on WordPress Multi-site?*

Yes, it does. However, a few steps must be taken to make Manga+Press' child-themes available to your network. See the question below on the steps to take to enable the child-themes on Multisite.

*The bundled themes aren't available in WordPress Multi-site. What's going on?*

This is because the plugin hasn't been activated for the entire MS network. In order for the child-themes to be available, Manga+Press must be available to the entire network. This can be done by going to **Network Admin > Plugins** and clicking the _Network Activate_ link for Manga+Press. Once this is done, then both the parent- and child-themes need to made available to the network as well. This can be accomplished by going to **Network Admin > Themes**, selecting the themes in question, choosing **Bulk Actions > Network Enable**, and then clicking **Apply**.

*Is Manga+Press responsive?*

Not by itself. However, Manga+Press doesn't really output markup other than the comic navigation. Responsiveness depends on the theme that is being used. The themes bundled with Manga+Press — the TwentyEleven thru TwentyFourteen child-themes — all have some level of responsiveness that is dependent on their parent themes.

*Is Manga+Press compatible with Advanced Custom Fields*

Yes, it is! Manga+Press is simply a stripped down custom post-type with a custom Featured Image meta-box. Like any other post-type, you can add a new field group using ACF — however, you _will_ have to configure your theme to display these custom fields.

*Is Manga+Press compatible with the WPML plugin?*

I have never had the chance to test Manga+Press with the WPML plugin so I can't really guarantee compatibility. Since Manga+Press works like a standard WordPress post, and WPML _is_ compatible with custom post-types, this shouldn't be a problem.

*Do you take feature requests?*

I do take feature requests, but I also judge each request on the basis of how well the new feature fits into Manga+Press' current functionality and also how feasible the new feature is to implement into Manga+Press' core.


== Screenshots ==

1. screenshot-1.png
2. screenshot-2.jpg
3. screenshot-3.jpg
4. screenshot-4.jpg

== Credits ==

(c) 2008-2020 Jessica C. Green

Found a bug? Or did you find a bug and figure out a fix? Visit http://www.manga-press.com/support/. Please include screenshots, WordPress version, a list of any other plugins you might have installed, or code (if you figured out a fix). Be as detailed as possible.

For updates, you can visit http://www.manga-press.com/

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
