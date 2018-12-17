// loads the jquery package from node_modules
const $ = require('jquery');

console.log( 'hola');

$(document).ready(function(){
	$('#incidencia_fichero').on('change',function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
 	});
	
});

