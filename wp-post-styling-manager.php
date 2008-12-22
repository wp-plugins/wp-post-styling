<?php

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
		$message = "WP Post Styling Options Updated";

	} 

	// FUNCTION to see if checkboxes should be checked
	function jd_checkCheckbox( $theFieldname ){
		if( get_option( $theFieldname ) == '1'){
			echo 'checked="checked"';
		}
	}
?>
<style type="text/css">
<!-- 
#wp-post-styling fieldset {
margin: 0;
padding:0;
border: none;
}
#wp-post-styling form p {
background: #eaf3fa;
padding: 10px 5px;
margin: 4px 0;
border: 1px solid #eee;
}
#wp-post-styling form .error p {
background: none;
border: none;
}
-->
</style>
<?php if ($message) : ?>
<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div id="dropmessage" class="updated" style="display:none;"></div>

<div class="wrap" id="wp-post-styling">

<h2><?php _e('WP Post Styling Options'); ?></h2>
<p>
<?php _e("This plugin offers the possibility of adding up to three additional fields to your posting interface for adding styles. Usually, you'll probably only need to add custom screen styles, but you can also choose to add mobile or print media styles for each post, if your default style sheets don't cover this."); ?>
</p>
<p>
<?php _e("Note that the styles you assign a given post using this plugin will only apply to that post's individual post page, and will <em>not</em> be applied on any archive pages."); ?>
</p>
		
	<form method="post" action="">
	<div>
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
		<div>
		<input type="hidden" name="submit-type" value="options" />
		</div>
		<input type="submit" name="submit" value="<?php _e('Save WP Post Styling Options'); ?>" />			

</div>


<div class="wrap">
	<h3><?php _e('Need help?'); ?></h3>
	<p><?php _e('Visit the <a href="http://www.joedolson.com/articles/wp-post-styling/">WP Post Styling plugin page</a>.'); ?></p>
</div>
