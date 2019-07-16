<?php

require_once __DIRMAIN__.'vendor/autoload.php';
spl_autoload_register(function($sClase){
	$sRuta = __DIRMAIN__.str_replace('\\', '/', $sClase).'.php';
	if(is_readable($sRuta)){
		require_once $sRuta;
	}
});

?>