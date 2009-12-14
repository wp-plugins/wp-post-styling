=== Plugin Name ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: css, post, page, custom, styling, admin, mobile, print
Requires at least: 2.3
Tested up to: 2.7.1
Stable tag: trunk

Allows you to define custom styles for any specific post or page on your WordPress site. This is particularly useful for journal-style publications which want to provide a unique character for specific articles.

== Description ==

This plugin simply provides a custom field on your WordPress interface where you can add custom styles to be applied only on that page or post. Useful for being able to publish articles with a unique look.

The use you'll get out of this plugin depends on the flexibility of the theme you're using and your own knowledge of CSS (Cascading Style Sheets).

**New in version 1.1.0:**

* Added a database to store pre-determined style groups. 
* Corrected a few layout bugs.

How to use the style library:

1. Add the styles you want on your settings page.
1. Navigate to an article which requires specific styles.
1. Select the library style from the drop down, leaving the style textarea blank.
1. Update or post the new document.

A selected style from the style library will always overwrite any other hand-written styles. If you wish to alter the library styles for a specific page, you can do this in the textarea after you've saved the page with the style library template. 

== Installation ==

1. Upload the `wp-post-styling` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Go to Settings > WP Post Styling
4. Adjust the WP Post Styling options if necessary. 
5. Set up custom styles for your posts and pages as needed!

== Frequently Asked Questions ==

= I don't really know CSS. Can I use this plugin? =

You really do need to know CSS to get anywhere with this. Given the huge variety in styles provided by WordPress themes, it's impractical to attempt to predict what kinds of styles you might need. 

= The Custom styles I added aren't showing up in my blog -- why not? =

Well, this is just a stab in the dark, but it's possible that the developer of your theme didn't use the WordPress function <code>wp_head</code>, which needs to be in your theme for this plugin to work. 

== Screenshots ==

1. WP Post Styling Settings Page
2. WP Post Styling Custom Styles Box