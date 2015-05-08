<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Line
{
	private $name;
	private $value;
	private $type;
	private $line_nr;

	public function __construct( $name, $value, $type, $line_nr ) {
		$this->name = $name;
		$this->value = $value;
		$this->type = $type;
		$this->line_nr = $line_nr;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_value() {
		return $this->value;
	}

	public function set_value( $value ) {
		$this->value = $value;

		return $this;
	}

	public function get_type() {
		return $this->type;
	}

	public function get_line_nr() {
		return $this->line_nr;
	}
}