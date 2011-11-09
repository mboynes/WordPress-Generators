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
	$generator = new Theme($argv[2], $argv[3]);
	$dest = $argv[4];
}

# Run the copy script for the generator
echo "\n\nCreating a new {$argv[1]} in $dest\n----------------------------------------------\n";
$generator->copy($dest);

?>