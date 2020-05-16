<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class ValidationCommand implements Command{
        public function execute(Request $request, Response $response) {

            // if (isset($_SESSION['user'])){
            //     $currentUser = unserialize($_SESSION['user']);
            // }
            // else{
            //     // header to bye bye weil keine Session
            //     header('location: index.php');
            // }
            // if (!($currentUser instanceof User)){
            //     // header to bye bye weil session = wtf
            //     header('location: index.php');
            // }
            // if ($currentUser->getStatus() != "user"){
            //     header('location: index.php');
            //     // header to bye bye weil kein user - glaub nun sollten alle möglichen unberechtigten rausgefiltert worden sein.
            // }

            $alert = "";

            if($request->issetParameter('validate')) {
                $key = $request->getParameter('key');

                $userDAO = new UserDAO();

                if($userDAO->checkValidationKey($key)) {

                    if($userDAO->validateGuest($key)) {

                        $alert = "Bestätigung erfolgreich! Gehen Sie weiter zum <a href='index.php'>Login</a>!";
                    } else {
                        $alert = "Ihre Adresse konnte nicht bestätigt werden!";
                    }
                } else {
                    $alert = "Der Key konnte nicht gefunden werden!";
                }
            }

            $view = 'Validation';

            $template = new HtmlTemplateView($view);
            
            $style = "default";

            $template->assign('style', $style);
            $template->assign('alert', $alert);
            $template->render( $request, $response);
        }
    }
?>