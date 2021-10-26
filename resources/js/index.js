
$(function () {
    "use strict";

/*
 * Codigo del modal
 */
var modal = $('#deleteModal');
//Añadimos el id del elemento que hay que borrar al mostrar el modal
modal.on('show.bs.modal', function (e) {
	var button = $(e.relatedTarget); // Botón que ha lanzado el modal
	var id = button.data('id'); // Cogemos el id a borrar
	$('#deleteBtn').data('id', id);
});

$('#deleteBtn').click(function(){
	//Enviamos la petición por ajax
	$.ajax({
		headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
		type: "POST",
		url: "/delete",
		dataType: 'json',
		cache: false,
		data: { id: $(this).data('id')},
		success : function(response) {
			if(JSON.parse(response)){
				location.reload();
			}else{
				modal.find('.modal-body').html('Ocurrió un error');
			}
		},
		error: function(xhr, ajaxOptions, thrownError){
			modal.find('.modal-body').html('Ocurrió un error');
		}
	});

});


	
})