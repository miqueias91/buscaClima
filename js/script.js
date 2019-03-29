$('#myModal').dialog({
    draggable: false,
    resizable: false,
    modal: true,
    closeOnEscape: false,
    buttons: {
        "Utilizar localização": function() {
            if ("geolocation" in navigator){ //check geolocation available 
                //try to get user current location using getCurrentPosition() method
                navigator.geolocation.getCurrentPosition(function(position){ 
                        // console.log("Found your location \nLat : "+position.coords.latitude+" \nLang :"+ position.coords.longitude);
                    $.ajax({
                        url: "https://nominatim.openstreetmap.org/reverse?format=json&lat="+ position.coords.latitude+"&lon="+position.coords.longitude,
                        dataType: 'html',
                        type: 'get',
                        success: function(valorRetornado) {
                            var obj = JSON.parse(valorRetornado);
                            if (obj) {
                                //console.log(obj['address']['road']);
                                //console.log(obj['address']['city_district']);
                                //console.log(obj['address']['state']);
                                //console.log(obj['address']['country']);
                                //console.log(obj['address']['postcode']);
                                buscaClimaMunicipio(obj['address']['state'], obj['address']['city_district']);                           
                            }
                        },
                    });
                });
            }else{
                alert("Atençao! Esse navegador não suporta geolocalização");
                window.location.reload();
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
                $('#aguarde').dialog('open');
                $('#myModal').dialog('close');
                buscaClimaMunicipio($('#estado').val(), $('#municipio').val());
                return true;
            }
        },
    },
});
       
$('#localidadeEstado').change(function(){
    if ($(this).val() != '') {
        $('#estado').val($('option:selected', this).attr('sigla'));
        $('#myModal').dialog('close');
        $('#aguarde').dialog('open');
        $.ajax({
            url: "buscaMunicipio.php",
            dataType: 'html',
            type: 'post',
            data: {
                'uf': parseInt($(this).val()),
            },
            success: function(a) {
                $('#localidadeMunicipio').html("<option value=''>Município</option>\n"+a);
                $('#aguarde').dialog('close');
                $('#myModal').dialog('open');
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
    window.location.reload();
});

$('#aguarde').dialog({
    autoOpen: false,
    resizable: false,
    draggable: false,
});

function buscaClimaMunicipio (estado, municipio){
    console.log('buscaClimaMunicipio()')
    $.ajax({
        url: "buscaClimaMunicipio.php",
        dataType: 'html',
        type: 'post',
        data: {
            'estado': estado,
            'municipio': municipio,
        },
        success: function(valorRetornado) {
            console.log(valorRetornado)
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