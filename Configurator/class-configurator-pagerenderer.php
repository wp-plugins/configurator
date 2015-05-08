<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_PageRenderer
{
	/**
	 * Render the plugin page
	 */
	public static function display_plugin_page() {
		$config_lines = Configurator_Configurator::read_config();

		include CONFIGURATOR_ABS_PATH . '/views/configurator.php';
	}
}