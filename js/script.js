//ESTRUTURA DO MODAL DE BUSCA
$('#myModal').dialog({
    draggable: false,
    resizable: false,
    modal: true,
    closeOnEscape: false,
    buttons: {
        "Utilizar localização": function() {
            if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)
            ){
                alert('Atenção! Essa funcionalidade está indisponível para moblie.\n\nPara utiliza-lá baixe o nosso APP na Play Store ou utilize um desktop.')
                return true;
            }
            else {
                if ("geolocation" in navigator){ //check geolocation available 
                    //try to get user current location using getCurrentPosition() method
                    navigator.geolocation.getCurrentPosition(function(position){ 
                    $('#aguarde').dialog('open');
                    $('#myModal').dialog('close');
                        $.ajax({
                            url: "https://nominatim.openstreetmap.org/reverse?format=json&lat="+ position.coords.latitude+"&lon="+position.coords.longitude,
                            dataType: 'html',
                            type: 'get',
                            success: function(valorRetornado) {
                                var obj = JSON.parse(valorRetornado);
                                if (obj) {
                                    window.localStorage.setItem('estado', obj['address']['state']);
                                    window.localStorage.setItem('municipio', obj['address']['city_district']);
                                    buscaClimaMunicipio(obj['address']['state'], obj['address']['city_district']);                           
                                }
                            },
                        });
                    });
                }else{
                    alert("Atençao! Esse navegador não suporta geolocalização");
                    window.location.reload();
                }
            }
        },
        "Buscar": function() {
            if ($('#localidadeEstado').val() == '') {
                alert('Atenção! Selecione um estado.');
                return false;
            }         
            else if ($('#localidadeMunicipio').val() == '') {
                alert('Atenção! Selecione um município.');
                return false;
            }
            else{
                window.localStorage.setItem('estado', $('#estado').val());
                window.localStorage.setItem('municipio', $('#municipio').val());

                $('#aguarde').dialog('open');
                $('#myModal').dialog('close');
                buscaClimaMunicipio($('#estado').val(), $('#municipio').val());
                return true;                   
            }
        },
    },
});
       
$('#localidadeEstado').change(function(){
    if ($(this).val() !== '') {
        $('#estado').val($('option:selected', this).attr('sigla'));
        $('#myModal').dialog('close');
        $('#aguarde').dialog('open');
        $.ajax({
            url: "buscaMunicipio.php",
            dataType: 'JSON',
            type: 'GET',
            data: {
                'uf': $('option:selected', this).attr('sigla'),
            },
            success: function(a) {
                if (a === 'ERROR') {
                    alert('Atenção! Selecione um estado.');
                }
                else{
                    var html_municipio = "<option value=''>Município</option>\n";
                    for (var i = 0; i < a.length; i++) {
                        var nome = a[i]['nome'].replace("'", "%27", a[i]['nome']);
                        nome = nome.replace(" ", "%20", a[i]['nome']);
                        html_municipio+= "<option  localidade='"+nome+"' value='"+a[i]['nome']+"'>"+a[i]['nome']+"</option>";
                    }
                    $('#localidadeMunicipio').html(html_municipio);
                    $('#aguarde').dialog('close');
                    $('#myModal').dialog('open');                    
                }
            },
        });
    }
    else{
        alert('Atenção! Selecione um estado.');
    }
});
 
$('#localidadeMunicipio').change(function(){
    if ($(this).val() != '') {
        $('#municipio').val($('option:selected', this).attr('localidade'));
    }
    else{
        alert('Atenção! Selecione um município.');
    }
});

$('#novaBusca').click(function(){
    $('#aguarde').dialog('open');
    $('#myModal').dialog('close');
    //APAGO OQ ARMAZENEI NO NAVEGADOR
    window.localStorage.removeItem('estado');
    window.localStorage.removeItem('municipio');
    //window.localStorage.removeItem('token');
    window.location.reload();
});

$('#aguarde').dialog({
    autoOpen: false,
    resizable: false,
    draggable: false,
});

function buscaClimaMunicipio (estado, municipio){
    var token = window.localStorage.getItem('token');

    $.ajax({
        url: "buscaClimaMunicipio.php",
        dataType: 'html',
        type: 'get',
        data: {
            'estado': estado,
            'municipio': municipio,
        },
        success: function(valorRetornado) {
            if (valorRetornado == "ERROR") {
                alert("Atenção! Não foi possível buscar o clima na localidade.");
                $('#aguarde').dialog('close');
                $('#myModal').dialog('open');
            }
            else{                
                var obj = JSON.parse(valorRetornado);
                if (obj) {
                    //RETORNA O RESULTADO E IMPRIME NA TELA
                    $('#resultadoTempo h2 span').html(obj['name']+' - '+obj['state']+', '+obj['country']);
                    $('.dadosTemperatura h1').html(obj['data']['temperature']+'ºC');
                    $('.dadosTemperatura h2').html(obj['data']['condition']);
                    $('.dadosTemperatura h4 .direcao').html(obj['data']['wind_direction']);
                    $('.dadosTemperatura h4 .vento').html(obj['data']['wind_velocity']);
                    $('.dadosTemperatura h4 .umidade').html(obj['data']['humidity']);
                    $('.dadosTemperatura h4 .pressao').html(obj['data']['pressure']);
                    $('.dadosTemperatura h4 .sensacao').html(obj['data']['sensation']);

                    var date = new Date(obj['data']['date']);
                    $('#resultadoTempo h3 .data').html(date);

                    $('#aguarde').dialog('close');
                    $('#myModal').dialog('close');
                    $('#resultadoTempo').css('display', '');                            
                }
            }
        },
    });
}
   

//BUSCO OQ ARMAZENEI NO NAVEGADOR
var estado = window.localStorage.getItem('estado');
var municipio = window.localStorage.getItem('municipio');
var token = window.localStorage.getItem('token');

//QUANDO O USUARIO ABRIR A PAGINA NOVAMENTE, CARREGO COM A ULTIMA PESQUISA DELE
if (estado && municipio) {
    $('#aguarde').dialog('open');
    $('#myModal').dialog('close');
    buscaClimaMunicipio(estado, municipio);
}