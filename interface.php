<?php

	interface Connector {
		public function connect();
		public function disconnect();
		public function getConnection();
		public function isConnected();
	}