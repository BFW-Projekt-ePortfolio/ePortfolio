<?php
	namespace classes\commands;

	use classes\request\Request;
	use classes\response\Response;
	use classes\template\HtmlTemplateView;
	use classes\mapper\UserDAO;
	use classes\model\User;

	class MainPageCommand implements Command{
		public function execute(Request $request, Response $response){
			$view = 'MainPage';

			$template = new HtmlTemplateView($view);

			$style = "default";

			$template->assign('style', $style);
			$template->assign('passwordLogin', null);
			$template->assign('email', null);
			$template->render( $request, $response);

			if(isset($template->passwordLogin) && isset($template->email)) {

				$userDAO = new UserDAO();

				$user = $userDAO->authentification($template->email, $template->passwordLogin);

				if(!$user == null) {
					$_SESSION['user'] = serialize($user);

					switch($user->getStatus()) {
						case "user":
							header('location: index.php?cmd=UserHome');
							break;
						case "admin":
							header('location: index.php?cmd=UserHome');
							break;
						case "guest":
							header('location: index.php?cmd=UserHome');
							break;
					}
				}
			}
		}
	}
?>