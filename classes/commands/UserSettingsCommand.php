<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class UserSettingsCommand implements Command{
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

            $confirmText = "";
            if($request->issetParameter('deleteAcc')){
                // user wants to delete his Acc - asking for a confirmation
                $confirmText .= '<br><div style="color: red; text-align: center;">Sind Sie sich wirklich sicher?</div><br>';
                $confirmText .= '<div style="text-align: center">Es gibt danach keinen Weg zur Wiederherstellung</div>';
                $confirmText .= '<form action="#" method="post" style="text-align:center"><button type="submit" value="cancel" name="cancel">zurück!</button></form>';
                $confirmText .= '<form action="#" method="post" style="text-align:center"><button type="submit" value="ConfirmAccDelete" name="ConfirmAccDelete">Account entgültig löschen!</button></form>';
                $confirmText .= '<br>';
            }
            if($request->issetParameter('ConfirmAccDelete')){
                // confirmed - deleting acc
                $userDAO = new UserDAO;
                $userDAO->deleteUser($currentUser->getId());
                // deleting files
                if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // glob sucht nach Dateien im angegebenen Verzeichnis und unlink löscht diese
                    foreach (glob(USERS_DIR . $currentUser->getId() . "/*.*") as $filename) {
                        unlink($filename);
                    }
                    // wenn der Ordner leer ist kann er mit unlink gelöscht werden
                    unlink(USERS_DIR . $currentUser->getId());
                } else {
                    // löscht den Ordner und alle darin enthaltenen Dateien und Unterordner
                    shell_exec('rm -rf ' . USERS_DIR . $currentUser->getId());

                }
                // and bye bye
                header("location: ./?cmd=Logout");
                exit;
            }

            // Hier muss noch einiges rein damit der User seinen Account und seine Pages verwalten kann. Seiten bearbeiten macht er an anderer Stelle

            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'UserSettings';

            $template = new HtmlTemplateView($view);

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('deleteAccText', $confirmText);
            $template->render( $request, $response);
            
        }
    }
?>