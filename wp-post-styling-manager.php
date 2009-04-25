<?php
global $wp_version;
$wp_post_styling_directory = get_bloginfo( 'wpurl' ) . '/' . PLUGINDIR . '/' . dirname( plugin_basename(__FILE__) );

	// Set Default Options
	if( get_option( 'post-styling-initial') != '1' ) {
		update_option( 'jd-post-styling-screen', '1' );
		update_option( 'post-styling-initial', '1' );
		update_option( 'jd-posts-styling-default', 'enable' );
		update_option( 'jd-post-styling-boxsize', '6' );
	}
		
	if ( $_POST['submit-type'] == 'options' ) {
		//UPDATE OPTIONS
		update_option( 'jd-post-styling-screen', $_POST['jd-post-styling-screen'] );
		update_option( 'jd-post-styling-mobile', $_POST['jd-post-styling-mobile'] );
		update_option( 'jd-post-styling-print', $_POST['jd-post-styling-print'] );
		update_option( 'jd-post-styling-default', $_POST['jd-post-styling-default'] );
		update_option( 'jd-post-styling-boxsize', $_POST['jd-post-styling-boxsize'] );
		$message = __("WP Post Styling Options Updated");

	} 
	if ( $_POST['submit-type'] == 'library' ) {
		if ( ($_POST[ 'jd_style_library_name' ] == "") || ($_POST[ 'jd_style_library_css' ] == "") || ($_POST[ 'jd_style_library_type' ] == "") ) {
		$message = "<ul>";
			if ( $_POST[ 'jd_style_library_name' ] == "" ) {
			$message .= "<li>" . __("Please enter a name for this Style Library record.") . "</li>";
			}
			if ( $_POST[ 'jd_style_library_css' ] == "" ) {
			$message .= "<li>" . __("Please enter some CSS for this Style Library record.") . "</li>";		
			}
			if ( $_POST[ 'jd_style_library_type' ] == "" ) {
			$message .= "<li>" . __("Please select a type for this Style Library record.") . "</li>";		
			}	
        $message .= "</ul>";
		} else {
			$results = insert_new_library_style( $_POST[ 'jd_style_library_name' ], $_POST[ 'jd_style_library_css' ], $_POST[ 'jd_style_library_type' ]);
			if ($results == TRUE) {
			$message = __("WP Post Styling Library Updated");
			} else {
			$message = __("WP Post Styling Library Update Failed");
			}
		}
	}

	// FUNCTION to see if checkboxes should be checked
	function jd_checkCheckbox( $theFieldname ){
		if( get_option( $theFieldname ) == '1'){
			echo 'checked="checked"';
		}
	}
?>
<?php if ($message) : ?>
<div id="message" class="updated fade"><?php echo $message; ?></div>
<?php endif; ?>
<div id="dropmessage" class="updated" style="display:none;"></div>

	<?php if ( version_compare( $wp_version,"2.7",">" )) {
	echo "<div class=\"wrap\">";
	} ?>

<div id="wp-post-styling">

<p>
<?php _e("This plugin offers the possibility of adding up to three additional fields to your posting interface for adding styles. Usually, you'll probably only need to add custom screen styles, but you can also choose to add mobile or print media styles for each post, if your default style sheets don't cover this."); ?>
</p>
<p>
<?php _e("Note that the styles you assign a given post using this plugin will only apply to that post's individual post page, and will <em>not</em> be applied on any archive pages."); ?>
</p>
<div class="post-styling-options">
<h2><?php _e('WP Post Styling Options'); ?></h2>
	<form method="post" action="">
		<fieldset>
			<legend><?php _e('WordPress Post Styling Options'); ?></legend>
			<p>
				<input type="checkbox" name="jd-post-styling-screen" id="jd-post-styling-screen" value="1" <?php jd_checkCheckbox('jd-post-styling-screen')?> />
				<label for="jd-post-styling-screen"><strong><?php _e('Add Custom Screen Styles'); ?></strong></label>
			</p>
			<p>
				<input type="checkbox" name="jd-post-styling-mobile" id="jd-post-styling-mobile" value="1" <?php jd_checkCheckbox('jd-post-styling-mobile')?> />
				<label for="jd-post-styling-mobile"><strong><?php _e('Add Custom Mobile Styles'); ?></strong></label>
			</p>
			<p>				
				<input type="checkbox" name="jd-post-styling-print" id="jd-post-styling-print" value="1" <?php jd_checkCheckbox('jd-post-styling-print')?> />
				<label for="jd-post-styling-print"><strong><?php _e('Add Custom Print Styles'); ?></strong></label>
			</p>
			<p>				
				<input type="checkbox" name="jd-post-styling-default" id="jd-post-styling-default" value="disable" <?php jd_checkCheckbox('jd-post-styling-default')?> />
				<label for="jd-post-styling-default"><strong><?php _e('Disable Custom Styles as default condition'); ?></strong></label>				
			</p>
			<p>				
				<input type="text" name="jd-post-styling-boxsize" id="jd-post-styling-boxsize" value="<?php echo get_option('jd-post-styling-boxsize'); ?>" size="3" />
				<label for="jd-post-styling-boxsize"><strong><?php _e('Size of custom style text box (in lines.)'); ?></strong></label>				
			</p>
		</fieldset>
		<div>
		<input type="hidden" name="submit-type" value="options" />
		</div>
		<p>
		<input type="submit" name="submit" class="button-submit"  value="<?php _e('Save WP Post Styling Options'); ?>" />
		</p>
	</form>
</div>
<div class="post-styling-library">
<h2><?php _e('Custom Style Library'); ?></h2>
	<form method="post" action="">
		<fieldset>
		<legend><?php _e('Add Custom Style to Library'); ?></legend>
		<p>
		<label for="jd_style_library_name"><?php _e('Style Name'); ?></label><br /><input type="text" name="jd_style_library_name" id="jd_style_library_name" value="<?php if (isset($_POST['jd_style_library_name'])) { echo $_POST['jd_style_library_name']; } ?>" size="40" />
		</p>
		<p>
		<label for="jd_style_library_css"><?php _e('CSS'); ?></label><br /><textarea name="jd_style_library_css" id="jd_style_library_css" rows="6" cols="40"><?php if (isset($_POST['jd_style_library_css'])) { echo $_POST['jd_style_library_css']; } ?></textarea>
		</p>
		<p>
		<label for="jd_style_library_type"><?php _e('Library Type'); ?></label> <select name="jd_style_library_type" id="jd_style_library_type"><option value="screen"><?php _e('Screen'); ?></option><option value="mobile"><?php _e('Mobile'); ?></option><option value="print"><?php _e('Print'); ?></option></select>
		</p>
		</fieldset>
		<div>
		<input type="hidden" name="submit-type" value="library" />
		</div>	
	<p>
	<input type="submit" name="submit" class="button-submit" value="<?php _e('Add to WP Post Styling Library'); ?>" />	
	</p>
	</form>
</div>



	<h3><?php _e('Need help?'); ?></h3>
	<p><?php _e('Visit the <a href="http://www.joedolson.com/articles/wp-post-styling/">WP Post Styling plugin page</a>.'); ?></p>
	<p><?php _e('<a href="http://www.joedolson.com/donate.php">Support this plugin</a>.'); ?></p>
</div>
<?php if ( version_compare( $wp_version,"2.7",">" )) {
echo "</div>";
} ?>