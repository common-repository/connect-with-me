<?php
/* ADMIN PAGE */
if ( is_admin() ){
	// hook the admin options page to settings menu
	add_action('admin_menu', 'plugin_admin_add_page');
	// add the actual menu element
	function plugin_admin_add_page() {
		$page = add_options_page('Connect With Me', 'Connect With Me', 'manage_options', 'connect-with-me-admin', 'cwm_admin_page');
		add_action( 'admin_print_styles-' . $page, 'cwm_admin_styles' );
	}
	//
	function cwm_admin_styles() {
		//It will be called only on your plugin admin page, enqueue our stylesheet here
		wp_enqueue_style( 'cwm_admin_css' );
	}
	// display the admin options page
	function cwm_admin_page() {
	?>
	<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div><h2>Connect With Me Settings</h2>
	<p>Enter your social media profile ID's and choose an icon style to activate your Connect With Me display links.</p>
	<p>To place it on your site, you can either place the Connect With Me widget in any of your theme's sidebar, or place the code <code>&lt;?php wperConnectWithMe(); ?&gt;</code> in your theme template(s).</p>
	<form action="options.php" method="post">
	<?php settings_fields('social_media'); ?>
	<?php do_settings_sections('connect-with-me-admin'); ?>
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	<p>Questions or comments? Go to <a href="http://thewordpresser.com/projects/plugins/connect-with-me/" target="_blank">Connect With Me plugin page</a>.</div>
	<?php
	}
	
	// add_action to call the administration functions
	add_action('admin_init', 'cwm_admin_init');
	// the actual administration function
	function cwm_admin_init(){
		/* Register our stylesheet. */
		wp_register_style( 'cwm_admin_css', plugins_url('admin.css', __FILE__) );
		/* SETTINGS: social media (profiles), social media icons */
		register_setting( 'social_media', 'social_media', '' );
		/* SECTIONS: social media (profiles), social media icons */
		add_settings_section('section_social_media', 'Social Media Profiles', 'section_social_media_desc', 'connect-with-me-admin');
		/* FIELDS - social media (profiles) */
		add_settings_field('cwm_facebook', 'Your Facebook ID', 'cwm_facebook_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_twitter', 'Your Twitter ID', 'cwm_twitter_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_linkedin', 'Your LinkedIn ID', 'cwm_linkedin_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_googleplus', 'Your Google+ ID', 'cwm_googleplus_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_youtube', 'Your YouTube Channel ID', 'cwm_youtube_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_flickr', 'Your Flickr ID', 'cwm_flickr_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_email', 'Your E-mail', 'cwm_email_input', 'connect-with-me-admin', 'section_social_media');
		add_settings_field('cwm_skype', 'Your Skype ID', 'cwm_skype_input', 'connect-with-me-admin', 'section_social_media');
		/* FIELD - social media icons */
		add_settings_field('cwm_iconstyle', 'Icons style', 'cwm_style_input', 'connect-with-me-admin', 'section_social_media');
	}
	//SECTIONS - descriptions
	function section_social_media_desc() {
		echo '<p>Enter the ID of your social media profiles in the fields below. Leave fields empty to exclude the profile from the displayed list of icons/links.</p>';
	}
	//INPUTS - social media profiles
	function cwm_facebook_input() { //Facebook
		$options = get_option('social_media');
		echo "<input id='cwm_facebook' name='social_media[facebook]' size='40' type='text' value='{$options['facebook']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the name in your profile url: <em>http://www.facebook.com/<b>akerbak</b></em>.</p>";
	}
	function cwm_twitter_input() { //Twitter
		$options = get_option('social_media');
		echo "<input id='cwm_twitter' name='social_media[twitter]' size='40' type='text' value='{$options['twitter']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the name in your profile url: <em>http://www.twitter.com/#!/<b>akerbak</b></em>.</p>";
	}
	function cwm_linkedin_input() { //LinkedIn
		$options = get_option('social_media');
		echo "<input id='cwm_linkedin' name='social_media[linkedin]' size='40' type='text' value='{$options['linkedin']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the name in your profile url: <em>http://www.linkedin.com/in/<b>akerbak</b></em>.</p>";
	}
	function cwm_googleplus_input() { //Google+
		$options = get_option('social_media');
		echo "<input id='cwm_googleplus' name='social_media[googleplus]' size='40' type='text' value='{$options['googleplus']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the ID in your profile url: <em>https://plus.google.com/<b>103024091491269741782</b></em>.</p>";
	}
	function cwm_youtube_input() { //YouTube
		$options = get_option('social_media');
		echo "<input id='cwm_youtube' name='social_media[youtube]' size='40' type='text' value='{$options['youtube']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the name in your channel url: <em>http://www.youtube.com/user/<b>djus</b></em>.</p>";
	}
	function cwm_flickr_input() { //Flickr
		$options = get_option('social_media');
		echo "<input id='cwm_flickr' name='social_media[flickr]' size='40' type='text' value='{$options['flickr']}' />
		<p class='cwm-help'><span>How to find?</span> Locate the ID in your photos or profile url: <em>http://www.flickr.com/photos/<b>50506828@N07</b></em>.</p>";
	}
	function cwm_email_input() { //E-mail
		$options = get_option('social_media');
		echo "<input id='cwm_email' name='social_media[email]' size='40' type='text' value='{$options['email']}' />";
	}
	function cwm_skype_input() { //Skype
		$options = get_option('social_media');
		echo "<input id='cwm_skype' name='social_media[skype]' size='40' type='text' value='{$options['skype']}' />";
	}
	//INPUTS - icons style sets
	function cwm_style_input() { //LinkedIn
		//Preparing some variables
		$file = dirname(__FILE__) . '/connect-with-me.php';
		$plugin_url = plugin_dir_url($file);
		// Output something like: http://example.com/wp-content/plugins/your-plugin/
		$options = get_option('social_media');
		
		$number_of_icons = 3;
		for($i=1;$i<=$number_of_icons;$i++) {
			
			if($options['style'] == $i) {
				$checked = "checked";
			} else { $checked = ""; }
		
			echo "<div class='iconstyle'>
			<img src='".$plugin_url."images/icons-".$i."/preview.png' alt='Style set' />
			<p>Use this icon set: <input id='cwm_iconstyle_".$i."' name='social_media[style]' size='40' type='radio' value='".$i."' ".$checked." /></p>";
		}
	}
}
?>