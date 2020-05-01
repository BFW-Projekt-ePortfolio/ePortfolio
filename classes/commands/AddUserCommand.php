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
                
                // Die Konstante wird in conf/dirs.inc definiert und über die UserDAO geladen. Bin mir noch nicht sicher, ob das so passt.
                // Die Berechtigungen für die einzelnen Ordner und Dateien im gesamten Projekt muss ich noch anpassen, habe mich etwas eingelesen
                // und muss das noch testen.
                mkdir(USERS_DIR . $id);

                header('location: index.php?cmd=AdminHome');
                exit;
            }
        }
    }
?>
