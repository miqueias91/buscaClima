<?php
  	include_once("config/config.php");
	include_once "class/class.municipios.php";

	$mun = new Municipios();

	if (isset($uf) && !empty($uf)) {
		$resultadoMunicipios = $mun->buscaMunicipios($uf);
		if ($resultadoMunicipios) {
			foreach ($resultadoMunicipios as $key => $row) {
				$nome = str_replace("'", "%27", $row['Nome']);
				$nome = str_replace(" ", "%20", $nome);
				$option[] = ("<option  localidade=".$nome." value='".$row['Id']."'>$row[Nome]</option>");
			}	
			echo (implode("", $option));
		}
	}
	else{
		echo "ERROR";			
	}
