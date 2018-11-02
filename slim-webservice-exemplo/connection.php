<?php

	require_once('interface.php');

	class Connection {

		private $conn;

		public function getConnectionMysqli() {
			$this->conn = new mysqli("localhost", "root", "", "api_teste");
			return $this->conn;
		}

		public function close() {
			$this->conn->close();
		}

	}