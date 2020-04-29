<?php
	session_start();
	use classes\request\HttpRequest;
	use classes\response\HttpResponse;
	use classes\commands\FrontController;

	/*
	*	Anders als in der Literatur funktionieren Namespaces nicht wie oben angegeben unter Linux/Unix
	*/
	function autoload($className){
		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			// Austausch des Backslash: Linux braucht / und Windows \
			$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
	
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
	}

	spl_autoload_register('autoload');
	/*
	*	Ende
	*/
	//ALT: spl_autoload_register();
	
	$request = new HttpRequest();
	$response = new HttpResponse();
	$controller = new FrontController('classes\commands', 'MainPage');

	$controller->handleRequest($request, $response);
?>