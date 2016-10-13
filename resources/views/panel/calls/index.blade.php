@extends('panel.template')

@section('content')
	<div style="display:none">{{ date_default_timezone_set('America/Lima') }}</div>
	@include('partials.messages')
	<div class="row">
		<h4>Calls Comparison</h4>
		<br>
		<div class="col hidden-xs col-sm-3 text-center">
			<p style="padding-top:6px"><strong>Busqueda por Nombre o email:</strong></p>
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
	  <table class="table table-striped table-hover">
	  	<thead>
	  	  <tr><th class="text-center">ID</th><th class="text-center">Name - Email</th><th class="text-center">Fecha</th><th class="text-center">Phone</th><th class="text-center">Solicitar</th><th class="text-center">Call</th><th class="text-center">Prima</th><th class="text-center">Compañia</th><th class="text-center">Update</th></tr>
	  	</thead>
	  	<tbody>
	  		@foreach($calls as $c)
	  			<?php $request = ($c->request); ?>
	  			<tr><td>{{ $c->id }}</td><td>{{ $c->name }}<br>{{ $c->e }}</td><td>{{ date('d-m-Y h:i A', $c->time) }}</td><td><input class="form-control" type="input" value="{{ $c->phone }}"></td><td class="text-center">{{ $request['carname'] }}<br>({{ $request['year'] }})<br><a href="{{ $c->compare }}" target="_blank">Resultados</a></td><td><button class="btn btn-success">Llamar</button></td><td>{{ $c->prima }}</td><td>{{ $c->company }}</td><td><a class="btn btn-warning">Actualizar</a></td></tr>
	  		@endforeach
	  	</tbody>
	  	<tbody>
	  		
	  	</tbody>
	  </table>
	</div>



@stop