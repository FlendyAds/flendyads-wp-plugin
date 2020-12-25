<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/claudeamadu/FlendyAds
 * @since             1.0.0
 * @package           FlendyAds
 *
 * @wordpress-plugin
 * Plugin Name:       FlendyAds
 * Plugin URI:        https://github.com/claudeamadu/FlendyAds
 * Description:       Allows you to initialize FlendyAds in your WordPress site.
 * Version:           1.0.0
 * Author:            Claude Amadu
 * Author URI:        https://github.com/claudeamadu/FlendyAds
 * Requires at least:   3.8.0
 * Requires PHP:        5.2+
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flendyads
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SETTINGS_PAGE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/flendyads-activator.php
 */
function activate_flendyads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/flendyads-activator.php';
	FlendyAds_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/flendyads-deactivator.php
 */
function deactivate_flendyads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/flendyads-deactivator.php';
	FlendyAds_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flendyads' );
register_deactivation_hook( __FILE__, 'deactivate_flendyads' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/flendyads.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
 
 
// Hook the 'wp_footer' action, run the function named 'mfp_Add_Text()'
add_action("wp_footer", "flendyads_script_add");
add_action("wp_footer", "flendyads_add_ads");
 
// 
function flendyads_script_add()
{
	$devid = get_option('flendyads_settings');
	echo "<script ad-client='".$devid['flendyads_profile_id_setting']."' async src='https://flendyads.com/ads/script/ads.js'></script>";
}

function flendyads_add_ads()
{
	$settings = get_option('flendyads_settings');
	$code = $settings['flendyads_place_setting'];
	if(!empty($code)){
		$split = explode(",",$code);
?>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script>
<?php
		foreach ($split as $key => $value) {
			// $arr[3] will be updated with each value from $arr...
			$split = explode("-",$value);
?>
			$('<?=$split[0]?>').append('<div ad-type="<?=$split[1]?>" ad-data="<?=$split[2]?>"></div>');
<?php
		}
	}
	
	$settings = get_option('flendyads_settings');
	$code = $settings['flendyads_place_setting2'];
	if(!empty($code)){
		$split = explode(",",$code);
?>
<?php
		foreach ($split as $key => $value) {
			// $arr[3] will be updated with each value from $arr...
			$split = explode("-",$value);
?>
			$('<?=$split[0]?>').prepend('<div ad-type="<?=$split[1]?>" ad-data="<?=$split[2]?>"></div>');
<?php
		}
	}
?>
	</script>
<?php
}
 
function run_flendyads() {

	$plugin = new FlendyAds();
	$plugin->run();

}
run_flendyads();
