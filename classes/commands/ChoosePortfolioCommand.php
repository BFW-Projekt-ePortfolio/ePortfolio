<?php
	namespace classes\commands;

	use classes\request\Request;
	use classes\response\Response;
	use classes\template\HtmlTemplateView;
	use classes\mapper\UserDAO;
	use classes\mapper\ContentDAO;
	use classes\model\User;

	class ChoosePortfolioCommand implements Command{
		public function execute(Request $request, Response $response){
			// noch 02.05
			if(isset($_SESSION['admin']) || isset($_SESSION['user']) || isset($_SESSION['guest'])){
				// remove all session variables
				session_unset();
				// destroy the session
				session_destroy();
			}
			// prüfen ob das Formular ausgefüllt wurde:
			
			if($request->issetParameter('submit_param')){
				$userDAO = new UserDAO;
				$chosenUser = $userDAO->readUserWithPagesAndTheirContent($request->getParameter('submit_param'));
				session_start();
				$_SESSION["guest"] = serialize($chosenUser);
				header('location: index.php?cmd=GuestHome');
				exit;
			}
			else{
				// header to bye bye - du bist hier nicht regulär hergelangt.
				header('location: index.php?cmd=MainPage');
				exit;
			}


		}
	}
?>