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
	 * @author Scott Anderson <scott@getcodesmart.com>
	 * @since  0.0.1
	 */
	public function signup( $attributes = [] ) {

		wp_verify_nonce( 'gc_email_octopus', filter_input( INPUT_POST, '_gc_email_octopus_nonce', FILTER_DEFAULT ) ?? '' );
		$email = filter_input( INPUT_POST, 'gceo_email', FILTER_DEFAULT ) ?? '';

		if ( ! isset( $_POST['_gc_email_octopus_nonce'] ) || ! is_email( $email ) ) {
			return $this->display_signup_form( $attributes );
		}

		return $this->register_email( $email, $attributes );
	}

	private function display_signup_form( $attributes ) {
		ob_start() ?>
		<form method="post" action="<?php the_permalink(); ?>#gc-emailoctopus" id="gc-emailoctopus" class="gc-octo-signup-form">
			<style>
			.gc-octo-signup-form .left{
				float:left;
				margin-right: 5px;
			}

			.gc-octo-signup-form .left input, .gc-octo-signup-form .right button{
				height:50px;
			}

			.gc-octo-signup-form .left input {
				min-width: 300px;
			}

			.gc-octo-signup-form button {
					background-color: <?php echo $attributes[ 'button-color' ] ?? '#F8AE00'; ?>;
					color: <?php echo $attributes[ 'button-text' ] ?? '#FFFFFF'; ?>;
					border: none;
					min-width: 150px;
			}

			</style>
			<input type="hidden" id="_gc_email_octopus_nonce" name="_gc_email_octopus_nonce" value="<?php echo esc_attr( wp_create_nonce( 'gc_email_octopus' ) ); ?>">
			<div class="left"><input type="email" name="gceo_email" placeholder="Email address"></div>
			<div class="right"><button style="background-color: <?php echo $attributes[ 'button-color' ] ?? ''; ?>;color:<?php echo $attributes[ 'button-text' ] ?? ''; ?>">Subscribe</button></div>
		</form>
		<?php
		return ob_get_clean();
	}

	private function register_email( string $email, $attributes ) {

		$url = EMAIL_URL;

		$response = wp_remote_post( $url, array(
			'body'        => array(
				'email_address' => $email,
				'api_key' => EMAIL_KEY,
			),
			'cookies'     => array()
			)
		);

		if ( isset( $attributes['redirect'] ) ) {
			header( "Location: {$attributes['redirect']}?email={$email}" );
			die();
		}

		ob_start();
		?>
			<style>
				.gc-octo-success{
					color: #fff;
				}
			</style>
			<p class="gc-octo-success" id="gc-emailoctopus" >Thanks for subscribing!</p>
		<?php
		return ob_get_clean();
	}
}
