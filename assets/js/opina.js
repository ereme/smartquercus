import 'bootstrap/dist/js/bootstrap.bundle.min.js';

$( document ).ready(function() {

	console.log('Binevenido al proyecto de Alburquerque');


	$('.botonopina').on('click', function(){
		var idopina = $(this).parent().find('input').val();
        var idvecino = $('#usuarioid').val();
		var valor = $(this).attr('valor');
		//console.log('Has pinchado en el botón de A favor'+idopina+valor);
            var favor = $(this).parent().parent().parent().find('.bg-success');
            var contra = $(this).parent().parent().parent().find('.bg-danger');
            var clase = $(this).attr('class');
            var elemento = $(this);
                
		$.ajax({
            url: '/opina/' + idopina + '/' + idvecino + '/' + valor + '/json',
            dataType: 'json',
            success: function success(datos) {
     
     			var mas = Math.round(100 * datos.votosfavor / (datos.votosfavor + datos.votoscontra));
     			var menos = Math.round(100-mas);

            	favor.find('span').text(mas +' ' + '%');          	
            	favor.attr({
            				'aria-valuenow': mas,
            				'style': 'width:'+mas+'%',
            	});

            	contra.find('span').text(menos + ' ' + '%');          	
            	contra.attr({
            				'aria-valuenow': menos,
            				'style': 'width:'+menos+'%',
            	});

                //Cambio el color del boton pulsado
                clase = clase.replace("outline-", "");
                elemento.attr('class',clase);

                //Desactivar los botones de esa opina
                elemento.parent().find('.botonopina').attr('disabled','disabled');
               
            }
        });

	});


    $('#opina_fichero').on('change',function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    });

});