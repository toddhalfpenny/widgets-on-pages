<?php

/*  Copyright 2010  TODD HALFPENNY  (email : todd@gingerbreaddesign.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Plugin Name: Widgets on Pages
Plugin URI: http://gingerbreaddesign.co.uk/wordpress/plugins/widgets_on_pages
Description: Allows 'in-page' widget areas so widgets can be defined via shortcut straight into page/post content
Author: Todd Halfpenny
Version: 0.0.1
Author URI: http://gingerbreaddesign.co.uk/todd
*/


/* ===============================
  C O R E    C O D E 
================================*/


function widgets_on_page(){
  $str =  "<div id='widgets_on_page'>
    <ul>";
  ob_start();
  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Widgets on Pages") ) :
  endif;
  $myStr = ob_get_contents();
  ob_end_clean();
  $str .= $myStr;
  $str .=  "</ul>
  </div><!-- widget_on_page -->";
return $str;
}

add_shortcode('widgets_on_pages', 'widgets_on_page');


?>