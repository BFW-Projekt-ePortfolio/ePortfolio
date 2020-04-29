
<?php
namespace classes\commands;

use classes\request\Request;
use classes\response\Response;
use classes\template\HtmlTemplateView;

class UserHomeCommand implements Command{
	public function execute(Request $request, Response $response){
        $view = 'UserHome';

        $user = $_SESSION['user'];

        $template = new HtmlTemplateView($view);
        
        $pageDAO = new PageDAO();

        $pageList = $pageDAO->readPagesOfUserWithContent($user->getId());

		$template->assign('pageList', $pageList);
		$template->render( $request, $response);
	}
}