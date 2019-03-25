$('#myModal').dialog({
    resizable: false,
    modal: true,
    buttons: {
        "Cancelar": function() {
            $( this ).dialog( "close" );
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
                    success: function(a) {
                        console.log(a)
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