<?php
  	include_once("config/config.php");

	$resultado = "ERROR";
	if ((isset($_GET['municipio']) && isset($_GET['estado'])) && ($_GET['municipio'] != 'undefined' && $_GET['estado'] != 'undefined')) {
		include_once 'class/class.estadosBrasileiros.php';

		//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
		function CURL($url){
			$ch   	= 	curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = utf8_decode(curl_exec($ch));
			return $result;
		}

		$name = $_GET['municipio'];
		$state = $_GET['estado'];
		$name = str_replace('_', '%20', $name);
		$name = str_replace(' ', '%20', $name);

		if (strlen($state) > 2) {
			$br = new estadosBrasileiros();
			$retorno_estado = $br->buscaEstadosBrasileiros($state);
			$state = $retorno_estado ? $retorno_estado : null;
		}

		//BUSCA ID DA LOCALIDADE
		$url0 = "http://apiadvisor.climatempo.com.br/api/v1/locale/city?name=$name&state=$state&token=$tokenClimaTempo";
		$result0 = CURL($url0);
		$resultado0 = json_decode($result0);
		$resultado0 = $resultado0[0];

		$localidade = $resultado0->id;
		$municipio = $resultado0->name;
		$estado = $resultado0->state;
		$pais = $resultado0->country;

		//Tempo no momento por ID da cidade.
		$url3 = "http://apiadvisor.climatempo.com.br/api/v1/weather/locale/$localidade/current?token=$tokenClimaTempo";


		$result1 = CURL($url3);
		$resultado = $result1;
	}
	echo $resultado;

