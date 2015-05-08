<?php

/**
 * Autoload class
 *
 * @param string $class
 */
function configurator_autoload( $class ) {
	// Get the base directory of the plugin
	$base_dir = dirname( __FILE__ );

	// Convert the class name to be compliant with WordPress
	$class_name = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';

	// Split the parts of the class to imitate namespacing and remove the last part since that would be the class name
	$namespace_parts = explode( '_', $class );
	array_pop( $namespace_parts );

	// Get the class' directory path
	$class_dir = $base_dir . '/' . implode( '/', $namespace_parts );

	// Get the class' full path
	$full_class_path = $class_dir . '/' . $class_name;

	// Require the class if it exists
	if ( file_exists( $full_class_path ) ) {
		require $full_class_path;
	}
}

spl_autoload_register( 'configurator_autoload' );