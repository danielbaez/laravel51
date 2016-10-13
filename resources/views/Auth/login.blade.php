@extends('auth.template')
@section('content')
	<div class="container text-center page-login">
		<img class="logo" src="https://comparabien.com/apps/panel/public/images/logo.png" alt="">

		<div class="row container-login">
			@include('partials.errors')
			<form class="form-horizontal" method="POST" action="{{ route('login-post') }}" novalidate>
				{!! csrf_field() !!}
			    <div class="form-group">
			      
			      <div class="col-sm-12">
			        <input type="email" name="email" class="form-control" placeholder="Ingrese su email" value="{{ old('email') }}">
			      </div>
			    </div>
			    <div class="form-group">
			      
			      <div class="col-sm-12">
			        <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña">
			      </div>
			    </div>
			    <div class="form-group">
			      
			      <div class="col-sm-12">
			        <input type="checkbox" name="remember"> Remember Me
			      </div>
			    </div>
			    <div class="form-group">
			      <div class="col-sm-12">
			        <button type="submit" class="btn btn-primary">Ingresar</button>
			      </div>
			    </div>
			</form>
		</div>
	</div>
@stop