<?php
	//FUNCAO CURL PARA CONEXA REMOTA, USADA PARA CONECTAR AO WEBSERVICE
	function CURL($url){
		$ch   	= 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		return $result;
	}

	//BUSCA OS ESTADOS DO BRASIL
	$url0 = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";
	$result0 = CURL($url0);
	$resultadoEstados = json_decode($result0);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Websie para buscar informações do clima de uma determinada localidade.">
    <meta name="author" content="Miqueias Matias Caetano">
    <meta name="keywords" content="Clima, tempo, meterologia, localidade, chuva, sol, vento, nublado">
    <meta content="pt-br, pt, en" http-equiv="Content-Language">
    <meta name="revised" content="2018-03-25">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fontawesome-free-5.6.3-web/css/all.css">

    <!-- Optional Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">


    <title>Buscaclima - Veja como está o tempo hoje</title>
  </head>
  <body>
  	<form action='./' method='post' name='form' id='form' enctype='multipart/form-data'>

		<div title="Buscar localidade" id='myModal' class="modal" tabindex="-1" role="dialog">
			<p><i class="fas fa-thumbtack"></i>&nbsp;Você deseja ver o clima em qual lugar?</p>
			<div class="form-group">
				<input type="text" id="estado" name="estado" value="">
				<input type="text" id="municipio" name="municipio" value="">
			    
			    <select class="form-control" id="localidadeEstado" name="localidadeEstado">
			      <option value="">Estado</option>
			      <?php
					if ($resultadoEstados) {
						foreach ($resultadoEstados as $key => $row) {
					?>
						<option sigla="<?=$row->sigla?>" value="<?=$row->id?>"><?=$row->nome." - ".$row->sigla?></option>
					<?php
						}
					}
			      ?>
			    </select>
			</div>	
			<div class="form-group">
			    <select class="form-control" id="localidadeMunicipio" name="localidadeMunicipio">
			      <option value="">Município</option>
			    </select>
			</div>	  
		</div>
	</form>

    <!-- Optional JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>