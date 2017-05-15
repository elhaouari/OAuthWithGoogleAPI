<?php 

class DB{
	protected $mysqli;

	public function __construct(){
		$this->mysqli = new MySQLi('localhost', 'root', 'root', 'website');
		
		if ($this->mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
	}

	public function query($sql) {
		$res = $this->mysqli->query($sql);
		if (!$res) 
   			printf("ErrorDB: %s\n", $this->mysqli->error);
	}
	
}
?>