<?php
	
	require_once('connection.php');
	
	// class Persistence
	class Persistence {

		// método insert como parametro do tipo objeto.
		public function insert($object) {

			// verifica se o objeto exite.
			if ($this->isValidObject($object)) {
				
				// cria a estrutura do sql insert.
				// CLASS_NAME é o nome da tabela passada no atributo da class User.
				$sql = "INSERT INTO " . $object->CLASS_NAME . " (";

	    		foreach ($object as $key => $value) {
	    			if ($key != "CLASS_NAME") {
	    				if ($value != '' || $value != null) {
	    					$sql .= $key . ", ";
	    				}
	    			}
	    		}

	    		$sql = substr($sql, 0, strlen(trim($sql)) -1) . ") VALUES (";

	    		foreach ($object as $key => $value) {
	    			if ($key != "CLASS_NAME") {
	    				if ($value != '' || $value != null) {
	    					$sql .= "'" . $value . "', ";
	    				}
	    			}
	    		}

	    		$sql = substr($sql, 0, strlen(trim($sql)) -1) . ")";

    			$conn = new Connection();
	    		$mysqli = $conn->getConnectionMysqli();
	    		if ($mysqli->query($sql)) {
	    			$conn->close();
	    			return "Sucesso ao salvar.\n\n" . $sql;
	    		} else {
	    			$conn->close();
	    			return "Erro ao salvar.\n\n" . $sql;
	    		}

	    	} else {
	    		return "Objeto inválido.\n" . $sql;
	    	}

	    }

		// método update como parametro do tipo objeto.
	    public function update($object) {

			// verifica se o objeto exite.
	    	if ($this->isValidObject($object)) {
				
				// cria a estrutura do sql insert.
				// CLASS_NAME é o nome da tabela passada no atributo da class User.
	    		$sql = "UPDATE " . $object->CLASS_NAME . " SET ";

	    		foreach ($object as $key => $value) {
	    			if ($key != "CLASS_NAME") {
	    				if ($value != '' || $value != null) {
	    					if ($key != "id") {
	    						$sql .= $key . " = '" . $value .  "', ";
	    					} else {
	    						$end_sql = $key . " = " . $value;
	    					}
	    				}
	    			}
	    		}

	    		$sql = substr($sql, 0, strlen(trim($sql)) -1) . " WHERE " . $end_sql;

    			$conn = new Connection();
	    		$mysqli = $conn->getConnectionMysqli();
	    		if ($mysqli->query($sql) === true) {
	    			$r = true;
	    		} else {
	    			$r = false;
	    		}
	    		$conn->close();
	    		return $r;
	    	} else {
	    		return "Objeto inválido.\n" . $sql;
	    	}

	    }

		// método delete como parametro do tipo objeto.
	    public function delete($object) {

			// verifica se o objeto exite.
	    	if ($this->isValidObject($object)) {
	    		$conn = new Connection();
				
				// cria a estrutura do sql insert.
				// CLASS_NAME é o nome da tabela passada no atributo da class User.
				$sql = "DELETE FROM " . $object->CLASS_NAME . " WHERE id = " . $object->id;
				
				// obtem a conexao com o banco de dados.
	    		$mysqli = $conn->getConnectionMysqli();
	    		if ($result = $mysqli->query($sql) === true) {
	    			$r = true;
	    		} else {
	    			$r = false;
	    		}
	    	} else {
	    		$r = "Objeto inválido.\n" . $sql;
	    	}
	    	$conn->close();
	    	return $r;

	    }

		// método listByid como parametro do tipo objeto.
	    public function listByid($object) {
	
			// verifica se o objeto exite.
	    	if ($this->isValidObject($object)) {
	    		$conn = new Connection();
				
				// cria a estrutura do sql insert.
				// CLASS_NAME é o nome da tabela passada no atributo da class User.
				$sql = "SELECT * FROM " . $object->CLASS_NAME . " WHERE id = " . $object->id;
				
				// obtem a conexao com o banco de dados.
	    		$mysqli = $conn->getConnectionMysqli();
	    		if ($result = $mysqli->query($sql)) {
	    			if (mysqli_num_rows($result) > 0) {
		    			while ($row = $result->fetch_object()) {
		    				$retorno[] = $row;
		    			}
		    			$r = $retorno;
		    		} else {
		    			$r = false;
		    		}
	    		} else {
	    			$r = "Erro ao seleciona.\n\n" . $sql;
	    		}
	    	} else {
	    		$r = "Objeto inválido.\n" . $sql;
	    	}
	    	$conn->close();
	    	return $r;

	    }

		// método listAll como parametro do tipo objeto.
	    public function listAll($object) {

			// verifica se o objeto exite.
	    	if ($this->isValidObject($object)) {
	    		$conn = new Connection();
				
				// cria a estrutura do sql listAll.
				// CLASS_NAME é o nome da tabela passada no atributo da class User.
				$sql = "SELECT * FROM " . $object->CLASS_NAME;
				
				// obtem a conexao com o banco de dados.
	    		$mysqli = $conn->getConnectionMysqli();
	    		if ($result = $mysqli->query($sql)) {
	    			while ($row = $result->fetch_object()) {
	    				$retorno[] = $row;
	    			}
	    			$r = $retorno;
	    		} else {
	    			$r = "Erro ao seleciona.\n\n" . $sql;
	    		}
	    	} else {
	    		$r = "Objeto inválido.\n" . $sql;
	    	}
	    	$conn->close();
	    	return $r;
	    }

		// método para verifica se exite objeto.
	    private function isValidObject($object) {
	    	return (isset($object->CLASS_NAME) && $object->CLASS_NAME != "");
	    }
	}