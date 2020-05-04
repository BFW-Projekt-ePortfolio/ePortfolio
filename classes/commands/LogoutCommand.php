<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\model\User;

    class LogoutCommand implements Command{
        public function execute(Request $request, Response $response) {

            header('location: ./');
            exit;
            
        }
    }
?>