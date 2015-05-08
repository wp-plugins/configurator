<?php

/*
Plugin Name: Configurator
Description: Configurator is a plugin that allows you to edit wp-config.php in the browser.
Version: 1.0
Author: CodeRichard
Author URI: http://www.coderichard.com/
License: GPLv2 or later
*/

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

require 'autoload.php';

define( 'CONFIGURATOR_PLUGIN_NAME', 'Configurator' );
define( 'CONFIGURATOR_PLUGIN_SLUG', 'configurator' );
define( 'CONFIGURATOR_PLUGIN_VERSION', '1.0.0' );
define( 'CONFIGURATOR_ABS_PATH', dirname( __FILE__ ) );

add_action( 'init', 'Configurator_Configurator::start' );