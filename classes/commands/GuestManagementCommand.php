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

            $pageList = $currentUser->getPages();
            $userDAO = new UserDAO;
            $MyGuestList = $userDAO->readGuestListOfUserWithTheirPages($currentUser->getId());

            if($request->issetParameter('addPermission')){
                $guestIndex = $request->getParameter('guestIndex');
                $pageIndex = $request->getParameter('addPermission');
                $guestIdToSetPermissionFor = $MyGuestList[$guestIndex]->getId();
                $pageId = $pageList[$pageIndex]->getNummer();
                $pageDAO = new PageDAO;
                $pageDAO->setPermissionForPage($guestIdToSetPermissionFor, $pageId);
            }
            if($request->issetParameter('removePermission')){
                $guestIndex = $request->getParameter('guestIndex');
                $pageIndex = $request->getParameter('removePermission');
                $guestId = $MyGuestList[$guestIndex]->getId();
                $pageId = $pageList[$pageIndex]->getNummer();
                $pageDAO = new PageDAO;
                $pageDAO->deletePermissionOfGuestForPage($guestId, $pageId);
            }
            if($request->issetParameter('removeGuest')){
                $guestIndex = $request->getParameter('removeGuest');
                $guestId = $MyGuestList[$guestIndex]->getId();
                $userDAO->deleteGuest($guestId);
            }
            unset($MyGuestList);
            $MyGuestList = $userDAO->readGuestListOfUserWithTheirPages($currentUser->getId());

            $displayname = $currentUser->getDisplayname();
            
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
