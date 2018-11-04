<?php
	
	// class User model
	
	class User {

		public $CLASS_NAME = "users"; // nome da tabela a ser passada
		
		// atributos
		public $id;
	    public $name;
	    public $email;
	    public $telefone;
	    public $address;

		// método construtor
	    public function __construct($id = null, $name = "", $email = "", $telefone = 0, $address = "") {
	    	$this->setId($id);
	        $this->setName($name);
	        $this->setEmail($email);
	        $this->setTelefone($telefone);
	        $this->setAddress($address);
	    }

	    public function setId($id) {
	    	$this->id = $id;
	    }

	    public function setName($name) {
	        $this->name = mb_strtoupper($name);
	    }

	    public function setEmail($email) {
	        $this->email = $email;
	    }

	    public function setTelefone($telefone) {
	    	$this->telefone = $telefone;
	    }

	    public function setAddress($address) {
	    	$this->address = mb_strtoupper($address);
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getName() {
	        return $this->name;
	    }

	    public function getEmail() {
	        return $this->email;
	    }

	    public function getTelefone() {
	    	return $this->telefone;
	    }

	    public function getAddress() {
	    	return $this->address;
	    }
	    
	}