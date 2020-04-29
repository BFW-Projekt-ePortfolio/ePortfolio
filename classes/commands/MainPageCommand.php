<?php
	namespace classes\commands;

	use classes\request\Request;
	use classes\response\Response;
	use classes\template\HtmlTemplateView;

	class MainPageCommand implements Command{
		public function execute(Request $request, Response $response){
			$view = 'MainPage';

			$template = new HtmlTemplateView($view);

			$style = "default";

			$template->assign('style', $style);
			$template->render( $request, $response);
		}
	}
?>