<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class AddUserCommand implements Command{
        public function execute(Request $request, Response $response) {

            // ich werde heute noch den Command hier anpassen damit nur Admins hierauf zugreifen können. Da diente nur zu Testzwecken, ob auch ein Ordner angelegt wird. klappt soweit.

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

                $id = $userDAO->createUser($template->firstname, $template->lastname, $displayname, $template->email, $template->password);

                mkdir($id); // ich musste vorher mit chown den Eigentümer ändern. Sonst gibt es Probleme mit den Berechtigungen. mit chmod ist mir zu unsicher, da sonst jeder lesen und schreiben kann usw.
            }
        }
    }
?>