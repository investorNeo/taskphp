<?php


namespace core;


class Router {
	
	static public function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'task';
		$action_name = 'index';

		$URIParts = explode('?',$_SERVER['REQUEST_URI']);
		$routes = explode('/',$URIParts[0]);

		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{
			$controller_name = $routes[1];
			// получаем имя экшена
			if ( !empty($routes[2]) )
			{
				$action_name = $routes[2];
			}
		}


		// добавляем префиксы
		$controller_name = '\controllers\Controller_'.ucfirst($controller_name);
		$action_name = 'action_'.$action_name;


		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;

		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			parse_str($URIParts[1]??'', $params);
			$controller->$action($params);
		}
		else
		{
			self::ErrorPage404();
		}

	}

	
	static public function ErrorPage404()
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
	}
}
