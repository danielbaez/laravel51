@extends('panel.template')

@section('content')
	<div class="row">
		<div class="col col-xs-6">
			<h3>Crear Usuario</h3>
		</div>
	</div>

	<div class="row containter-form-user">
		@include('partials.errors')
        {!! Form::model($user, array('route' => array('user.update', $user))) !!}
            <input type="hidden" name="_method" value="PUT">
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="name">Nombres:</label>
                    
                    {!! 
                        Form::text(
                            'name', 
                            null, 
                            array(
                                'class'=>'form-control',
                                'placeholder' => 'Ingresa nombre...',
                                'autofocus' => 'autofocus',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="email">Correo:</label>
                    
                    {!! 
                        Form::text(
                            'email', 
                            null, 
                            array(
                                'class'=>'form-control',
                                'placeholder' => 'Ingresa el correo...',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div>                
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="password">Password:</label>
                    
                    {!! 
                        Form::password(
                            'password', 
                            array(
                                'class'=>'form-control',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Password:</label>
                    
                    {!! 
                        Form::password(
                            'password_confirmation',
                            array(
                                'class'=>'form-control',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="type">Tipo:</label><br>
                    <label class="radio-inline">
                    	{!! Form::radio('type', '1', true) !!} Administrador
                    </label>
                    <label class="radio-inline">
                    	{!! Form::radio('type', '2') !!} Empleado
                    </label>
                    <label class="radio-inline">
                    	{!! Form::radio('type', '3') !!} Cliente
                    </label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="{{$user->type == 3 ? 'form-group showCont':'form-group hideCont' }}">
                	<label for="type">Compañia:</label>
                    {!! Form::select('company_id', $companies, null, ['class' => 'form-control', 'placeholder' => 'Seleccione']) !!}
                </div>
            </div>	
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="type">País:</label><br>
                    <label class="radio-inline">
                    	{!! Form::radio('country', 'pe', true) !!} Perú
                    </label>
                    <label class="radio-inline">
                    	{!! Form::radio('country', 'mx') !!} México
                    </label>
                </div>
            </div>  
            <div class='col-md-6'>
                <div class="{{$user->type == 3 ? 'form-group byType2 hideCont':'form-group byType2 showCont' }}">
                    <label for="type">Metodo de llamadas:</label><br>
                    <label class="radio-inline">
                        {!! Form::radio('method_call', 'web', true) !!} Web
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('method_call', 'mobile') !!} Mobile
                    </label>
                </div>
            </div>  
            <div class='col-md-6'>
                <div class="{{$user->type == 3 ? 'form-group byType2 hideCont':'form-group byType2 showCont' }}">
                    <label for="name">Numero Perú:</label>
                    
                    {!! 
                        Form::text(
                            'phone_pe', 
                            null, 
                            array(
                                'class'=>'form-control',
                                'placeholder' => 'Ingresa su numero...',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div> 
            <div class='col-md-6'>
                <div class="{{$user->type == 3 ? 'form-group byType2 hideCont':'form-group byType2 showCont' }}">
                    <label for="name">Numero México:</label>
                    
                    {!! 
                        Form::text(
                            'phone_mx', 
                            null, 
                            array(
                                'class'=>'form-control',
                                'placeholder' => 'Ingresa su numero...',
                                //'required' => 'required'
                            )
                        ) 
                    !!}
                </div>
            </div>      
            <div class='col-md-6'>    
                <div class="form-group">
                    <label for="active">Activo:</label>
                    
                    {!! Form::checkbox('active', null, $user->active == 1 ? true : false) !!}

                </div>
            </div>    
            <div class='col-sm-12'>
                <div class="form-group text-center">
                    {!! Form::submit('Guardar', array('class'=>'btn btn-primary')) !!}
                </div>
            </div>
        {!! Form::close() !!}

	</div>

@stop