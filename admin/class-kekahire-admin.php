<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://lumel.com
 * @since      1.0.0
 *
 * @package    Kekahire
 * @subpackage Kekahire/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kekahire
 * @subpackage Kekahire/admin
 * @author     Aman & KG <amans@lumel.com and kg@lumel.com>
 */
class Kekahire_Admin {

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

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Kekahire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kekahire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kekahire-admin.css', array(), $this->version, 'all' );
		
		/**
		 * Include Select2 CSS in admin settings page.
		 *
		 * @since    1.0.0
		 */
		if( $_GET[ 'page' ] == "kekahire-settings" ) {

			wp_enqueue_style( $this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13', 'all' );

		}

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
		 * defined in Kekahire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kekahire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kekahire-admin.js', array( 'jquery' ), $this->version, false );
		
		/**
		 * Localize script.
		 *
		 * @since    1.0.0
		 */
		wp_localize_script( $this->plugin_name, 'KH_OBJECT',
			
			array( 
				
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			
			)
		
		);
		
		/**
		 * Include Select2 JS in admin settings page.
		 *
		 * @since    1.0.0
		 */
		if( $_GET[ 'page' ] == "kekahire-settings" ) {

			wp_enqueue_script( $this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), '4.0.13', false );

		}
		
		/**
		 * Include Color Picker JS in admin settings page.
		 *
		 * @since    1.0.0
		 */
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

	}
	
	/**
	 * Admin menu hook for adding Kekahire Settings menu.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_add_options_page() {

		add_menu_page( 'Kekahire Settings', 'Kekahire', 'administrator', 'kekahire-settings', array ( $this, 'kekahire_settings_page' ) , plugins_url( 'kekahire/admin/images/kekahire-icon.png' ) );

	}
	
	/**
	 * Kekahire Settings page.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_settings_page() {

		$kekahire_subdomain = get_option( 'kekahire_subdomain' );
		
		if($kekahire_subdomain !== false && $kekahire_subdomain !== '' ) {
			
			$kekahire_dept_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/organization/departments/" );
			
			$kekahire_location_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/organization/locations/" );

			$departments = json_decode( $kekahire_dept_payload[ 'body' ] , true );
			
			$locations = json_decode( $kekahire_location_payload[ 'body' ] , true );
		
		}
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kekahire-countries.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/kekahire-admin-display.php';

	}
	
	/**
	 * Hook to register the settings fields for Kekahire.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_register_setting() {

		add_settings_section( "kekahire_settings", "General Settings", array( $this, "kekahire_settings_callback" ), "kekahire-settings" );

		add_settings_field( "kekahire_subdomain", "Kekahire Subdomain", array( $this, "kekahire_subdomain_callback" ), "kekahire-settings", "kekahire_settings" );
		
		add_settings_section( "kekahire_settings_color", "Color Settings", array( $this, "kekahire_settings_color_callback" ), "kekahire-settings" );

		add_settings_field( "kekahire_color", "Color Theme", array( $this, "kekahire_color_callback" ), "kekahire-settings", "kekahire_settings_color" );
		
		add_settings_field( "kekahire_button_bg", "Button Background", array( $this, "kekahire_button_bg_callback" ), "kekahire-settings", "kekahire_settings_color" );
		add_settings_field( "kekahire_button_color", "Button Color", array( $this, "kekahire_button_color_callback" ), "kekahire-settings", "kekahire_settings_color" );

		add_settings_field( "kekahire_button_hover_bg", "Button Hover Background", array( $this, "kekahire_button_hover_bg_callback" ), "kekahire-settings", "kekahire_settings_color" );
		add_settings_field( "kekahire_button_hover_color", "Button Hover Color", array( $this, "kekahire_button_hover_color_callback" ), "kekahire-settings", "kekahire_settings_color" );
		
		register_setting( "kekahire_settings" , "kekahire_subdomain" );
		register_setting( "kekahire_settings" , "kekahire_color" );
		register_setting( "kekahire_settings" , "kekahire_button_bg" );
		register_setting( "kekahire_settings" , "kekahire_button_color" );
		register_setting( "kekahire_settings" , "kekahire_button_hover_bg" );
		register_setting( "kekahire_settings" , "kekahire_button_hover_color" );

	}

	/**
	 * Callback to display the "Kekahire Settings" section description.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_settings_callback() {

		?>
		
		<p class="description"><?php _e( 'Please enter your Keka subdomain below', 'kekahire' ); ?></p>
		
		<?php

	}

	/**
	 * Callback to display the "Kekahire Subdomain" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_subdomain_callback() {

		?>
		
		<input type="text" id="kekahire_subdomain" name="kekahire_subdomain" value="<?php echo get_option( 'kekahire_subdomain' ); ?>" />.keka.com
		
		<?php

	}
	
	/**
	 * Callback to display the "Kekahire Color Settings" section description.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_settings_color_callback() {

		?>
		
		<p class="description"><?php _e( 'Please select Color theme', 'kekahire' ); ?></p>
		
		<?php

	}

	/**
	 * Callback to display the "Kekahire Color Setting" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_color_callback() {

		?>
		
		<input type="text" class="kekahire-my-color-field" id="kekahire_color" name="kekahire_color" value="<?php echo get_option( 'kekahire_color' ); ?>" />
		
		<?php

	}
	
	/**
	 * Callback to display the "Kekahire Button Background Setting" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_button_bg_callback() {

		?>
		
		<input type="text" class="kekahire-my-color-field" id="kekahire_button_bg" name="kekahire_button_bg" value="<?php echo get_option( 'kekahire_button_bg' ); ?>" />
		
		<?php

	}
	
	/**
	 * Callback to display the "Kekahire Button Color Setting" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_button_color_callback() {

		?>
		
		<input type="text" class="kekahire-my-color-field" id="kekahire_button_color" name="kekahire_button_color" value="<?php echo get_option( 'kekahire_button_color' ); ?>" />
		
		<?php

	}
	
	/**
	 * Callback to display the "Kekahire Button Hover Background Setting" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_button_hover_bg_callback() {

		?>
		
		<input type="text" class="kekahire-my-color-field" id="kekahire_button_hover_bg" name="kekahire_button_hover_bg" value="<?php echo get_option( 'kekahire_button_hover_bg' ); ?>" />
		
		<?php

	}
	
	/**
	 * Callback to display the "Kekahire Button Hover Color Setting" setting.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_button_hover_color_callback() {

		?>
		
		<input type="text" class="kekahire-my-color-field" id="kekahire_button_hover_color" name="kekahire_button_hover_color" value="<?php echo get_option( 'kekahire_button_hover_color' ); ?>" />
		
		<?php

	}
	
	/**
	 * Callback to display state/city.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_load_state_city_ajax(){
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kekahire-countries.php';
		
		$classObject = new KH_Countries();
		
		$statesname = $classObject->get_states();

		$country = $_POST["country"];
		
		$state = explode(",",$_POST["state"]);

		header("Content-Type: text/html");
		
		$output = '';
		
		$kekahire_subdomain = get_option( 'kekahire_subdomain' );
		
		$kekahire_location_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/organization/locations/" );
		
		$locations = json_decode( $kekahire_location_payload[ 'body' ] , true );
		
		if($country) {
			
			foreach ( $locations as $location ) {
				
				if($country == $location['address'][ 'countryCode' ]) {
					
					$output .= '<option value="' . $location['address'][ 'state' ] . '">' . $statesname[$location['address'][ 'countryCode' ]][$location['address'][ 'state' ]] . '</option>'; 
				
				}

			}
		}
		
		if($state) {
			
			foreach ( $locations as $location ) {
				
				if(in_array($location['address'][ 'state' ],$state)) {
					
					$output .= '<option value="' . $location['address'][ 'city' ] . '">' . $location['address'][ 'city' ] . '</option>'; 
				
				}

			}
		}
		
		die($output);
	}

}
