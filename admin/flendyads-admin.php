<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/claudeamadu/FlendyAds
 * @since      1.0.0
 *
 * @package    FlendyAds
 * @subpackage FlendyAds/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    FlendyAds
 * @subpackage FlendyAds/admin
 * @author     Claude Amadu <obiriclaude@gmail.com>
 */
class FlendyAds_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		// $this->plugin_name = $plugin_name;
		$this->plugin_name = 'flendyads';
		// $this->version = $version;
		$this->version = '1.0.0';
		add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);   
		add_action('admin_init', array( $this, 'registerAndBuildFields' )); 

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in FlendyAds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The FlendyAds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/flendyads-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in FlendyAds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The FlendyAds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/flendyads-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function addPluginAdminMenu() {
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page(  $this->plugin_name, 'FlendyAds', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-admin-site-alt', 26 );
        // add_options_page(
            // 'FlendyAds', 
            // 'FlendyAds', 
            // 'flendyads_options', 
            // 'flendyads_general_settings', 
            // array( $this, 'displayPluginAdminDashboard' )
        // );
	}
	public function displayPluginAdminDashboard() {
		$this->options = get_option( 'flendyads_settings' );
		require_once 'partials/'.$this->plugin_name.'-admin-display.php';
	}
	public function FlendyAdsSettingsMessages($error_message){
		switch ($error_message) {
				case '1':
						$message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );                 $err_code = esc_attr( 'profile_id_setting' );                 $setting_field = 'profile_id_setting';                 
						break;
		}
		$type = 'error';
		add_settings_error(
					$setting_field,
					$err_code,
					$message,
					$type
			);
	}

	public function getOptions(){
		return $this->options;
	}
	
	public function registerAndBuildFields() { 

			/**
		 * First, we add_settings_section. This is necessary since all future settings must belong to one.
		 * Second, add_settings_field
		 * Third, register_setting
		 */     
		add_settings_section(
			// ID used to identify this section and with which to register options
			'flendyads_general_section', 
			// Title to be displayed on the administration page
			'',  
			// Callback used to render the description of the section
				array( $this, 'flendyads_display_general_account' ),    
			// Page on which to add this section of options
			'flendyads_general_settings'                   
		);

		register_setting(
						'flendyads_general_settings',
						'flendyads_settings'
						);

		add_settings_field(
			'flendyads_profile_id_setting',
			'Profile ID',
			array( $this, 'flendyads_profile_id_settings_field' ),
			'flendyads_general_settings',
			'flendyads_general_section'
		);
		add_settings_field(
			'flendyads_website_setting',
			'Website',
			array( $this, 'flendyads_website_settings_field' ),
			'flendyads_general_settings',
			'flendyads_general_section'
		);
		add_settings_field(
			'flendyads_place_setting',
			'Classes & IDs(Append)',
			array( $this, 'flendyads_place_settings_field' ),
			'flendyads_general_settings',
			'flendyads_general_section'
		);
		add_settings_field(
			'flendyads_place_setting2',
			'Classes & IDs(Prepend)',
			array( $this, 'flendyads_place_settings_field2' ),
			'flendyads_general_settings',
			'flendyads_general_section'
		);
	}
	


	function flendyads_profile_id_settings_field() {
		//$profile_id_setting = get_option('flendyads_settings[flendyads_profile_id_setting]');
		printf(
			'<input id="flendyads_profile_id_setting" class="normal-text code" name="flendyads_settings[flendyads_profile_id_setting]" type="text" value="%s" />',
			isset( $this->options['flendyads_profile_id_setting'] ) ? esc_attr( $this->options['flendyads_profile_id_setting']) : ''
			);
	}

	function flendyads_website_settings_field() {
		//$website_setting = get_option('flendyads_settings[flendyads_website_setting]');
		printf(
			'<input id="flendyads_website_setting" class="normal-text code" name="flendyads_settings[flendyads_website_setting]" type="url" value="%s" />',
			isset( $this->options['flendyads_website_setting'] ) ? esc_attr( $this->options['flendyads_website_setting']) : ''
			);
	}

	function flendyads_place_settings_field() {
		printf(
			'<textarea id="flendyads_place_setting" class="normal-text code" name="flendyads_settings[flendyads_place_setting]">%s</textarea>',
			isset( $this->options['flendyads_place_setting'] ) ? esc_attr( $this->options['flendyads_place_setting']) : ''
			);
	}
	function flendyads_place_settings_field2() {
		printf(
			'<textarea id="flendyads_place_setting2" class="normal-text code" name="flendyads_settings[flendyads_place_setting2]">%s</textarea>',
			isset( $this->options['flendyads_place_setting2'] ) ? esc_attr( $this->options['flendyads_place_setting2']) : ''
			);
	}
	public function flendyads_display_general_account() {
		echo '
		<p>These settings apply to all FlendyAds functionality.</p>
		<p>Insert ads(Format: htmlelement-adtype-addata). Seperate with commas</p>';
	} 

}
