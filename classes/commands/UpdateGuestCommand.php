<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class UpdateGuestCommand implements Command{
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
            $allertText = "";
            $successText = "";
            $changedSomething = false;
            if($request->issetParameter('firstnameChange')){
                $requestedFirstname = $request->getParameter('firstname');
                if($requestedFirstname != ""){
                    if($currentUser->getFirstname() != $requestedFirstname){
                        $currentUser->setFirstname($requestedFirstname);
                        $changedSomething = true;
                        $currentUser->setDisplayname($requestedFirstname . " " . $currentUser->getLastname());
                        $successText .= '<p style="Color: green; text-align: center">Vorname wurde erfolgreich geändert</p>';
                    }
                }
                else{
                    $allertText .= '<p style="Color: red; text-align: center">Sie müssen einen Vornamen für Ihr Portfolio angeben!</p>';
                }
            }
            if($request->issetParameter('lastnameChange')){
                $requestedLastname = $request->getParameter('lastname');
                if($requestedLastname != ""){
                    if($currentUser->getLastname() != $requestedLastname){
                        $currentUser->setLastname($requestedLastname);
                        $changedSomething = true;
                        $currentUser->setDisplayname($currentUser->getFirstname() . " " . $requestedLastname);
                        $successText .= '<p style="Color: green; text-align: center">Nachname wurde erfolgreich geändert</p>';
                    }
                }
                else{
                    $allertText .= '<p style="Color: red; text-align: center">Sie müssen einen Nachnamen füt Ihr Portfolio angeben!</p>';
                }
            }
            if($request->issetParameter('emailChange')){
                $requestedEmail = $request->getParameter('email');
                if($requestedEmail != ""){
                    if($userDAO->exist($requestedEmail)){
                        if($currentUser->getEmail() != $requestedEmail){
                            $allertText .= '<p style="Color: red; text-align: center">Diese E-Mail Adresse ist bereits vergeben!</p>';
                        }
                    }
                    else{
                        $currentUser->setEmail($requestedEmail);
                        $changedSomething = true;
                        $successText .= '<p style="Color: green; text-align: center">Ihr E-Mail Adresse wurde erfolgreich geändert</p>';
                    }
                }
                else{
                    $allertText .= '<p style="Color: red; text-align: center">Sie müssen eine gültige E-Mail Adresse angeben!</p>';
                }
            }
            if($request->issetParameter('pwChange')){
                $requestedPw = $request->getParameter('password');
                $requestedPwRepeat = $request->getParameter('pwRepeat');
                if($requestedPw != $requestedPwRepeat){
                    $allertText .= '<p style="Color: red; text-align: center">Das Passwort stimmt nicht mit der Wiederholung überein!</p>';
                }
                if($requestedPw != ""){
                    $currentUser->setPasswd(password_hash($requestedPw, PASSWORD_DEFAULT));
                    $changedSomething = true;
                    $successText .= '<p style="Color: green; text-align: center">Ihr Passwort wurde erfolgreich geändert</p>';
                }
                else{
                    $allertText .= '<p style="Color: red; text-align: center">Sie müssen ein Passwort für Ihr Portfolio setzen!</p>';
                }
            }
            if ($changedSomething){
                // The actual update of the user
                $userDAO->updateUser($currentUser);
                // Then updating the session
                unset($_SESSION['user']);
                $_SESSION['user'] = serialize($currentUser);
            }
        
            $displayname = $currentUser->getDisplayname();
            
            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'UpdateGuest';

            $template = new HtmlTemplateView($view);

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('user', $currentUser);
            $template->assign('allertText' ,$allertText);
            $template->assign('successText', $successText);
            $template->render( $request, $response);
        }
    }
?>