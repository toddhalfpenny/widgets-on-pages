=== Widgets on Pages ===
Contributors: toddhalfpenny
Donate link: http://gingerbreaddesign.co.uk/wordpress/plugins/plugins.php
Tags: widgets, sidebar, pages, post, shortcode, inline
Requires at least: 2.8
Tested up to: 2.9.2
Stable tag: 0.0.5

Allows 'in-page' widget areas so widgets can be defined via shortcode straight into page/post content

== Description ==

Allows 'in-page' widget areas so widgets can be defined via shortcut straight into page/post content.
There is one default widget area that can be used or you can add more from the settings menu. You can currently have an unlimited number of sidebars.
Each sidebar can be called indepentenly by  a shortcode and you can call more than one per post/page.
Sidebars can be included in the post/page by using a shortcode like `[widgets_on_pages id=x]` where `x` is the number of the sidebar.


== Installation ==


1. Install the plugin from within the Dashboard or upload the directory `widgets-on-pages` and all its contents to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widgets you want to the `Widgets on Pages` widget area in the admin screens
1. Add the shortcut `[widgets_on_pages id=x]` to the page or post in the place where you'd like your widgets to appear (where 'x' = the id of the sidebar to use. If using only the default sidebar then no 'id' argument is needed (i.e. `[widgets_on_pages]`).


== Frequently Asked Questions ==

= Can I have more than one defined sidebar area =

Yes... you can have an unlimited number of sidebars defined. The number available can be administered via the settings menu.

== Screenshots ==

1. The 'auto' defined Sidebar that can be called by the shortcode.

== Changelog ==

= 0.0.5 = 

Fix for activation errors. Looks like it might've been the use of php short open tags or line ending chars.

= 0.0.4 = 

There is now no longer a limit on the number of sidebars that can be defined. Each sidebar can be called independently.

= 0.0.3 = 

The number of sidebars can now be defined via the settings menu. There can be up to 5 defined. Each sidebar can be called independently.

= 0.0.2 = 

Minor update so that the functions.php code is not needed anymore... makes like easier.

= 0.0.1 = 

1st release - only supports one defined in-post/page widget area
