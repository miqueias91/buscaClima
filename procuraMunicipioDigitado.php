<?php
	// Atribui o conteúdo do arquivo para variável $arquivo
	$arquivo = file_get_contents('js/cidades/estados-cidades.json');

	// Decodifica o formato JSON e retorna um Objeto
	$json = json_decode($arquivo);

	// Loop para percorrer o Objeto
	$string_cidades = '';
	foreach($json->estados as $key_sigla => $cadaEstado){
		foreach ($cadaEstado->cidades as $key_municipio => $cadaMunicipio) {
			$string_cidades .= $cadaMunicipio." - ".$cadaEstado->sigla.',';
		}
	}
	$size = strlen($string_cidades);
	$string_cidades = substr($string_cidades,0, $size-2);
	echo "$string_cidades";