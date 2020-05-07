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

    class RemoveContentCommand implements Command{
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
            $pageId = $pageList[0]->getNummer();

            if($request->issetParameter('page')){
                $index = $request->getParameter('page');
                if($index >= 0 && $index < count($pageList) && is_numeric($index)){
                    $ContentList = $pageList[$index]->getContentList();
                    $pageId = $pageList[$index]->getNummer();
                }
            }

            if($request->issetParameter('remove')) {
                $contentDAO = new ContentDAO();
                $contentId = $request->getParameter('content');

                $file = $contentDAO->readContentName($contentId);

                // Der Content wird erfolgreich aus der DB und die Datei aus dem Ordner gelöscht, aber die Funktion gibt bei Scheitern nichts zurück
                if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    unlink(USERS_DIR . $currentUser->getId() . '/' . $file);
                } else {
                    shell_exec('rm ' . USERS_DIR . $currentUser->getId() . '/' . $file);
                }
                
                $contentDAO->deleteContent($contentId);

                $pageDAO = new PageDAO();

                $updatedPagesList = $pageDAO->readPagesOfUserWithContent($currentUser->getId());

                $currentUser->setPages($updatedPagesList);

                unset($_SESSION['user']);

                $_SESSION['user'] = serialize($currentUser);

                header('location: index.php?cmd=EditPage&page=' . $request->getParameter('page'));
                exit;
            }

            if($request->issetParameter('keep')) {
                header('location: index.php?cmd=EditPage&page=' . $request->getParameter('page'));
                exit;
            }

            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'RemoveContent';

            $template = new HtmlTemplateView($view);


            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->render( $request, $response);
        }
    }
?>