<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class AddGuestCommand implements Command{
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

            // Hier muss noch einiges rein damit der User seinen Account und seine Pages verwalten kann. Seiten bearbeiten macht er an anderer Stelle

            // Die Create-Guest Anfrage:
            $pwAllert = "";
            $emailAllert = "";
            $createdGuest = false;
            if($request->issetParameter('createGuestemail')){
                if($request->getParameter('createGuestpassword') == ""){
                    $pwAllert = '<span style="color:red"> Sie müssen ein Passwort vergeben </span><br>';
                }
                if($request->getParameter('createGuestpassword') != $request->getParameter('createGuestpwRepeat')){
                    $pwAllert .= '<span style="color:red"> Die Passwörter stimmen nicht überein </span><br>';
                }
                $GuestEmail = $request->getParameter('createGuestemail');
                if($GuestEmail == ""){
                    $emailAllert = '<span style="color:red"> Sie müssen eine Email Adresse angeben </span><br>';
                }

                $userDAO = new UserDAO;
                $MyGuestList = $userDAO->readGuestListOfUser($currentUser->getId());
                foreach($MyGuestList as $guest){
                    if($guest->getEmail() == $GuestEmail){
                        $emailAllert .= '<span style="color:red"> Sie haben diesen Gast bereits angelegt </span><br>'; 
                    }
                }
                if($emailAllert == "" && $pwAllert == ""){
                    //create Guest
                    $password = password_hash($request->getParameter('createGuestpassword'), PASSWORD_DEFAULT);
                    $newGuestId = $userDAO->createGuest("","","",$GuestEmail, $password);
                    $pageDAO = new PageDAO;
                    for($i = 0; $i < count($pageList); $i++){
                        if($i == 0){
                            $pageDAO->setPermissionForPage($newGuestId, $pageList[$i]->getNummer());
                        }
                        else{
                            if($request->issetParameter('page'.$i)){
                                $pageDAO->setPermissionForPage($newGuestId, $pageList[$i]->getNummer());
                            }
                        }
                    }
                    $createdGuest = true;

                    $message = "<h1>Gast erfolgreich angelegt</h1>";
                    $view = "CreatedGuestSuccesfully";
                    $style = "default";
                    $template = new HtmlTemplateView($view);
                    $template->assign('style', $style);
                    $template->assign('pageList', $pageList);
                    $template->assign('displayname', $displayname);
                    $template->assign('message', $message);
                    $template->render( $request, $response);
                }

            }

            if(!$createdGuest){
                $view = "CreateGuest";
                $style = "default";
                $template = new HtmlTemplateView($view);
                $template->assign('style', $style);
                $template->assign('pageList', $pageList);
                $template->assign('displayname', $displayname);
                $template->assign('pwAllert', $pwAllert);
                $template->assign('emailAllert', $emailAllert);
                $template->render( $request, $response);
            }
 
        }
    }
?>