<!DOCTYPE html>
<html lang="en">
<head>
    
    @include('partials.styles')

    @yield('stylesheets')

</head>

<body class="hold-transition skin-blue sidebar-mini">

	<div class="wrapper">
		@include('admins.header')
		<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

			@yield('content')

			</div>
      <!-- /.content-wrapper -->

		@include('admins.footer')
	</div><!-- /wrapper -->	

	<!--   Core JS Files   -->
	@include('partials.scripts')

	@yield('scripts')
	<script type="text/javascript">
    $('.datepicker').attr('placeholder', 'MM/DD/YYYY');
    $('.datepicker').datepicker({
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
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [50, 25, 50, 100, -1],
                [50, 25, 50, 100, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>

<script type="text/javascript">
  function AlertS(){
      $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/admin/notification/0/edit',
        success: function (data) {
          // var obj = JSON.parse(JSON.stringify(data));
          // console.log(data);
          var notifications = "";
          $.each(data, function (key, val) {
             notifications += '<li><a href="/admin/notification/'+val.id+'">'+val.title+'</a></li>';
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