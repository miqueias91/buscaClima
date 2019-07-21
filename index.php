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
    <meta name="revised" content="2019-07-20">
    <meta http-equiv="Content-Security-Policy" content="default-src *; img-src * 'self' data: https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' *; style-src  'self' 'unsafe-inline' *">

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


    <title>Clima Hoje - Veja como está o clima hoje</title>
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
					<option sigla="AC" value="12">Acre - AC</option>
					<option sigla="AL" value="27">Alagoas - AL</option>
					<option sigla="AM" value="13">Amazonas - AM</option>
					<option sigla="AP" value="16">Amapá - AP</option>
					<option sigla="BA" value="29">Bahia - BA</option>
					<option sigla="CE" value="23">Ceará - CE</option>
					<option sigla="DF" value="53">Distrito Federal - DF</option>
					<option sigla="ES" value="32">Espírito Santo - ES</option>
					<option sigla="GO" value="52">Goiás - GO</option>
					<option sigla="MA" value="21">Maranhão - MA</option>
					<option sigla="MT" value="51">Mato Grosso - MT</option>
					<option sigla="MS" value="50">Mato Grosso do Sul - MS</option>
					<option sigla="MG" value="31">Minas Gerais - MG</option>
					<option sigla="PA" value="15">Pará - PA</option>
					<option sigla="PB" value="25">Paraíba - PB</option>
					<option sigla="PR" value="41">Paraná - PR</option>
					<option sigla="PI" value="22">Piauí - PI</option>
					<option sigla="PE" value="26">Pernambuco - PE</option>
					<option sigla="RJ" value="33">Rio de Janeiro - RJ</option>
					<option sigla="RN" value="24">Rio Grande do Norte - RN</option>
					<option sigla="RS" value="43">Rio Grande do Sul - RS</option>
					<option sigla="RO" value="11">Rondônia - RO</option>
					<option sigla="RR" value="14">Roraima - RR</option>
					<option sigla="SP" value="35">São Paulo - SP</option>
					<option sigla="SC" value="42">Santa Catarina - SC</option>
					<option sigla="SE" value="28">Sergipe - SE</option>
					<option sigla="TO" value="17">Tocantins - TO</option>
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
	<footer class="text-center footer">	 
	 	<div class="informacoes">
	 		<div class="container">	 			
		 		<div class="row">
		 			<div class="col-md-3">
		 				<a href="./">Buscar Clima</a>
		 			</div>
		 			<div class="col-md-3">
		 				<a href="https://play.google.com/store/apps/details?id=com.phonegap.climahojemobile" target="_blank">Google Play</a>
		 			</div>
		 			<div class="col-md-3">
		 				<a href="./policy.html" target="_blank">Politica de Privacidade</a>
		 			</div>
		 			<div class="col-md-3">
		        		<a href="https://www.linkedin.com/in/miqueias-matias-caetano-21902068/" target="_blank">LinkedIn</i></a>
		 			</div>
		 			
		 		</div>
		 		<div class="row">
		 			<div class="col-md-12">
		 				<a href="https://miqueiasmcaetano.000webhostapp.com/" target="_blank">© 2019 Desenvolvido por Miqueias Matias Caetano - Todos os direitos reservados</a>
		        	</div>	 			
		 		</div>	 		
	 		</div>
	 	</div>
    </footer>

    <!-- Optional JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
	<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>