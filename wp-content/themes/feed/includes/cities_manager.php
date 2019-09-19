<?php

/**
 * Main file for cities management
 * @author Costin Botez <contact@costinbotez.co.uk>
 * @version 1.0
 */
class Cities_Manager {

	private $cities_main_url = 'https://files.feed.xyz/test/population.json'; //Main URL (Required)

	/**
	 * Main constructor
	 */
	function __construct() {

		$this->cities_init_actions();
	}

	/**
	 * Bind all hooks to ensure the functionality
	 * @return void
	 */
	function cities_init_actions() {
		// Manually trigger the import automation (uncomment the next line to take effect)

		// add_action('wp', array($this, 'cities_request_cb'));

		// Check api data (uncomment the next line to take effect) --> USE IN MAINTENANCE MODE ONLY
		// add_action('init', array($this, 'cities_show_api_data'));

	}

	/**
	 * Check if there are cities
	 * @return Boolean
	 */
	function city_post_exists() {
		$city_args = array(
			'post_type'	 	=> 'city',
			'posts_per_page'=> -1,
			'post_status'	=> array('publish'),
		);
		$query = new WP_Query($city_args);

		return $query->have_posts();
	}

	/**
	 * Delete all city posts types
	 * @return void
	 */
	function city_delete_all_posts() {
		$city_args = array(
			'post_type'	 	=> 'city',
			'posts_per_page'=> -1,
			'post_status'	=> array('publish'),
		);
		$query = new WP_Query($city_args);
		foreach ($query->posts as $key => $city_post) {
			wp_delete_post( $city_post->ID, true );
		}
	}


	/**
	 * Cities Request callback
	 * @return void
	 */
	function cities_request_cb() {

		// if there are an posts
		if ($this->city_post_exists()) {
			//delete them and prepare for pull
			$this->city_delete_all_posts();
		}
		// Initializing curl
		$ch = curl_init( $this->cities_main_url );

		// Configuring curl options
		$options = array(
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_HTTPHEADER 		=> array('Content-type: application/json'),
		);

		// Setting curl options
		curl_setopt_array( $ch, $options );

		// Getting results
		$result = curl_exec($ch); // Getting jSON result string
		$result = json_decode($result);

		if ( is_object( $result ) ) {	// if success then proceed

			$cities = $result->geonames;
			// echo '<pre>'; print_r( $cities ); echo '</pre>'; exit;
			if ( is_array($cities) && count($cities) > 0 ) {
				foreach ($cities as $key => $city) {
					// echo '<pre>'; print_r( $city ); echo '</pre>';

					// Get the important details
					$geonameId = !empty($city->geonameId) ? $city->geonameId : '';
					$name = !empty($city->name) ? $city->name : '';
					$population = !empty($city->population) ? $city->population : '';

					// Check if it already exists
					if( !get_page_by_title($name, OBJECT, 'city') ) {
						$my_post = array(
						  'post_title'    => $name,
						  'post_status'   => 'publish',
						  'post_author'   => 1,
						  'post_type'	  => 'city',
						);
						// Insert the post into the database
						$new_post_id = wp_insert_post( $my_post );

						// Update cf accordingly
						update_post_meta($new_post_id, 'geonameId', $geonameId);
						update_post_meta($new_post_id, 'name', $name);
						update_post_meta($new_post_id, 'population', $population);
					}

				}
			}
			// echo '<pre>'; print_r($result); echo '</pre>'; exit;
		}
	}

	/**
	 * Use only for debugging purposes
	 * @return the API Response against the current call
	 */
	function cities_show_api_data() {

		// Initializing curl
		$ch = curl_init( $this->cities_main_url);

		// Configuring curl options
		$options = array(
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_HTTPHEADER 		=> array('Content-type: application/json'),
		);

		// Setting curl options
		curl_setopt_array( $ch, $options );

		// Getting results
		$result = curl_exec($ch); // Getting jSON result string
		$result = json_decode($result);

		if ( is_object( $result ) ) {	// if success then proceed

			$cities = $result->geonames;
			// echo '<pre>'; print_r($cities); echo '</pre>'; exit;
		}
	}

}
new Cities_Manager;

?>