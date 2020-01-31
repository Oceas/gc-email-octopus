<?php
/**
 * Plugin name: Email Octopus
 * Plugin URI: https://scottkeithanderson.com
 * Description:  Simple email signup form for https://emailoctopus.com/
 * Author: Scott Anderson
 * Author URI:   https://scottkeithanderson.com
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  gce
 * Version:     0.0.1
 * Domain Path:  /languages
 *
 * @package SKA_Email_Octopus
 * @since 0.0.1
 */

namespace SKA_Email_Octopus;

use SKA_Email_Octopus\Shortcodes\Signup;

/**
 * Main initiation class.
 *
 * @since  0.0.1
 */
final class SKA_Email_Octoups {

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
		protected $basename = '';

	/**
	 * Singleton instance of plugin.
	 *
	 * @var    SKA_Email_Octopus
	 * @since  0.0.1
	 */
	protected static $single_instance = null;


	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return  SKA_Email_Octopus A single instance of this class.
	 * @since   0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}
		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
	}

	/**
	 * Add hooks and filters.
	 * Priority needs to be
	 * < 10 for CPT_Core,
	 * < 5 for Taxonomy_Core,
	 * and 0 for Widgets because widgets_init runs at init priority 1.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'init' ], 0 );
	}

	/**
	 * Initialize all maajor class actions
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function init() {

		// Include class files.
		$this->includes();

		// Initialize plugin classes.
		$this->plugin_classes();

	}

	/**
	 * Include all class files.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function includes() {
		include $this->path . 'src/Shortcodes/gc-mail-signup.php';
	}

	/**
	 * Initialize all class files.
	 *
	 * @since  0.0.1
	 * @author Scott Anderson <scott@getcodesmart.com>
	 */
	public function plugin_classes() {
		new Signup();
	}

}


/**
 * Grab the SKA_Email_Octoups object and return it.
 * Wrapper for SKA_Email_Octoups::get_instance().
 *
 * @return SKA_Email_Octoups  Singleton instance of plugin class.
 * @since  0.0.1
 * @author Scott Anderson <scott@getcodesmart.com>
 */
function ska_email_octopus_signup() {
	return SKA_Email_Octoups::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', [ ska_email_octopus_signup(), 'hooks' ] );
