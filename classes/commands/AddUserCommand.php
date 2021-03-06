<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;
    use classes\mapper\PageDAO;
    use classes\mapper\ContentDAO;

    class AddUserCommand implements Command{
        public function execute(Request $request, Response $response) {

            if(!isset($_SESSION['admin'])) {
                header('location: index.php?cmd=NoPermission');
                exit;
            }

            $password = "";
            $email = "";
            $firstname = "";
            $lastname = "";
            $displayname = "";

            if ($request->issetParameter("password") && $request->issetParameter("email") && $request->issetParameter("firstname") && $request->issetParameter("lastname")) {
                
                $userDAO = new UserDAO();

                if(!$userDAO->exist($request->getParameter("email"))) {
                    if($request->getParameter("password") === $request->getParameter("pwRepeat")) {
                        $password = password_hash($request->getParameter("password"), PASSWORD_DEFAULT);
                        $email = $request->getParameter("email");
                        $firstname = $request->getParameter("firstname");
                        $lastname = $request->getParameter("lastname");
                        $displayname = $firstname . " " . $lastname;

                        $id = $userDAO->createUser($firstname, $lastname, $displayname, $email, $password);

                        $this->createMainPageForUser($id, $firstname, $lastname);

                        // Die Konstante wird in conf/dirs.inc definiert und über die UserDAO geladen. Bin mir noch nicht sicher, ob das so passt.
                        // Die Berechtigungen für die einzelnen Ordner und Dateien im gesamten Projekt muss ich noch anpassen, habe mich etwas eingelesen
                        // und muss das noch testen.
                        mkdir(USERS_DIR . $id, 0750, true);

                        header('location: index.php?cmd=AdminHome');
                        exit;
                    } else {
                        $error = "Passwort stimmt nicht überein!";
                    }
                } else {
                    $error = "E-Mail existiert bereits!";
                }
            } else {
                $error = "";
            }

            $view = 'AddUser';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->assign('error', $error);
            $template->render( $request, $response);
        }

        private function createMainPageForUser($userId, $firstname, $lastname){
            $pageDAO = new PageDAO;
            $contentDAO = new ContentDAO;

            $ownerId = $userId;
            $title = "Home";

            $content = "defaultContent";
            $contentDescription = '<div>';
            $contentDescription .= '<h1 id="defaultContent" style="text-align: center;">Herzlich willkommen '.$firstname." ".$lastname. '</h1>';
            $contentDescription .= '<div style="font-size: 1.2rem;"><strong>Diese Seite wird automatisch all Ihren Gästen zur Begrüßung angezeigt ❗ </strong></div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Sie sollten also zuallererst diese Seite bearbeiten und nach Ihren Wünschen gestalten.</div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Wenn Sie weitere Seiten eingerichtet haben, können Sie diese für ausgewählte ';
            $contentDescription .= 'Gäste freigeben. Dieser Gast hat dann über die Navigationsleiste die möglichkeit ';
            $contentDescription .= 'diese Seite(n) zu öffnen.</div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Sie haben neben der Möglichkeit Texte zu schreiben auch die Option ';
            $contentDescription .= 'Bilder zur Dekoration einzufügen und Pdf-Dateien, sowie links auf all Ihren Seiten zu hinterlegen.</div>';
            $contentDescription .= '<br>';
            $contentDescription .= '<div style="font-size: 1.2rem;"><strong>Wenn Sie Ihrer Seite Inhalt hinzufügen, können Sie in den Textfeldern auch html verwenden.</strong></div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Wir empfehlen zur bestmöglichen Gestaltungsfreiheit das Nutzen von internen Style-sheets (&lt;style&gt;&lt;/style&gt;) oder Inline Styles.</div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Hier eine gute Quelle zu html/css: <a href="https://wiki.selfhtml.org/wiki/Startseite" target="_blank">selfhtml</a></div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Sie haben 65,535 Zeichen pro Inhalt zur verfügung.</div>';
            $contentDescription .= '<br>';
            $contentDescription .= '<div style="font-size: 1.2rem;"><strong>Bei jedem neuen Konto empfehlen wir dringend Ihr Kennwort zu ändern!</strong></div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Der Administrator der Ihr Konto angelegt hat, könnte Ihr Passwort nicht sicher gewählt, bzw es sich gemerkt haben.</div>';
            $contentDescription .= '<div style="padding-left: 2rem;">Sie finden die Option zum Passwort-ändern in den Einstellungen unter Profil bearbeiten</div>';
            $contentDescription .= '<h3>Wir wünschen Ihnen viel Spaß beim erstellen Ihres Portfolios</h3>';
            $contentDescription .= '</div>';
            $html_id = "defaultContent";

            $belongsToPageNr = $pageDAO->createPage($ownerId, $title);
            $pageDAO->setPermissionForPage($ownerId, $belongsToPageNr);
            $contentDAO->createContent($belongsToPageNr, $contentDescription, $content, $html_id);

        }

    }
?>