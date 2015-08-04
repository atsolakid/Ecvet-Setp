=== Twitter Widget with Styling ===
Contributors: mpol
Tags: twitter, widget, twitter style, twitter styling, stylesheet, embedded timeline, easy twitter widget
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 1.2.8
License: GPLv2 or later


A Twitter widget that is easy to configure and easy to style.

== Description ==

A Twitter widget that is easy to configure and easy to style. It uses the Embedded Timeline widget of Twitter.com.
You can have it load an extra stylesheet, where you can style the layout of the widget.

= Languages =

* nl_NL [Marcel Pol](http://zenoweb.nl)
* se_RS [Borisa Djuraskovic](http://webhostinghub.com)

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to [Twitter](https://dev.twitter.com/docs/embedded-timelines).
4. Create your own Embedded Timeline App.
5. Go to Appearance->Widgets, add the widget to any sidebar.
6. Add your Twitter Name and your Twitter ID from the code you got from Twitter.
7. Enjoy!

= Todo list =

There are some improvements that can be made:

* Support only this plugin, not just blindly the first Twitter Widget.
* Add the stylesheet to every widget, not just the first one.

== Frequently Asked Questions ==

= How do I edit the stylesheet? =

Copy the style_twitter.css from the plugin to your theme directory.
The widget will find it and add it to the webpage instead of the default in the plugin.
Do not edit the style_twitter.css in the plugin itself, it will be overwritten when updating.

= I edit the stylesheet, but I do not see the changes in the browser =

This is because the browser cache does not refresh.
You can set "Development" on in the widget. It will make sure it refreshes the browser cache.

= Can I add multiple widgets to a page? =

You can, but it will probably not load any styling in the second widget.

= Is WordPress MultiSite supported? =

Not really. I heard there is funky behaviour with activating and deactivating the plugin.
I will look at it soon.

== Screenshots ==

1. Screenshot of the widget in the admin section.
2. Screenshot of the frontend of the widget with transparent styling
3. Screenshot of the frontend of the widget with grey styling
4. Screenshot of the frontend of the widget with brown styling
5. Screenshot of the frontend of the widget with blue styling
6. Screenshot of the frontend of the widget with blue styling

== Changelog ==

= 1.2.8 =
* 2015-05-30
* Have checkTwitter var really be a counter.

= 1.2.7 =
* 2014-11-07
* Support Child Themes
* Drop unneeded Widget Customizer support

= 1.2.6 =
* 2014-04-15
* Support Widget Customizer in 3.9

= 1.2.5 =
* 2014-04-11
* Only load js when widget is loaded (in footer)

= 1.2.4 =
* 2014-04-02
* More examples

= 1.2.3 =
* 2014-04-02
* Examples now included

= 1.2.2 =
* 2014-02-18
* Fix issue with Contact Form 7

= 1.2.1 =
* 2013-12-10
* Change name of var to not conflict

= 1.2 =
* 2013-11-22
* Add Serbo-Croatian language (thanks Borisa)
* Add development mode

= 1.1 =
* 2013-11-13
* First fix issue of loading on every page

= 1.0 =
* 2013-11-12
* First Version
