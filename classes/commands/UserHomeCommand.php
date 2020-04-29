<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;

    class UserHomeCommand implements Command{
        public function execute(Request $request, Response $response) {
            $view = 'UserHome';

            $userId = $_SESSION['userId'];

            $template = new HtmlTemplateView($view);
            
            $pageDAO = new PageDAO();

            $pageList = $pageDAO->readPagesOfUserWithContent($userId);

            $style = "default"; // provisorisch

            $template->assign('style', $style);
            $template->assign('pageList', $pageList);
            $template->render( $request, $response);
        }
    }
?>