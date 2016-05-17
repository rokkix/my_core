<?php 
namespace App\Core\Mvc;
use App\Core\Dbase\Db;

abstract class Model
{
	const TABLE = '';
	
	public function isNew() {
		
		return empty($this->id);
	}
	
	public function fill(array $data){
		$keys = array_keys($data);
		//var_dump($keys); die;
		foreach ($keys as $attribute) {
		if ($attribute == 'id') {
			continue;
		}
		$this->{$attribute} = $data[$attribute];
		//var_dump($attribute); die;
		}
		return $this;
	}
	
	public static function findAll() {
		$db = Db::instance();
		return $db->query('SELECT * FROM ' . static::TABLE, static::class);
	}
	public static function findById($id) {
		
		$db = DB::instance();
		$sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id = :id';
		return $db->query($sql, static::class, [':id' => $id])[0];
	
	}
	public function save() {
		if ($this->isNew()) {
			$this->insert();
		} else {
			$this->update();
		}
	}
	
	public function insert(){
		
		$db = DB::instance();
		$columns = [];
		$values = [];
		foreach ($this as $key=>$value) {
			if ($key == 'id') {
				continue;
			} 
			$columns[] = $key;
			$values[':' . $key] = $value;
		}
		$sql = 'INSERT INTO news('. implode(', ',$columns) .') VALUES ('. implode(', ', array_keys($values)) .')';
		$db->execute($sql, $values);
		$this->id = $db->lastInsertId();
		
	}
	
	public function update() {
		$db = DB::instance();
		$columns = [];
		$values = [];
		foreach ($this as $key=>$value) {
			$values[':' . $key] = $value;
			if ($key == 'id') {
				continue;
			}
			$columns[] = $key . '=:' . $key;
			
		}
		$sql = 'UPDATE ' . static::TABLE . ' SET ' . implode(', ',$columns) . ' WHERE id = :id';
		$db->execute($sql, $values);
	}
	public function delete() {
		if ($this->isNew()) {
            return false;
        }
		//var_dump($id); die;
        $sql = 'DELETE FROM ' . static::TABLE .
            ' WHERE id = ' . $this->id;
        $db = Db::instance();
        $db->execute($sql);
        return true;
	}
}

?>