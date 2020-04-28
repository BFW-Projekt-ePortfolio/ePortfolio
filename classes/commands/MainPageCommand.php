<?php
namespace classes\commands;

use classes\request\Request;
use classes\response\Response;
use classes\template\HtmlTemplateView;

class MainPageCommand implements Command{
	public function execute(Request $request, Response $response){
        $view = 'mainPage';

		$template = new HtmlTemplateView($view);

		//$template->assign('link', $link);
		$template->render( $request, $response);
	}
}