<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class AddUserCommand implements Command{
        public function execute(Request $request, Response $response) {
            $view = 'AddUser';

            $user = unserialize($_SESSION['user']);

            $template = new HtmlTemplateView($view);
            
            $style = "default"; // provisorisch

            $template->assign('style', $style);
            $template->assign('firstname', null);
            $template->assign('lastname', null);
            $template->assign('email', null);
            $template->assign('password', null);
            $template->render( $request, $response);

            if(isset($template->email) && isset($template->password)) {

                $userDAO = new UserDAO();

                $displayname = $template->firstname . " " . $template->lastname;

                $userDAO->createUser($template->firstname, $template->lastname, $displayname, $template->email, $template->password);
            }
        }
    }
?>