<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class AddAdminCommand implements Command{
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

            if ($request->issetParameter("password") && $request->issetParameter("email") && $request->issetParameter("firstname") && $request->issetParameter("lastname") && $request->issetParameter("displayname")) {
                if($request->getParameter("password") === $request->getParameter("pwRepeat")) {
                    $password = password_hash($request->getParameter("password"), PASSWORD_DEFAULT);
                    $email = $request->getParameter("email");
                    $firstname = $request->getParameter("firstname");
                    $lastname = $request->getParameter("lastname");
                    $displayname = $firstname . " " . $lastname;

                    $userDAO = new UserDAO();
                    $id = $userDAO->createAdmin($firstname, $lastname, $displayname, $email, $password);

                    header('location: index.php?cmd=AdminHome');
                    exit;
                } else {
                    $error = "Passwort stimmt nicht überein!";
                }
            } else {
                $error = "";
            }

            $view = 'AddAdmin';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->assign('error', $error);
            $template->render( $request, $response);
        }
    }
?>