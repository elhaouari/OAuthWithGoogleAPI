<?php

class User extends DB{

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS google_user(id INT NOT NULL primary KEY auto_increment, sub varchar(255) not null unique, email varchar(255));";
		$this->query($sql);
	}

	public function store($params){
		$sql = "INSERT INTO `google_user` (`sub`, `email`) 
		VALUES({$params['sub']}, '{$params['email']}') ";

		print_r($this->query($sql));
	}

}

