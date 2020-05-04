<?php
    namespace classes\commands;

    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;

    class AdminHomeCommand implements Command{
        public function execute(Request $request, Response $response) {
            $view = 'AdminHome';

            if (isset($_SESSION['admin'])){
                $currentUser = unserialize($_SESSION['admin']);
            }
            else{
                // header to bye bye weil keine Session
                header('location: index.php');
            }
            if (!($currentUser instanceof User)){
                // header to bye bye weil session = wtf
                header('location: index.php');
            }
            if ($currentUser->getStatus() != "admin"){
                header('location: index.php');
                // header to bye bye weil kein user - glaub nun sollten alle möglichen unberechtigten rausgefiltert worden sein.
            }


            $template = new HtmlTemplateView($view);
            
            $pageDAO = new PageDAO();

            $style = "default"; // provisorisch
            $template->assign('currentAdmin', $currentUser);
            $template->assign('style', $style);
            $template->render( $request, $response);
        }
    }
?>