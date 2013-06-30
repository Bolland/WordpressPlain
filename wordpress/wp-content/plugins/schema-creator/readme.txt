=== Schema Creator by Raven ===
Contributors: norcross, raventools
Tags: schema, schema.org, microdata, structured data, seo, html5
Tested up to: 3.5
Stable tag: 1.042
Requires at least: 3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Insert schema.org microdata into WordPress pages and posts.

== Description ==

Provides an easy to use form to embed properly constructed schema.org microdata into a WordPress post or page.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `schema-creator` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How does this all work? =

The Schema Creator plugin places an icon above the Post/Page rich text editor (next to the Add Media icon). Click on the icon to select a supported schema, fill in the form, and then insert it into your page/post. The plugin uses shortcode, so you can easily edit the schema after you create it. There are additional options on the Schema Creator Settings page.

= Can I test the output to see how the search engine will view it? =

Yes, although there is no guarantee that it will indeed show up that way. Google offers a [Rich Snippet Testing tool](http://www.google.com/webmasters/tools/richsnippets/ "Google Rich Snippet Test") to review.

= I have a problem. Where do I go? =

This plugin is also maintained on [GitHub](https://github.com/norcross/schema-creator/ "Schema Creator on GitHub"). The best place to post questions / issues / bugs / enhancement requests is on the [issues page](https://github.com/norcross/schema-creator/issues "Issues page for Schema Creator on GitHub") there.


== Screenshots ==

1. The plugin creates a Schema Creator icon above the rich text editor. Click the icon to create a new schema.
2. Choose the schema you want to create from the select menu and then enter the data. Once you're finished, insert it into your post or page.
3. Schema Creator creates shortcode, which enables you to edit the schema after it's created.
4. This is an example of schema being rendered on a post.
5. Schema Creator also has a Settings page.
6. The Settings page allows you to turn on and off CSS, and to also include or exclude certain microdata attributes.

== Upgrade Notice ==

= 1.0 =
* Initial Release

== Changelog ==

= 1.042 =
* add Spanish language support. props @fitorec

= 1.041 =
* add Italian language support. props @rotello
* added a 'testing' button to the WP-Admin bar to load a single post or page in Google's Microdata testing tool

= 1.040 =
* additional error check for non-standard 404 pages

= 1.039 =
* removed error from 404 and search results pages

= 1.038 =
* Language support
* minor bug fixes

= 1.037 =
* bugfix: sodium / sugar was reversed

= 1.036 =
* Exclude form loading on non-content editing pages
* Button text change

= 1.035 =
* UI change for WordPress 3.5 release

= 1.034 =
* fixed missing yield display on recipes
* added labels for phone and fax

= 1.033 =
* changed method of adding button to editor to in anticipation of 3.5 release

= 1.032 =
* added recipes as an available schema type

= 1.031 =
* bumped version number to fix update quirk

= 1.023 =
* bugfix for HTML entities in schema descriptions
* metabox option to disable itemprop & itemtype on a post by post basis
* change to the readme and instructions page to include a link to the Google Rich Snippet testing page

= 1.022 =
* replacing body tag method from JS to using core WP functionality.

= 1.021 =
* loading JS for body tag in head

= 1.02 =
* update to logic for loading itemprop body tags and content wrapping

= 1.01 =
* minor bugfix

= 1.0 =
* Initial Release
