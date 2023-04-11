@extends('admin')
@section('title', 'Home')
@section('content')

<?php
$fleetowners = $drivers = $dispatchers = $shippers = 0;
foreach($users as $user){
  if($user->user_role == 'Fleet Owner'){
    $fleetowners++;
  }elseif($user->user_role == 'Driver'){
    $drivers++;
  }elseif($user->user_role == 'Dispatcher'){
    $dispatchers++;
  }elseif($user->user_role == 'Shipper'){
    $shippers++;
  }
}

//shipments
$init_ships = $picked_ships = $trans_ships = $deliv_ships = $compl_ships = $cancel_ships = $earning = $receivable = 0;
foreach($shipments as $shipment){
  if($shipment->status == 0){
    $init_ships ++;
  }elseif($shipment->status == 1){
    $picked_ships ++;
  }elseif ($shipment->status == 2) {
    $trans_ships ++;
  }elseif ($shipment->status == 3) {
    $deliv_ships ++;
  }elseif ($shipment->status == 4) {
    $compl_ships ++;
  }elseif ($shipment->status == 5) {
    $cancel_ships ++;
  }
}

$total_ships = $init_ships + $picked_ships = $trans_ships + $deliv_ships + $compl_ships + $cancel_ships;

$vehicles_onroad = $vehicles_offroad = 0;
foreach($vehicles as $vehicle){
  if($vehicle->vehicle_status == 'Active'){
    $vehicles_onroad++;
  }else{
    $vehicles_offroad++;
  }
}

?>

<?php
  $actusers = $inactusers = $earnings = $dates = '';
  $total_earnings = $total_actusers = $total_inactusers = 0;
  for($rs = 6; $rs >= 0; $rs--){
    $payments = DB::table('payments')->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->sum('paid_amount');
    $total_earnings += $payments;
    $earnings .= $payments.', ';

    $users = count(DB::table('users')->where('status', 1)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $total_actusers += $users;
    $actusers .= $users.', ';

    $users = count(DB::table('users')->where('status', 0)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $total_inactusers += $users;
    $inactusers .= $users.', ';

    $dates .= "'".date('M y', strtotime('-'.$rs.' month'))."', ";
  }

// dd($inactusers);

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{Auth::guard('admin')->user()->user_role_name}}
        <small> Dashboard</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner item-status">
              <h3 title="Total Shipment">{{$total_ships}}</h3>
              <p>Initiated Shipments: {{$init_ships}}<br>Ready for pick up: {{$picked_ships}}<br> In transit Shipments: {{$trans_ships}}<br> Delivered Shipments: {{$deliv_ships}}<br>Completed Shipments: {{$compl_ships}}<br>Cancelled Shipments: {{$cancel_ships}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/admin/view_shipments" class="small-box-footer">Shipments <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner item-status">
              <h3 title="Total Active Users">{{$fleetowners+$drivers+$dispatchers+$shippers}}</h3>
              <p>Active Fleet Owners: {{$fleetowners}}<br>Active Dispatchers: {{$dispatchers}}<br>Active Shippers: {{$shippers}}<br>Active Drivers: {{$drivers}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="/admin/view_users/active" class="small-box-footer">View Users <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner item-status">
              <h3 title="Total Vehicles">{{$vehicles_onroad+$vehicles_offroad}}</h3>
              <p>Vehicles on Road: {{$vehicles_onroad}}<br>Vehicles off the Road: {{$vehicles_offroad}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/admin/view_vehicles" class="small-box-footer">View Vehicles <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner item-status">
              <h3 title="Total Revenue">${{number_format($total_earnings, 2)}}</h3>
              <p>Up to date Revenue: ${{number_format($total_earnings, 2)}}
                {{-- <br>Accounts Receivable: ${{$receivable}} --}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Financial Details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> <!-- ./col -->
      </div> <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Revenue (${{number_format($total_earnings, 2)}})</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="areaChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- DONUT CHART -->
          {{-- <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Donut Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box --> --}}

        </div>
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Users ({{$total_inactusers+$total_actusers}}) <span class="text-aqua">Verified ({{$total_actusers}})</span>, <span class="text-yellow">Unverified ({{$total_inactusers}})</span></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- BAR CHART -->
          {{-- <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box --> --}}

        </div> <!-- /.col (RIGHT) -->
      </div>
    </section> <!-- /.content -->

@endsection

@section('scripts')
<script>
  $(function () {
  // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : [<?php echo $dates;?>],
      datasets: [
        {
          label               : 'Earnings',
          fillColor           : '#9ee',
          strokeColor         : '#00c0ef',
          pointColor          : '#00c0ef',
          pointStrokeColor    : '#00c0ef',
          pointHighlightFill  : '#00a65a',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $earnings; ?>]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : true,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 3,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    //-------------
    //- LINE CHART -
    //--------------

    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    var lineChartData = {
      labels  : [<?php echo $dates;?>],
      datasets: [
        {
          label               : 'Verified Users',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : '#00c0ef',
          pointColor          : '#00c0ef',
          pointStrokeColor    : '#00c0ef',
          pointHighlightFill  : '#00a65a',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $actusers; ?>]
        },
        {
          label               : 'Unverified Users',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : '#f39c12',
          pointColor          : '#f39c12',
          pointStrokeColor    : '#f39c12',
          pointHighlightFill  : '#dd4b39',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $inactusers; ?>]
        }
      ]
    }
    lineChartOptions.datasetFill = false
    lineChart.Line(lineChartData, lineChartOptions)
  })
</script>

@endsection