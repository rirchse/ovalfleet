@extends('user')
@section('title', 'Add New Customer')
@section('content')
  
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Invite Naw</h2>

				 <form action="" class="col-md-6">
				  <div class="form-group">
				    <label for="email">Email address:</label>
				    <input type="email" class="form-control" placeholder="Email" id="email">
				  </div>
				  <div class="form-group">
				    <label for="text">Text:</label>
				    <textarea type="password" rows="4" class="form-control" placeholder="Text" id="text"></textarea>
				  </div>
				  
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form> 
			</div>
		</div>
	</div>
@endsection