<?php
/** 
WOP tinyMCE editor dialog
*/

global $wp_registered_sidebars;

$wop_sidebars = array();
if( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) ){
    foreach( $wp_registered_sidebars as $sidebar ){		
    	     if( preg_match( "/^wop\-/", $sidebar['id'] ) ){		
	     	 $wop_sidebars[] = $sidebar;
		 }
	}
}

?>
<style>
	label {clear : both; float: left; width: 100px;line-height:2.5em }
	select {float: left; clear : none;}
	.submit_btn {clear: both;}
</style>
<div class="wop_dialog_content">
	<?php if( is_array( $wop_sidebars ) && count( $wop_sidebars ) ){?>
		<p>
			<?php _e( 'Please select a sidebar from the dropdown list', 'wop' );?>
		</p>
		<p>
			<label for="wop_sidebar"><?php _e( 'Select sidebar', 'wop' )?></label>
			<select id="wop_sidebar" name="wop_sidebar" style="width: 200px;">
				<?php foreach( $wop_sidebars as $sidebar ){?>
					<option value="<?php echo $sidebar['name']?>"><?php echo $sidebar['name']?></option>
				<?php }?>
			</select>
			<label for="wop_columns"><?php _e( 'Num of columns', 'wop' )?></label>
		
			<select id="wop_columns" name="wop_columns">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>
			
		</p>
		<p class='submit_btn'>
			<input type="button" class="button-primary" value="<?php _e('Cancel', 'wop')?>" onclick="tb_remove();" />
			<input type="button" class="button-primary" value="<?php _e('Insert', 'wop')?>" onclick="insertShortCode();" />
		</p>
	<?php }else{?>
		<?php _e( 'There are no available sidebars', 'wop' );?>
	<?php }?>
</div>
