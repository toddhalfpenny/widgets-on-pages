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
Plugin URI: http://gingerbreaddesign.co.uk/wordpress/plugins/widgets-on-pages.php
Description: Allows 'in-page' widget areas so widgets can be defined via shortcut straight into page/post content
Author: Todd Halfpenny
Version: 0.0.5
Author URI: http://gingerbreaddesign.co.uk/todd
*/

/* ===============================
  A D M I N   M E N U / P A G E
================================*/


add_action('admin_menu', 'wop_menu');

function wop_menu() {
  add_options_page('Widgets on Pages options', 'Widgets on Pages', 7, 'wop_options', 'wop_plugin_options');
  add_action( 'admin_init', 'register_mysettings' );

}


function register_mysettings() { // whitelist options
  register_setting( 'wop_options', 'num_of_wop_sidebars' );
}


/*--------------------------------
  wop_options
------------------------------- */
function wop_plugin_options() {
?>
  <div class="wrap">
  <div id="icon-tools" class="icon32"></div>
  <h2>Widgets on Pages: Options</h2>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <?php settings_fields( 'wop_options' ); ?>
    <?php $cur_num_sidebars = get_option('num_of_wop_sidebars');?>
    
    <script language="JavaScript">
    function validate(evt) {
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      if ((key == 8) || (key == 9) || (key == 13)) {
      }
      else {
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
          theEvent.returnValue = false;
          theEvent.preventDefault();
        }
      }
    }
    </script>

    <table class="form-table">
    
      <tr valign="top">
      <th scope="row">Number of additional sidebars</th>
      <td><input type='text'  name="num_of_wop_sidebars" size='3' value="<?php echo get_option('num_of_wop_sidebars');?>"  onkeypress='validate(event)' />
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="num_of_wop_sidebars" />
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
  </div>
<?php
}




/* ===============================
  C O R E    C O D E 
================================*/


function widgets_on_page($atts){
  reg_wop_sidebar();
  extract(shortcode_atts( array('id' => '1'), $atts));
  $str =  "<div id='widgets_on_page'>
    <ul>";
  ob_start();
  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Widgets on Pages $id") ) :
  endif;
  $myStr = ob_get_contents();
  ob_end_clean();
  $str .= $myStr;
  $str .=  "</ul>
  </div><!-- widget_on_page -->";
  return $str;
}



function reg_wop_sidebar() {
  // register the main sidebar
  if ( function_exists('register_sidebar') )
    register_sidebar(array(
      'name' => 'Widgets on Pages 1',
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
      'after_widget' => '</li>',
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
  ));
  
  // register any other additional sidebars
  $num_sidebars = (get_option('num_of_wop_sidebars') + 1);
  if ($num_sidebars > 1)  :
    for ( $sidebar = 2; $sidebar <= $num_sidebars; $sidebar++){
      if ( function_exists('register_sidebar') )
        register_sidebar(array(
          'name' => "Widgets on Pages $sidebar",
          'before_widget' => '<li id="%1$s" class="widget %2$s">',
          'after_widget' => '</li>',
          'before_title' => '<h2 class="widgettitle">',
          'after_title' => '</h2>',
      ));
    }
  endif;
}

add_action('admin_init', 'reg_wop_sidebar'); 
add_shortcode('widgets_on_pages', 'widgets_on_page');


?>
