<?php 
namespace App\Controllers;

use App\Core\Mvc\Controller;
use App\Core\Mvc\View;
use App\Models\News as NewsModel;
use App\Core\Exception404;

class News extends Controller
{
	public function beforeAction() {}
	
	protected function actionAll(){
		$this->view->news = NewsModel::findAll();
		$this->view->display(__DIR__ . '/../Views/news/index.php');
	}
	protected function actionOne(){
		
		$id = (int)$_GET['id'];
		//var_dump
		if (empty($id)) {
			$this->redirect('/');
		}
		$this->view->news = NewsModel::findById($id);
		if (null == $this->view->news) {
			throw new Exception404('Страница с такой новостью не найдена');
		}
		$this->view->display(__DIR__ . '/../Views/news/one.php');
		
	}
	
}


?>