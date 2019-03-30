<?php
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
	$url0 = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";
	$result0 = ConnURLPost($url0);
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

	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
	<script>
	  var OneSignal = window.OneSignal || [];
	  OneSignal.push(function() {
	    OneSignal.init({
	      appId: "a1baa402-431f-4103-9f5e-9b8a3daa80ee",
	    });
	  });
	</script>


    <title>Climahoje - Veja como está o clima hoje</title>
  </head>
  <body>
  	<form action='./' method='post' name='form' id='form' enctype='multipart/form-data'>

		<div title="Aguarde" id='aguarde' class="modal" tabindex="-1">
			<img width="100" height="60" src="img/carregando.gif">
			<span>Carregando</span>
		</div>

		<div title="Buscar localidade" id='myModal' class="modal" tabindex="-1">
			<p><i class="fas fa-thumbtack"></i>&nbsp;Informe o estado e o município:</p>
			<div class="form-group">
				<input type="hidden" id="estado" name="estado" value="">
				<input type="hidden" id="municipio" name="municipio" value="">
			    
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
			<div class="text-center">
				<p>Ou</p>				
			</div>
			<div class="form-group ui-widget"  style="margin-bottom: 0;">
			  <input class="form-control" id="tags" placeholder="Pesquise um município...">
			</div>  
		</div>

		<div class="container">
			<div id="resultadoTempo" class="main" style="display: none;">
				<h2><i class="fas fa-location-arrow"></i>&nbsp;<span>XXXXXXX - XX, XX</span></h2>	
				<br>
				<div class="dadosTemperatura">
					<h1>00ºC</h1>
					<h2>XXXXXXXXX</h2>
					<h4>Direção do vento:&nbsp;<span class="direcao">XXX</span></h4>
		            <h4>Vento:&nbsp;<span class="vento">00</span>km/h</h4>
		            <h4>Umidade:&nbsp;<span class="umidade">00</span>%</h4>
		            <h4>Pressão:&nbsp;<span class="pressao">00</span>&nbsp;hPa</h4>
		            <h4>Sensação:&nbsp;<span class="sensacao">00</span>&nbsp;ºC</h4>				
				</div>
				<br>
				<h3>Verificado em: <span class="data"></span></h3>	
				<h3>Fonte: Climatempo</h3>
				<br>	
				<button type="button" class="btn btn-primary" id="novaBusca">Nova Busca</button>
			</div>			
		</div>
	</form>

    <!-- Optional JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
	<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>
    <script  type="module" src="js/script.js"></script>
  </body>
</html>