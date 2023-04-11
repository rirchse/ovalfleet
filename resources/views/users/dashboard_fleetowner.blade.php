<?php
$user = Auth::user();
$totalships = 0;
$initiated = $pickup = $intransit = $delivered = $completed = $cancelled = $receivable = $earning = $commission_paid = $pending_commission = 0;
foreach(DB::table('shipments')->where('fleetowner_id', $user->id)->get() as $shipment){
  if($shipment->status == 0){
    $initiated ++;
    $receivable += $shipment->shipment_cost+$shipment->extra_charge;
  } else if($shipment->status == 1) {
    $pickup ++;
    $receivable += $shipment->shipment_cost+$shipment->extra_charge;
  }else if($shipment->status == 2) {
    $intransit ++;
    $receivable += $shipment->shipment_cost+$shipment->extra_charge;
    $pending_commission += $shipment->driver_commission+$shipment->dispatcher_commission;
  }else if($shipment->status == 3) {
    $delivered ++;
    $receivable += $shipment->shipment_cost+$shipment->extra_charge;
    $pending_commission += $shipment->driver_commission+$shipment->dispatcher_commission;
  }else if($shipment->status == 4) {
    $completed ++;
    $earning += $shipment->shipment_cost+$shipment->extra_charge;
    $commission_paid += $shipment->driver_commission+$shipment->dispatcher_commission;
  }else if($shipment->status == 5) {
    $cancelled ++;
  }
}
$totalships = $initiated + $pickup + $intransit + $delivered + $completed + $cancelled;
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
              <h3 title="Total Active Users">{{$dispatchers+$shippers+$drivers}}</h3>
              <p>Active Dispatchers: {{$dispatchers}}<br>Active Shippers: {{$shippers}}<br>Active Drivers: {{$drivers}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/view_relation_users" class="small-box-footer">User Details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner item-status">
              <h3 title="Total Vehicles">{{count($vehicles)}}</h3>
              <p>Vehicles on Road: {{$actv = count(App\Shipment::whereNotNull('vehicle_id')->where('status', 2)->where('fleetowner_id', $user->id)->get())}}<br>Vehicles off the Road: {{count($vehicles)-$actv}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/view_vehicles" class="small-box-footer">Vehicle Details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner item-status">
              <h3 title="Total">${{number_format($receivable+$earning, 2)}}</h3>
              <p>Total Revenue YTD: ${{number_format($earning, 2)}}<br> Accounts Receivable: ${{number_format($receivable, 2)}}<br>Total Commission Payout YTD: ${{number_format($commission_paid, 2)}}<br>Pending Commissions: ${{number_format($pending_commission, 2)}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/financial_reports" class="small-box-footer">Financial Details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
      </div><!-- /.row -->

<?php
  $completed = $initiated = $revenues = $receivables = $dates = '';
  $compcount = $initcount = $total_revenue = $total_receive = 0;
  for($rs = 5; $rs >= 0; $rs--){
    $revenue = DB::table('shipments')->where('fleetowner_id', $user->id)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->where('status', 4)->sum('shipment_cost');
    $total_revenue += $revenue;
    $revenues .= $revenue.', ';

    $receive = DB::table('shipments')->where('fleetowner_id', $user->id)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->whereIn('status', [0,1,2,3])->get();
    $total_receive += $receive->sum('shipment_cost');
    $total_receive += $receive->sum('extra_charge');
    $receivables .= $receive->sum('shipment_cost')+$receive->sum('extra_charge').', ';

    $complete = count(DB::table('shipments')->where('fleetowner_id', $user->id)->where('status', 4)->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $compcount += $complete;
    $completed .= $complete.', ';

    $init = count(DB::table('shipments')->where('fleetowner_id', $user->id)->whereIn('status', [0,1,2,3])->where('created_at', 'like', '%'.date('Y-m', strtotime('-'.$rs.' month')).'%')->get());
    $initcount += $init;
    $initiated .= $init.', ';

    $dates .= "'".date('M y', strtotime('-'.$rs.' month'))."', ";
  }
?>


      <!-- Main row -->
      <div class="row"><!-- Left col -->
        <section class=" connectedSortable">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><span style="color:#666">Accounts Receivable (${{number_format($total_receive, 2)}})</span> <span class="text-aqua">Revenue (${{number_format($total_revenue, 2)}})</span></h3>

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
        },
        {
          label               : 'Receivable',
          fillColor           : '#D3D3D3',
          strokeColor         : '#A9A9A9',
          pointColor          : '#A9A9A9',
          pointStrokeColor    : '#A9A9A9',
          pointHighlightFill  : '#00a65a',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $receivables; ?>]
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