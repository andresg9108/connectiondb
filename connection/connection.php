<?php

namespace andresg9108\connectiondb;

use \Exception;
use \mysqli;
use \PDO;
use andresg9108\connectiondb\constantConnection;

class connection{

	// Attributes
	private static $instance;
	private $oConnection;
	private $sMotor;
	private $sServer;
	private $sCharset;
	private $sUser;
	private $sPassword;
	private $sDatabase;
	private $query;

	// Properties
	public function getQuery(){ return $this->query; }

	// Construct
	function __construct($oConnection)
	{
		$this->sMotor = (isset($oConnection->motor)) ? $oConnection->motor : '';
		$this->sServer = (isset($oConnection->server)) ? $oConnection->server : '';
		$this->sCharset = (isset($oConnection->charset)) ? $oConnection->charset : '';
		$this->sUser = (isset($oConnection->user)) ? $oConnection->user : '';
		$this->sPassword = (isset($oConnection->password)) ? $oConnection->password : '';
		$this->sDatabase = (isset($oConnection->database)) ? $oConnection->database : '';
		$this->query = [];
	}

	  /*
	  */
	  public static function getInstance($oConnection){
	    if(static::$instance === null){
	        static::$instance = new static($oConnection);
	    }
	    return static::$instance;
	  }
	
	  /*
	  */
	  public function connect(){
	    if($this->sMotor == "mysql"){
	    	$this->connectMySQL();
	    }else if($this->sMotor == "mysqlpdo"){
	    	$this->connectMySQLPDO();
	    }else if($this->sMotor == "sqlitepdo"){
	    	$this->connectSQLitePDO();
	    }
	  }

	  /*
	  */
	  public function run($sQuery){
	    if($this->sMotor == "mysql"){
	    	$this->runMySQL($sQuery);
	    }else{
	    	$this->runPDO($sQuery);
	    }
	  }

	  /*
	  */
	  public function queryArray($sQuery, $aParameters = []){
	  	$this->query = [];
	  	
	    if($this->sMotor == "mysql"){
	    	$this->queryArrayMySQL($sQuery, $aParameters);
	    }else{
	    	$this->queryArrayPDO($sQuery);
	    }
	    	
	  }

	  /*
	  */
	  public function queryRow($sQuery, $aParameters = []){
	  	$this->query = [];
	  	
	    if($this->sMotor == "mysql"){
	    	$this->queryRowMySQL($sQuery, $aParameters);
	    }else{
	    	$this->queryRowPDO($sQuery);
	    }
	  }

	  /*
	  */
	  public function commit(){
	      if($this->sMotor == "mysql"){
	      	$this->commitMySQL();
	      }else{
	      	$this->commitPDO();
	      }
	  }

	  /*
	  */
	  public function rollback(){
	      if($this->sMotor == "mysql"){
	      	$this->rollbackMySQL();
	      }else{
	      	$this->rollbackPDO();
	      }
	  }

	  /*
	  */
	  public function close(){
	      if($this->sMotor == "mysql"){
	      	$this->closeMySQL();
	      }else{
	      	$this->closePDO();
	      }
	  }
	  
	  /*
	  */
	  public function getIDInsert(){
	  	if($this->sMotor == "mysql"){
	  		return $this->getIDInsertMySQL();
	  	}else{
	  		return $this->getIDInsertPDO();
	  	}

	  	return null;
	  }

	/*MySQL*/

	/*
	*/
	private function connectMySQL(){
		$this->oConnection = @new mysqli($this->sServer, $this->sUser, $this->sPassword, $this->sDatabase);
	    if($this->oConnection->connect_error){
	    	$sMessageErr = constantConnection::FAIL_CONNECTION_FAILURE_DB;
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
	    }

	    $this->oConnection->set_charset($this->sCharset);
	    $this->oConnection->autocommit(FALSE);
	}

	/*
	*/
	private function runMySQL($sQuery){
		if($this->oConnection->connect_error){
			$sMessageErr = constantConnection::FAIL_CONNECTION_FAILURE_DB;
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    if(!@$this->oConnection->query($sQuery)){
	    	$sMessageErr = constantConnection::ERROR_IN_THE_QUERY;
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }
	}

	/*
	*/
	private function queryRowMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error){
			$sMessageErr = constantConnection::FAIL_CONNECTION_FAILURE_DB;
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery){
	    	$sMessageErr = constantConnection::ERROR_IN_THE_QUERY;
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }

	    $aRow = $oQuery->fetch_row();
      	$oResponse = [];
      	if(is_array($aRow)){
      		foreach ($aRow as $i => $v) {
      			$sPosition = (!empty($aParameters[$i])) ? $aParameters[$i] : '';
      			if(!empty($sPosition)){
      				$oResponse[$sPosition] = $v;
      			}
	      	}
      	}

	    $this->query = (object)$oResponse;
	}

	/*
	*/
	private function queryArrayMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error){
			$sMessageErr = constantConnection::FAIL_CONNECTION_FAILURE_DB;
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery){
	    	$sMessageErr = constantConnection::ERROR_IN_THE_QUERY;
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }

	    $aResponse = [];
	    for($i=0;$i<$oQuery->num_rows;$i++){
	      $aRow = $oQuery->fetch_row();
	      $aRow2 = [];
	      if(is_array($aRow)){
	      	foreach ($aRow as $i1 => $v2) {
	      		$sPosition = (!empty($aParameters[$i1])) ? $aParameters[$i1] : '';
	      		if(!empty($sPosition)){
	      			$aRow2[$sPosition] = $v2;
	      		}
	      	}
	      }
	      $aResponse[] = (object)$aRow2;
	    }

	    $this->query = $aResponse;
	}

	/*
	*/
	private function commitMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->commit();
	}

	/*
	*/
	private function rollbackMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->rollback();
	}

	/*
	*/
	private function closeMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->close();
	}

  	/*
	*/
	private function getIDInsertMySQL(){
		if(!$this->oConnection->connect_error)
			return @$this->oConnection->insert_id;
	}

	/*MySQL PDO*/
	/*
	*/
	private function connectMySQLPDO(){
		$sConnection = 'mysql:host='.$this->sServer.';dbname='.$this->sDatabase.';charset='.$this->sCharset;
	    
	    $this->connectPDO($sConnection);
	}

	/*SQLite PDO*/
	/*
	*/
	private function connectSQLitePDO(){
		$sConnection = 'sqlite:db.sqlite';
	    
	    $this->connectPDO($sConnection);
	}

	/*PDO*/
	/*
	*/
	private function connectPDO($sConnection){
		$this->oConnection = new PDO($sConnection, $this->sUser, $this->sPassword);

		$this->oConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->oConnection->beginTransaction();
	}

	/*
	*/
	private function runPDO($sQuery){
		$this->oConnection->exec($sQuery);
	}
	
	/*
	*/
	private function queryArrayPDO($sQuery){
		$oQuery = $this->oConnection->query($sQuery);

		$aResponse = [];
		foreach ($oQuery as $aRow) {
			$oRow = (object)$aRow;
			$aResponse[] = $oRow;
		}

		$this->query = $aResponse;
		$oQuery = null;
	}

	/*
	*/
	private function queryRowPDO($sQuery){
		$oQuery = $this->oConnection->query($sQuery);
		$this->query = (object)$oQuery->fetch();
		$oQuery = null;
	}

	/*
	*/
	private function commitPDO(){
		if(!empty($this->oConnection)){
			$this->oConnection->commit();
		}
	}

	private function rollbackPDO(){
		if(!empty($this->oConnection)){
			$this->oConnection->rollback();
		}
	}

	/*
	*/
	private function closePDO(){
		$this->oConnection = null;
		$this->query = null;
	}

	/*
	*/
	private function getIDInsertPDO(){
		return $this->oConnection->lastInsertId();
	}

}
