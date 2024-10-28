<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://lumel.com
 * @since      1.0.0
 *
 * @package    Kekahire
 * @subpackage Kekahire/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kekahire
 * @subpackage Kekahire/public
 * @author     Aman & KG <amans@lumel.com and kg@lumel.com>
 */
class Kekahire_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kekahire-public.css', array(), $this->version, 'all' );
		
		/**
		 * Include Select2 CSS.
		 *
		 * @since    1.0.0
		 */

		wp_enqueue_style( $this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13', 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kekahire-public.js', array( 'jquery' ), $this->version, false );
		
		/**
		 * Include Select2 JS.
		 *
		 * @since    1.0.0
		 */

		wp_enqueue_script( $this->plugin_name . '-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), '4.0.13', false );
		

	}
	
	/**
	 * Adding Kekahire shortcodes for listings and signle job posts.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_add_shortcodes() {

		add_shortcode( 'kekajobs' , array ( $this, 'kekahire_listings_callback' ) );

	}
	
	/**
	 * Kekahire Listings shortcode callback.
	 *
	 * @since    1.0.0
	 */
	public function kekahire_listings_callback( $atts ) {

		$atts = shortcode_atts( 
			array( 
				'title' => '',
				'listing' => '',
				'departments' => '',
				'country' => '',
				'state' => '',
				'city' => '',
				'zerolisting' => '',
				'hidecount' => '',
				'defaultdepartment' => '',
				'defaultlocation' => '',
				'itemsinrow' => '',
				'excludejobs' => '',
			), 
			$atts, 
			'kekajobs' 
		);
		
		$listingtype = $atts[ 'listing' ];
		
		$kekahire_subdomain = get_option( 'kekahire_subdomain' );
		
		if( $kekahire_subdomain == "" ) {
			
			return false;
		
		}
		
		$kekahire_color = get_option( 'kekahire_color' );
		$kekahire_button_bg = get_option( 'kekahire_button_bg' );
		$kekahire_button_color = get_option( 'kekahire_button_color' );
		$kekahire_button_hover_bg = get_option( 'kekahire_button_hover_bg' );
		$kekahire_button_hover_color = get_option( 'kekahire_button_hover_color' );

		$kekahire_dept_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/organization/departments/" );
		$kekahire_location_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/organization/locations/" );
		$kekahire_listings_payload = wp_remote_get( "https://$kekahire_subdomain.keka.com/careers/api/jobs/default/active/" );

		$departments = json_decode( $kekahire_dept_payload[ 'body' ] , true );
		$locations = json_decode( $kekahire_location_payload[ 'body' ] , true );
		$listings = json_decode( $kekahire_listings_payload[ 'body' ] , true );

		ob_start();

		$locationcountarray = array();
		
		$departmentcountarray = array();
		
		$departmentcounter = 0;
		
		foreach ( $listings as $listing ) {
			
			$listing_passed = true;
			
			if( $atts[ 'excludejobs' ] !== "" ) {
				
				$excludejobs = explode(",", $atts[ 'excludejobs' ] );
		
				foreach ( $excludejobs as $excludejob ) {

					if( $excludejob == $listing[ 'id' ] ) {

						$listing_passed = false;

					}

				}

			}
			
			if( $listing_passed ) {
				
				if($listing['jobLocations'][0]['city']!='') {
					
					$locationcountarray[$listing['jobLocations'][0]['city']]['count']++;
				
				}
				
				if($listing['departmentId']!='') {
					
					$departmentcountarray[$listing['departmentId']]['count']++;
				
				}
			
			} 
		
		}
		?>
		<style>
		.kekahire-smart-listing-container .kekahire-sidebar-wrapper ul li.selected,
		.kekahire-smart-listing-container .kekahire-sidebar-wrapper ul li:hover {
			color: <?php echo $kekahire_color; ?>;
		}
		.kekahire-smart-listing-container .kekahire-apply-button {
			background: <?php echo $kekahire_button_bg; ?>;
			color: <?php echo $kekahire_button_color; ?>;
		}
		.kekahire-smart-listing-container .kekahire-apply-button:hover {
			background: <?php echo $kekahire_button_hover_bg; ?>;
			color: <?php echo $kekahire_button_hover_color; ?>;
		}
		</style>
		
		<?php
		
		//Listing Type - Smart
		
		if($listingtype == "smart") {
		
		?>
		
		<div class="kekahire-smart-listing-container kekahire-data-fetch" data-department="<?php echo $atts[ 'defaultdepartment' ]; ?>" data-location="<?php echo $atts[ 'defaultlocation' ]; ?>">
			
			<div class="kekahire-location-selector-wrapper">
				
				<div class="kekahire-location-selector">
					
					<label for="kekahire-location-selector-select" class="kekahire-location-selector-title">
						
						<?php _e( 'Select Location', 'kekahire' ); ?>
					
					</label>
					
					<select id="kekahire-location-selector-select">
						
						<option value=""><?php _e( 'All', 'kekahire' ); ?></option>
						
						<?php
						
						foreach ( $locations as $location ) {
							
							$locationcount = '';
							
							if($atts[ 'hidecount' ] != 1) {
								
								$locationcount = ' ('.$locationcountarray[$location['address'][ 'city' ]]['count'].')';
							
							}
							
							$defaultlocation = '';
							
							if($atts[ 'defaultlocation' ] == $location['address'][ 'city' ]) {
								
								$defaultlocation = ' selected';
							
							}
							
							if($locationcountarray[$location['address'][ 'city' ]]['count'] > 0) {
								
								echo '<option value="' . $location['address'][ 'city' ] . '"'.$defaultlocation.' />' . $location['address'][ 'city' ]. ',' . $location['address'][ 'countryCode' ] .$locationcount; 
							
							}
							
							else if($atts[ 'zerolisting' ] != 1) {
								
								echo '<option value="' . $location['address'][ 'city' ] . '"'.$defaultlocation.' />' . $location['address'][ 'city' ]. ',' . $location['address'][ 'countryCode' ]; 
							
							}
							
						}
						
						?>
					
					</select>
				
				</div>
				
				<div class="kekahire-department-selector">
					
					<label class="kekahire-department-selector-title">
						
						<?php _e( 'Select Department', 'kekahire' ); ?>
					
					</label>
					
					<select id="kekahire-department-selector-select">
						
						<option value=""><?php _e( 'All', 'kekahire' ); ?></option>
						
						<?php						
						
						foreach ( $departments as $department ) {
							
							$departmentcount = '';
							
							if($atts[ 'hidecount' ] != 1) {
								
								$departmentcount = ' ('.$departmentcountarray[$department[ 'id' ]]['count'].')';
							
							}
							
							$defaultdepartment = '';
							
							if($atts[ 'defaultdepartment' ] == $department[ 'id' ]) {
								
								$defaultdepartment = ' selected';
							
							}
							
							if($departmentcountarray[$department[ 'id' ]]['count'] > 0) {
								
								echo '<option value="' . $department[ 'id' ] . '"'.$defaultdepartment.' />' . $department[ 'name' ] .$departmentcount;
							
							}
							
							else if($atts[ 'zerolisting' ] != 1) {
								
								echo '<option value="' . $department[ 'id' ] . '"'.$defaultdepartment.' />' . $department[ 'name' ];
							
							} 

						}
						
						?>
						
					</select>
				
				</div>
			
			</div>
			
			<div class="kekahire-sidebar-listing-wrapper">
				
				<h4><?php _e( 'Departments', 'kekahire' ); ?></h4>
				
				<div class="kekahire-sidebar-wrapper">
					
					<ul>
						
						<li <?php if($atts[ 'defaultdepartment' ] == '') {?>class="selected"<?php } ?> data-value=""><span><?php _e( 'All', 'kekahire' ); ?></span></li>
						
						<?php							
						
						foreach ( $departments as $department ) {
							
							$departmentcount = '';
							
							if($atts[ 'hidecount' ] != 1) {
								
								$departmentcount = ' ('.$departmentcountarray[$department[ 'id' ]]['count'].')';
							
							}
							
							$defaultdepartment = '';
							
							if($atts[ 'defaultdepartment' ] == $department[ 'id' ]) {
								
								$defaultdepartment = ' class="selected"';
							
							}
							
							if($departmentcountarray[$department[ 'id' ]]['count'] > 0) {
								
								echo '<li'.$defaultdepartment.' data-value="' . $department[ 'id' ] . '"><span>' . $department[ 'name' ] .$departmentcount.'</span></li>';
							
							}
							
							else if($atts[ 'zerolisting' ] != 1) {
								
								echo '<li'.$defaultdepartment.' data-value="' . $department[ 'id' ] . '"><span>' . $department[ 'name' ] .'</span></li>';
							
							} 

						}

						?>
					
					</ul>
				
				</div>
				
				<div class="kekahire-listing-wrapper">
					
					<?php
					
					foreach ( $listings as $listing ) {
						
						$listing_passed = true;
						
						if( $atts[ 'excludejobs' ] !== "" ) {
							
							$excludejobs = explode(",", $atts[ 'excludejobs' ] );
					
							foreach ( $excludejobs as $excludejob ) {

								if( $excludejob == $listing[ 'id' ] ) {

									$listing_passed = false;

								}

							}

						}
						
						if( $listing_passed ) {
						
						?>
						
						<div class="kekahire-listing" data-departmentId="<?php echo $listing['departmentId']; ?>" data-city="<?php echo $listing['jobLocations'][0]['city']; ?>">
							
							<div class="kekahire-listing-title-wrapper">
								
								<h3><?php echo $listing['title']; ?></h3>
								
								<?php if($listing['jobLocations'][0]['city']!="" && $listing['jobLocations'][0]['countryName']!="") { ?>
								
								<span><?php echo $listing['jobLocations'][0]['city']; ?>,<?php echo $listing['jobLocations'][0]['countryName']; ?></span>
								
								<?php } ?>
							
							</div>
							
							<div class="kekahire-listing-button-wrapper">
								
								<a href="https://<?php echo $kekahire_subdomain; ?>.keka.com/careers/jobdetails/<?php echo $listing['id']; ?>/" target="_blank" class="kekahire-apply-button">Apply Now</a>
							
							</div>
						
						</div>
						
						<?php } ?>
					
					<?php } ?>
				
				</div>
			
			</div>
		
		</div>
		
		<?php 
		
		} 
		
		//Listing Type - Grid
		
		else if( $listingtype == "grid" ) {
		
		?>
		
		<div class="kekahire-grid-listing-container kekahire-data-fetch" data-department="<?php echo $atts[ 'defaultdepartment' ]; ?>" data-location="<?php echo $atts[ 'defaultlocation' ]; ?>">
			
			<div class="kekahire-location-selector-wrapper">
				
				<div class="kekahire-location-selector">
					
					<label for="kekahire-location-selector-select" class="kekahire-location-selector-title">
						
						<?php _e( 'Select Location', 'kekahire' ); ?>
					
					</label>
					
					<select id="kekahire-location-selector-select">
						
						<option value=""><?php _e( 'All', 'kekahire' ); ?></option>
						
						<?php
						
						foreach ( $locations as $location ) {
							
							$locationcount = '';
							
							if($atts[ 'hidecount' ] != 1) {
								
								$locationcount = ' ('.$locationcountarray[$location['address'][ 'city' ]]['count'].')';
							
							}
							
							$defaultlocation = '';
							
							if($atts[ 'defaultlocation' ] == $location['address'][ 'city' ]) {
								
								$defaultlocation = ' selected';
							
							}
							
							if($locationcountarray[$location['address'][ 'city' ]]['count'] > 0) {
								
								echo '<option value="' . $location['address'][ 'city' ] . '"'.$defaultlocation.' />' . $location['address'][ 'city' ]. ',' . $location['address'][ 'countryCode' ] .$locationcount; 
							
							}
							
							else if($atts[ 'zerolisting' ] != 1) {
								
								echo '<option value="' . $location['address'][ 'city' ] . '"'.$defaultlocation.' />' . $location['address'][ 'city' ]. ',' . $location['address'][ 'countryCode' ]; 
							
							}
							
						}
						
						?>
						
					</select>
					
				</div>
				
				<div class="kekahire-department-selector">
					
					<label class="kekahire-department-selector-title">
						
						<?php _e( 'Select Department', 'kekahire' ); ?>
					
					</label>
					
					<select id="kekahire-department-selector-select">
						
						<option value=""><?php _e( 'All', 'kekahire' ); ?></option>
						
						<?php						
						
						foreach ( $departments as $department ) {
							
							$departmentcount = '';
							
							if($atts[ 'hidecount' ] != 1) {
								
								$departmentcount = ' ('.$departmentcountarray[$department[ 'id' ]]['count'].')';
							
							}
							
							$defaultdepartment = '';
							
							if($atts[ 'defaultdepartment' ] == $department[ 'id' ]) {
								
								$defaultdepartment = ' selected';
							
							}
							
							if($departmentcountarray[$department[ 'id' ]]['count'] > 0) {
								
								echo '<option value="' . $department[ 'id' ] . '"'.$defaultdepartment.' />' . $department[ 'name' ] .$departmentcount;
							
							}
							
							else if($atts[ 'zerolisting' ] != 1) {
								
								echo '<option value="' . $department[ 'id' ] . '"'.$defaultdepartment.' />' . $department[ 'name' ];
							
							} 

						}
						
						?>
						
					</select>
				
				</div>
			
			</div>
			
			<div class="kekahire-sidebar-listing-wrapper">
				
				<div class="kekahire-listing-wrapper">
				
					<?php
					
					foreach ( $listings as $listing ) {
						
						$listing_passed = true;
						
						if( $atts[ 'excludejobs' ] !== "" ) {
							
							$excludejobs = explode(",", $atts[ 'excludejobs' ] );
					
							foreach ( $excludejobs as $excludejob ) {

								if( $excludejob == $listing[ 'id' ] ) {

									$listing_passed = false;

								}

							}

						}
						
						if( $listing_passed ) {
							
						?>
						
						<div class="kekahire-listing kekahire-col-default-<?php echo $atts[ 'itemsinrow' ]; ?>" data-departmentId="<?php echo $listing['departmentId']; ?>" data-city="<?php echo $listing['jobLocations'][0]['city']; ?>">
							
							<div class="kekahire-listing-container">
								
								<div class="kekahire-listing-title-wrapper">
									
									<h3><?php echo $listing['title']; ?></h3>
								
								</div>
								
								<div class="kekahire-listing-button-wrapper">
									
									<?php if($listing['jobLocations'][0]['city']!="" && $listing['jobLocations'][0]['countryName']!="") { ?>
									
									<span><?php echo $listing['jobLocations'][0]['city']; ?>,<?php echo $listing['jobLocations'][0]['countryName']; ?></span>
									
									<?php } ?>
									
									<a href="https://<?php echo $kekahire_subdomain; ?>.keka.com/careers/jobdetails/<?php echo $listing['id']; ?>/" target="_blank" class="kekahire-apply-button">Apply Now</a>
								
								</div>
							
							</div>
						
						</div>
						
						<?php } ?>
					
					<?php } ?>
				
				</div>
			
			</div>
		
		</div>
		
		<?php
		
		}
		
		//Listing Type - Simple
		
		else { 
		
		?>
		
		<div class="kekahire-simple-listings-container">
		
			<?php 

			if( $atts[ 'title' ] !== "" ) {

				echo '<h4><strong>' . $atts[ 'title' ] . '</strong></h4>';

			}
			
			?>
			
			<ul class="kekahire-listings">
			
				<?php

				foreach ( $listings as $listing ) {
					
					$listing_passed = true;

					if( $atts[ 'departments' ] !== "" ) {

						$listing_passed = false;
						
						$departments = explode(",", $atts[ 'departments' ] );
				
						foreach ( $departments as $department ) {
						
							if( $department == $listing[ 'departmentId' ] ) {

								$listing_passed = true;

							}

							if( $department == "Other" && empty( $listing[ 'departmentId' ] ) ) {

								$listing_passed = true;

							}

						}

					}
					
					$jobLocations = $listing['jobLocations'];
					
					foreach ( $jobLocations as $jobLocation ) {
					
						if( $atts[ 'country' ] !== "" &&  $atts[ 'country' ] !== $jobLocation['countryCode'] ) {

							$listing_passed = false;

						}
						
						if( $atts[ 'state' ] !== "" &&  $atts[ 'state' ] !== $jobLocation[ 'state' ] ) {

							$listing_passed = false;

						}

						if( $atts[ 'city' ] !== "" &&  $atts[ 'city' ] !== $jobLocation[ 'city' ] ) {

							$listing_passed = false;

						}
					
					}
					
					if( $atts[ 'excludejobs' ] !== "" ) {
						
						$excludejobs = explode(",", $atts[ 'excludejobs' ] );
				
						foreach ( $excludejobs as $excludejob ) {

							if( $excludejob == $listing[ 'id' ] ) {

								$listing_passed = false;

							}

						}

					}

					if( $listing_passed ) {

						echo '<li class="listing"><a href="https://'.$kekahire_subdomain.'.keka.com/careers/jobdetails/' . $listing[ 'id' ] . '" target="_blank">' . $listing[ 'title' ] . '</a></li>';

					}

				}

				?>
			
			</ul>
		
		</div>
		
		<?php } ?>
		
		<?php

		$output = ob_get_clean();

		return $output;

	}

}
