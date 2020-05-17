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
			// prüfen ob das Formular ausgefüllt wurde:
			$allertText = "";
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
							// Den Fall rausgefiltert, dass ein Gast zwar existiert, aber überhaupt keine Freigaben hat.
							$pageList = array();
							$pageList = $user[0]->getPages();
							if(count($pageList) != 0 && $user[0]->getValidation() == ""){ // validation-check
								session_start();
								$_SESSION["guest"] = serialize($user[0]);
								header('location: index.php?cmd=GuestHome');
								exit;
							}
							else{	// dann wird er nicht eingeloggt
								$view = 'MainPage';
								$template = new HtmlTemplateView($view);
								$style = "default";
								$allertText = '<span style="color: red">Login fehlgeschlagen</span><br>';
								$template->assign('allertText', $allertText); 
								$template->assign('style', $style);
								$template->render( $request, $response);
							}
						break;
					}
				}
				else{
					// Sie haben tatsächlich mehrere freigaben mit dem selben PW bekommen
					// herzlichen Glückwunsch und willkommen in der seltensten if Bedingung!!!
					// Dieser Gast hat mehrere Portfolio-berechtigungen mit dem gleichen pw.
					// Den Fall rausgefiltert, dass ein Gast zwar existiert, aber überhaupt keine Freigaben hat
					$ownerArray = array();
					$updatedUserList = array();
					foreach($user as $guest){
						$pageList = array();
						$pageList = $guest->getPages();
						if(count($pageList) != 0 && $guest->getValidation() == ""){	//validation-Check

							$ownerArray[] = $userDAO->readUserById($pageList[0]->getOwner());
							$updatedUserList[] = $guest;
						}
					}
					if(count($updatedUserList) > 1){
						$view = "ChoosePortfolio";
						$style = "default";
						$template = new HtmlTemplateView($view);
						$template->assign('style', $style);
						$template->assign('Guestemail', $email);					
						$template->assign('ownerArray', $ownerArray); // These are the Owners of the different portfolios he has permission to. 
						$template->assign('users', $updatedUserList); // He has permissions to see all portfolios in $user[]
						$template->render( $request, $response);
					}
					elseif(count($updatedUserList) == 1){
						session_start();
						$_SESSION["guest"] = serialize($updatedUserList[0]);
						header('location: index.php?cmd=GuestHome');
						exit;
					}
					else{
						$style = "default";
						$view = 'MainPage';
						$template = new HtmlTemplateView($view);
						$template->assign('style', $style);
						$allertText = '<span style="color: red">Login fehlgeschlagen</span><br>';
						$template->assign('allertText', $allertText); 
						$template->render( $request, $response);
					}
				}
			
			}
			else{	// Die Anmeldung schlug fehl, oder die Seite wurde neu aufgerufen:

				if ($password != "" || $email != ""){
					// Du hast ungültige Daten eingegeben - vertippt...
					$allertText = '<span style="color: red">Login fehlgeschlagen</span><br>'; 
				}
	
	
				// else {
				// 		header('location: index.php?cmd=NotFound');
				// 		exit;
				// }
	
				$view = 'MainPage';
				$template = new HtmlTemplateView($view);
				$style = "default";
				$template->assign('style', $style);
				$template->assign('allertText', $allertText);
				$template->render( $request, $response);

			}


		}
	}
?>