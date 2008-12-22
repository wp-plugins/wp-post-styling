<?php
/*
Plugin Name: WP Post Styling
Plugin URI: http://www.joedolson.com/articles/wp-post-styling/
Description: Allows you to define custom styles for any specific post or page on your WordPress site. Helps reduce clutter in your stylesheet.
Version: 1.0.0
Author: Joseph Dolson
Author URI: http://www.joedolson.com/
*/
/*  Copyright 2008  Joseph C Dolson  (email : wp-post-styling@joedolson.com)

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
$jd_plugin_url = "http://www.joedolson.com/articles/wp-post-styling/";

global $wp_version;	

$exit_msg=__('WP Post Styling requires WordPress 2.3 or more recent. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update your WordPress version!</a>');

	if ( version_compare( $wp_version,"2.3","<" )) {
	exit ($exit_msg);
	}

// Add custom Tweet field on Post & Page write/edit forms
function jd_add_post_styling_textinput() {
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	$jd_post_styling_print = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'jd_post_styling_print', true)));
	$jd_post_styling_mobile = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'jd_post_styling_mobile', true)));
	$jd_post_styling_screen = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'jd_post_styling_screen', true)));
	
	$jd_style_this = get_post_meta($post_id, 'jd_style_this', true);
		if ($jd_style_this == 'disable' || (get_option( 'jd-post-styling-default' ) == 'disable' && $jd_style_this == 'disable' ) ) {
		$jd_selected = array(' checked="checked"','');
		} else {
		$jd_selected = array('',' checked="checked"');
		}
	$jd_box_size = get_option('wp-post-styling-box-size');
	if ($jd_box_size == "") {
	$jd_box_size = 6;
	}
	?>
	<?php /* Compatibility with version 2.3 and below (needs to be tested.) */ ?>
	<?php if (substr(get_bloginfo('version'), 0, 3) >= '2.5') { ?>
	<div id="wp-post-styling" class="postbox closed">
	<h3><?php _e('WP Post Styling', 'wp-post-styling') ?></h3>
	<div class="inside">
	<div id="jd-post-styling">
	<?php } else { ?>
	<div class="dbx-b-ox-wrapper">
	<fieldset id="stylediv" class="dbx-box">
	<div class="dbx-h-andle-wrapper">
	<h3 class="dbx-handle"><?php _e('WP Post Styling', 'wp-post-styling') ?></h3>
	</div>
	<div class="dbx-c-ontent-wrapper">
	<div class="dbx-content">
	<?php } ?>
	<?php if ( get_option( 'jd-post-styling-screen' ) == '1' ) { ?>
	<p>
	<label for="jd_post_styling_screen"><?php _e('Custom Screen Styles For This Post', 'wp-post-styling') ?></label><br /><textarea name="jd_post_styling_screen" id="jd_post_styling_screen" rows="<?php echo $jd_box_size; ?>" cols="60"><?php echo $jd_post_styling_screen ?></textarea>
	</p>
	<?php } ?>
	
	<?php if ( get_option( 'jd-post-styling-mobile' ) == '1' ) { ?>
	<p>
	<label for="jd_post_styling_mobile"><?php _e('Custom Mobile Styles For This Post', 'wp-post-styling') ?></label><br /><textarea name="jd_post_styling_mobile" id="jd_post_styling_mobile" rows="<?php echo $jd_box_size; ?>" cols="60"><?php echo $jd_post_styling_mobile ?></textarea>
	</p>
	<?php } ?>
	
	<?php if ( get_option( 'jd-post-styling-print' ) == '1' ) { ?>
	<p>
	<label for="jd_post_styling_print"><?php _e('Custom Print Styles For This Post', 'wp-post-styling') ?></label><br /><textarea name="jd_post_styling_print" id="jd_post_styling_print" rows="<?php echo $jd_box_size; ?>" cols="60"><?php echo $jd_post_styling_print ?></textarea>
	</p>
	<?php } ?>
	
	<p><a target="__blank" href="http://www.joedolson.com/articles/wp-post-styling/"><?php _e('Get Support', 'wp-post-styling') ?></a> &raquo;
</p>
<p>
	<input type="radio" name="jd_style_this" value="disable"<?php echo $jd_selected[0]; ?> id="jd_style_this" /> <label for="jd_style_this">Disable custom styles on this post.</label>
	<input type="radio" name="jd_style_this" value="enable"<?php echo $jd_selected[1]; ?> id="jd_style_this_enable" /> <label for="jd_style_this_enable">Enable custom styles on this post.</label>	
</p>
	<?php if (substr(get_bloginfo('version'), 0, 3) >= '2.5') { ?>
	</div></div></div>
	<?php } else { ?>
	</div>
	</fieldset>
	</div>
	<?php } 
}

// Post the Custom Tweet into the post meta table
function set_jd_post_styling( $id ) {
	$jd_post_styling_screen = $_POST[ 'jd_post_styling_screen' ];
		if (isset($jd_post_styling_screen) && !empty($jd_post_styling_screen)) {
		delete_post_meta( $id, 'jd_post_styling_screen' );
		add_post_meta( $id, 'jd_post_styling_screen', $jd_post_styling_screen );
		}
	$jd_post_styling_print = $_POST[ 'jd_post_styling_print' ];
		if (isset($jd_post_styling_print) && !empty($jd_post_styling_print)) {
		delete_post_meta( $id, 'jd_post_styling_print' );
		add_post_meta( $id, 'jd_post_styling_print', $jd_post_styling_print );
		}
	$jd_post_styling_mobile = $_POST[ 'jd_post_styling_mobile' ];
		if (isset($jd_post_styling_mobile) && !empty($jd_post_styling_mobile)) {
		delete_post_meta( $id, 'jd_post_styling_mobile' );
		add_post_meta( $id, 'jd_post_styling_mobile', $jd_post_styling_mobile );
		}		
	$jd_style_this = $_POST[ 'jd_style_this' ];
	if (isset($jd_style_this) && !empty($jd_style_this)) {		
		if ($jd_style_this == 'disable') {
			delete_post_meta( $id, 'jd_style_this' );
			add_post_meta( $id, 'jd_style_this', 'disable');
		} else if ($jd_style_this == 'enable') {
			delete_post_meta( $id, 'jd_style_this' );
			add_post_meta( $id, 'jd_style_this', 'enable');
		}
	}
}

function post_jd_post_styling() {
	global $wp_query;
	$this_post = $wp_query->get_queried_object();
	$id = $this_post->ID;
	if ( get_post_meta( $id, 'jd_style_this', TRUE ) == 'enable' ) {
echo "<!-- Styles Added by WP Post Styling (http://www.joedolson.com/articles/wp-post-styling/) -->\n";
			if ( get_post_meta( $id, 'jd_post_styling_screen', TRUE) != '') {
			$this_post_styles = get_post_meta( $id, 'jd_post_styling_screen', TRUE );
			echo "
<style type='text/css' media='screen'>\n
$this_post_styles\n
</style>\n";
			}
			if ( get_post_meta( $id, 'jd_post_styling_mobile', TRUE) != '' ) {
			$this_post_styles = get_post_meta( $id, 'jd_post_styling_mobile', TRUE );
			echo "
<style type='text/css' media='handheld'>\n
$this_post_styles\n
</style>\n";
			}
			if ( get_post_meta( $id, 'jd_post_styling_print', TRUE) != '' ) {
			$this_post_styles = get_post_meta( $id, 'jd_post_styling_print', TRUE );
			echo "
<style type='text/css' media='print'>\n
$this_post_styles\n
</style>\n";
			}	
echo "<!-- End WP Post Styling -->\n";	
	}
}


// Add the administrative settings to the "Settings" menu.

function jd_addpost_stylingAdminPages() {
    if ( function_exists( 'add_submenu_page' ) ) {
		 add_options_page( 'WP Post Styling', 'WP Post Styling', 8, __FILE__, 'jd_wp_post_styling_manage_page' );
    }
 }
// Include the Manager page
function jd_wp_post_styling_manage_page() {
    include(dirname(__FILE__).'/wp-post-styling-manager.php' );
}
function jd_post_styling_plugin_action($links, $file) {
	if ($file == plugin_basename(dirname(__FILE__).'/wp-post-styling.php'))
		$links[] = "<a href='options-general.php?page=wp-post-styling/wp-post-styling-manager.php'>" . __('Settings', 'wp-post-styling') . "</a>";
	return $links;
}

//Add Plugin Actions and Filters to WordPress

add_filter('plugin_action_links', 'jd_post_styling_plugin_action', -10, 2);

if ( substr( get_bloginfo( 'version' ), 0, 3 ) >= '2.5' ) {
	add_action( 'edit_form_advanced','jd_add_post_styling_textinput' );
	add_action( 'edit_page_form','jd_add_post_styling_textinput' );
} else {
	add_action( 'dbx_post_advanced','jd_add_post_styling_textinput' );
	add_action( 'dbx_page_advanced','jd_add_post_styling_textinput' );
}

add_action( 'save_post', 'set_jd_post_styling' );
add_action( 'wp_head','post_jd_post_styling' );
add_action( 'admin_menu', 'jd_addpost_stylingAdminPages' );
?>