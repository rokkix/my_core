<?php
namespace App\Controllers;
use App\Core\Mvc\Controller;
use App\Core\Mvc\View;
use App\Models\News as NewsModel;

class Admin extends Controller
{
	
	protected function actionAll() {
		$this->view->news = NewsModel::findAll();
		$this->view->display(__DIR__ . '/../Views/admin/index.php');
	}
	
	protected function beforeAction() {}
	
	protected function actionOne() {
		$id = (int)$_GET['id'];
		
		if (empty($id)) {
			$this->redirect('/');
		}
		$this->view->article = NewsModel::findById($id);
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
			redirect('/admin/');
		}
		 if (!empty($id)) {
            if (!empty($article = NewsModel::findById($id))) {
                $this->view->article = $article;
                $this->view->display(__DIR__ . '/../Views/admin/form.php');
			}
		 }
	}
	protected function actionDelete() {
		$id = (int)$_GET['id'] ?: false;
        if (!empty($article = NewsModel::findById($id))) {
            $article->delete();
        }
		$this->redirect('/admin/');
	}
}	
