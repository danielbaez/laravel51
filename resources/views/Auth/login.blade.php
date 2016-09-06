@extends('Auth.template')
@section('content')
	<div class="container text-center page-login">
		<img src="https://comparabien.com/apps/panel/public/images/logo.png" alt="">

		<div class="row container-login">
			<form class="form-horizontal">
			    <div class="form-group">
			      
			      <div class="col-sm-12">
			        <input type="email" name="email" class="form-control" placeholder="Ingrese su email">
			      </div>
			    </div>
			    <div class="form-group">
			      
			      <div class="col-sm-12">
			        <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña">
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