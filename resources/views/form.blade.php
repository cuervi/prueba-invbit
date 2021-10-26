@extends('layouts.base') @section('content')

@section('breadcrumb-title') Prueba Invbit - {{ $data['title'] }} @endsection
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid" id="index-view">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
    				<form id="registerUserForm"
    					action="{{ $data['action'] }}" method="POST"  enctype="multipart/form-data">
    					
    					@csrf()
    					
    					<input type="text" name="id" id="id" class="form-control"
    						 value="<?= (key_exists('user', $data)) ? $data['user']->id : ''  ?>"
    						autocomplete="off" hidden="hidden">
    					<div class="row">
    						<div class="col-md-12">
    							<div class="form-group">
    								<label>Nombre</label> <input type="text" class="form-control"
    									id="name" value="<?= (key_exists('user', $data)) ? $data['user']->name : ''  ?>" name="name" placeholder="Nombre" autocomplete="off" required>
    							</div>
    						</div>
    						<div class="col-md-12">
    							<div class="form-group">
    								<label>Email</label> <input type="text" class="form-control"
    									id="email" value="<?= (key_exists('user', $data)) ? $data['user']->email : ''  ?>" name="email" placeholder="Email" autocomplete="off" required>
    							</div>
    						</div>
    						<div class="col-md-6">
    							<div class="form-group">
    								<label>Nota Media</label> <input type="number" step="any"
    									value="<?= (key_exists('user', $data)) ? $data['user']->average : ''  ?>"
    									class="form-control" id="average" name="average"
    									placeholder="Nota media" autocomplete="off" required>
    							</div>
    						</div>
    						<div class="col-md-6">
    							<div class="form-group">
    								<label>Fecha de nacimiento</label> <input type="date"
    									value="<?= (key_exists('user', $data)) ? date('Y-m-d', strtotime( $data['user']->birthdate)) : ''  ?>"
    									name="birthdate" id="birthdate" class="form-control"
    									placeholder="Fecha de nacimiento" autocomplete="off" required>
    							</div>
    						</div>
    						<div class="col-md-12">
    							<div class="form-group">
    								<label>Contraseña</label> <input type="password" name="password"
    									value="<?= (key_exists('password', $data)) ? $data['password'] : ''  ?>"
    									id="password" class="form-control" placeholder=""
    									autocomplete="off" required>
    							</div>
    						</div>
    						<div class="col-md-6">
    							<div class="form-group">
    								<label>Imagen</label> <input type="file" name="image"
    									id="image" class="form-control" placeholder="Selecciona una imangen"
    									autocomplete="off" required>
    							</div>
    						</div>
    					</div>
    
    					<div>
    						<button type="submit" id="submit"
    							class="btn btn-rounded btn-primary float-right">{{ $data['title'] }}</button>
    					</div>
    				</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection