<?php
	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
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

	$token = 'db0b630c9cfd789d97c89c45e8e52068';
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$url0 = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$latitude&lon=$longitude";

	//Previsão 72 horas por latitude e longitude.
	//$url = "http://apiadvisor.climatempo.com.br/api/v1/forecast/geo/hours/72?latitude=$latitude&longitude=$longitude&token=$token";

	$result0 = ConnURLPost($url0);
	$resultado = json_decode($result0);

	print_r($_POST);
	print_r($result0);
	echo $resultado;
	echo "$url0";