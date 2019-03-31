<?php

  	include_once("config/config.php");
	include_once "class/class.notificacoes.php";

	$not = new Notificacoes();
	if(isset($token)){
	    print_r($_POST);
	  	$not->atualizaNotificacao($token, $municipio, $estado);  
	}
