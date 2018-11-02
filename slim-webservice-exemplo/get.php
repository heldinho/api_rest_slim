<?php

	require_once 'bootstrap.php';

	$app->get('/users', 'getUsers');
	$app->get('/user/:id', 'getUser');
	$app->delete('/user/:id', 'delUser');
	$app->post('/users','setUser');
	$app->put('/users', 'upUser');

	$app->run();

	function getUsers() {
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$modelUser = new User(null);
		$persistencia = new Persistence();
		$resp = $persistencia->listAll($modelUser);
		echo "['GET/ALL']: \n" . "{ users: " . json_encode($resp) . " }";
	}

	function getUser($id) {
		$request = \Slim\Slim::getInstance()->request();
		$modelUser = new User($id);
		$persistencia = new Persistence();
		$resp = $persistencia->listByid($modelUser);
		if ($resp != false) {
			echo "['GET/{$id}']: \n" . "{ user: " . json_encode($resp) . " }";
		} else {
			echo "Not Found.";
		}
	}

	function delUser($id) {
		$request = \Slim\Slim::getInstance()->request();
		$modelUser = new User($id);
		$persistencia = new Persistence();
		$resp = $persistencia->delete($modelUser);
		if ($resp != false) {
			echo "['DELETE/{$id}']: \n" . "Delete success. #Id = " . $id;
		} else {
			echo "Not Found.";
		}
	}

	function setUser() {
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$modelUser = new User(null, $user->name, $user->email, $user->telefone, $user->address);
		$persistencia = new Persistence();
		$persistencia->insert($modelUser);
		echo "['POST']: \n" . json_encode($user);
	}

	function upUser() {
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$modelUser = new User($user->id, $user->name, $user->email, $user->telefone, $user->address);
		$persistencia = new Persistence();
		$resp = $persistencia->update($modelUser);
		echo "['PUT']: \n" . json_encode($user);
	}