<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Reader
{
	/**
	 * @var string $file
	 */
	private $file;

	/**
	 * @var array
	 */
	public $lines = array();

	/**
	 * Instantiate a new reader
	 *
	 * @param string $file Absolute path to the file
	 */
	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Read the config file and return the parsed lines
	 *
	 * @return array
	 */
	public function read() {
		$config = $this->open();
		$lines = explode( PHP_EOL, $config );

		$parser = new Configurator_Parser();

		$this->lines = $parser->parse_lines( $lines );
	}

	/**
	 * Open the config file and read the contents
	 *
	 * @return string
	 */
	public function open() {
		$res = fopen( $this->file, 'r' );
		$contents = fread( $res, filesize( $this->file ) );
		fclose( $res );

		return $contents;
	}
}