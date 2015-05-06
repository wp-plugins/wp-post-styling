<?php
// Set Default Options
$message = ''; 
	if( get_option( 'post-styling-initial') != '1' ) {
		update_option( 'jd-post-styling-screen', '1' );
		update_option( 'post-styling-initial', '1' );
		update_option( 'jd-post-styling-default', '1' );
		update_option( 'jd-post-styling-library', '0' );		
		update_option( 'jd-post-styling-boxsize', '6' );
	}
		
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'options' ) {
		//UPDATE OPTIONS
		update_option( 'jd-post-styling-screen', ( isset( $_POST['jd-post-styling-screen'] ) )?1:0 );
		update_option( 'jd-post-styling-mobile', ( isset( $_POST['jd-post-styling-mobile'] ) )?1:0 );
		update_option( 'jd-post-styling-print', ( isset( $_POST['jd-post-styling-print'] ) )?1:0 );
		update_option( 'jd-post-styling-default', ( isset( $_POST['jd-post-styling-default'] ) )?1:0 );
		update_option( 'jd-post-styling-library', ( isset( $_POST['jd-post-styling-library'] ) )?1:0 );
		update_option( 'jd-post-styling-boxsize', (int) $_POST['jd-post-styling-boxsize'] );
		$message = __("WP Post Styling Options Updated",'wp-post-styling');

	} 
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'library' ) {
		if ( ( ( !isset( $_POST['jd_style_library_name'] ) || $_POST[ 'jd_style_library_name' ] == "") || 
				( !isset( $_POST['jd_style_library_css'] ) || $_POST[ 'jd_style_library_css' ] == "") || 
				( !isset( $_POST['jd_style_library_type'] ) || $_POST[ 'jd_style_library_type' ] == "")) && !isset($_POST['delete_style']) ) {
		$message = "<ul>";
			if ( $_POST[ 'jd_style_library_name' ] == "" ) {
				$message .= "<li>" . __("Please enter a name for this Style Library record.",'wp-post-styling') . "</li>";
			}
			if ( $_POST[ 'jd_style_library_css' ] == "" ) {
				$message .= "<li>" . __("Please enter styling instructions for this Style Library record.",'wp-post-styling') . "</li>";		
			}
			if ( $_POST[ 'jd_style_library_type' ] == "" ) {
				$message .= "<li>" . __("Please select a type for this Style Library record.",'wp-post-styling') . "</li>";		
			}	
        $message .= "</ul>";
		} else {
			if (isset($_POST['edit_style'])) {
			$results = update_library_style( $_POST['edit_style'], $_POST[ 'jd_style_library_name' ], $_POST[ 'jd_style_library_css' ], $_POST[ 'jd_style_library_type' ]);			
			$type = "update";
			} elseif (isset($_POST['delete_style'])) {
            $results = delete_library_style( $_POST['delete_style'] );
			$type = "delete";
			} else {
			$type = "insert";
			$results = insert_new_library_style( $_POST[ 'jd_style_library_name' ], $_POST[ 'jd_style_library_css' ], $_POST[ 'jd_style_library_type' ]);
			}
			if ( $results == TRUE ) {
				if ( $type == "update" ) {
					$message = __("WP Post Styling Library Updated",'wp-post-styling');
				} elseif ( $type == "delete" ) {
					$message = __("Record Deleted from WP Post Styling Library",'wp-post-styling');				
				} elseif ( $type == "insert" ) {
					$message = __("Record Added to WP Post Styling Library",'wp-post-styling');				
				}
			} else {
			$message = __("WP Post Styling Library Update Failed",'wp-post-styling');
			}
		}
	}
	if (isset($_GET['delete_style'])) {
		$delete_style = (int) $_GET['delete_style'];
		$message = __("Are you sure you want to delete this record?",'wp-post-styling');
		$message .= "<form method=\"post\" action=\"?page=wp-post-styling/wp-post-styling.php\">
		<div>
		<input type=\"hidden\" name=\"delete_style\" value=\"$delete_style\" />
		<input type=\"hidden\" name=\"submit-type\" value=\"library\" />
		<input type=\"submit\" name=\"submit\" class=\"button-primary\" value=\"".__('Yes, delete it!',"wp-post-styling")."\" />
		</div>
		</form>";
	}
	// FUNCTION to see if checkboxes should be checked
	if ( !function_exists('wps_checkbox') ) {
		function wps_checkbox( $theFieldname ){
			if( get_option( $theFieldname ) == '1'){
				echo 'checked="checked"';
			}
		}
	}
?>
<?php if ($message) : ?>
<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div class="wrap" id="wp-post-styling">

<h2><?php _e( 'WP Post Styling', 'wp-post-styling' ); ?></h2>

<div class="postbox-container" style="width:70%">
<div class="metabox-holder">
	<div class="meta-box-sortables">
		<div class="postbox">
		<h3><?php _e("WP Post Styling Settings", 'wp-post-styling'); ?></h3>
		<div class="inside">
			<p>
			<?php _e( "This plugin adds up to three style fields to your posting interface for adding custom styles. Usually, you'll only need custom screen styles, but you can also choose to add mobile or print media styles for each post, if your default style sheets don't cover this.", 'wp-post-styling' ); ?>
			</p>
			<p>
			<?php _e( "Note that the styles you assign a given post using this plugin will only apply to that post's individual post page, and will <em>not</em> be applied on any archive pages.", 'wp-post-styling' ); ?>
			</p>
		</div>
		</div>
	</div>

	<div class="meta-box-sortables">
		<div class="postbox">
		<h3><?php _e("WP Post Styling Settings", 'wp-post-styling'); ?></h3>
		<div id="post-styling-library" class="inside post-styling-library">
		<form method="post" action="<?php admin_url( 'options-general.php?page=wp-post-styling/wp-post-styling.php' ); ?>">
		<?php if (isset($_GET['edit_style']))  { ?>
		
		<?php 
			$id = (int) $_GET['edit_style'];
			$name = jd_post_style_data( $id, 'name' );
			$css = jd_post_style_data( $id, 'css' );
			echo "<div><input type='hidden' name='edit_style' value='$id' /></div>";
		}  else { 
			$name = $css = '';
		}
		?>
			<fieldset>
			<legend><?php if (!isset($_GET['edit_style'])) { 
				_e('Add a Custom Style','wp-post-styling'); 
			} else { 
				_e('Edit Custom Style','wp-post-styling'); 
			} ?></legend>
			<p>
			<label for="jd_style_library_name"><?php _e('Style Name','wp-post-styling'); ?></label><br /><input type="text" name="jd_style_library_name" id="jd_style_library_name" value="<?php esc_attr_e( $name ); ?>" size="40" />
			</p>
			<p>
			<label for="jd_style_library_css"><?php _e('CSS','wp-post-styling'); ?></label><br /><textarea name="jd_style_library_css" id="jd_style_library_css" rows="20" cols="50"><?php esc_html_e( $css ); ?></textarea>
			</p>
			<p>
			<label for="jd_style_library_type"><?php _e('Library Type','wp-post-styling'); ?></label> 
			<select name="jd_style_library_type" id="jd_style_library_type">
				<?php
					$id = ( isset( $_GET['edit_style'] ) ) ? (int) $_GET['edit_style'] : false;
					$type = jd_post_style_data( $id, 'type' );
				?>
				<option value="screen"<?php selected( 'screen', $type ); ?>><?php _e('Screen'); ?></option>
				<option value="mobile"<?php selected( 'mobile', $type ); ?>><?php _e('Mobile'); ?></option>
				<option value="print"<?php selected( 'print', $type ); ?>><?php _e('Print'); ?></option>
			</select>
			</p>
			</fieldset>
			<div>
			<input type="hidden" name="submit-type" value="library" />
			</div>	
		<p>
		<input type="submit" name="submit" class="button-primary" value="<?php if (!isset($_GET['edit_style'])) {  _e('Add to WP Post Styling Library','wp-post-styling'); } else { _e('Update WP Post Styling Library','wp-post-styling'); }?>" />	
		</p>
		</form>
		<?php if ( isset($_GET['edit_style']) ) { 
			echo "<p><a href=\"?page=wp-post-styling/wp-post-styling.php\">"; 
			_e( 'Add New Style','wp-post-styling' ); 
			echo "</a></p>"; 
		} ?>
</div>
</div>
</div>

	<div class="meta-box-sortables">
		<div class="postbox">
		<h3><?php _e('General Settings','wp-post-styling'); ?></h3>
		<div id="post-styling-library" class="inside post-styling-library">
	<form method="post" action="<?php admin_url( 'options-general.php?page=wp-post-styling/wp-post-styling.php' ); ?>">
		<fieldset>
			<legend><?php _e('WordPress Post Styling Options','wp-post-styling'); ?></legend>
			<p>
				<input type="checkbox" name="jd-post-styling-screen" id="wps-screen" value="1" <?php wps_checkbox('jd-post-styling-screen'); ?> />
				<label for="wps-screen"><?php _e('Add Custom Screen Styles','wp-post-styling'); ?></label>
			</p>
			<p>
				<input type="checkbox" name="jd-post-styling-mobile" id="wps-mobile" value="1" <?php wps_checkbox('jd-post-styling-mobile'); ?> />
				<label for="wps-mobile"><?php _e('Add Custom Mobile Styles','wp-post-styling'); ?></label>
			</p>
			<p>				
				<input type="checkbox" name="jd-post-styling-print" id="wps-print" value="1" <?php wps_checkbox('jd-post-styling-print'); ?> />
				<label for="wps-print"><?php _e('Add Custom Print Styles','wp-post-styling'); ?></label>
			</p>
			<p>				
				<input type="checkbox" name="jd-post-styling-default" id="wps-default" value="disable" <?php wps_checkbox('jd-post-styling-default'); ?> />
				<label for="wps-default"><?php _e('Disable Custom Styles as default condition','wp-post-styling'); ?></label>				
			</p>
			<p>				
				<input type="checkbox" name="jd-post-styling-library" id="wps-library" value="disable" <?php wps_checkbox('jd-post-styling-library'); ?> />
				<label for="wps-library"><?php _e('Pull Post Styles Directly from Library','wp-post-styling'); ?></label>				
			</p>			
			<p>				
				<input type="text" name="jd-post-styling-boxsize" id="wps-boxsize" value="<?php esc_attr_e( get_option('jd-post-styling-boxsize') ); ?>" size="3" />
				<label for="wps-boxsize"><?php _e('Size of custom style text box (in lines.)','wp-post-styling'); ?></label>				
			</p>
		</fieldset>
		<div><input type="hidden" name="submit-type" value="options" /></div>
		<p><input type="submit" name="submit" class="button-primary"  value="<?php _e('Save WP Post Styling Options','wp-post-styling'); ?>" /></p>
	</form>
</div>
</div>
</div>

	<div class="meta-box-sortables">
		<div class="postbox">
			<h3><?php _e('Your Style Library','wp-post-styling'); ?></h3>
			<div id="post-styling-library" class="inside post-styling-entries">

			<?php jd_post_style_library_listing(); ?>

			<p>
			<?php _e('Note: editing the styles in your style library will not effect any previously published posts using those styles.','wp-post-styling'); ?>
			</p>
			</div>
		</div>
	</div>
</div>

</div>



<div class="postbox-container" style="width:25%">
	<div class="metabox-holder">
		<div class="meta-box-sortables">
			<div class="postbox">
				<h3><?php _e("Resources", 'wp-post-styling'); ?></h3>
				<div class="inside resources">
					<p>
						<a href="https://twitter.com/intent/tweet?screen_name=joedolson&text=WP%20Post%20Styling%20is%20great%20-%20Thanks!" class="twitter-mention-button" data-size="large" data-related="joedolson">Tweet to @joedolson</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</p>
					<ul>
						<li><a href="https://wordpress.org/plugins/wp-post-styling/"><?php _e("Get Support",'wp-post-styling'); ?></a></li>
						<li><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<div>
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="hosted_button_id" value="5C4T2NCL4GEBE" />
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" name="submit" alt="Donate!" />
						<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
						</div>
						</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
	
		<div class="meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Try my other plugins','wp-post-styling'); ?></h3>
			<div id="support" class="inside resources">
			<ul>
				<li><span class='dashicons dashicons-twitter' aria-hidden="true"></span> <a href="https://wordpress.org/plugins/wp-to-twitter/">WP to Twitter</a></li>
				<li><span class='dashicons dashicons-calendar-alt' aria-hidden="true"></span> <a href="https://wordpress.org/plugins/my-calendar/">My Calendar</a></li>
				<li><span class='dashicons dashicons-tickets' aria-hidden="true"></span> <a href="https://wordpress.org/plugins/my-tickets/">My Tickets</a></li>
				<li><span class='dashicons dashicons-universal-access-alt' aria-hidden="true"></span> <a href="https://wordpress.org/plugins/wp-accessibility/">WP Accessibility</a></li>
				<li><span class='dashicons dashicons-universal-access' aria-hidden="true"></span> <a href="https://wordpress.org/plugins/access-monitor/">Access Monitor</a></li>
				<li><span class='dashicons dashicons-wordpress' aria-hidden="true"></span> <a href="http://profiles.wordpress.org/users/joedolson/"><?php _e('And even more...','wp-post-styling'); ?></a></li>
			</ul>
			</div>
			</div>
		</div>		
	</div>
</div>
</div>
