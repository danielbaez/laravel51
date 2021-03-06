@extends('panel.template')
<div style="display:none">{{ date_default_timezone_set('America/Lima') }}</div>

@section('alerts')
	@if(isset($alerts))
	@foreach($alerts as $al)
		<li>
	        <a href="#" class="text-center">{{ date('d-m-Y h:i A', $al->time) }}</a>
	    </li>    
    @endforeach
    <li class="divider"></li>
    <li>
        <a href="#">Ver Todas</a>
    </li>
    @endif
@stop

@section('content')
	@include('partials.messages')
	<input type="hidden" name="idUser" id="idUser" value="{{Auth::user()->id}}">
	<div class="row">
		<div class="alert alert-info alert-dismissible text-center" id="msgOperationSuccessDiv" role="alert" style="display:none">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4><strong><i class="fa fa-info-circle"></i></strong> <span id="msgOperationSuccess"></span></h4>
		</div>
		<div class="alert alert-danger alert-dismissible text-center" id="msgOperationErrorDiv" role="alert" style="display:none">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4><strong><i class="fa fa-info-circle"></i></strong> <span id="msgOperationError"></span></h4>
		</div>

		<h4 id="status-call">Calls Comparison</h4>
		<br>
		<!-- <div class="col hidden-xs col-sm-3 text-center">
			<p style="padding-top:6px"><strong>Busqueda por Nombre o email:</strong></p>
		</div> -->
		<div class="col col-xs-8 col-xs-offset-0 col-sm-6 col-sm-offset-2 col-md-offset-2 text-center">
			<input class="form-control" type="text" name="search" placeholder="Busqueda por nombre o email">
		</div>
		<div class="col col-xs-4 col-md-2 text-center">
			<button class="btn btn-primary  btn-search">Buscar</button>
		</div>
	</div>
	<br><br>

	<div class="table-responsive table-calls">
	  <table class="table table-striped table-hover" {{ (Request::is('admin/repcot') ? 'data-table=repcot' : 'data-table=calls') }}>
	  	<thead>
	  	  <tr><th class="text-center">ID</th><th class="text-center">Name / Email</th><th class="text-center">Fecha</th><th class="text-center">Celular</th><th class="text-center">Solicitar</th><th class="text-center">Llamar</th><th class="text-center">Prima</th><th class="text-center">Compañia</th><th class="text-center">Operación</th></tr>
	  	</thead>
	  	<tbody>
	  		@foreach($calls as $c)
	  			<?php $request = ($c->request); ?>
	  			<tr data-idcall="{{$c->id}}" data-email="{{$c->e}}" {{$c->normal == 0 ? 'data-id='.$c->call_id.' data-table=repcot' : 'data-table=calls'}}>
	  				<td class="text-center">
	  					<p class="table-colum-id">{{ $c->id }}</p>
	  					<?php if($c->cant > 1){

	  						if($c->normal == 1)
	  						{
	  							?>
		  						<button class="btn entriesMoreClient" style="color:white;background:teal; font-size:15px" data-id="{{$c->id}}" data-email="{{$c->e}}">{{$c->cant}} <i class="icon-morecall fa fa-arrow-down" aria-hidden="true"></i></button>
		  					<?php
	  						}
	  						else
	  						{
	  							?>
		  						<button class="btn entriesMoreClientRepCot" style="color:white;background:teal; font-size:15px" data-id="{{$c->call_id}}" data-idt="{{$c->id}}" data-email="{{$c->e}}">{{$c->cant}} <i class="icon-morecall fa fa-arrow-down" aria-hidden="true"></i></button>
		  					<?php
	  						}
	  					
	  					}

	  					if($c->normal == 0 && $c->operation_id == 4){
	  					?>
	  						<i class="fa fa-database info-cotiz" aria-hidden="true" data-id="{{$c->id}}"></i>
	  					<?php
	  					}
	  					?>
	  				</td>
	  				<td>{{ $c->name }}<br>{{ $c->e }}<br>
	  					<?php
		  					if($c->cant > 1)
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/sinaccion.png')}}">
	  					<?php
	  						}
	  					?>	  					
	  					<?php
		  					if($c->normal == 1 && $c->usuario != '' && $c->usuario != Auth::user()->id)
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/redir.png')}}">
	  					<?php
	  						}
	  					?>
	  					<?php
		  					if($c->normal == 1 && $c->state == 0 && $c->lead == 'clicktocall')
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/clicktocall.png')}}">
	  					<?php
	  						}
	  					?>
	  					<?php
		  					if($c->normal == 1 && $c->state == 0 && $c->lead == 'si')
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/lead.png')}}">
	  					<?php
	  						}
	  					?>
	  					<?php
		  					if($c->normal == 0 && $c->operation_id == 4)
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/cotizacion.png')}}">
	  					<?php
	  						}
	  					?>
	  					<?php
		  					if($c->normal == 0 && $c->operation_id == 5)
		  					{
	  					?>
	  						<img style="height: 25px;width: 25px;margin-right:5px" src="{{asset('images/reprogramado.png')}}">
	  					<?php
	  						}
	  					?>
	  				</td>
	  				<td>{{ date('d-m-Y h:i A', $c->time) }}</td>
	  				<td><input class="form-control input-tel" type="input" value="{{ $c->phone }}"></td>
	  				<td class="text-center">
	  					<?php 
	  						$carname = '';
			  				if(isset($c->request['carname']))
							{
								$carname = $c->request['carname'];
							}
							if(isset($c->request['year']))
							{
								$carname.= ' ('.$c->request['year'].')';
							}
							if(strlen($carname)>0){
							?>
							<?php echo $carname; ?>
							<?php
							}
				  			?>
			  			<?php if(isset($c->compare) and strlen($c->compare) > 0){ ?>
							<br><a href="{{$c->compare}}" target="_blank">Resultados</a>
						<?php } ?>
					</td>
	  				<td class="text-center"><button class="btn btn-success btn-calling"><i class="fa fa-phone fa-2x" aria-hidden="true"></i></button><p class="counterCall" style="margin-top: 7px;"><?php if($c->countCall > 0){?>
	  					<span class="badge call-bagde bagde-counter-call">{{ $c->countCall }}</span></p>
	  				<?php } ?></td>
	  				<td>{{ $c->prima }}</td>
	  				<td>{{ $c->company }}</td>
	  				<td class="text-center"><a class="btn btn-warning btn-actualizar"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a></td>
	  			</tr>
	  		@endforeach
	  	</tbody>
	  	<tbody>
	  		
	  	</tbody>
	  </table>
	</div>

	<div class="table-responsive table-calls-search" style="display:none">
	  <table class="table table-striped table-hover">
	  	<thead>
	  	  <tr><th class="text-center">ID</th><th class="text-center">Name / Email</th><th class="text-center">Fecha</th><th class="text-center">Celular</th><th class="text-center">Solicitar</th><th class="text-center">Llamar</th><th class="text-center">Prima</th><th class="text-center">Compañia</th><th class="text-center">Operación</th></tr>
	  	</thead>
	  	<tbody>
	  		
	  	</tbody>
	  	<tbody>
	  		
	  	</tbody>
	  </table>
	</div>

<!-- Modal 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div> -->


<div class="text-center paginator-calls">
	{!! $calls->render() !!}
</div>

<div class="text-center paginator-calls-search">
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="myModal">
  <div class="modal-dialog modal-lg" role="document">
    <form id="form-operations" action="{{route('calls-operation')}}" method="POST">
    	{!! csrf_field() !!}
    	<input type="hidden" name="idCall" id="idCall">
    	<input type="hidden" name="idt" id="idt">
    	<input type="hidden" name="uri" id="uri" {{ (Request::is('admin/repcot') ? 'value=repcot' : 'value=calls') }}>
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="gridSystemModalLabel">Actualizar</h4>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-xs-12">		
						  <div class="form-group col-xs-12">
						    <label for="operacion">Operación</label>
						    <select class="form-control" name="operacion" id="select-operaciones">
								  <option value="">Seleccione una operación</option>
								  <option value="5">Reprogramar</option>
								  <option value="1">Exito</option>
								  <option value="2">Rechazo</option>
								  <option value="4">Enviar Cotización</option>
								  <option value="6">Transferir Llamada</option>
								</select>
						  </div>
						  <div class="form-group div-fecha col-xs-12">
						  	<label for="operacion">Fecha</label>
	                <div class='input-group date' id='datetimepicker1'>
	                    <input type='text' name="fecha" class="form-control" readonly />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	              </div>
              <div class="form-group div-producto col-xs-12">
						    <label for="operacion">Producto</label>
							    
						    {!! Form::select('producto', $products, null, ['class' => 'form-control', 'id' => 'select-producto', 'placeholder' => 'Seleccione un Producto']) !!}
						  </div>
						  <div class="form-group div-motivo col-xs-12">
						    <label for="operacion">Motivo</label>
						    <select class="form-control" name="motivo" id="select-motivo">
								  <option value="">Selecciona un motivo</option>
								  <option value="2">No Interesado</option>
									<option value="3">Precios muy altos</option>
									<option value="4">Desconfianza</option>
									<option value="6">Número invalido</option>
									<option value="7">No contesta</option>				
									<option value="8">Duplicado</option>	
									<option value="10">Datos Falsos</option>					
									<option value="9">No hay oferta</option>				
									<option value="5">Otros</option>
								</select>
						  </div>
						  <div class="form-group div-gps col-xs-12 col-sm-3 col-md-2">
		          	<label for="comentario">GPS</label><br>
						    <label class="radio-inline"><input type="radio" checked name="gps" value="si">Si</label>
								<label class="radio-inline"><input type="radio" name="gps" value="no">No</label>
		          </div>
		          <div class="form-group div-email col-xs-12 col-sm-6 col-md-7">
		          	<label for="email">Email</label><br>
						    <input type='email' id="email" class="form-control" name="email" />
		          </div>
		          <div class="form-group div-valor col-xs-12 col-sm-3 col-md-3">
		          	<label for="email">Valor del auto</label><br>
						    <input type='text' class="form-control" name="valor" />
		          </div>
		          <div class="form-group div-prima col-xs-12 col-sm-4">
		          	<label for="prima">Prima Anual</label><br>
						    <input type='text' class="form-control" name="prima" />
		          </div>
		          <div class="form-group div-cuota col-xs-12 col-sm-4">
		          	<label for="cuota">Cuota</label><br>
						    <input type='text' class="form-control" name="cuota" />
		          </div>
		          <div class="form-group div-nrocuotas col-xs-12 col-sm-4">
		          	<label for="nrocuotas">Nro cuotas</label><br>
						    <input type='text' class="form-control" name="nrocuotas" />
		          </div>
		          <div class="form-group div-comentario col-xs-12">
		          	<label for="comentario">Comentario</label>
						    <textarea style="resize: vertical;" name="comentario" class="form-control" rows="2" id="comment"></textarea>
		          </div>
						  <!-- <div class="form-group">
						    <label for="exampleInputPassword1">Password</label>
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						  </div> -->
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	        <button type="button" class="btn btn-primary btn-guardar-operacion">Guardar</button>
	      </div>
	    </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="modalDetailCall">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="gridSystemModalLabel">Detalle de Llamadas</h4>
	      </div>
	      <div class="modal-body body-detail-call text-center">
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	      </div>
	</div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="modalDetailCotiz">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="gridSystemModalLabel">Detalle Cotización</h4>
	      </div>
	      <div class="modal-body body-detail-call text-center">
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	      </div>
	</div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section('leyenda')
	<hr style="margin:0;border:2px solid;">
	<div style="display: inline-block; width: 100%; color:white">
		<h4 style="padding:0px 10px;margin-bottom: 7px;">Leyenda</h4>
		<ul style="padding:10px">
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/sinaccion.png') }}" style="height: 25px;width: 25px; margin-right:10px">Reentrada 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/cotizacion.png') }}" style="height: 25px;width: 25px; margin-right:10px">Cotizacion 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/redir.png') }}" style="height: 25px;width: 25px; margin-right:10px">Redirigido 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/reprogramado.png') }}" style="height: 25px;width: 25px; margin-right:10px">Reprogranado 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/lead.png') }}" style="height: 25px;width: 25px; margin-right:10px">Lead 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/transferir.png') }}" style="height: 25px;width: 25px; margin-right:10px">Transferido 
	    	</li>
	    	<li style="list-style:none;padding-bottom:5px">
	    		<img src="{{ asset('images/clicktocall.png') }}" style="height: 25px;width: 25px; margin-right:10px">LLamanos 
	    	</li>
    	</ul>
	</div>
@stop

@section('js')

<script type="text/javascript">

  // Set up with TOKEN, a string generated server-side
  Twilio.Device.setup("{{$token}}");

  Twilio.Device.ready(function() {
	$('#status-call').text('Ready to start call');
      // Could be called multiple times if network drops and comes back.
      // When the TOKEN allows incoming connections, this is called when
      // the incoming channel is open.
  });

  Twilio.Device.offline(function() {
      // Called on network connection lost.
      $('#status-call').text('Offline');
  });

  Twilio.Device.connect(function (conn) {
      // Called for all new connections
      console.log(conn.status);
      $('#status-call').text("Successfully established call");
  });

  Twilio.Device.disconnect(function (conn) {
      // Called for all disconnections
      console.log(conn.status);
      $('#status-call').text("Call ended");
  });

  Twilio.Device.error(function (e) {
      console.log(e.message + " for " + e.connection);
  });
</script>

@stop
