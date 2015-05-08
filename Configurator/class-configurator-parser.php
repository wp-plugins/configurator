<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Parser {

	/**
	 * A whitelist of patterns to look for
	 *
	 * @var array $whitelist
	 */
	private $whitelist = array(
		'define' => array(
			'pattern' => "/^define\('(.*)'(\s*),(\s*)(.*)\)/",
			'capture' => '1,4',
		),
		'$' => array(
			'pattern' => '/\$(.*)=(\s*)(.*);/',
			'capture' => '1,3',
		),
	);

	/**
	 * Parse the lines
	 *
	 * @param array $lines The lines to parse
	 *
	 * @return array An array of parsed lines
	 */
	public function parse_lines( array $lines ) {
		$parsed_lines = array();
		$line_nr = 0;

		foreach ( $lines as $line ) {
			++$line_nr;
			$parsed_line = $this->parse_line( $line );

			if ( is_array( $parsed_line ) ) {
				$parsed_lines[] = new Configurator_Line( $parsed_line['name'], $parsed_line['value'], $parsed_line['token'], $line_nr );
			}
		}

		return $parsed_lines;
	}

	/**
	 * Parse the given line
	 *
	 * @param string $line The line to parse
	 *
	 * @return array|bool An array or false when not matched
	 */
	protected function parse_line( $line ) {
		$token = null;
		$search_pattern = null;
		$captures = null;

		foreach ( $this->whitelist as $start_token => $pattern ) {
			$start_token_pos = stripos( $line, $start_token );

			if ( 0 === $start_token_pos ) {
				$token = $start_token;
				$search_pattern = $pattern['pattern'];
				$captures = explode( ',', $pattern['capture'] );
			}
		}

		if ( null === $token || null === $search_pattern || null === $captures ) {
			return false;
		}

		preg_match_all( $search_pattern, $line, $matches );

		list( $key, $val ) = $captures;
		$key = (int) $key;
		$val = (int) $val;
		$name = trim( $matches[ $key ][0] );
		$value = $this->parse_value( $matches[ $val ][0] );

		return compact( 'name', 'value', 'token' );
	}

	/**
	 * Parse a value, having the value on the correct type
	 *
	 * @param string $value The value to parse
	 *
	 * @return mixed The given value with the correct type ('true' -> true, '1.23' -> 1.23 etc)
	 */
	public function parse_value( $value ) {
		$value = trim( $value, "'" );

		if ( is_numeric( $value ) ) {
			$floatVal = (float) $value;
			$intVal = (int) $value;

			if ( $value === $floatVal && $intVal !== $floatVal ) {
				$value = $floatVal;
			} else {
				$value = $intVal;
			}
		} elseif ( 'true' === $value || 'false' === $value ) {
			$value = 'true' === $value ? true : false;
		}

		return $value;
	}
}