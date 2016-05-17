<?php 

namespace App\Models;
use App\Core\Mvc\Model;

class News extends Model
{
	const TABLE = 'news';
	public $id;
	public $title;
	public $text;
	public $dt;


    public function fill(array $post)
    {
	parent::fill($post);
	$this->dt = date("Y-m-d H:i:s");
	//var_dump($this); die;
	//$this->validate();
	return $this;
	
    }
}
?>