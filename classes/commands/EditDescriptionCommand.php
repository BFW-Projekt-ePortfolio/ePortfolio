<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class EditDescriptionCommand implements Command{
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
            $ContentList = $pageList[0]->getContentList();
            $requestedTitle = $pageList[0]->getTitle();
            $pageId = $pageList[0]->getNummer();
            $alert = "";

            if($request->issetParameter('page')){
                $index = $request->getParameter('page');
                if($index >= 0 && $index < count($pageList) && is_numeric($index)){
                    $ContentList = $pageList[$index]->getContentList();
                    $requestedTitle = $pageList[$index]->getTitle();
                    $pageId = $pageList[$index]->getNummer();
                }
            }

            foreach($ContentList as $content) {
                if($content->getNummer() == $request->getParameter('content')) {
                    $oldDescription = $content->getContentDescription();
                    $requestedContent = $content;
                    break;
                } else {
                    $alert = "Content wurde nicht gefunden!";
                }
            }

            

            if($request->issetParameter('save')) {
                
                $newDescription = $request->getParameter('newDescription');

                $requestedContent->setContentDescription($newDescription);

                $contentDAO = new ContentDAO();

                $contentDAO->updateContent($requestedContent);

                $userDAO = new UserDAO();

                $pageDAO = new PageDAO();

                $updatedPagesList = $pageDAO->readPagesOfUserWithContent($currentUser->getId());

                $currentUser->setPages($updatedPagesList);

                unset($_SESSION['user']);

                $_SESSION['user'] = serialize($currentUser);

                header('location: index.php?cmd=UserHome&page=' . $index);
                exit;

            }

            if($request->issetParameter('cancel')) {
                header('location: index.php?cmd=EditPage&page=' . $index);
                exit;
            }

            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'EditDescription';

            $template = new HtmlTemplateView($view);

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('alert', $alert);
            $template->assign('oldDescription', $oldDescription);
            $template->render( $request, $response);
        }
    }
?>