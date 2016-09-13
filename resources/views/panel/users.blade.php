@extends('panel.template')

@section('content')
	<h1>Usuarios</h1>

	<div class="table-responsive">
	  <table class="table table-striped">
	  	<thead>
	  	  <tr><th>#</th><th>Nombres</th><th>Email</th><th>Empresa</th><th>Acciones</th></tr>
	  	</thead>
	  	<tbody>
	  		@foreach($users as $user)
	  	  <tr><th scope="row">{{ $user->id }}</th><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->company }}</td><td>aa</td></tr>
	  		@endforeach
	  	</tbody>
	  </table>
	</div>

@stop