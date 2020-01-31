<?php
/**
 * Contains class to handle catechism of the week.
 *
 * @package SKA_Email_Octopus
 * @since 0.0.1
 */

namespace SKA_Email_Octopus\Shortcodes;

/**
 * Provides catechism of the week Shortcodes.
 *
 * @package SKA_Email_Octopus
 * @since 0.0.1
 */
class Signup {

	/**
	 * Setup our verse of the day Shortcodes.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Register hooks for class.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function hooks() {
		add_shortcode( 'gc-mail-signup', [ $this, 'signup' ] );
	}

	/**
	 * Return Email Signup
	 *
	 * @return string
	 * @author Scott Anderson <scott@getcodesmart.com>
	 * @since  0.0.1
	 */
	public function signup() {
		return 'Signup Form';
	}
}
