<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'connection/constantConnection.php';
require_once __DIRMAIN__.'connection/connection.php';

use andresg9108\connectiondb\connection;

// MySQL with MySQLi
/*try {
	$aConnection = [
		'motor' => 'mysql',
		'server' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => 'my_database'
	];

	$oAConnection = (object)$aConnection;

	$oConnection = connection::getInstance($oAConnection);
	$oConnection->connect();

	$oConnection->queryArray("SELECT * FROM user;", ['field1', 'field2', 'field3', 'field4']);
	$aResponse = $oConnection->getQuery();

	echo json_encode($aResponse);
} catch (Exception $e) {
	echo "Error: ".$e->getMessage();
}*/

// MySQL with PDO
try {
	$aConnection = [
		'motor' => 'mysqlpdo',
		'server' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => 'my_database'
	];
	$oConnection = (object)$aConnection;
	
	$oPDO = new PDO('mysql:host='.$oConnection->server.';dbname='.$oConnection->database, $oConnection->user, $oConnection->password);
	$oPDO = null;
} catch (Exception $e) {
	echo "Error: ".$e->getMessage();
} catch (PDOException $e) {
	echo "Error: ".$e->getMessage();
}