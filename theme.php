<?php
/**
* Generate a Theme
*/
class Theme {
	var $name_lower;
	var $name_expanded;
	var $domain;
	var $search;
	var $replace;

	function __construct($name, $domain) {
		$this->name_expanded = ucwords( str_replace( '-', ' ', $name ) );
		$this->name_lower = strtolower(str_replace('-', '', $name));
		$this->domain = $domain;
		$this->search = array(
			'{theme-lower}',
			'{theme-expanded}',
			'{domain}'
		);
		$this->replace = array(
			$this->name_lower,
			$this->name_expanded,
			$this->domain
		);
	}

	public function copy( $dest, $path=false ) {
		if (!$path) $path = dirname(__FILE__).'/theme';

		if ( file_exists($dest) ) {
			echo ">>> ERROR <<< $dest already exists!\n";
		}
		elseif( is_dir($path) ) {
			@mkdir( $dest );
			$objects = scandir($path);
			if( sizeof($objects) > 0 )
			{
				foreach( $objects as $file )
				{
					if( $file == "." || $file == ".." )
						continue;
					// go on
					$this->copy( $dest.DIRECTORY_SEPARATOR.$file, $path.DIRECTORY_SEPARATOR.$file );
				}
			}
			return true;
		}
		elseif( is_file($path) ) {
			if ( preg_match('/\.(php|s?css)$/i', $path) ) {
				$rfp = fopen($path, 'r');
				$contents = fread($rfp, filesize($path));
				fclose($rfp);

				# replace the placeholders
				$contents = str_replace($this->search, $this->replace, $contents);

				if ( ! $wfp = fopen($dest, 'a') ) {
					echo ">>> ERROR <<< could not open $dest for writing\n";
				}
				elseif ( fwrite($wfp, $contents) !== FALSE ) {
					echo "Created $dest\n";
				}
				else {
					echo ">>> ERROR <<< Could not write contents of `$path` to `$dest`\n";
				}
				@fclose($wfp);
			}
			else {
				if (copy( $path, $dest ))
					echo "Created $dest\n";
				else
					echo ">>> ERROR <<< Could not write contents of `$path` to `$dest`\n";
			}
		}
		else {
			return false;
		}
	}
}

?>