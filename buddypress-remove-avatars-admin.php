<?php

function bp_remove_avatars_admin() { 
	global $bp, $bbpress_live;
		
	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('remove-avatars-settings') ) {

		if( isset($_POST['bp_11_css']) && $_POST['bp_11_css'] ) {
			$bp_11_css = 1;
		} else {
			$bp_11_css= 0;
		}
		if( isset($_POST['remove_icons']) && $_POST['remove_icons'] ) {
			$remove_icons = 1;
		} else {
			$remove_icons= 0;
		}
		update_option( 'bp_remove_avatars_remove_icons', $remove_icons );
		update_option( 'bp_remove_avatars_include_bp_11', $bp_11_css );

		$updated = true;
	}
	
	$bp_11_css = get_option( 'bp_remove_avatars_include_bp_11' );
	$remove_icons = get_option( 'bp_remove_avatars_remove_icons' );
?>
	<div class="wrap">
		<h2><?php _e( 'Remove Avatars Admin', 'buddypress-remove-avatars' ) ?></h2>
		<br />
		
		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'buddypress-remove-avatars' ) . "</p></div>" ?><?php endif; ?>
			
		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp-remove-avatars-settings' ?>" name="remove-avatars-settings-form" id="remove-avatars-settings-form" method="post">				

			<table class="form-table">
				<tr>
					<th style="width: 300px;"><label><?php _e('Remove Icons (in addition to avatars)','buddypress-remove-avatars') ?></label></th>
					<td>
						<input type="checkbox" name="remove_icons" id="remove_icons" <?php if( $remove_icons ) echo 'checked="checked"'; ?> value="1" /></td>
				</tr>
				<!--
				<tr>
					<th><label><?php _e('Include CSS for BP 1.1 Default Theme','buddypress-remove-avatars') ?></label></th>
					<td>
						<input type="checkbox" name="bp_11_css" id="bp_11_css" <?php if( $bp_11_css ) echo 'checked="checked"'; ?> value="1" /></td>
				</tr>
				-->
			</table>
			<p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'buddypress-remove-avatars' ) ?>"/>
			</p>
			
			<?php wp_nonce_field( 'remove-avatars-settings' ); ?>
		</form>
	</div>
<?php
}
?>
