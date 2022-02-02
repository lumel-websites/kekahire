<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://lumel.com
 * @since      1.0.0
 *
 * @package    Kekahire
 * @subpackage Kekahire/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap kekahire-settings">
	<h2>
		<span class="main_title" tabindex="1"><?php _e( 'Kekahire for WordPress', 'kekahire' ); ?></span>
	</h2>
	<form method="post" action="options.php">
        <?php
     
           settings_fields("kekahire_settings");

           do_settings_sections("kekahire-settings");
             
           submit_button();
           
        ?>
    </form>
    <hr>
    <div class="kekahire-shortcode-generator">
    	<h2><?php _e( 'Shortcode Generator', 'kekahire' ); ?></h2>
    	<p><?php _e( 'The', 'kekahire' ); ?> <strong>[kekajobs]</strong> <?php _e( 'shortcode by default will retrieve all jobs across all locations and departments. To filter based on Location and/or Department, please select the appropriate options from below. Your shortcode will be auto-generated for you which can be added to any web page on your site.', 'kekahire' ); ?></p>
    </div>
    <form id="kekahire-shortcode-generator-form">
    	<table class="form-table">
    		<tbody>
    			<tr>
    				<th scope="row"><?php _e( 'Title', 'kekahire' ); ?></th>
    				<td><input type="text" id="kekahire-title" placeholder="Title"></td>
    			</tr>
				<tr>
    				<th scope="row"><?php _e( 'Listing Style', 'kekahire' ); ?></th>
    				<td>
    					<select id="kekahire-listing-selector">
    						<option value="simple"><?php _e( 'Simple', 'kekahire' ); ?></option>
							<option value="smart"><?php _e( 'Smart', 'kekahire' ); ?></option>
    					</select>
    				</td>
    			</tr>
    			<tr class="kekahire-admin-simple-listing-row">
    				<th scope="row"><?php _e( 'Departments', 'kekahire' ); ?></th>
    				<td>
    					<select id="kekahire-department-selector" multiple>
    						<?php
							
    						foreach ( $departments as $department ) {
    							
    							echo '<option value="' . $department[ 'id' ] . '">' . $department[ 'name' ] . '</option>'; 

    						}

    						?>
    					</select>
    				</td>
    			</tr>
				<?php 
				$classObject = new CB_Countries();
				$countriesname = $classObject->get_countries();
				?>
    			<tr class="kekahire-admin-simple-listing-row">
    				<th scope="row"><?php _e( 'Locations', 'kekahire' ); ?></th>
    				<td>
    					<select id="kekahire-location-selector">
    						<option value=""><?php _e( 'All Locations', 'kekahire' ); ?></option>
    						<?php

    						foreach ( $locations as $location ) {
    							
    							echo '<option value="' . $location['address'][ 'countryCode' ] . '">' . $countriesname[$location['address'][ 'countryCode' ]] . '</option>'; 

    						}
					
    						?>
    					</select>
    				</td>
    			</tr>
    			<tr class="kekahire-admin-simple-listing-row">
    				<th scope="row"><?php _e( 'State', 'kekahire' ); ?></th>
					<td>
    					<select id="kekahire-state-selector" multiple disabled>

    					</select>
    				</td>
    			</tr>
    			<tr class="kekahire-admin-simple-listing-row">
    				<th scope="row"><?php _e( 'City', 'kekahire' ); ?></th>
					<td>
    					<select id="kekahire-city-selector" multiple disabled>
						
    					</select>
    				</td>
    			</tr>
				<tr class="kekahire-admin-smart-listing-row">
    				<th scope="row"><?php _e( 'Hide Location/Department with no listing', 'kekahire' ); ?></th>
					<td>
    					<input type="checkbox" id="kekahire-jobs-zero-listing" name="kekahire-jobs-zero-listing" value="1"></input>
    				</td>
    			</tr>
				<tr class="kekahire-admin-smart-listing-row">
    				<th scope="row"><?php _e( 'Hide Count from Departments', 'kekahire' ); ?></th>
					<td>
    					<input type="checkbox" id="kekahire-jobs-hide-count" name="kekahire-jobs-hide-count" value="1"></input>
    				</td>
    			</tr>
				<tr class="kekahire-admin-smart-listing-row">
    				<th scope="row"><?php _e( 'Default Department', 'kekahire' ); ?></th>
    				<td>
    					<select id="kekahire-default-department-selector">
							<option value=""> - </option>
    						<?php
    						foreach ( $departments as $department ) {
    							
    							echo '<option value="' . $department[ 'id' ] . '">' . $department[ 'name' ] . '</option>'; 

    						}
    						?>
    					</select>
    				</td>
    			</tr>
				<tr class="kekahire-admin-smart-listing-row">
    				<th scope="row"><?php _e( 'Default Location', 'kekahire' ); ?></th>
					<td>
    					<select id="kekahire-default-location-selector">
							<option value=""> - </option>
							<?php
							foreach ( $locations as $location ) {
								
								echo '<option value="' . $location['address'][ 'city' ] . '">' . $location['address'][ 'city' ]. ',' . $location['address'][ 'countryCode' ] .'</option>'; 
								
							}
							?>
    					</select>
    				</td>
    			</tr>
				<tr>
    				<th scope="row"><?php _e( 'Exclude Jobs', 'kekahire' ); ?></th>
					<td>
    					<input type="text" id="kekahire-jobs-exclude" placeholder="<?php _e( 'Insert Job IDS', 'kekahire' ); ?>">
    				</td>
    			</tr>
    		</tbody>
    	</table>
    </form>
   	<hr>
	<table class="kekahire-shortcode-view form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e( 'Your Shortcode', 'kekahire' ); ?></th>
				<td>
					<div class="kekahire-shortcode-container">
						<div id="kekahire-shortcode">[kekajobs]</div>
					</div>
					<div class="clear"></div>
					<p class="kekahire-shortcode-view-description"><?php _e( 'Copy the above shortcode and then paste it anywhere on the website to show your desired listings from Keka.', 'kekahire' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
