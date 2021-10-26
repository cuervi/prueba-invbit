@extends('layouts.base') @section('content')

@section('breadcrumb-title')
	Prueba Invbit
@endsection
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid" id="transport-route-list-view">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- Botones -->
    <div class="row">
    	<div class="col-12 mb-3">
    		<button id="exportExcel" data-toggle="modal" data-target="#form-Modal" class="btn btn-primary mr-1">
    			Crear Usuario
    		</button>
    	</div>
    </div>
    <!-- basic table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="routesTable" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Nota Media</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Crear Modal</h4>
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"
                        aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="registerRoutesForm" action="{{ route('testuser.create') }}" method="POST">
                    <input type="text" name="id" id="id" class="form-control" autocomplete="off" hidden="hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nota Media</label>
                                <input type="number" class="form-control" id="average" name="average" placeholder="Nota media" autocomplete="off">
                            </div>
                        </div>
 						<div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input type="date" name="bithdate" id="birthdate" class="form-control" placeholder="Fecha de nacimiento" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" id="submit" class="btn btn-rounded btn-primary float-right modal-confirm">@lang('website.add-transportr-btn')</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
<script type="text/javascript">
<!--

//-->
var modal = $('#carrier-modal');
		modal.on('hide.bs.modal', function (e) {
			modal.find('form').trigger("reset");
			var buttons = modal.find('button');
			buttons.off('click')
			modal.find(".brands").addClass('d-none');
			$(".brands input[type=checkbox]").each(function(){
				$(this).prop('checked', false);
				$(this).prop('disabled', true);
			});
		});
		
		/**
		 * Mostramos el modal, recargamos los inputs, ponemos el modal close y sus animaciones.
		 * Se ponen los textos de título y subtítulo
		 */
		modal.on('show.bs.modal', function (e) {
			// Datos obligatorios para cargar el modal
			var button = $(e.relatedTarget) // Button that triggered the modal
			var recipient = button.data('view') // Extract info from data-* attributes
    		
			// Fin datos obligatorios
			var url = '/transportistas/crear';
			if(recipient == 'update'){
				$('#id').val(button.data('id'));
				messageModalError = Lang.get('website.error-plus-try-again', {'error': Lang.get('website.carrier-edit-error')}); 
				modal.find(".modal-title").html(Lang.get('website.edit-carrier'));
				// ajax para cargar los datos del empleado
				$('.modal-confirm').html(Lang.get('website.edit-carrier-btn'));
				$('.modal-confirm').prop('disabled', true);
				isFormEdit = true;
				url = '/transportistas/actualizar';
				$.ajax({
					
					type: "GET",
					url: "/transportistas/transportista",
					dataType: 'json',
					cache: false,
					data: { id: button.data('id') },
					success: function(response) {
						if(response.result){
							
							// Toast true
// 							modal.find('#name').val(response.carrier.name);
// 							modal.find("#carrier_type").val(response.carrier.carrier_type);
// 							modal.find("#fiscal_city").val(response.carrier.fiscal_city);
// 							modal.find("#email").val(response.carrier.email);
// 							modal.find("#phone_number").val(response.carrier.phone_number);
// 							modal.find("#fiscal_number").val(response.carrier.fiscal_number);
// 							modal.find("#fiscal_number_type").val(response.carrier.fiscal_number_type);
// 							modal.find("#fiscal_address_line").val(response.carrier.fiscal_address_line);
// 							modal.find("#fiscal_address_line2").val(response.carrier.fiscal_address_line2);
// 							modal.find("#fiscal_cp").val(response.carrier.fiscal_cp);
// 							modal.find("#fiscal_state").val(response.carrier.fiscal_state);
// 							modal.find("#fiscal_country").val(response.carrier.fiscal_country);
// 							modal.find("#contact_person_full_name").val(response.carrier.contact_person_full_name);
// 							modal.find("#contact_person_number").val(response.carrier.contact_person_number);
// 							modal.find("#contact_person_email").val(response.carrier.contact_person_email);
// 							modal.find("#observations").val(response.carrier.observations);
							$('.modal-confirm').prop('disabled', false);
							
							// Si es jefe se habilita las marcas
							if(response.isTheBoss) {
								modal.find(".brands").removeClass('d-none');
								if(!AppUtils.empty(response.brands))
									$('.brands input[value="'+response.brands.id+'"]').prop('checked', true);
								
								$(".brands input[type=checkbox]").each(function(){
									$(this).prop('disabled', false);
								});
							}
							
						}else{
							// Toast error
							Swal.fire({
				        		title: response.title,
				        		icon: 'error',
				        		text: response.message,
				        		showCancelButton: false,
				        		showConfirmButton: true,
				  			});
						}
					},
					error: function(xhr, ajaxOptions, thrownError){
						Swal.fire({
							title: Lang.get('website.error-retreiving-info-title'),
							icon: 'error',
							text: Lang.get('website.error-plus-try-again', {'error': Lang.get('website.error-retreiving-carrier-info')}),
							showCancelButton: false,
							showConfirmButton: true,
						});
					}
				});
			}else{
				messageModalError = Lang.get('website.error-plus-try-again', {'error': Lang.get('website.carrier-create-error')}); 
				modal.find(".modal-title").html(Lang.get('website.add-carrier'));
				// ajax para cargar los datos del profesor
				$('.modal-confirm').html(Lang.get('website.add-carrier-btn'));
				$('.modal-confirm').prop('disabled', false);
			}
			$('#registerCarrierForm').prop('action', url);
		});
</script>

