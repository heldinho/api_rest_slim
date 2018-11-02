<?php

	require_once 'bootstrap.php';

	$app->get('/users', 'getUsers');
	$app->get('/user/:id', 'getUser');
	$app->delete('/user/:id', 'delUser');
	$app->post('/users','setUser');
	$app->put('/users', 'upUser');

	$user = new User('', 'Helder', 'helder@email.com', '11970707070', 'Rua Antigo Continente, 35');

	foreach ($user as $key => $value) {
		if ($value != '' || $value != null) {
			echo $key . " => " . $value . "\n";
		}
	}

	echo "\n";

	$app->run();

	function getConn() {
		return new PDO('mysql:host=localhost;dbname=api_teste', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	function getUsers() {
		$pdo = getConn();
		$stmt = $pdo->query("SELECT * FROM users");
		$user = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "['GET/ALL']: \n" . "{ users: " . json_encode($user) . " }";
	}

	function getUser($id) {
		$pdo = getConn();
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$sql = "SELECT * FROM users WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		if ($user) {
			echo "['GET/{$id}']: \n" . "{ user: " . json_encode($user) . " }";
		} else {
			echo "Not Found.";
		}
	}

	function delUser($id) {
		$pdo = getConn();
		$request = \Slim\Slim::getInstance()->request();
		//$user = json_decode($request->getBody());
		$sql = "DELETE FROM users WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		echo "['DELETE/{$id}']: \n" . "Delete success. #Id = " . $id;
	}

	function setUser() {
		$pdo = getConn();
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$sql = "INSERT INTO users (name, email, telefone, address) values (:name, :email, :telefone, :address) ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam("name", $user->name);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("telefone", $user->telefone);
		$stmt->bindParam("address", $user->address);
		$stmt->execute();
		//$user->id = $pdo->lastInsertId();
		echo "['POST']: \n" . json_encode($user);
	}

	function upUser() {
		$pdo = getConn();
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$sql = "UPDATE users SET name = :name, email = :email, telefone = :telefone, address = :address WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam("id", $user->id);
		$stmt->bindParam("name", $user->name);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("telefone", $user->telefone);
		$stmt->bindParam("address", $user->address);
		$stmt->execute();
		echo "['PUT']: \n" . json_encode($user);
	}