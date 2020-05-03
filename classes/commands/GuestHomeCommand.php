<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\UserDAO;

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

            $userDAO = new UserDAO;
            $pageList = $currentUser->getPages();
            $ContentList = $pageList[0]->getContentList();
            $owner = $userDAO->readUserById($pageList[0]->getOwner());

            if($request->issetParameter('page')){
                $index = $request->getParameter('page');
                if($index >= 0 && $index < count($pageList) && is_numeric($index)){
                    $ContentList = $pageList[$index]->getContentList();
                }
            }

            $view = 'GuestHome';
            $style = "default"; // provisorisch

            $template = new HtmlTemplateView($view);
            
            $template->assign('owner', $owner);
            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('requestedContent', $ContentList);
            $template->render( $request, $response);
        }
    }
?>