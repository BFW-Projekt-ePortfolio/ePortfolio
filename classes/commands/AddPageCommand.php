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
            if($request->issetParameter('createPage')){
                if(count($pageList) < 10){ // Seiten Anzahl auf 10 ? begrenzt
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
                else{
                    $allertText .= '<div style="color:red; text-align: center;">Portfolios sind derzeit auf maximal 10 Seiten begrenzt!</div>';
                }
            }
            if($request->issetParameter('deletePage')){
                $pageId = $pageList[$request->getParameter('deletePage')]->getNummer();
                $pageTitle = $pageList[$request->getParameter('deletePage')]->getTitle();
                $userDAO = new UserDAO;
                $pageDAO = new PageDAO;
                $guestList = $userDAO->readGuestListOfUserWithTheirPages($currentUser->getId());
                foreach($guestList as $guest){
                    $guestPages = $guest->getPages();
                    foreach($guestPages as $g_Page){
                        if($g_Page->getNummer() == $pageId){
                            // permission des Gastes entfernen
                            $pageDAO->deletePermissionOfGuestForPage($guest->getId(), $pageId);
                        }
                    }
                } // jetzt sind alle permissions der Gäste für diese Seite gelöscht
                // jetzt die eigene permission löschen
                $pageDAO->deletePermissionOfGuestForPage($currentUser->getId(), $pageId);

                $pageContent = $pageList[$request->getParameter('deletePage')]->getContentList();

                //hier sollten die Dateien der jeweiligen Page gelöscht werden...
                if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // ...auf Windows...
                    foreach($pageContent as $file) {
                        unlink(USERS_DIR . $currentUser->getId() . "/" . $file->getContent());
                    }
                } else {
                    // ...und Linux, BSD, macOS, Solaris, etc.
                    foreach($pageContent as $file) {
                        shell_exec("rm " . USERS_DIR . $currentUser->getId() . "/". $file->getContent());
                    }
                }

                // und dann endlich die Seite selbst löschen
                $pageDAO->deletePage($pageId);
                // und jetzt das Objekt $currentUser updaten
                $currentUser->setPages($pageDAO->readPagesOfUserWithContent($currentUser->getId()));
                // und dann die session aktualisieren
                unset($_SESSION['user']);
                $_SESSION['user'] = serialize($currentUser);
                // und dann die pagelist für die SeitenAnsicht updaten
                unset($pageList);
                $pageList = $currentUser->getPages();
                // und ne meldung erzeugen mit dem allertText
                $allertText .= '<div style="color:green; text-align: center;">Die Seite '.$pageTitle.' wurde erfolgreich gelöscht!</div>';
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