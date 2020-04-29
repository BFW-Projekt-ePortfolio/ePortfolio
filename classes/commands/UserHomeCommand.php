
<?php
namespace classes\commands;

use classes\request\Request;
use classes\response\Response;
use classes\template\HtmlTemplateView;

class UserHomeCommand implements Command{
	public function execute(Request $request, Response $response){
        $view = 'userHome';

        $userId = $_SESSION['userId'];

        $template = new HtmlTemplateView($view);
        
        $pageDAO = new PageDAO();

        $pageList = $pageDAO->readPagesOfUserWithContent($userId);

		$template->assign('pageList', $pageList);
		$template->render( $request, $response);
	}
}