<?php
  	include_once("config/config.php");
	include_once "class/class.municipios.php";
	header('Access-Control-Allow-Origin: *');  
	header("Content-type: text/json");
	$mun = new Municipios();

	if (isset($uf) && !empty($uf)) {
		$resultadoMunicipios = $mun->buscaMunicipios($uf);
		echo $resultadoMunicipios;die;
	}
	else{
		echo "ERROR";			
	}
