<style type="text/css">
	.alert{max-width:800px; width: 100%; z-index:9999;display: block;margin-top: 10px;margin-bottom: 0}
	.alert ul{list-style:none;padding-left: 15px}
</style>

@if(Session::has('success'))
	<div class="alert alert-success alert-dismissible">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
	  <h4><i class="icon fa fa-check"></i> Success:</h4>
	  {!! Session::get('success') !!}
	</div>
@endif

@if(Session::has('error'))

	<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
    <h4><i class="icon fa fa-warning"></i> Error:</h4>
    {!! Session::get('error') !!}
  </div>

@endif

@if(count($errors) > 0)

	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
		<h4><i class="icon fa fa-danger"></i> Errors:</h4>
		<ul>
			@foreach($errors->all() as $error)
			<li>{!! $error !!}</li>
			@endforeach
		</ul>
	</div>

@endif