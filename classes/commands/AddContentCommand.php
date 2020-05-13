<?php
    namespace classes\commands;
    use classes\model\User; // added um instanceof benutzen zu können.
    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;
    use classes\mapper\UserDAO;

    class AddContentCommand implements Command{
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

            // Hier stehen die für den Upload erlaubten MIME-Types
            $allowedMime = ["text/rtf", "text/richtext", "text/plain", "text/comma-separated-values", "image/tiff", "image/png", "image/jpeg", "image/gif", "image/bmp", 
                            "image/x-bmp", "image/x-ms-bmp", "application/zip", "application/x-tar", "application/vnd.oasis.opendocument.text", 
                            "application/vnd.oasis.opendocument.spreadsheet", "application/rtf", "application/pdf", "application/msword", "application/mspowerpoint", 
                            "application/msexcel", "application/gzip", "audio/x-wav", "audio/mpeg", "audio/ogg", "audio/mp4", "audio/wav", "audio/x-midi", "audio/x-mpeg", "audio/", 
                            "video/mpeg", "video/mp4", "video/ogg"];


            $alert = "";

            if($request->issetParameter('saveFile')) {

                $uploadDir = USERS_DIR . $currentUser->getId() . "/";

                $description = $request->getParameter('descriptionFile');
                $pageId = $request->getParameter('page');

                // Code zum Dateiupload
                // 1. Prüfung, ob upgeloadete Datei
                if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                    $mimeType = mime_content_type($_FILES['userfile']['tmp_name']);

                    // 2. Prüfung, ob MIME-Type zulässig (kein php, sh, etc.)
                    if(in_array($mimeType, $allowedMime)) {
                        // 3. Entfernen von Leerzeichen im Dateinamen
                        $fileName = str_replace(" ", "", $_FILES['userfile']['name']);
                        $tmpFile = $_FILES['userfile']['tmp_name'];
                        
                        // 4. Prüfung, ob Datei mit selbem Namen bereits existiert
                        if(file_exists($uploadDir . $fileName)) {
                            $alert = "Eine Datei mit diesem Name existiert bereits. Bitte ändern Sie den Dateinamen oder wählen Sie eine andere Datei!";
                        } else {

                            $uploadFile = $uploadDir . $fileName;

                            // 5. Verschieben in den User Ordner
                            if(move_uploaded_file($tmpFile, $uploadFile)) {
                                // 6. Erstellen von Datensatz in der DB
                                $contentDAO = new ContentDAO();

                                if($contentDAO->createContent($pageId, $description, $fileName, null) >= 0) {

                                    $userDAO = new UserDAO();

                                    $pageDAO = new PageDAO();
                    
                                    $updatedPagesList = $pageDAO->readPagesOfUserWithContent($currentUser->getId());
                    
                                    $currentUser->setPages($updatedPagesList);
                    
                                    unset($_SESSION['user']);
                    
                                    $_SESSION['user'] = serialize($currentUser);

                                    $alert = "Dateiupload erfolgreich!";
                                } else {
                                    $alert = "Fehler beim Schreiben in die Datenbank!";
                                }
                            } else {
                                $alert = "Fehler beim Datei-Upload!";
                            }
                        }
                    } else {
                        $alert = "Dateien vom Typ " . $mimeType .  " sind nicht zulässig!";
                    }
                }
            }

            if($request->issetParameter('saveNoFile')) {
                $description = $request->getParameter('descriptionNoFile');
                $pageId = $request->getParameter('page');

                $contentDAO = new ContentDAO();

                if($contentDAO->createContent($pageId, $description, null, null) >= 0) {

                    $userDAO = new UserDAO();

                    $pageDAO = new PageDAO();
    
                    $updatedPagesList = $pageDAO->readPagesOfUserWithContent($currentUser->getId());
    
                    $currentUser->setPages($updatedPagesList);
    
                    unset($_SESSION['user']);
    
                    $_SESSION['user'] = serialize($currentUser);

                    $alert = "Dateiupload erfolgreich!";
                } else {
                    $alert = "Fehler beim Schreiben in die Datenbank!";
                }
            }

            if($request->issetParameter('cancel')) {
                header('location: index.php?cmd=UserHome');
                exit;
            }


            // Hier muss noch einiges rein damit der User seinen Account und seine Pages verwalten kann. Seiten bearbeiten macht er an anderer Stelle


            // Hier müsste das was unter style in der Tabelle user hinterlegt ist geladen werden. Wie z. B.
            // $style = $currentUser->getStyle();
            $style = "default";

            $view = 'AddContent';

            $template = new HtmlTemplateView($view);

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->assign('displayname', $displayname);
            $template->assign('alert', $alert);
            $template->render( $request, $response);
        }
    }
?>