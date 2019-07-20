<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'connection/constantConnection.php';
require_once __DIRMAIN__.'connection/connection.php';

use andresg9108\connectiondb\connection;

try {
	$aConnection = [
		'motor' => 'mysql', 
		'server' => 'localhost', 
		'charset' => 'utf8', 
		'user' => 'root', 
		'password' => '', 
		'database' => 'example' 
	];
	$oAConnection = (object)$aConnection;

	$oConnection = connection::getInstance($oAConnection);
	$oConnection->connect();

	//Test run
	$oConnection->run("INSERT INTO `example`(`name`, `last`, `phone`) VALUES ('Daniel', 'Velez', '456');");
	$oResponse = $oConnection->getIDInsert();
	echo "Test run:<br />";
	echo "ID: ".json_encode($oConnection->getIDInsert());
	echo "<br /><br />";

	$oConnection->run("INSERT INTO `example2`(`id2`, `name`, `last`, `phone`) VALUES (1, 'Daniel', 'Velez', '456');");
	$oResponse = $oConnection->getIDInsert();
	echo "Test run:<br />";
	echo "ID: ".json_encode($oConnection->getIDInsert());
	echo "<br /><br />";

	// Test queryArray
	$oConnection->queryArray("SELECT * FROM example;", ['id', 'name', 'last', 'phone']);
	$aResponse = $oConnection->getQuery();

	echo "Test queryArray:<br />";
	foreach ($aResponse as $i => $v) {
		echo $v->id.' - ';
		echo $v->name.' - ';
		echo $v->last.' - ';
		echo $v->phone.' - ';
		echo "<br />";
	}
	echo "<br /><br />";

	// Test queryRow
	$oConnection->queryRow("SELECT * FROM example;", ['id', 'name', 'last', 'phone']);
	$oResponse = $oConnection->getQuery();
	echo "ID: ".$oResponse->id."<br />";
	echo "Name: ".$oResponse->name."<br />";
	echo "Last Name: ".$oResponse->last."<br />";
	echo "Phone: ".$oResponse->phone."<br />";
	echo "<br /><br />";

	$oConnection->commit();
	$oConnection->close();
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();

	echo "Error: ".$e->getMessage();
}