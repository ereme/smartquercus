$( document ).ready(function() {

	console.log('Binevenido al proyecto de Alburquerque');


	$('.botonopina').on('click', function(){
		var idopina = $(this).parent().find('input').val();
		var valor = $(this).attr('valor');
		//console.log('Has pinchado en el botón de A favor'+idopina+valor);
            var favor = $(this).parent().parent().find('.bg-success');
            var contra = $(this).parent().parent().find('.bg-danger');
            var clase = $(this).attr('class');
            var elemento = $(this);
                
		$.ajax({
            url: '/opina/' + idopina + '/' + valor + '/json',
            dataType: 'json',
            success: function success(datos) {
     
     			mas = Math.round(100 * datos.votosfavor / (datos.votosfavor + datos.votoscontra));
     			menos = Math.round(100-mas);

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

});