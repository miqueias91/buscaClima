<?php
	$uf = $_POST['uf'];

	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
	function ConnURLPost($url,$options = '0',$timeout = 20){

		//Montando as opções do CURL
		$contentLength = "Content-length: ".strlen($options);
		$methodOptions = Array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $options,
		);
	
		$options = Array(
			CURLOPT_HTTPHEADER => Array(
					"Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
					$contentLength
			),
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CONNECTTIMEOUT => $timeout,
			CURLOPT_TIMEOUT => $timeout
		);
		$options = ($options + $methodOptions);
	
		//INICIA CONEXAO
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$resp  = curl_exec($curl);
		$info  = curl_getinfo($curl);
		$error = curl_errno($curl);
		$errorMessage = curl_error($curl);
		if($error){
			return false ;
		}
		//FECHA CONEXAO
		curl_close($curl);
	
		return $resp;
	}

	//BUSCA OS ESTADOS DO BRASIL
	$url0 = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";



	$result0 = ConnURLPost($url0);
	$resultadoMunicipios = json_decode($result0);

	if ($resultadoMunicipios) {
		foreach ($resultadoMunicipios as $key => $row) {
			$nome = str_replace("'", "%27", $row->nome);
			$nome = str_replace(" ", "%20", $nome);
			$option[] = ("<option  localidade=".$nome." value='".$row->id."'>$row->nome</option>");
		}	
		echo (implode("", $option));
	}