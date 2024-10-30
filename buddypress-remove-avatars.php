<?php
/*
Plugin Name: BP Remove Avatars
Description: This BuddyPress component removes all avatars from the site
Version: .2.2
Revision Date: January 31, 2010
Requires at least: WPMU 2.8, BuddyPress 1.1
Tested up to: WPMU 2.9.1, BuddyPress 1.2
License: Example: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Peter Anselmo, Studio66
Author URI: http://www.studio66design.com
Site Wide Only: true
*/

define ( 'BP_REMOVE_AVATARS_IS_INSTALLED', 1 );
define ( 'BP_REMOVE_AVATARS_VERSION', '.2.2' );


//adds an admin menu for changing options
function bp_remove_avatars_admin_menu() {	
	global $wpdb, $bp;

	if ( !is_site_admin() )
		return false;
	
	//Add the component's administration tab under the "BuddyPress" menu for site administrators
	require ( WP_PLUGIN_DIR . '/buddypress-remove-avatars/buddypress-remove-avatars-admin.php' );

	add_submenu_page( 'bp-general-settings', __( 'Remove Avatars Admin', 'buddypress-remove-avatars' ), __( 'Remove Avatars', 'buddypress-remove-avatars' ), 'manage-options', 'bp-remove-avatars-settings', "bp_remove_avatars_admin" );	

	add_option('bp_remove_avatars_remove_icons', false );

	//Currently this is not a user option
	//add_option('bp_remove_avatars_include_bp_11', false );
	//add_option('bp_remove_avatars_include_bp_12', false );
}
add_action( 'admin_menu', 'bp_remove_avatars_admin_menu',35);


//Removes the "Choose Avatar" link from the group creation process
function bp_remove_avatars_group_create() {
	global $bp;

	if( $bp->groups->group_creation_steps['group-avatar'] ) {
		unset( $bp->groups->group_creation_steps['group-avatar'] );
	}
}
add_action('groups_setup_globals','bp_remove_avatars_group_create');


//Updates the site option for users not to be able to upload their own avatars
function bp_remove_avatars_disable_upload() {
	update_site_option('bp-disable-avatar-uploads',1);
}
add_action('plugins_loaded','bp_remove_avatars_disable_upload');


//removes the "Change Avatar" link from the user navigation on the 
//profile page and in the top admin bar
function bp_remove_avatars_main_nav() {
	global $bp;
	unset($bp->bp_options_nav['profile']['change-avatar']);
}
add_action('xprofile_setup_nav','bp_remove_avatars_main_nav');


//a kinda janky way to determine whether to use the 1.1 or 1.2 theme specific issues
function bp_remove_avatars_set_theme() {
	switch( substr( BP_VERSION, 0, 3 ) ) {
		case '1.2':
			if( 'BuddyPress Classic' == get_current_theme() ) {
				define( 'BP_REMOVE_AVATARS_THEME_VERSION', '1.1' );
			} else {
				define( 'BP_REMOVE_AVATARS_THEME_VERSION', '1.2' );
			}
		break;
		case '1.1':
			define( 'BP_REMOVE_AVATARS_THEME_VERSION', '1.1' );
		break;
	}
}
add_action('plugins_loaded','bp_remove_avatars_set_theme');


//call the css and js files for anything we couldn't take out with php
function bp_remove_avatars_add_cssjs() {

	wp_enqueue_style('bp-remove-avatars-main',WP_PLUGIN_URL . '/buddypress-remove-avatars/css/main.css');

	switch( BP_REMOVE_AVATARS_THEME_VERSION ){
		case '1.1':
			wp_enqueue_style('bp-remove-avatars-bp-11', WP_PLUGIN_URL . '/buddypress-remove-avatars/css/bp-11.css' );
		break;
		case '1.2':
			wp_enqueue_style('bp-remove_avatars-bp-12', WP_PLUGIN_URL . '/buddypress-remove-avatars/css/bp-12.css' );
		break;
	}

	if( get_option('bp_remove_avatars_remove_icons') ) 
		wp_enqueue_style('bp-remove-avatars-icons', WP_PLUGIN_URL . '/buddypress-remove-avatars/css/icons.css' );

	wp_enqueue_script( 'bp-remove-avatars-js', WP_PLUGIN_URL . '/buddypress-remove-avatars/buddypress-remove-avatars.js',array('jquery') );
}
add_action( 'template_redirect', 'bp_remove_avatars_add_cssjs', 1 );

