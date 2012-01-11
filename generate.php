<?php

/**
 * A series of WP generators
 *
 * @author Matthew Boynes
 */

/*
	$argv[1] should contain the type of generator, as theme or plugin (or more as this expands)
*/


if ( strtolower($argv[1]) == 'theme' ) {
/*
	$argv should be laid out as such for themes:
	[2] => name, all lowercase, dashes between words, e.g. my-theme-name (it will become My Theme Name)
	[3] => the domain, e.g. mydomain.com or blog.mydomain.com
	[4] => the destination directory
*/
	require_once dirname(__FILE__).'/theme.php';
	if ( count($argv) < 5 ) die("\nInvalid theme parameters. Request should be of the format:\ngenerate.php theme my-theme-name domain.com /path/to/destination/\n");
	$generator = new Theme($argv[2], $argv[3]);
	$dest = $argv[4];
}

# Run the copy script for the generator
if ($generator) {
	echo "\n\nCreating a new {$argv[1]} in $dest\n----------------------------------------------\n";
	$generator->copy($dest);
}
else {
	echo "\n\n>>> ERROR <<< Failed to instantiate generator. You probably effed up the syntax, you silly programmer.
	You're asking me to generate a new `{$argv[1]}`, but I don't know how to make those.\n";
}

?>