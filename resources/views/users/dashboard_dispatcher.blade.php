<?php
$user = Auth::user();
$totalships = 0;
$initiated = $pickup = $intransit = $delivered = $completed = $cancelled = $act_ships = $completed_shipment = $receivable = $earnings = 0;
foreach(DB::table('shipments')->where('dispatcher_id', $user->id)->get() as $shipment){
  if($shipment->status == 0){
    $initiated ++;
    $receivable += $shipment->dispatcher_commission;
  } elseif($shipment->status == 1){
    $pickup ++;
    $receivable += $shipment->dispatcher_commission;
  } elseif($shipment->status == 2){
    $intransit ++;
    $receivable += $shipment->dispatcher_commission;
  } elseif($shipment->status == 3){
    $delivered ++;
    $receivable += $shipment->dispatcher_commission;
  } elseif($shipment->status == 4) {
    $completed ++;
    $earnings += $shipment->dispatcher_commission;
  } elseif($shipment->status == 5){
    $cancelled ++;
  }

  $totalships = $initiated + $pickup + $intransit + $delivered + $completed;
}

//get all relations
$fleetowners = DB::table('relations')->leftJoin('users', 'users.id', 'relations.owner_id')->where('users.user_role', 'Fleet Owner')->where('relations.user_id', $user->id)->select('users.id')->get();
?>
<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner item-status">
              <h3 title="Total Shipments">{{$totalships}}</h3>
              <p>Initiated Shipments: {{$initiated}}<br>Ready for pick up: {{$pickup}}<br> In transit Shipments: {{$intransit}}<br> Delivered Shipments: {{$delivered}}<br>Completed Shipments: {{$completed}}<br>Cancelled Shipments: {{$cancelled}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/view_shipments" class="small-box-footer">Shipments <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner item-status">
              <h3 title="Total Active Users">{{count($fleetowners)}}</h3>
              <p>Active Fleet Owners: {{count($fleetowners)}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/my/fleet owners" class="small-box-footer">My Fleet Owners <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner item-status">
              <h3 title="Total Referrals">{{count($referrals)}}</h3>
              <p>Verified Referrals: {{$act_referrals}}<br>Unverified Referrals: {{$inact_referrals}} <br> Pending Referrals: {{count($pending_referrals)}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/my_referrals" class="small-box-footer">My Referrals <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner item-status">
              <h3 title="Total Revenue">${{number_format($receivable + $earnings, 2)}}</h3>
              <p>Total Commissions YTD: ${{number_format($earnings, 2)}}<br>Pending Commissions: ${{number_format($receivable, 2)}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/financial_details" class="small-box-footer">Financial Details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> <!-- ./col -->
      </div> <!-- /.row -->

<?php
  $completed = $initiated = $revenues = $receivables = $dates = '';
  $compcount = $initcount = $total_revenue = $total_receive = 0;
  for($rs = 5; $rs >= 0; $rs--){
    $revenue = DB::table('shipments')->where('dispatcher_id', $user->id)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->where('status', 4)->sum('dispatcher_commission');
    $total_revenue += $revenue;
    $revenues .= $revenue.', ';

    $receive = DB::table('shipments')->where('dispatcher_id', $user->id)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->whereIn('status', [0,1,2,3])->sum('dispatcher_commission');
    $total_receive += $receive;
    $receivables .= $receive.', ';

    $complete = count(DB::table('shipments')->where('dispatcher_id', $user->id)->where('status', 4)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $compcount += $complete;
    $completed .= $complete.', ';

    $init = count(DB::table('shipments')->where('dispatcher_id', $user->id)->whereIn('status', [0,1,2,3])->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $initcount += $init;
    $initiated .= $init.', ';

    $dates .= "'".date('M y', strtotime('-'.$rs.' month'))."', ";
  }
?>


      <!-- Main row -->
      <div class="row"><!-- Left col -->
        <section class="connectedSortable">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><span class="text-aqua">Total Commissions YTD (${{number_format($total_revenue, 2)}})</span></h3>

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
              </div> <!-- /.box-body -->
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"> <span style="color:#666"> Active Shipments ({{$initcount}})</span>  <span class="text-aqua"> Completed Shipments ({{$compcount}})</span></h3>

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
              </div> <!-- /.box-body -->
            </div> <!-- /.box -->
          </div>

        </section> <!-- /.Left col -->
      </div><!-- /.row (main row) -->


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
          label               : 'Revenue',
          fillColor           : '#9ee',
          strokeColor         : '#00c0ef',
          pointColor          : '#00c0ef',
          pointStrokeColor    : '#00c0ef',
          pointHighlightFill  : '#00a65a',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $revenues; ?>]
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
          label               : 'Shipmet Initiated',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : '#00c0ef',
          pointColor          : '#00c0ef',
          pointStrokeColor    : '#00c0ef',
          pointHighlightFill  : '#00a65a',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $completed; ?>]
        },
        {
          label               : 'Shipment Completed',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : '#A9A9A9',
          pointColor          : '#A9A9A9',
          pointStrokeColor    : '#f39c12',
          pointHighlightFill  : '#dd4b39',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $initiated; ?>]
        }
      ]
    }
    lineChartOptions.datasetFill = false
    lineChart.Line(lineChartData, lineChartOptions)
  })
</script>
@endsection