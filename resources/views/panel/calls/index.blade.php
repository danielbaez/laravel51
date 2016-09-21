@extends('panel.template')

@section('content')
	@include('partials.messages')
	<div class="row">
		<h4>Calls Comparison</h4>
		<br>
		<div class="col hidden-xs col-sm-3 text-center">
			<p style="padding-top:6px">Busqueda por Nombre o email:</p>
		</div>
		<div class="col col-xs-8 col-sm-6 text-center">
			<input class="form-control" type="text" placeholder="Ingrese nombre o email">
		</div>
		<div class="col col-xs-4 col-sm-3 text-center">
			<button class="btn btn-primary">Buscar</button>
		</div>
	</div>
	<br><br>

	<div class="table-responsive">
	  <table class="table table-striped">
	  	<thead>
	  	  <tr><th class="text-center">ID</th><th class="text-center">Name - Email</th><th class="text-center">Fecha</th><th class="text-center">Phone</th><th class="text-center">Solicitar</th><th class="text-center">Call</th><th class="text-center">Prima</th><th class="text-center">Compañia</th><th class="text-center">Update</th></tr>
	  	</thead>
	  	<tbody>
	  		
	  	</tbody>
	  </table>
	</div>



@stop