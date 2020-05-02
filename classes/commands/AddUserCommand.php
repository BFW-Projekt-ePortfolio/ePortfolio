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

            $password = "";
            $email = "";
            $firstname = "";
            $lastname = "";
            $displayname = "";

            if ($request->issetParameter("password") && $request->issetParameter("email") && $request->issetParameter("firstname") && $request->issetParameter("lastname")) {
                
                $userDAO = new UserDAO();

                if(!$userDAO->exist($request->getParameter("email"))) {
                    if($request->getParameter("password") === $request->getParameter("pwRepeat")) {
                        $password = password_hash($request->getParameter("password"), PASSWORD_DEFAULT);
                        $email = $request->getParameter("email");
                        $firstname = $request->getParameter("firstname");
                        $lastname = $request->getParameter("lastname");
                        $displayname = $firstname . " " . $lastname;

                        $id = $userDAO->createUser($firstname, $lastname, $displayname, $email, $password);

                        // Die Konstante wird in conf/dirs.inc definiert und über die UserDAO geladen. Bin mir noch nicht sicher, ob das so passt.
                        // Die Berechtigungen für die einzelnen Ordner und Dateien im gesamten Projekt muss ich noch anpassen, habe mich etwas eingelesen
                        // und muss das noch testen.
                        mkdir(USERS_DIR . $id);

                        header('location: index.php?cmd=AdminHome');
                        exit;
                    } else {
                        $error = "Passwort stimmt nicht überein!";
                    }
                } else {
                    $error = "E-Mail existiert bereits!";
                }
            } else {
                $error = "";
            }

            $view = 'AddUser';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->assign('error', $error);
            $template->render( $request, $response);
        }
    }
?>