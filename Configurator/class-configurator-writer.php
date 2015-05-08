<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Writer {
	private $new_config;

	private $templates = array(
		'define' => "define('%s', %s);",
		'$'      => '$%s = %s;',
	);

	public function __construct( $new_config ) {
		$this->new_config  = $new_config;
	}

	public function write_config() {
		$this->backup_config();
		$lines = $this->create_lines();

		$file_contents = $this->create_config_file( $lines );
		$file_location = ABSPATH . DIRECTORY_SEPARATOR . 'wp-config.php';

		file_put_contents( $file_location, $file_contents );
	}

	/**
	 * Parse the config into actual lines
	 *
	 * @return array
	 */
	protected function create_lines() {
		$config_lines = array();

		$parser = new Configurator_Parser();

		/** @var Configurator_Line $config_line */
		foreach ( $this->new_config as $config_line ) {
			$type = $config_line->get_type();
			$name = $config_line->get_name();
			$value = $config_line->get_value();

			$template = $this->templates[ $type ];

			$actual_value = $parser->parse_value( $value );

			if ( is_string( $actual_value ) ) {
				$value = "'{$value}'";
			}

			$line = sprintf( $template, $name, $value );

			$config_lines[] = array(
				'line_nr' => $config_line->get_line_nr(),
				'line' => $line,
			);
		}

		return $config_lines;
	}

	protected function backup_config() {
		$config_file_location = ABSPATH . DIRECTORY_SEPARATOR . 'wp-config.php';
		$config_file_backup_location = ABSPATH . DIRECTORY_SEPARATOR . 'wp-config.php.bak';

		return copy( $config_file_location, $config_file_backup_location );
	}

	private function create_config_file( $lines ) {
		$config_file_location = ABSPATH . DIRECTORY_SEPARATOR . 'wp-config.php';
		$reader = new Configurator_Reader( $config_file_location );

		$config = $reader->open();
		$config_lines = explode( PHP_EOL, $config );

		foreach ( $lines as $line ) {
			$line_nr = $line['line_nr'];
			$entry = $line['line'];

			$config_lines[ $line_nr - 1 ] = $entry;
		}

		return implode( PHP_EOL, $config_lines );
	}
}