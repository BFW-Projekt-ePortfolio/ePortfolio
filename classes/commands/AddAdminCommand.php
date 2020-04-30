<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class AddAdminCommand implements Command{
        public function execute(Request $request, Response $response) {

            if(!isset($_SESSION['admin'])) {
                header('location: index.php?cmd=NoPermission');
                exit;
            }

            $view = 'AddAdmin';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->render( $request, $response);

            if(isset($template->email) && isset($template->password) && isset($template->firstname) && isset($template->lastname) && isset($template->displayname)) {
                $password = $template->password;
                $email = $template->email;
                $firstname = $template->firstname;
                $lastname = $template->lastname;
                $displayname = $template->displayname;

                $userDAO = new UserDAO();
                $id = $userDAO->createAdmin($firstname, $lastname, $displayname, $email, $password);
                
                header('location: index.php?cmd=AdminHome');
                exit;
            }
        }
    }
?>