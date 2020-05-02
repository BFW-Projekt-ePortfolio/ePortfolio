<?php
	namespace classes\commands;

	use classes\request\Request;
	use classes\response\Response;
	use classes\template\HtmlTemplateView;
	use classes\mapper\UserDAO;
	use classes\mapper\ContentDAO;
	use classes\model\User;

	class MainPageCommand implements Command{
		public function execute(Request $request, Response $response){
			// noch 29.4
			// Wenn ein user auf dieser seite ist, möchte er sich ja anmelden - wenn also schon
			// eine anmeldung vorliegt (user logt sich unter zweitaccount ein z.B. -aber eher wir beim basteln^^), dann geht die 
			// anmeldung schief wenn wir vorher nicht die Session zerstören, daher:
			if(isset($_SESSION['admin']) || isset($_SESSION['user']) || isset($_SESSION['guest'])){
				// remove all session variables
				session_unset();
				// destroy the session
				session_destroy();
			}
			$view = 'MainPage';
			// prüfen ob das Formular ausgefüllt wurde:
			$password = "";
			$email = "";
			$user = array();
			if ($request->issetParameter("password") && $request->issetParameter("email")){
				$password = $request->getParameter("password");
				$email = $request->getParameter("email");
			}
			// wenn beides ausgefüllt wurde, dann mit deiner funktion pw prüfen und die userdaten im $user ablegen
			if ($password != "" && $email != ""){
				$userDAO = new UserDAO();
				$user = $userDAO->authentification($email, $password);
			}
			
			if(Count($user) != 0) {
				// Userdaten erfolgreich geladen: also Session starten und die Daten da reinballern.
				// $_SESSION['user'] = serialize($user);
				if (Count($user) == 1){
				
					switch($user[0]->getStatus()) {
						case "user":
							session_start();
							$_SESSION["user"] = serialize($user[0]);
							header('location: index.php?cmd=UserHome');
							exit;
						break;
						case "admin":
							session_start();
							$_SESSION["admin"] = serialize($user[0]);
							header('location: index.php?cmd=AdminHome');
							exit;
						break;
						case "guest":
							session_start();
							$_SESSION["guest"] = serialize($user[0]);
							header('location: index.php?cmd=GuestHome');
							exit;
						break;
					}
				}
				else{
					// Sie haben tatsächlich mehrere freigaben mit dem selben PW bekommen
					// herzlichen Glückwunsch und willkommen in der seltensten if Bedingung!!!
					echo "test";
				}
			}

			if ($password != "" || $email != ""){
				// Du hast ungültige Daten eingegeben - vertippt...
			}


			// else {
			// 		header('location: index.php?cmd=NotFound');
			// 		exit;
			// }


			$template = new HtmlTemplateView($view);

			$style = "default";
			$template->assign('style', $style);
			$template->render( $request, $response);
		}
	}
?>