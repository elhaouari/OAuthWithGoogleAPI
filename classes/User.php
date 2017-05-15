<?php

class User extends DB{

	public function createTableGoogle(){
		$sql = "CREATE TABLE IF NOT EXISTS google_user(id INT NOT NULL primary KEY auto_increment, sub varchar(255) not null unique, email varchar(255));";
		$this->query($sql);

		return $this;
	}

	public function createTableFb(){
		$sql = "CREATE TABLE IF NOT EXISTS fb_user(id INT NOT NULL primary KEY auto_increment, token text, email varchar(255));";
		$this->query($sql);

		return $this;
	}

	public function store($params){
		$sql = "INSERT INTO `google_user` (`sub`, `email`) 
		VALUES({$params['sub']}, '{$params['email']}') ";

		print_r($this->query($sql));
	}

	public function sotreFb($params) {
		$sql = "INSERT INTO `fb_user` (`token`, `email`) 
		VALUES('{$params['token']}', '{$params['email']}') ";

		print_r($this->query($sql));
	}
}

