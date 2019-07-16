<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use connection\connection;

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