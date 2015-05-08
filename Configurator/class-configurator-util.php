<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Util
{
	/**
	 * Escape the given value
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public static function e( $value ) {
		return htmlspecialchars( $value, ENT_COMPAT, 'UTF-8' );
	}
}