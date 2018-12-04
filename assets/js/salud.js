import 'bootstrap/dist/js/bootstrap.bundle.min.js';

$(document).ready(function(){
	console.log('Holaa');

	 $('#salud_fichero').on('change',function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    });

});