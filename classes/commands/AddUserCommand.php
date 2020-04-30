<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class AddUserCommand implements Command{
        public function execute(Request $request, Response $response) {

            if(!isset($_SESSION['admin'])) {
                header('location: index.php?cmd=NoPermission');
                exit;
            }

            $view = 'AddUser';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->render( $request, $response);

            if(isset($template->email) && isset($template->password) && isset($template->firstname) && isset($template->lastname)) {
                $password = $template->password;
                $email = $template->email;
                $firstname = $template->firstname;
                $lastname = $template->lastname;

                $userDAO = new UserDAO();
                $displayname = $template->firstname . " " . $template->lastname;
                $id = $userDAO->createUser($firstname, $lastname, $displayname, $email, $password);
                
                // es muss für die betreffenden Ordner chown ausgeführt und auf den User des Servers übertragen werden (zB daemon, www-data usw.)
                // Es muss auch ein geeigneterer Pfade gefunden werden. Die index.php befindet sich bei mir in /opt/lampp/htdocs/ePortfolio
                mkdir('/opt/lampp/ePortfolio/users/' . $id); 

                header('location: index.php?cmd=AdminHome');
                exit;
            }
        }
    }
?>