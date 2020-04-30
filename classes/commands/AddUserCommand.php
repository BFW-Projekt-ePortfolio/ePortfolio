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

            if($request->issetParameter('email') && $request->issetParameter('password') && $request->issetParameter('firstname') && $request->issetParameter('lastname')) {
                $password = $request->issetParameter('password');
                $email = $request->issetParameter('email');
                $firstname = $request->issetParameter('firstname');
                $lastname = $request->issetParameter('lastname');

                $userDAO = new UserDAO();
                $displayname = $template->firstname . " " . $template->lastname;
                $id = $userDAO->createUser($template->firstname, $template->lastname, $displayname, $template->email, $template->password);
                mkdir($id); // ich musste vorher mit chown den Eigentümer ändern. Sonst gibt es Probleme mit den Berechtigungen. mit chmod ist mir zu unsicher, da sonst jeder lesen und schreiben kann usw.

                header('location: index.php?cmd=AdminHome'); // kehrt zurück zum Home Bildschirm, wenn User angelegt ist
                exit;                                        // Muss noch nach einer besseren Lösung suchen und diese imlementieren
            }

            // Hier fehlt noch ein Else falls das Formular nicht vollständig ausgefüllt wurde.

            $view = 'AddUser';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->render( $request, $response);
        }
    }
?>