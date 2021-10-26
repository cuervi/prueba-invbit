@extends('layouts.base') @section('content')

@section('breadcrumb-title') Prueba Invbit @endsection
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid" id="index-view">
	<!-- ============================================================== -->
	<!-- Start Page Content -->
	<!-- ============================================================== -->
	<!-- Botones -->
	<div class="row">
		<div class="col-12 mb-3">
			<a href="{{ route('testuser.create-view') }}" class="btn btn-primary mr-1">Crear Usuario</a>
		</div>
	</div>
	<!-- Tabla -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table id="userTable"
							class="table table-striped table-bordered no-wrap">
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
								@foreach ($users as $user)
									<tr>
										<td>{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ date('d/m/Y', strtotime( $user->birthdate)) }}</td>
										<td>{{ $user->average }}</td>
										<td>
											<a href="{{ route('testuser.edit-view', $user->id) }}" class="btn btn-sm btn-primary mr-1">Editar</a>
											<button data-id="{{ $user->id }}" data-toggle="modal" class="btn btn-sm btn-danger remove-user mr-1" data-target="#deleteModal">Borrar</button>
										</td>
									</tr>
								@endforeach 
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está deacuerdo en eliminar el registro?
      </div>
      <div class="modal-footer">
        <button id="deleteBtn" type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script>

</script>
@endsection

