<?php

/**
 * Managing Countries and States
 *
 * @link       https://lumel.com
 * @since      1.1.2
 *
 * @package    Chargebee_Settings
 * @subpackage chargebee-settings/public
 */

/**
 * The Class to manage Countries, States and locales
 *
 *
 * @package    Chargebee_Settings
 * @subpackage chargebee-settings/public
 * @author     K Gopal Krishna <kg@lumel.com>
 */


defined( 'ABSPATH' ) || exit;

class KH_Countries {

	/**
	 * Auto-load in-accessible properties on demand.
	 *
	 * @param  mixed $key Key.
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( 'countries' === $key ) {
			return $this->get_countries();
		} elseif ( 'states' === $key ) {
			return $this->get_states();
		} elseif ( 'locale' === $key ) {
			return $this->get_locale();
		}
	}

	/**
	 * Get all countries.
	 *
	 * @return array
	 */
	public function get_countries() {
		if ( empty( $this->countries ) ) {
			$this->countries = include 'includes//i18n/countries.php' ;
		}

		return $this->countries;
	}

	/**
	 * Get the states for a country.
	 *
	 * @param  string $cc Country code.
	 * @return false|array of states
	 */
	public function get_states( $cc = null ) {
		if ( ! isset( $this->states ) ) {
			$this->states = include 'includes/i18n/states.php' ;
		}

		if ( ! is_null( $cc ) ) {
			return isset( $this->states[ $cc ] ) ? $this->states[ $cc ] : false;
		} else {
			return $this->states;
		}
	}
	
	/**
	 * Get the locale for a country.
	 *
	 * @param  string $cc Country code.
	 * @return false|array of locales
	 */
	public function get_locale( $cc = null ) {
		if ( ! isset( $this->locale ) ) {
			$this->locale = include 'includes/i18n/locale-info.php' ;
		}

		if ( ! is_null( $cc ) ) {
			return isset( $this->locale[ $cc ] ) ? $this->locale[ $cc ] : false;
		} else {
			return $this->locale;
		}
	}

}

$KH_Countries = new KH_Countries();