<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    // include_once('conf/dirs.inc');

    class EditPageCommand implements Command{
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

            $addContentLink = "<a href='./index.php?cmd=AddContent&page=" .$requestedPageId . "'>Inhalt hinzufügen</a><br><br>";

            if($request->issetParameter('changeTitle')) {
                $pageDAO = new PageDAO();
                $newTitle = $request->getParameter('newTitle');
                if ($pageDAO->updatePageTitle($pageId, $newTitle) > 0) {
                    $userDAO = new UserDAO();

                    $updatedPagesList = $pageDAO->readPagesOfUserWithContent($currentUser->getId());

                    $currentUser->setPages($updatedPagesList);

                    unset($_SESSION['user']);

                    $_SESSION['user'] = serialize($currentUser);

                    header('location: index.php?cmd=EditPage&page=' . $request->getParameter('page'));
                    exit;
                    
                } else {
                    $alert = "da hat was nicht geklappt!";
                }
            }

            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'EditPage';

            $template = new HtmlTemplateView($view);
            $filepath = USERS_DIR . $currentUser->getId() ."/";

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('requestedContent', $ContentList);
            $template->assign('displayname', $displayname);
            $template->assign('requestedTitle', $requestedTitle);
            $template->assign('filepath', $filepath);
            $template->assign('alert', $alert);
            $template->assign('addContentLink', $addContentLink);
            $template->render( $request, $response);
        }
    }
?>