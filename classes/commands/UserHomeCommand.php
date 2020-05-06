<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class UserHomeCommand implements Command{
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
            $editLink = "<a href='./?cmd=EditPage&page=0'>Seite bearbeiten</a><br><br>";

                if($request->issetParameter('page')){
                    $index = $request->getParameter('page');
                    if($index >= 0 && $index < count($pageList) && is_numeric($index)){
                        $ContentList = $pageList[$index]->getContentList();
                        $requestedTitle = $pageList[$index]->getTitle();
                        $editLink = "<a href='./?cmd=EditPage&page=" . $index . "'>Seite bearbeiten</a><br><br>";
                    }
                }

            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'UserHome';

            $template = new HtmlTemplateView($view);
            $filepath = USERS_DIR . $currentUser->getId() ."/";

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('requestedContent', $ContentList);
            $template->assign('displayname', $displayname);
            $template->assign('editLink', $editLink);
            $template->assign('requestedTitle', $requestedTitle);
            $template->assign('filepath', $filepath);
            $template->render( $request, $response);
        }
    }
?>
