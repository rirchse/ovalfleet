@extends('admin')
@section('title', 'Create Shipment')
@section('content')

<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create Shipment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipments</a></li>
        <li class="active">Create Shipment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Shipment Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'admin.create.shipment', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                @if($user->user_role != 'Fleet Owner')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('fleet_owner', 'Fleet Owner:', ['class' => 'control-label']) }}
                    <a href="/search/fleet owner/shipment"> Add Fleet Owner</a>
                    <select name="fleet_owner" id="" class="form-control">
                      <option value="">Select Fleet Owner</option>
                      @foreach($fleetowners as $fleetowner)
                      <option value="{{$fleetowner->id}}">{{$fleetowner->account_number.'-'.$fleetowner->first_name.' '.$fleetowner->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                @if($user->user_role != 'Shipper')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('shipper', 'Shipper:', ['class' => 'control-label']) }}<a href="/search/shipper/shipment"> Add Shipper</a>
                    <select name="shipper" id="" class="form-control">
                      <option value="">Select Shipper</option>
                      @foreach($shippers as $shipper)
                      <option value="{{$shipper->id}}">{{$shipper->account_number.'-'.$shipper->first_name.' '.$shipper->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                @if($user->user_role != 'Dispatcher')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('dispatcher', 'Dispatcher: ', ['class' => 'control-label']) }}<a href="/search/dispatcher/shipment"> Add Dispatcher</a>
                    <select name="dispatcher" id="" class="form-control">
                      <option value="">Select Dispatcher [From My Dispatcher]</option>
                      @foreach($dispatchers as $dispatcher)
                      <option value="{{$dispatcher->id}}">{{$dispatcher->account_number.'-'.$dispatcher->first_name.' '.$dispatcher->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('driver', 'Driver Name:', ['class' => 'control-label']) }}<a href="/search/driver/shipment"> Add Driver</a>
                    <select name="driver" id="" class="form-control">
                      <option value="">Select Driver</option>
                      @foreach($drivers as $driver)
                      <option value="{{$driver->id}}">{{$driver->account_number.'-'.$driver->first_name.' '.$driver->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('vehicle', 'Vehicle', ['class' => 'control-label']) }}<a href="/create_vehicle/shipment"> Add Vehicle</a>
                    <select name="vehicle" id="" class="form-control">
                      <option value="">Select vehicle</option>
                      @foreach($vehicles as $vehicle)
                      <option value="{{$vehicle->id}}">{{$vehicle->name_type.'-'.$vehicle->license_plate.' '.$vehicle->make}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                
                <div class="col-md-12">
                  <h4 style="color: #800">Load Information:</h4>
                  <div class="form-group">
                    {{ Form::label('goods_description', 'Description of Goods:', ['class' => 'control-label']) }}
                    {{ Form::textarea('goods_description', null, ['class' => 'form-control','rows'=>'5'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('load_quantity', 'Load Quantity (in Tons):', ['class' => 'control-label']) }}
                    {{ Form::text('load_quantity', null, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('packing_type', 'Packaging type:', ['class' => 'control-label']) }}
                    {{ Form::select('packing_type', [''=>'', 'Boxes in Pallet'=>'Boxes in Pallet','Boxes'=>'Boxes','Open'=>'Open'],null, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    <input type="radio" value="Flammable" name='flame'> Flammable &nbsp;
                    <input type="radio" value="NON-Flammable" name='flame'> NON-Flammable
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('loading_point', 'Loading Point:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_point', null, ['class' => 'form-control', 'placeholder' => 'Enter starting point address or GPS coordinates'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('loading_date', 'Loading Date:', ['class' => 'control-label']) }}
                    {{ Form::date('loading_date', null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-3 bootstrap-timepicker">
                  <div class="form-group">
                    {{ Form::label('loading_time', ' Loading Time:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_time', null, ['class' => 'form-control timepicker'])}}
                  </div>
                </div>
                
                <div class="col-md-6">
                <h4 style="color: #800">Unload Information:</h4>
                  <div class="form-group">
                    {{ Form::label('unload_point', 'Unload Point:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_point', null, ['class' => 'form-control', 'placeholder' => 'Enter destination address or GPS coordinates'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_date', 'Unload Date:', ['class' => 'control-label']) }}
                    {{ Form::date('unload_date', null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_time', 'Unload Complete Time:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_time', null, ['class' => 'form-control timepicker'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('shipment_cost', 'Shipment Cost (in USD):', ['class' => 'control-label']) }}
                    {{ Form::text('shipment_cost', null, ['class' => 'form-control', 'placeholder'=>'$'])}}
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label class="control-label" for="">Google Map Route</label><br>
                    {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default">Google Map</button> --}}
                    <a href="/google_maps" class="btn btn-warning">Google Map</a>
                  </div>
                </div>

              <div class="col-md-12">                
                <div class="form-group">
                  {{ Form::label('details', 'Notes:', ['class' => 'control-label']) }}
                  {{ Form::textarea('details', null, ['class' => 'form-control','rows' => 4 ])}}
                </div>
              </div>
              </div>
             
              <!-- /.box-body -->
            <div class="box-footer">
                {{-- <div class="col-md-2 col-md-offset-8">
                  <a href="/view_shipments" class="btn btn-info pull-right"> Shipment</a>
                </div> --}}
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary pull-right btn-outline-primary"><i class="fa fa-save"></i> Save</button>
                </div>
              </div>
            {!! Form::close() !!}
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->

    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Google Map</h4>
              </div>
              <div class="modal-body">
                <div id="map"></div>
    <div id="right-panel">
    <div>
    <b>Start:</b>
    <select id="start">
      <option value="Halifax, NS">Halifax, NS</option>
      <option value="Boston, MA">Boston, MA</option>
      <option value="New York, NY">New York, NY</option>
      <option value="Miami, FL">Miami, FL</option>
      <option value="Dhaka, Bangladesh">Dhaka, Bangladesh</option>
    </select>
    <br>
    <b>Waypoints:</b> <br>
    <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br>
    <select multiple id="waypoints">
      <option value="montreal, quebec">Montreal, QBC</option>
      <option value="toronto, ont">Toronto, ONT</option>
      <option value="chicago, il">Chicago</option>
      <option value="winnipeg, mb">Winnipeg</option>
      <option value="fargo, nd">Fargo</option>
      <option value="calgary, ab">Calgary</option>
      <option value="spokane, wa">Spokane</option>
    </select>
    <br>
    <b>End:</b>
    <select id="end">
      <option value="Vancouver, BC">Vancouver, BC</option>
      <option value="Seattle, WA">Seattle, WA</option>
      <option value="San Francisco, CA">San Francisco, CA</option>
      <option value="Los Angeles, CA">Los Angeles, CA</option>
      <option value="Rajshahi, Bangladesh">Rajshahi, Bangladesh</option>
    </select>
    <br>
      <input type="submit" id="submit">
    </div>
    <div id="directions-panel"></div>
    </div>
              </div>
              <div class="modal-footer">
                {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> --}}
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
@endsection

@section('scripts')
<script type="text/javascript">

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    </script>

    <!-- this script for google maps -->
    <script>
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 41.85, lng: -87.65}
        });
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
          if (checkboxArray.options[i].selected) {
            waypts.push({
              location: checkboxArray[i].value,
              stopover: true
            });
          }
        }

        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsrrM_cjLyueDaFj3qvLwU0KF7ME2TIg&callback=initMap">
    </script>
@endsection