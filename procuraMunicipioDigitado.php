<?php
	include_once("config/config.php");
	include_once "class/class.municipios.php";
	$mun = new Municipios();	
	$resultadoMunicipios = $mun->buscaMunicipios(null, $termo);

	if ($resultadoMunicipios) {
		foreach ($resultadoMunicipios as $key => $row) {
			$nome = str_replace("'", "%27", $row['Nome']);
			$nome = str_replace(" ", "%20", $nome);
			$option[] = ("$row[Nome] - $row[Uf],");
		}	
		echo (implode("", $option));
	}