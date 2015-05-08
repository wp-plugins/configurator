<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_PostHandler {
	private $config_from_file;
	private $config_from_input;

	protected function __construct( $config_from_file, $config_from_input ) {
		$this->config_from_file  = $config_from_file;
		$this->config_from_input = $config_from_input;
	}

	/**
	 * Handle the incoming post request
	 */
	public static function handle() {
		$config       = Configurator_Configurator::read_config();
		$config_input = $_POST['configurator'];

		$handler    = new static( $config, $config_input);
		$new_config = $handler->merge_config();

		$config_writer = new Configurator_Writer( $new_config );
		$config_writer->write_config();

		$handler->redirect();
		die();
	}

	/**
	 * Redirect back to the plugin page
	 */
	public function redirect() {
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$location = Configurator_Util::e( $_SERVER['HTTP_REFERER'] );
		} else {
			$location = site_url( 'wp-admin/admin.php?page=configurator' );
		}

		header( "Location: {$location}" );
		die();
	}

	/**
	 * Merge the config from the file with the incoming changes
	 *
	 * @return array
	 */
	public function merge_config() {
		$config_file = $this->config_from_file;
		$config_input = $this->config_from_input;

		/** @var Configurator_Line $config_line */
		foreach ( $config_file as &$config_line ) {
			$name = $config_line->get_name();
			$new_value = $config_input[ $name ];
			$config_line->set_value( $this->parse_config_value( $new_value ) );
		}

		return $config_file;
	}

	/**
	 * Parse values to usable values which will be parsed later
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public function parse_config_value( $value ) {
		if ( 'bool_true' === $value ) {
			$value = 'true';
		} elseif ( 'bool_false' === $value ) {
			$value = 'false';
		}

		return $value;
	}
}