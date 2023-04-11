<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    
    @include('partials.home_styles')

    @yield('stylesheets')
    {!! htmlScriptTagJsApi() !!}

</head>

<body>

	@include('homes.header')

		@yield('content')

	@include('homes.footer')

	<!--   Core JS Files   -->
	@include('partials.home_scripts')

	@yield('scripts')

	<script type="text/javascript">
    $().ready(function() {
    	demo.checkFullPageBackgroundImage();
    	setTimeout(function() {
    		// after 1000 ms we add the class animated to the login/register card
    		$('.card').removeClass('card-hidden');
    	}, 700)
    });
  </script>

</body>
</html>