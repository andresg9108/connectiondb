<?php

namespace connection;

class constantConnection extends constant{

    const FAIL_CONNECTION_FAILURE_DB = "Failure to connect to the database.";
    const ERROR_IN_THE_QUERY = "Error in the query.";

    /*
	*/
	public static function getConstant($sNameConstant, $aParameters = []){
		$sConstant = '';
		$oConnection = Useful::getConnectionArray();
		$sConstantPrefix = (!empty($oConnection->constant_prefix)) ? $oConnection->constant_prefix : '';

		$sNameConstantPfx = $sConstantPrefix.$sNameConstant;
		if(defined("static::$sNameConstantPfx")){
			$sConstant = constant("static::$sNameConstantPfx");
		}else{
			if(defined("static::$sNameConstant")){
				$sConstant = constant("static::$sNameConstant");
			}
		}

		foreach ($aParameters as $i => $v) {
			$sConstant = str_replace("<".($i+1)."?>", $v, $sConstant);
	    }

	    $sConstant = str_replace("'", '"', $sConstant);
	    return $sConstant;
	}
}
