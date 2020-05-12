<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\model\Page;
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class AddPageCommand implements Command{
        public function execute(Request $request, Response $response) {

            if (isset($_SESSION['user'])){
                $currentUser = unserialize($_SESSION['user']);
            }
            else{
                // header to bye bye weil keine Session
                header('location: index.php');
            }
            if (!($currentUser instanceof User)){
                // header to bye bye weil session = wtf
                header('location: index.php');
            }
            if ($currentUser->getStatus() != "user"){
                header('location: index.php');
                // header to bye bye weil kein user - glaub nun sollten alle möglichen unberechtigten rausgefiltert worden sein.
            }

            $displayname = $currentUser->getDisplayname();

            $pageList = $currentUser->getPages();

            $allertText = "";
            if(count($pageList) < 10){ // Seiten Anzahl auf 10 ? begrenzt
                if($request->issetParameter('createPage')){
                    $requestedTitle = $request->getParameter('pageInput');
                    if($requestedTitle != ""){
                        //create Page
                        // db-stuff
                        $pageDAO = new PageDAO;
                        $newPage_id = $pageDAO->createPage($currentUser->getId(), $requestedTitle);
                        $pageDAO->setPermissionForPage($currentUser->getId(), $newPage_id);
                        // object-stuff
                        $newPage = new Page($newPage_id, $currentUser->getId(), $requestedTitle,array());
                        $pageList[] = $newPage;
                        $currentUser->setPages($pageList);
                        unset($_SESSION['user']);
                        $_SESSION['user'] = serialize($currentUser);
                        // send off to edit the new page
                        header('location: ./?cmd=EditPage&page='.(count($pageList) -1));
                        exit;
                    }
                    else{
                        $allertText .= '<div style="color:red; text-align: center;">Sie müssen Ihrer Seite einen Namen geben!</div>';
                    }

                }
            }
            else{
                $allertText .= '<div style="color:red; text-align: center;">Portfolios sind derzeit auf maximal 10 Seiten begrenzt!</div>';
            }
  

            // Hier muss noch einiges rein damit der User seinen Account und seine Pages verwalten kann. Seiten bearbeiten macht er an anderer Stelle


            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'AddPage';

            $template = new HtmlTemplateView($view);

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('allertText', $allertText);
            $template->render( $request, $response);
        }
    }
?>