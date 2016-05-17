<?php 

namespace App\Core\Dbase;
use App\Core\Mvc\TSinglton;

class Db 
{
	use TSinglton;
	
    protected $dbh;
	
	protected function __construct() {
		try {
			$this->dbh = new \PDO('mysql:dbname=project;host=localhost','root','');
		} catch (\PDOException $e) {
			die('Ошибка°');
		}
	}
	public function query($sql, $class, $values = []){
		try {
			$sth = $this->dbh->prepare($sql);
			$res = $sth->execute($values);
			if (false !== $res) {
				return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
			}
		} catch (\PDOException $e) {
			die('Ошибка');
		}
	}
	public function execute($sql,$values = []){
		$sth = $this->dbh->prepare($sql);
		return $sth->execute($values);
	}
	
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}
	
}


?>