@if(\Session::get('message'))
<div class="alert alert-info alert-dismissible text-center" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4><strong><i class="fa fa-info-circle"></i></strong> {{ \Session::get('message') }}</h4>
</div>
@endif
