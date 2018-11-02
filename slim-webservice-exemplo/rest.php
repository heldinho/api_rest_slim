<?php

	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	$app->get('/users/:dados', function($dados) {
		echo "Hello $dados";
	});

	$app->post('/users', function() use ($app) {
		//$nome = $app->request()->getBody();
		$nome = $app->response()->header('Content-Type', 'application/json;charset=utf-8');
		echo "Hello $nome";
	});

	$app->put('/users', function() use ($app) {
		//$nome = $app->request()->getBody();
		$nome = $app->response()->header('Content-Type', 'application/json;charset=utf-8');
		echo "Tudo bem $nome?";
	});

	$app->delete('/users', function() use ($app) {
		//$nome = $app->request()->getBody();
		$nome = $app->response()->header('Content-Type', 'application/json;charset=utf-8');
		echo "Tchau $nome";
	});

	$app->run();

?>
