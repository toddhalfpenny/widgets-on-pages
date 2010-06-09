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
Version: 0.0.6
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
  register_setting( 'wop_options', 'wop_options_field' );
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
    <?php
    wp_nonce_field('update-options'); 
    settings_fields( 'wop_options' ); 
    $options = get_option('wop_options_field');
    $num_add_sidebars = $options["num_of_wop_sidebars"];
    ?>
    
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
        <td><input type='text'  name="wop_options_field[num_of_wop_sidebars]" size='3' value="<?php echo $num_add_sidebars;?>"  onkeypress='validate(event)' /></td>
      </tr>
    
    <tr><td></td><td>
      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    </td></tr>
    <tr><td><h3>Optional Sidebar Names</h3></td><td></td></tr>
    <?
    for ($sidebar = 1; $sidebar <= ($num_add_sidebars + 1); $sidebar++) {
        $option_id = 'wop_name_' . $sidebar;
        ?>
        <tr valign="top">
          <th scope="row">WoP sidebar <? echo $sidebar;?> name:</th>
          <td><input type='text'  name="wop_options_field[<? echo $option_id;?>]" size='35' value="<?php echo $options[$option_id];?>"  /></td>
        </tr>
        <?
    }
    ?>
    <tr><td></td><td>
      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    </td></tr>
    <input type="hidden" name="action" value="update" />
  </form>
  </div>
<?php
}



/* ===============================
  I N S T A L L / U P G R A D E 
================================*/

function wop_install() {
  if (get_option('num_of_wop_sidebars')) {
    // older version sub run upgrade
    $num_of_sidebars = get_option('num_of_wop_sidebars');
    $wop_options = array(num_of_wop_sidebars => $num_of_sidebars);
    update_option('wop_options_field', $wop_options);
    delete_option('num_of_wop_sidebars');
    update_option('wop_version', "0.0.6");
  }
}



/* ===============================
  C O R E    C O D E 
================================*/


function widgets_on_page($atts){
  reg_wop_sidebar();
  extract(shortcode_atts( array('id' => '1'), $atts));
  if (is_numeric($id)) :
    $sidebar_name = 'Widgets on Pages ' . $id;
  else :
    $sidebar_name = $id;
  endif;
  $str =  "<div id='widgets_on_page'>
    <ul>";
  ob_start();
  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar_name) ) :
  endif;
  $myStr = ob_get_contents();
  ob_end_clean();
  $str .= $myStr;
  $str .=  "</ul>
  </div><!-- widget_on_page -->";
  return $str;
}



function reg_wop_sidebar() {
  $options = get_option('wop_options_field');
  $num_sidebars = $options["num_of_wop_sidebars"] + 1;
  // register the main sidebar
  if ( function_exists('register_sidebar') )
    if ($options['wop_name_1'] != "") :
      $name = $options['wop_name_1'];
      $sidebar_id = ' id="' .$name . '"';  
    else :
      $name = 'Widgets on Pages 1';
      $sidebar_id = ""; 
    endif;
    $id = 'wop_1';
    $desc = '#1 Widgets on Pages sidebar.
            Use shortcode
            "[widgets_on_pages' . $sidebar_id .']"';
register_sidebar(array(
  'name' => __( $name, 'wop' ),
        'description' => __( $desc, 'wop' ),
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget' => '</li>',
  'before_title' => '<h2 class="widgettitle">',
  'after_title' => '</h2>',
  ));
  
  // register any other additional sidebars
  if ($num_sidebars > 1)  :
    for ( $sidebar = 2; $sidebar <= $num_sidebars; $sidebar++){
      if ( function_exists('register_sidebar') )
          $option_id = 'wop_name_' . $sidebar;
          if ($options[$option_id] != "") :
            $name = $options[$option_id];
            $sidebar_id = ' id="' . $name . '"'; 
          else :
            $name = 'Widgets on Pages ' . $sidebar;
            $sidebar_id = ' id=' . $sidebar; 
          endif;
          $id = 'wop_' . $sidebar;
          $desc = '#' . $sidebar . 'Widgets on Pages sidebar.
              Use shortcode
              "[widgets_on_pages' . $sidebar_id .']"';
  register_sidebar(array(
              'name' => __( $name, 'wop' ),
              'description' => __( $desc, 'wop' ),
          'before_widget' => '<li id="%1$s" class="widget %2$s">',
          'after_widget' => '</li>',
          'before_title' => '<h2 class="widgettitle">',
          'after_title' => '</h2>',
      ));
    }
  endif;
}


register_activation_hook(__FILE__,'wop_install');

add_action('admin_init', 'reg_wop_sidebar'); 
add_shortcode('widgets_on_pages', 'widgets_on_page');


?>
