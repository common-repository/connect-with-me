<?php
/*
Plugin Name: Connect With Me
Plugin URI: http://www.thewordpresser.com/projects/plugins/connect-with-me
Description: Connect With Me offers a widget to place in any sidebar of your theme. Within the widget is a list of icons that link to your/your site\'s profile of the social media sites and communities (e.g. Facebook, Twitter, LinkedIn) of your choosing. You can easily manage which social media sites and communities you wish to include in the list, and you can select from various sets of icons to make the list suit your theme.
Version: 1.0
Author: akerbak
Author URI: http://www.thewordpresser.com
License: GPL
*/
include("connect-with-me-admin.php");
/* STYLES */
/* Hook up the CSS*/
    add_action('wp_enqueue_scripts', 'cwm_default_css');

    /*
     * Enqueue style-file, if it exists.
     */

    function cwm_default_css() {
        $cwm_css_url = plugins_url('cwm-style.css', __FILE__);
        $cwm_css_file = WP_PLUGIN_DIR . '/connect-with-me/cwm-style.css';
        if ( file_exists($cwm_css_file) ) {
            wp_register_style('cwm_default_style', $cwm_css_url);
            wp_enqueue_style( 'cwm_default_style');
        }
    }
/* MAKE THE LIST */
/* The function that prints the list*/
function wperConnectWithMe() {
	$cwm_profiles = get_option('social_media');
	if($cwm_profiles['style'] == 0) {
		$cwm_style_id = 1;
	} else {
		$cwm_style_id = $cwm_profiles['style'];
	}
	$cwm_file = dirname(__FILE__) . '/connect-with-me.php';
	$cwm_plugin_url = plugin_dir_url($cwm_file);
	$cwm_image_url = $cwm_plugin_url."images/icons-".$cwm_style_id;
	
	echo "<div id='cwm-container'><ul id='cwm-list'>";
	foreach ($cwm_profiles as $key => $val) {
		switch($key) {
			case 'facebook': $url = 'http://www.facebook.com/'.$val; break; 
			case 'twitter': $url = 'http://www.twitter.com/#!/'.$val; break; 
			case 'linkedin': $url = 'http://www.linkedin.com/in/'.$val; break;
			case 'googleplus': $url = 'http://plus.google.com/'.$val; break;
			case 'youtube': $url = 'http://www.youtube.com/user/'.$val; break;
			case 'flickr': $url = 'http://www.flickr.com/photos/'.$val; break;
			case 'email': $url = 'mailto:'.$val; break;
			case 'skype': $url = 'skype:'.$val.'?call'; break;
		}
		if(!empty($val) && $key != "style") {
			echo "<li><a href='".$url."' title='Connect With Me at ".$key."' target='_blank'><img src='".$cwm_image_url."/".$key.".png' alt='".$key."' /></a></li>";
		}
	}
	echo "</ul></div>";
}

/* PREPARE THE WIDGET */
class ConnectWithMe_Widget extends WP_Widget
{
function ConnectWithMe_Widget() {
	$widget_ops = array('classname' => 'ConnectWithMe_Widget', 'description' => 'The Connect With Me widget displays a list of icons and links to your social media profiles.');
	$this->WP_Widget('ConnectWithMe_Widget', 'Connect With Me', $widget_ops);
}

function form($instance) {
$instance = wp_parse_args((array) $instance, array( 'title' => '' ));
$title = $instance['title'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
}

function update($new_instance, $old_instance)
{
$instance = $old_instance;
$instance['title'] = $new_instance['title'];
return $instance;
}

function widget($args, $instance)
{
extract($args, EXTR_SKIP);

echo $before_widget;
$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

if (!empty($title))
echo $before_title . $title . $after_title;

/* The Widget Output, which is the list, populated by wperConnectWithMe() */
wperConnectWithMe();

echo $after_widget;
}
}
/* Add the widget to WordPress */
add_action( 'widgets_init', create_function('', 'return register_widget("ConnectWithMe_Widget");') );

?>