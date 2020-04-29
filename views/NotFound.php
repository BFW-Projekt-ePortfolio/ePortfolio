<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\PageDAO;

    class NotFoundCommand implements Command{
        public function execute(Request $request, Response $response) {
            $view = 'NotFound';

            $template = new HtmlTemplateView($view);
            
            $pageDAO = new PageDAO();

            $style = "default";

            $template->assign('style', $style);
            $template->render( $request, $response);
        }
    }
?>