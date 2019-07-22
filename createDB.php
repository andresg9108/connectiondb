<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'connection/constantConnection.php';
require_once __DIRMAIN__.'connection/connection.php';

use andresg9108\connectiondb\connection;

try {
	$sFile = getFileContents('SQL.sql');

	$aConnection = [
		'motor' => 'mysql', // mysql OR mysqlpdo OR sqlitepdo
		'server' => 'localhost', 
		'charset' => 'utf8', 
		'user' => 'root', 
		'password' => '', 
		'database' => 'example', 
		'sqlitepath' => 'E:/sql/db.sqlite'
	];
	$oAConnection = (object)$aConnection;

	$oConnection = connection::getInstance($oAConnection);
	$oConnection->connect();

	$oConnection->multiRun($sFile);

	$oConnection->commit();
	$oConnection->close();

	echo "OK";
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();

	echo "Error: ".$e->getMessage();
}

function getFileContents($sFilePath){
	$oFile = fopen($sFilePath, "r");

	$sFile = '';
	while (!feof($oFile)){
	    $sLine = fgets($oFile);
	    $sFile .= $sLine;
	}

	fclose($oFile);

	return $sFile;
}