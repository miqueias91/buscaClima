<?php
	echo "<pre>";

	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
	function CURL($url){
		$ch   	= 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = utf8_decode(curl_exec($ch));
		return $result;
	}

	$name = $_POST['municipio'];
	$state = $_POST['estado'];


	$token = 'db0b630c9cfd789d97c89c45e8e52068';

	//BUSCA ID DA LOCALIDADE
	$url0 = "http://apiadvisor.climatempo.com.br/api/v1/locale/city?name=$name&state=$state&token=$token";
	$result0 = CURL($url0);
	$resultado0 = json_decode($result0);
	$resultado0 = $resultado0[0];
	
	$localidade = $resultado0->id;
	$municipio = $resultado0->name;
	$estado = $resultado0->state;
	$pais = $resultado0->country;

	//Previsão 15 dias por ID da cidade.
	/*$url1 = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/$localidade/days/15?token=$token";

	//Previsão 72 horas por ID da cidade.
	$url2 = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/$localidade/hours/72?token=$token";*/

	//Tempo no momento por ID da cidade.
	$url3 = "http://apiadvisor.climatempo.com.br/api/v1/weather/locale/$localidade/current?token=$token";


	$result1 = CURL($url3);
	$resultado = json_decode($result1);

	echo "<pre>";
	print_r($resultado);