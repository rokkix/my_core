<?php

namespace App\Controllers;

use App\Core\Mvc\Controller;
use App\Core\Mvc\View;
use App\Models\News as NewsModel;
use App\Core\Exception404;
use App\Core\Authorization;


class Admin extends Controller
{
	public function action($action, $params = '') {
		
		Authorization::LogIn();
		//var_dump(Authorization::LogIn()); die;
		if (true === Authorization::check()) {
			parent::action($action, $params = '');
		} else {
			$this->view->display(__DIR__ .  '/../Views/admin/authorization.php');
		}
	}
	
	protected function actionAll() {
		
		$this->view->news = NewsModel::findAll();
		$this->view->display(__DIR__ . '/../Views/admin/index.php');
	}
	
	
	protected function beforeAction() {
		
	}
	
	protected function actionOne() {
		$id = (int)$_GET['id'];
		if (empty($id)) {
			$this->redirect('/admin/');
		}
		$news = NewsModel::findById($id);
		if (null == $news) {
			throw new Exception404('Страница с такой новостью не найдена');
		}
		$this->view->news = $news;
		$this->view->display(__DIR__ . '/../Views/admin/one.php');
	}
	
	protected function  actionCreate() {
		$this->view->display(__DIR__ . '/../Views/admin/form.php');
	}
	
	protected function actionSave(){
		$post = $_POST;
        if (empty($post)) {
			$this->redirect('/admin/');
        }
        if (empty($post['id'])) {
			$article = new NewsModel();
        } else {
			$article = NewsModel::findById($post['id']);
        }
		$article->fill($post)->save();
        $this->redirect('/admin/one/?id=' . $article->id);
	}
	
	protected function actionUpdate() {
		$id = (int)$_GET['id'] ?: false;
		if (empty($id)) {
			$this->redirect('/admin/');
		}
		$article = NewsModel::findById($id);
		$this->view->article = $article;
		$this->view->display(__DIR__ . '/../Views/admin/form.php');
	}
	
	protected function actionDelete() {
		$id = (int)$_GET['id'] ?: false;
		if (empty($id)) {
			$this->redirect('/admin/');
		}
		$article = NewsModel::findById($id);
		$article->delete();
		$this->redirect('/admin/');
	}
}
?>