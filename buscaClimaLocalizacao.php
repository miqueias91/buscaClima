<?php
	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
	function CURL($url){
		$ch   	= 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = utf8_decode(curl_exec($ch));
		return $result;
	}

	$token = 'db0b630c9cfd789d97c89c45e8e52068';
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	print_r($_POST);

	//Previsão 72 horas por latitude e longitude.
	$url = "http://apiadvisor.climatempo.com.br/api/v1/forecast/geo/hours/72?latitude=$latitude&longitude=$longitude&token=$token";

	echo "$url";
	$result1 = CURL($url);
	$resultado = $result1;

	echo $resultado;