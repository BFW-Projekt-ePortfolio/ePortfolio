<?php
namespace classes\commands;

use classes\request\Request;
use classes\response\Response;

class FrontController {
	private $path;
	private $defaultCommand;

	public function __construct($path, $defaultCommand){
		$this->path = $path;
		$this->defaultCommand = $defaultCommand;
	}
	
	public function handleRequest(Request $request, Response $response){
		$command = $this->getCommand($request);
		$command->execute($request, $response);
		$response->flush();
	}		
	
	public function getCommand(Request $request){
		if ($request->issetParameter("cmd")) {
			$cmdName = $request->getParameter("cmd");
			$command = $this->loadCommand($cmdName);
			if ($command instanceof Command) {
				return $command;
			}
		}
		$command = $this->loadCommand($this->defaultCommand);

		return $command;
	}
	
	public function loadCommand($cmdName){
		//$class = $cmdName . "Command";
		//$cmdName = rtrim($cmdName, DIRECTORY_SEPARATOR);
		$class = $this->path . "\\" . $cmdName . "Command";
		$file = $this->path . "/" . $cmdName . "Command.php";
		
		if (!file_exists($file)) {
			return false;
		}
		
		//include_once $file;
		$command = new $class();
		return $command;
	}
}