<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;
    use classes\model\User;

    class AdminVerwaltungCommand implements Command{
        public function execute(Request $request, Response $response) {

            if (isset($_SESSION['admin'])){
                $currentUser = unserialize($_SESSION['admin']);
            }
            else{
                // header to bye bye weil keine Session
                header('location: index.php');
            }
            if (!($currentUser instanceof User)){
                // header to bye bye weil session = wtf
                header('location: index.php');
            }
            if ($currentUser->getStatus() != "admin"){
                header('location: index.php');
                // header to bye bye weil kein user - glaub nun sollten alle möglichen unberechtigten rausgefiltert worden sein.
            }
            $userDAO = new UserDAO;

            if($request->issetParameter('deleteAdmin')){
                $userDAO->deleteUser($request->getParameter('deleteAdmin'));
            }

            $listOfAllAdmins = $userDAO->readAllUsersWithPages("admin");

            $view = 'AdminVerwaltung';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->assign('userList', $listOfAllAdmins);
            $template->render( $request, $response);
        }
    }
?>