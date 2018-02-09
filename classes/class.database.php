<?php
/**
* 
*/

class Database {

	public $pdo;
	public $selectParams=array(),$from,$where,$limit,$by,$arg,$like;

	function __construct() {

	
		$dbD = 'mysql:dbname=alumni;host=localhost';
		$username = '';
		$password = '';

		try {
			$pdo = new PDO($dbD,$username,$password);
			$this->pdo = $pdo;

		} catch (PDOException $e) {
			var_dump($e);

			echo  $e->getMessage();
			
		}
	}

	public function select() {

		$this->selectParams = func_get_args();
		return $this;

	}

	public function from($table) {

		$this->from = $table;
		return $this;

	}

	public function where($arg) {

		$this->where = $arg;
		return $this;
	
	}
	
	public function limit($limit) {

		$this->limit = $limit;
		return $this;

	}

	public function sort($by,$arg) {

		$this->arg = $arg;
		$this->by=$by;
		return $this;

	}

	public function like($arg) {

		$this->like = $arg;
		return $this;

	}

	/*
	 * result() function executes the other functions above
	 * to be used as expressed below
	 * $object->select("id,name,email")->from("users")->where("firstname='Jessam'")->limit(1)->result();
	 * where() and limit() are optional
	 *
	*/
	public function result() {

		$query = "SELECT ".join(",",$this->selectParams)." FROM ".$this->from;
		if(!empty($this->where)) {
			$keys = join(array_keys($this->where),"");
			$query.=" WHERE {$keys} = :{$keys}";
		}
		if(!empty($this->limit))
			$query.=" LIMIT {$this->limit}";
		if(!empty($this->by))
			$query.=" ORDER BY {$this->by} $this->arg";
		if(!empty($this->like))
			$query.=" LIKE {$this->like}";
		$db = $this->pdo->prepare($query);
		if(!empty($this->where))
			$db->execute($this->where);
		else
			$db->execute();
		return $db;
		
	}

	/* insert() method saves to database. Receives an array and string as arguement. to be used as stated below.
	 * $object->insert(array("name" => "Jessam",
	 "lastname" => "Joyson",
	 "location" => "Nigeria"),"users")
	 * 
	*/
	public function insert($data,$table) {

		$fields = join(array_keys($data),", ");
		$pdoFields = ':'.join(array_keys($data),", :");
//		$values = "'".join(array_values($data),"','")."'";
//		$query = "INSERT INTO {$table} ({$fields}) values({$values})";
		$sql="INSERT INTO {$table}({$fields}) values({$pdoFields})";
		$query = $this->pdo->prepare($sql);
		$query->execute($data);

	}


	public function delete($column,$content,$table) {

		$query = "delete from {$table} where {$column} = ?";
		$this->pdo->prepare($query)->execute($content);

	}

	/* update() method saves to database. Receives an array and string/int as arguement. to be used as stated below.
	 * $object->update("4",array("name" => "Jessam",
	 "lastname" => "Joyson",
	 "location" => "Nigeria"))
	 * 
	*/
	public function update($id, $data) {

		$queryparts = array();
		foreach ($data as $key=>$value) {
			$queryparts[] = "{$key} = '{$value}'";
		}
		$query = "UPDATE users SET ".join($queryparts,",")." WHERE id='{$id}'";
		$this->pdo->query($query);

	}

	//this function filters user input to be inputed in the database
	public function isSqlSafe($st) {

		$nuST = trim(htmlentities(strip_tags($st)));
		if (get_magic_quotes_gpc())
			$nuST = stripslashes($nuST);
		$nuST = $this->mysqli->real_escape_string($nuST);
		return $nuST;

	}

}

?>
