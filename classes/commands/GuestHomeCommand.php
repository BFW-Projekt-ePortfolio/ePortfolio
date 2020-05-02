<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;

    class GuestHomeCommand implements Command{
        public function execute(Request $request, Response $response) {

            if (isset($_SESSION['guest'])){
                $currentUser = unserialize($_SESSION['guest']);
            }
            else{
                // header to bye bye weil keine Session
                header('location: index.php');
            }
            if (!($currentUser instanceof User)){
                // header to bye bye weil session = wtf
                header('location: index.php');
            }
            if ($currentUser->getStatus() != "guest"){
                header('location: index.php');
                // header to bye bye weil kein user - glaub nun sollten alle möglichen unberechtigten rausgefiltert worden sein.
            }


            $view = 'GuestHome';

            $userId = $currentUser->getId();

            $template = new HtmlTemplateView($view);
            
           $pageList = $currentUser->getPages();

            $style = "default"; // provisorisch

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->render( $request, $response);
        }
    }
?>