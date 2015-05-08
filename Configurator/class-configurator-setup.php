<?php

defined( 'ABSPATH' ) or die('Hi! I am Configurator! Nice to meet you! You know, if you want me to be of your assistance, please do not call me directly, but enable me instead though the plugin page. :)');

class Configurator_Setup
{
	/**
	 * Set up the hooks
	 */
	public function setup() {
		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_post_configurator_handle_post', 'Configurator_PostHandler::handle' );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Set up the menu in the admin menu
	 */
	public function setup_menu() {
		add_menu_page( 'Edit wp-config.php file', CONFIGURATOR_PLUGIN_NAME, 'activate_plugins', CONFIGURATOR_PLUGIN_SLUG, 'Configurator_PageRenderer::display_plugin_page' );
	}

	public function enqueue() {
		wp_enqueue_style( 'configurator-style', plugins_url( 'configurator/css/configurator-style.css' ), array(), CONFIGURATOR_PLUGIN_VERSION );
	}
}