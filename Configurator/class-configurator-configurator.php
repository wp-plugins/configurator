<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Configurator
{
	/**
	 * Start the plugin
	 */
	public static function start() {
		$setup = new Configurator_Setup();
		$setup->setup();
	}

	/**
	 * Read the configuration and return the usable lines
	 *
	 * @return array
	 */
	public static function read_config() {
		$config_file = ABSPATH . DIRECTORY_SEPARATOR . 'wp-config.php';

		$reader = new Configurator_Reader( $config_file );
		$reader->read();

		return $reader->lines;
	}

	/**
	 * Flatten the lines to a single-dimensional array
	 *
	 * @param $lines
	 *
	 * @return array
	 */
	protected static function flatten_lines( $lines ) {
		$iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator( $lines ) );

		return iterator_to_array( $iterator );
	}
}
