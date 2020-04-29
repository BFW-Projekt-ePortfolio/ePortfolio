<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;

    class AdminHomeCommand implements Command{
        public function execute(Request $request, Response $response) {
            $view = 'AdminHome';

            $user = unserialize($_SESSION['user']);

            $template = new HtmlTemplateView($view);
            
            $pageDAO = new PageDAO();

            $style = "default"; // provisorisch

            $template->assign('style', $style);
            $template->render( $request, $response);
        }
    }
?>