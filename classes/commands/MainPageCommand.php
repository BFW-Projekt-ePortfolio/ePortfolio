<?php
	namespace classes\commands;

	use classes\request\Request;
	use classes\response\Response;
	use classes\template\HtmlTemplateView;
	use classes\mapper\UserDAO;
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
			// prüfen ob das Formular ausgefüllt wurde:
			$password = "";
			$email = "";
			$user = null;
			if ($request->issetParameter("password") && $request->issetParameter("email")){
				$password = $request->getParameter("password");
				$email = $request->getParameter("email");
			}
			// wenn beides ausgefüllt wurde, dann mit deiner funktion pw prüfen und die userdaten im $user ablegen
			if ($password != "" && $email != ""){
				$userDAO = new UserDAO();
				$user = $userDAO->authentification($email, $password);
			}

			if(!$user == null) {
				// Userdaten erfolgreich geladen: also Session starten und die Daten da reinballern.

				// $_SESSION['user'] = serialize($user);

				switch($user->getStatus()) {
					case "user":
						session_start();
						$_SESSION["user"] = serialize($user);
						header('location: index.php?cmd=UserHome');
						exit;
					break;
					case "admin":
						session_start();
						$_SESSION["admin"] = serialize($user);
						header('location: index.php?cmd=AdminHome');
						exit;
					break;
					case "guest":
						session_start();
						$_SESSION["guest"] = serialize($user);
						header('location: index.php?cmd=GuestHome');
						exit;
					break;
				}
			}

			if ($password != "" || $email != ""){
				// Du hast ungültige Daten eingegeben - vertippt...
			}

			// else {
			// 		header('location: index.php?cmd=NotFound');
			// 		exit;
			// }

			$view = 'MainPage';
			$template = new HtmlTemplateView($view);

			$style = "default";
			$template->assign('style', $style);
			$template->render( $request, $response);
		}
	}
?>