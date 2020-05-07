<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class GuestManagementCommand implements Command{
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

            if($request->issetParameter('addPermission')){
                $guestIdToSetPermissionFor = $request->getParameter('guestId');
                $pageId = $request->getParameter('addPermission');
                $pageDAO = new PageDAO;
                $pageDAO->setPermissionForPage($guestIdToSetPermissionFor, $pageId);
            }
            if($request->issetParameter('removePermission')){
                $guestId = $request->getParameter('guestId');
                $pageId = $request->getParameter('removePermission');
                $pageDAO = new PageDAO;
                $pageDAO->deletePermissionOfGuestForPage($guestId, $pageId);
            }

            $userDAO = new UserDAO;

            if($request->issetParameter('removeGuest')){
                $guestId = $request->getParameter('removeGuest');
                $userDAO->deleteGuest($guestId);
            }

            $displayname = $currentUser->getDisplayname();
            $pageList = $currentUser->getPages();

            $MyGuestList = $userDAO->readGuestListOfUserWithTheirPages($currentUser->getId());
            
            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'GuestManagement';

            $template = new HtmlTemplateView($view);
            $filepath = USERS_DIR . $currentUser->getId() ."/";

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('guestList', $MyGuestList);
            $template->render( $request, $response);
        }
    }
?>
