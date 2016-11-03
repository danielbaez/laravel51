@extends('panel.template')

@section('content')
	<div style="display:none">{{ date_default_timezone_set('America/Lima') }}</div>
	@include('partials.messages')
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

		<h4>Calls Comparison</h4>
		<br>
		<div class="col hidden-xs col-sm-3 text-center">
			<p style="padding-top:6px"><strong>Busqueda por Nombre o email:</strong></p>
		</div>
		<div class="col col-xs-8 col-sm-6 text-center">
			<input class="form-control" type="text" name="search" placeholder="Ingrese nombre o email">
		</div>
		<div class="col col-xs-4 col-sm-3 text-center">
			<button class="btn btn-primary  btn-search">Buscar</button>
		</div>
	</div>
	<br><br>

	<div class="table-responsive table-calls">
	  <table class="table table-striped table-hover">
	  	<thead>
	  	  <tr><th class="text-center">ID</th><th class="text-center">Name / Email</th><th class="text-center">Fecha</th><th class="text-center">Celular</th><th class="text-center">Solicitar</th><th class="text-center">Llamar</th><th class="text-center">Prima</th><th class="text-center">Compañia</th><th class="text-center">Operación</th></tr>
	  	</thead>
	  	<tbody>
	  		@foreach($calls as $c)
	  			<?php $request = ($c->request); ?>
	  			<tr data-idcall="{{$c->id}}">
	  				<td class="text-center">
	  					<p class="table-colum-id">{{ $c->id }}</p>
	  					<?php if($c->cant > 1){
	  					?>
	  						<button class="btn entriesMoreClient" style="color:white;background:teal; font-size:15px" data-id="{{$c->id}}" data-email="{{$c->e}}">{{$c->cant}} <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
	  					<?php
	  					}
	  					?>
	  				</td>
	  				<td>{{ $c->name }}<br>{{ $c->e }}</td>
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
							    <select class="form-control" name="producto" id="select-producto">
								  <option value="">Seleccione un Producto</option>
								  <option value="5">Rimac Web</option>
								  <option value="1">Exito</option>
								</select>
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
						    <label class="radio-inline"><input type="radio" checked name="gps">Si</label>
								<label class="radio-inline"><input type="radio" name="gps">No</label>
		          </div>
		          <div class="form-group div-email col-xs-12 col-sm-6 col-md-7">
		          	<label for="email">Email</label><br>
						    <input type='email' class="form-control" name="email" />
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

@stop