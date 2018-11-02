<?php
	
	//$loader = require __DIR__ . '/vendor/autoload.php';
	
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	#Tiramos o require do autoload e incluimos o bootstrap.php
	require 'Slim/Slim.php';
	require 'persistencia.php';
	require 'user.php';

	\Slim\Slim::registerAutoloader();


	$app = new \Slim\Slim();