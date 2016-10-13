@extends('panel.template')

@section('content')
	@include('partials.messages')
	<div class="row">
		<div class="col col-xs-6">
			<h1>Usuarios</h1><h4>{{ $users->count() }} de {{ $users->total() }}</h4>
		</div>
		<div class="col col-xs-6 text-right">
			<a href="{{ route('admin.user.create') }}" class="btn btn-primary" style="margin:30px 0px 10px 0px">Agregar <i class="fa fa-plus"></i></a>
		</div>
	</div>


	<div class="table-responsive">
	  <table class="table table-striped">
	  	<thead>
	  	  <tr><th class="text-center">#</th><th class="text-center">Nombres</th><th class="text-center">Email</th><th class="text-center">Empresa</th><th class="text-center">Acciones</th></tr>
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
	  	  	<td class="text-center">
	  	  		{!! Form::open(['route' => ['admin.user.destroy', $user], 'class' => 'formDelete']) !!}
		  	  		<a class="btn btn-primary btn-option" href="{{ route('admin.user.edit', $user) }}">Editar</a> 
		  	  		<input type="hidden" name="_method" value="DELETE">
		  	  		<button class="btn btn-danger btn-option" onClick="return confirm('Eliminar registro?')">Eliminar</button>
	  	  		{!! Form::close() !!}

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