$(document).ready(function(){
	$('#salud_fichero').on('change',function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
 	});	
});

