<?php

	require_once('interface.php');
	
	// class Connection
	
	class Connection {
		
		private $conn; // variavel de conexao
		
		// método de obter a conexao ao banco de dados MySQL.
		public function getConnectionMysqli() {
			$this->conn = new mysqli("localhost", "root", "", "api_teste"); // instacia com parametro de conexao ao banco de dodos MySQL.
			return $this->conn;
		}

		// método de fechamento da conexao do banco de dados.
		public function close() {
			$this->conn->close();
		}

	}