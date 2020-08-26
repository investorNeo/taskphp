<?php

use \core\Router;

spl_autoload_register(function ($class_name){
	$class = str_replace('\\', '/', $class_name) . '.php';
	if(file_exists($class)) {
		require_once( $class );
	}else
	{
		Router::ErrorPage404();
	}
});

session_start();
Router::start();
