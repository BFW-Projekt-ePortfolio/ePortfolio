<?php
    namespace classes\commands;

    use classes\request\Request;
    use classes\response\Response;
    use classes\template\HtmlTemplateView;
    use classes\mapper\UserDAO;

    class NoPermissionCommand implements Command{
        public function execute(Request $request, Response $response) {

            // ich werde heute noch den Command hier anpassen damit nur Admins hierauf zugreifen können. Da diente nur zu Testzwecken, ob auch ein Ordner angelegt wird. klappt soweit.
            $view = 'NoPermission';

            $template = new HtmlTemplateView($view);
            $style = "default"; // provisorisch
            $template->assign('style', $style);
            $template->render( $request, $response);
        }
    }
?>