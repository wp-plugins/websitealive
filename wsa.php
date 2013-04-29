<?php
/*
Plugin Name: WebsiteAlive Live Chat
Plugin URI: 
Description: AliveChat is the easy-to-use Live Chat solution for your Wordpress website. Visitors can immediately chat with someone at your company who can answer all their questions, all in real time.This plugin adds your AliveChat Embedded Icon/Tracking Code in the footer section of your Wordpress site.
Version: 1.1
Author: AYU Technology Solutions, LLC
Author URI: http://www.websitealive.com
License: no.
*/


if ( !class_exists( 'WebsiteAlive' ) ) {
	
	define('WSAURL',    plugins_url('', __FILE__));
	wp_register_style('WSAStyleSheet', WSAURL . '/wsa.css');
    wp_enqueue_style( 'WSAStyleSheet');
	
	class WSA {

	function WSA() {
		
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
		
	}
	
	function init() {
		load_plugin_textdomain( 'websitealive', false, dirname( plugin_basename ( __FILE__ ) ).'/lang' );
	}
	
	function admin_init() {
		register_setting( 'websitealive', 'wsa_objectref', 'trim' );
		register_setting( 'websitealive', 'wsa_groupid', 'trim' );
		register_setting( 'websitealive', 'wsa_websiteid', 'trim' );
	}
	
	function admin_menu() {
		add_submenu_page( 'options-general.php', 'WebsiteAlive', 
			'WebsiteAlive', 'manage_options', __FILE__, array( &$this, 'options_panel' ) );
	}

	function wp_footer() {
		if ( !is_admin() && !is_feed() && !is_robots() && !is_trackback() ) {
			$text = '<!-- Start WebsiteAlive Embedded Icon/Tracking Code -->
					<script type="text/javascript">
					function wsa_include_js(){
					var wsa_host = (("https:" == document.location.protocol) ? "https://" : "http://");
					var js = document.createElement("script");
					js.setAttribute("language", "javascript");
					js.setAttribute("type", "text/javascript");
					js.setAttribute("src",wsa_host + "tracking.websitealive.com/vTracker_v2.asp?objectref='.get_option( 'wsa_objectref', '' ).'&groupid='.get_option( 'wsa_groupid', '' ).'&websiteid='.get_option( 'wsa_websiteid', '' ).'");
					document.getElementsByTagName("head").item(0).appendChild(js);
					}
					if (window.attachEvent) {window.attachEvent("onload", wsa_include_js);}
					else if (window.addEventListener) {window.addEventListener("load", wsa_include_js, false);}
					else {document.addEventListener("load", wsa_include_js, false);}
					</script>
					<!-- End WebsiteAlive Embedded Icon/Tracking Code -->';
			
			$text = convert_smilies( $text );
			$text = do_shortcode( $text );
			
			if ( $text != '' ) {
				echo $text, "\n";
			}
		}
	}
	
	        
	
	function options_panel() {
?>
<div id="ichat-wrap">
<div class="wrap">
<?php screen_icon(); ?>
<h2>WebsiteAlive for Wordpress - AliveChat Options</h2>
<div class="ichat-wrap">
<form name="dofollow" action="options.php" method="post">
<?php settings_fields( 'websitealive' ); ?>
<label class="ichat-labels footerlabel" for="ichat_insert_footer">If you are a current AliveChat client, please enter the proper account values in the fields below. The values can be found within your WebsiteAlive account
Click here to login: <a href="http://www.websitealive.com/">My Account</a> </label>
<br></br>
If you do not have an existing AliveChat account? No problem, we will be happy to give you a free 10 day test drive! Get AliveChat now -><a href="http://www.websitealive.com/refer/?promocode=promosales-528&page=trial">SIGN UP</a> 
<br></br>
Input your account information below to install AliveChat on your Wordpress site
<br></br>
<span>objectref:</span>	<input type="text" id="wsa_objectref" name="wsa_objectref" value="<?php echo esc_html( get_option( 'wsa_objectref' ) ); ?>" /><br />
<span>groupid: </span>	<input type="text" id="wsa_groupid" name="wsa_groupid" value="<?php echo esc_html( get_option( 'wsa_groupid' ) ); ?>" /><br />
<span>websiteid:</span>	<input type="text" id="wsa_websiteid" name="wsa_websiteid" value="<?php echo esc_html( get_option( 'wsa_websiteid' ) ); ?>" /><br />
<br />
This plugin adds WebsiteAlive Embedded Icon/Tracking Code in the footer section of your Wordpress site.

<p class="submit">
<input type="submit" name="Submit" value="Save settings" /> 
</p>

</form>
</div>


</div>
</div>
<?php
	}
}


$wp_insert_headers_and_footers = new WSA();

}