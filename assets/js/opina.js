$( document ).ready(function() {

	console.log('Binevenido al proyecto de Alburquerque');


	$('.botonopina').on('click', function(){
		var idopina = $(this).parent().find('input').val();
		var valor = $(this).attr('valor');
		console.log('Has pinchado en el botón de A favor'+idopina+valor);


		$.ajax({
            url: '/opina/' + idopina + '/' + valor + '/json',
            dataType: 'json',
            success: function success(datos) {
               console.log(datos);
            }
        });

	});

});