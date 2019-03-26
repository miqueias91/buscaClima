$('#myModal').dialog({
    resizable: false,
    modal: true,
    buttons: {
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
                //$("#form").attr('action','.index.php?buscar=sim');
                //$("#form").submit();
                $.ajax({
                    url: "buscaClima.php",
                    dataType: 'html',
                    type: 'post',
                    data: {
                        'estado': $('#estado').val(),
                        'municipio': $('#municipio').val(),
                    },
                    success: function(valorRetornado) {
                        console.log(valorRetornado);
                        var obj = JSON.parse(valorRetornado);
                        if (obj) {
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

                            $('#myModal').dialog('close');
                            $('#resultadoTempo').css('display', '');                            
                        }
                    },
                });
                return true;
            }
        },
    },
});
       
$('#localidadeEstado').change(function(){
    if ($(this).val() != '') {
        $('#estado').val($('option:selected', this).attr('sigla'));

        $.ajax({
            url: "buscaMunicipio.php",
            dataType: 'html',
            type: 'post',
            data: {
                'uf': parseInt($(this).val()),
            },
            success: function(a) {
                $('#localidadeMunicipio').html("<option value=''>Município</option>\n"+a);
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