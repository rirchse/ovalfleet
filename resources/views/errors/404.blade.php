<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 page not found!</title>
  @include('partials.styles')
</head>
<body>
  <div class="row">
    <div class="container-fluid" style="background:#3c8dbc;min-height:60px">
      <a href="/" style="margin-left:50px">
      <img src="/img/logo.png" alt="logo" width="250">
    </a>
    </div>
  </div>

    <div class="row">
    	<div class="" style="background:#fff; text-align:center;margin-top:5%">
        <div class="">
          <br><br>
          <div style="text-align:center;max-width:250px; margin:0 auto">
            <img src="/img/opps.png" alt="" class="img-responsive">
          </div>
          <br>
        	{{-- <h1 style="font-size:60px">404</h1> --}}
          <h1> The page you requested cannot be found.</h1>
        	<h3 class="btn btn-default" onclick="window.history.back();">Back to Previous Page</h3>
            <h2>{{ $exception->getMessage() }}</h2>
        </div>
       </div>
    </div>

    <div class="row">
    <div class="container-fluid" style="background:#3c8dbc;min-height:60px; position:fixed; bottom:0;left:0;right:0">
      
    </div>
  </div>
@include('partials.scripts')
</body>
</html>