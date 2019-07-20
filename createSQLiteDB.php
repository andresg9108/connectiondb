<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'connection/constantConnection.php';
require_once __DIRMAIN__.'connection/connection.php';

use andresg9108\connectiondb\connection;

try {
	$sFile = getFileContents('SQLite.sql');

	$aConnection = [
		'motor' => 'sqlitepdo', 
		'sqlitepath' => 'E:/sql/db.sqlite'
	];
	$oAConnection = (object)$aConnection;

	$oConnection = connection::getInstance($oAConnection);
	$oConnection->connect();

	$oConnection->run($sFile);

	$oConnection->commit();
	$oConnection->close();

	echo "OK";
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();

	echo "Error: ".$e->getMessage();
}

function getFileContents($sFileName){
	$oFile = fopen($sFileName, "r");

	$sFile = '';
	while (!feof($oFile)){
	    $sLine = fgets($oFile);
	    $sFile .= $sLine;
	}

	fclose($oFile);

	return $sFile;
}