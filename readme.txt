=== Widgets on Pages ===
Contributors: toddhalfpenny
Donate link: n/a
Tags: widgets, sidebar, pages, post
Requires at least: 2.8
Tested up to: 2.9.1
Stable tag: 0.0.1

Allows 'in-page' widget areas so widgets can be defined via shortcut straight into page/post content

== Description ==

Allows 'in-page' widget areas so widgets can be defined via shortcut straight into page/post content


== Installation ==


1. Upload the directory `widgets-on-pages` and all its contents to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the following lines to the end of your themes `functions.php` file
`<?php if ( function_exists('register_sidebar') )
register_sidebar(array(
    'name' => 'Widgets on Pages',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
)); ?>`
1. Add the shortcut `[widgets_on_pages]` to the page or post in the place where you'd like your widgets to appear.
1. Add the widgets you want to the `Widgets on Pages` widget area in the admin screens
 

== Frequently Asked Questions ==

= Can I have more than one defined sidebar area =

No, sorry not yet. The plan is to get this supported though

== Changelog ==

= 0.0.1 = 

1st release - only supports one defined in-post/page widget area
