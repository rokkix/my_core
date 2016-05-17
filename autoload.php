<?php 

function __autoload($class) {
	
	$path = str_replace('\\',DIRECTORY_SEPARATOR,$class) . '.php';
	if (file_exists($path)) {
		require $path;
	}	
}



?>