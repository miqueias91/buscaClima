<?php
	$uf = $_POST['uf'];

	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
	function CURL($url){
		$ch   	= 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}

	//BUSCA OS ESTADOS DO BRASIL
	$url0 = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";



	$result0 = CURL($url0);
	$resultadoMunicipios = json_decode($result0);

	if ($resultadoMunicipios) {
		foreach ($resultadoMunicipios as $key => $row) {
			$nome = str_replace("'", "%27", $row->nome);
			$nome = str_replace(" ", "%20", $nome);
			$option[] = ("<option  localidade=".$nome." value='".$row->id."'>$row->nome</option>");
		}	
		echo (implode("", $option));
	}