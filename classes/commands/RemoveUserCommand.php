<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;
    use classes\model\User;

    class RemoveUserCommand implements Command{
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

            if($request->issetParameter('deleteUser')){
                $userDAO->deleteUser($request->getParameter('deleteUser'));
            }

            $listOfAllUsers = $userDAO->readAllUsersWithPages("user");
            $multiListArray = array();
            for($i = 0; $i < count($listOfAllUsers); $i++){
                $multiListArray[$i][] = $listOfAllUsers[$i];
                $multiListArray[$i][] = $userDAO->readGuestListOfUser($listOfAllUsers[$i]->getId());
            }

            $view = 'RemoveUser';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->assign('userList', $multiListArray);
            $template->render( $request, $response);
        }
    }
?>