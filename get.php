<?php

	require_once 'bootstrap.php';
	
	// acesso as resquisiçõe s GET, POST, PUT e DELETE
	// com parametro de rota e função callback a ser executada.
	$app->get('/users', 'getUsers');
	$app->get('/user/:id', 'getUser');
	$app->delete('/user/:id', 'delUser');
	$app->post('/users','setUser');
	$app->put('/users', 'upUser');

	// rum onde roda as requisições.
	$app->run();

	// método que lista todos os users.
	function getUsers() {
		$request = \Slim\Slim::getInstance()->request(); // instancia do métodos request do Slim.
		$modelUser = new User(null); // intancia da da class User (model) com parametro null.
		$persistencia = new Persistence(); // instancia da class Persistence.
		$resp = $persistencia->listAll($modelUser); // método da class Persistence.
		echo "['GET/ALL']: \n" . "{ users: " . json_encode($resp) . " }"; // retorno via json do método (listAll).
	}

	// método que lista user por ${id}
	function getUser($id) {
		$request = \Slim\Slim::getInstance()->request(); // instancia do métodos request do Slim.
		$modelUser = new User($id); // intancia da da class User (model) com parametro ${id}.
		$persistencia = new Persistence(); // instancia da class Persistence.
		$resp = $persistencia->listByid($modelUser); // retorno do método (listByid).
		if ($resp != false) {
			// se ${resp} for true retorna via json todos os dados do user especifico.
			echo "['GET/{$id}']: \n" . "{ user: " . json_encode($resp) . " }";
		} else {
			// se ${resp} for false retorna nada encontrado.
			echo "Nada encontrado.";
		}
	}

	// método que deleta o user por ${id}
	function delUser($id) {
		$request = \Slim\Slim::getInstance()->request(); // instancia do métodos request do Slim.
		$modelUser = new User($id); // intancia da da class User (model) com parametro ${id}.
		$persistencia = new Persistence(); // instancia da class Persistence.
		$resp = $persistencia->delete($modelUser); // retorno do método (delete).
		if ($resp != false) {
			// se ${resp} for true retorna a mensagem.
			echo "['DELETE/{$id}']: \n" . "Delete success. #Id = " . $id;
		} else {
			// se ${resp} for false retorna nada encontrado.
			echo "Nada encontrado.";
		}
	}

	// método que gravar o user
	function setUser() {
		$request = \Slim\Slim::getInstance()->request(); // instancia do métodos request do Slim.
		$user = json_decode($request->getBody()); // parametros passados via json para ser capturado do método getBody do request do Slim.
		$modelUser = new User(null, $user->name, $user->email, $user->telefone, $user->address); // parametro do user com o ${id} null pois o banco de dados gera automaticamente a ser gravados.
		$persistencia = new Persistence(); // instancia da class Persistence.
		$persistencia->insert($modelUser); // retorno do método (insert).
		// retorna via json o que foi gravado.
		echo "['POST']: \n" . json_encode($user);
	}

	function upUser() {
		$request = \Slim\Slim::getInstance()->request(); // instancia do métodos request do Slim.
		$user = json_decode($request->getBody()); // parametros passados via json para ser capturado do método getBody do request do Slim.
		$modelUser = new User($user->id, $user->name, $user->email, $user->telefone, $user->address); // parametro do user com o ${id} especifico a ser mudado, se os outros valores forem null não seram alterados no banco de dados.
		$persistencia = new Persistence(); // instancia da class Persistence.
		$resp = $persistencia->update($modelUser); // retorno do método (update).
		// retorna via json o que foi alterado.
		echo "['PUT']: \n" . json_encode($user);
	}