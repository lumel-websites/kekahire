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
		<span class="main_title" tabindex="1">Kekahire for WordPress</span>
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
    	<h2>Shortcode Generator</h2>
    	<p>The <strong>[kekajobs]</strong> shortcode by default will retrieve all jobs across all locations and departments. To filter based on Location and/or Department, please select the appropriate options from below. Your shortcode will be auto-generated for you which can be added to any web page on your site.</p>
    </div>
    <form id="kekahire-shortcode-generator-form">
    	<table class="form-table">
    		<tbody>
    			<tr>
    				<th scope="row">Title</th>
    				<td><input type="text" id="kekahire-title" placeholder="Title"></td>
    			</tr>
				<tr>
    				<th scope="row">Listing Style</th>
    				<td>
    					<select id="kekahire-listing-selector">
    						<option value="simple">Simple</option>
							<option value="smart">Smart</option>
    					</select>
    				</td>
    			</tr>
    			<tr class="admin-simple-listing-row">
    				<th scope="row">Departments</th>
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
    			<tr class="admin-simple-listing-row">
    				<th scope="row">Locations</th>
    				<td>
    					<select id="kekahire-location-selector">
    						<option value="">All Locations</option>
    						<?php

    						foreach ( $locations as $location ) {
    							
    							echo '<option value="' . $location['address'][ 'countryCode' ] . '">' . $countriesname[$location['address'][ 'countryCode' ]] . '</option>'; 

    						}
					
    						?>
    					</select>
    				</td>
    			</tr>
    			<tr class="admin-simple-listing-row">
    				<th scope="row">State</th>
					<td>
    					<select id="kekahire-state-selector" multiple disabled>

    					</select>
    				</td>
    			</tr>
    			<tr class="admin-simple-listing-row">
    				<th scope="row">City</th>
					<td>
    					<select id="kekahire-city-selector" multiple disabled>
						
    					</select>
    				</td>
    			</tr>
				<tr class="admin-smart-listing-row">
    				<th scope="row">Hide Location/Department with no listing</th>
					<td>
    					<input type="checkbox" id="kekahire-jobs-zero-listing" name="kekahire-jobs-zero-listing" value="1"></input>
    				</td>
    			</tr>
				<tr class="admin-smart-listing-row">
    				<th scope="row">Hide Count from Departments</th>
					<td>
    					<input type="checkbox" id="kekahire-jobs-hide-count" name="kekahire-jobs-hide-count" value="1"></input>
    				</td>
    			</tr>
				<tr class="admin-smart-listing-row">
    				<th scope="row">Default Department</th>
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
				<tr class="admin-smart-listing-row">
    				<th scope="row">Default Location</th>
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
    				<th scope="row">Exclude Jobs</th>
					<td>
    					<input type="text" id="kekahire-jobs-exclude" placeholder="Insert Job IDS">
    				</td>
    			</tr>
    		</tbody>
    	</table>
    </form>
   	<hr>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">Your Shortcode</th>
				<td>
					<div class="kekahire-shortcode-container">
						<div id="kekahire-shortcode">[kekajobs]</div>
					</div>
					<div class="clear"></div>
					<p class="description">Copy the above shortcode and then paste it anywhere on the website to show your desired listings from Keka.</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
