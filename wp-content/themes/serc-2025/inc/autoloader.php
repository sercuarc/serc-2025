<?php

/**
 * Theme Autoloader
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 * Since: 0.1.0
 */

spl_autoload_register('serc2025_autoloader');
function serc2025_autoloader($class)
{
	$namespace = 'Serc2025';
	$directory = get_template_directory();

	// Check if the class starts with the namespace
	if (strpos($class, $namespace) !== 0) {
		return;
	}

	// Remove the namespace
	$class = str_replace($namespace, '', $class);

	// Replace the namespace separator with the directory separator
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

	// Check if the class is in the src directory
	$path = $directory . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class;
	if (file_exists($path)) {
		require_once($path);
	}
}
