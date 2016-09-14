@extends('panel.template')

@section('content')
	<h1>Usuarios</h1><h4>{{ $users->count() }} de {{ $users->total() }}</h4>

	<div class="table-responsive">
	  <table class="table table-striped">
	  	<thead>
	  	  <tr><th>#</th><th>Nombres</th><th>Email</th><th>Empresa</th><th>Acciones</th></tr>
	  	</thead>
	  	<tbody>
	  		@foreach($users as $user)
	  	  <tr><th scope="row">{{ $user->id }}</th><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>
	  	  	@if($user->company)
	  	  		{{ $user->company->CO_NAME }}
	  	  	@else
	  	  		Comparabien
	  	  	@endif
	  	  	</td>
	  	  	<td>
	  	  		<!-- <button class="btn btn-primary btn-option">Editar</button> <button class="btn btn-danger btn-option">Eliminar</button> -->
	  	  		<div class="btn-group hidden-xs">
    <button class="btn btn-default">View</button>
    <button class="btn btn-default">Delete</button>
</div>
<div class="btn-group-vertical visible-xs">
    <button class="btn btn-default">View</button>
    <button class="btn btn-default">Delete</button>
</div>
	  	  	</td>
	  	  	</tr>
	  		@endforeach
	  	</tbody>
	  </table>
	</div>

	<div class="text-center">
		{!! $users->render() !!}
	</div>

@stop