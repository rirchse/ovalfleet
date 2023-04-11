<!DOCTYPE html>
<html lang="en">
<head>
    
    @include('partials.styles')

    @yield('stylesheets')

</head>

<body class="hold-transition skin-blue sidebar-mini">	
		
		<div class="wrapper">

			@include('users.header')
			<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

				@yield('content')

			</div>
      <!-- /.content-wrapper -->

			@include('users.footer')

		</div><!-- /wrapper -->	

	<!--   Core JS Files   -->
	@include('partials.scripts')

	@yield('scripts')

	<script type="text/javascript">
		$(document).ready(function() {
			// Javascript method's body can be found in assets/js/demos.js
			// demo.initDashboardPageCharts();
			// demo.initVectorMap();
		});
	</script>

	<script type="text/javascript">
    $(document).ready(function() {
        // md.initSliders()
        // demo.initFormExtendedDatetimepickers();
    });


    $('.datepicker').attr('placeholder', 'MM/DD/YYYY');
    $('.datepicker').datepicker({
    	format: 'mm/dd/yyyy',
	    autoclose: true
	  })
    </script>

	<!-- for text editor-->
    <script>
        $('.textarea').wysihtml5({
          toolbar: {
            "link": false,
            "image": false
          }
        });
    </script>



  <script type="text/javascript">
  function AlertS(){
	  $.ajax({
	    type: 'GET', //THIS NEEDS TO BE GET
	    url: '/notification/0/edit',
	    success: function (data) {
	      // var obj = JSON.parse(JSON.stringify(data));
	      var notifications = "";

	      $.each(data, function (key, val) {
	         notifications += '<li><a href="/notification/'+val.id+'">'+val.title+'</a></li>';
	      });

	      if(notifications != ""){
	      	$("#Notifications").html(notifications);
	      	$(".alertCounter").html(data.length);
	      }else{
	      	$("#Notifications").html('');
	      }
	    },
	    error: function(data) {
	      return 'data error';
	    }
	  });
	}

	AlertS();
	function call1(){
		setTimeout(function(){ AlertS(); call2();}, 60000);
	}

	function call2(){
		setTimeout(function(){ AlertS(); call1(); }, 60000);
	}

	call1();
	
  </script>
</body>
</html>