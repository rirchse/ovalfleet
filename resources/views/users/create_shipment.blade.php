@extends('user')
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
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Shipment Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'create.shipment', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                @if($user->user_role != 'Fleet Owner')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('fleet_owner', 'Fleet Owner:', ['class' => 'control-label']) }}
                    @if($user->user_role != 'Dispatcher')
                    <a href="/search/fleet owner/shipment"> Add Fleet Owner</a>
                    @endif
                    <select name="fleet_owner" id="FleetOwner" class="form-control">
                      <option value="">Select Fleet Owner</option>
                      @foreach($fleetowners as $fleetowner)
                      <option value="{{$fleetowner->id}}">{{$fleetowner->account_number.' '.$fleetowner->first_name.' '.$fleetowner->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                @if($user->user_role != 'Shipper')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('shipper', 'Shipper:', ['class' => 'control-label']) }}
                    @if($user->user_role != 'Dispatcher')
                    <a href="/search/shipper/shipment"> Add Shipper</a>
                    @endif
                    <select name="shipper" id="shipper" class="form-control">
                      <option value="">Select Shipper</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($shippers as $shipper)
                      <option value="{{$shipper->id}}">{{$shipper->account_number.' '.$shipper->first_name.' '.$shipper->last_name}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('users')->leftJoin('relations', 'relations.user_id', 'users.id')->where('relations.owner_id', $fleetowner->id)->where('users.user_role', 'Shipper')->select('users.*')->get() as $shipper)
                        <option value="{{$shipper->id}}" class="owner" ownerid="{{$fleetowner->id}}">{{$shipper->account_number.'-'.$shipper->first_name.' '.$shipper->last_name}}</option>
                        @endforeach
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                @endif
                @if($user->user_role != 'Dispatcher')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('dispatcher', 'Dispatcher: ', ['class' => 'control-label']) }}
                    <a href="/search/dispatcher/shipment"> Add Dispatcher</a>
                    <select name="dispatcher" id="dispatcher" class="form-control">
                      <option value="">Select Dispatcher [From My Dispatcher]</option>
                      @foreach($dispatchers as $dispatcher)
                      <option value="{{$dispatcher->id}}">{{$dispatcher->account_number.' '.$dispatcher->first_name.' '.$dispatcher->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('driver', 'Driver Name:', ['class' => 'control-label']) }}
                    @if($user->user_role != 'Dispatcher')
                    <a href="/search/driver/shipment"> Add Driver</a>
                    @endif
                    <select name="driver" id="driver" class="form-control">
                      <option value="">Select Driver</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($drivers as $driver)
                      <option value="{{$driver->id}}">{{$driver->account_number.' '.$driver->first_name.' '.$driver->last_name}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('users')->leftJoin('relations', 'relations.user_id', 'users.id')->where('relations.owner_id', $fleetowner->id)->where('users.user_role', 'Driver')->select('users.*')->get() as $driver)
                        <option value="{{$driver->id}}" class="owner" ownerid="{{$fleetowner->id}}">{{$driver->account_number.'-'.$driver->first_name.' '.$driver->last_name}}</option>
                        @endforeach
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('vehicle', 'Vehicle', ['class' => 'control-label']) }}
                    @if($user->user_role != 'Dispatcher')
                    <a href="/create_vehicle/shipment"> Add Vehicle</a>
                    @endif
                    <select name="vehicle" id="vehicle" class="form-control">
                      <option value="">Select Vehicle</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($vehicles as $vehicle)
                      <option value="{{$vehicle->id}}">{{$vehicle->name_type.' '.$vehicle->license_plate.' '.$vehicle->make}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('vehicles')->where('user_id', $fleetowner->id)->where('vehicle_status', 'Active')->get() as $vehicle)
                        <option value="{{$vehicle->id}}" class="owner" ownerid="{{$fleetowner->id}}">{{$vehicle->name_type.'-'.$vehicle->license_plate.' '.$vehicle->make}}</option>
                        @endforeach
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <h4 style="color: #800">Load Information:</h4>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('load_quantity', 'Load Quantity(tons):', ['class' => 'control-label']) }}
                    {{ Form::text('load_quantity', null, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('packing_type', 'Packaging Type:', ['class' => 'control-label']) }}
                    {{ Form::select('packing_type', [''=>'', 'Boxes in Pallet'=>'Boxes in Pallet','Boxes'=>'Boxes','Open'=>'Open'],null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" style="min-height:55px">
                    {{ Form::label('goods_type', 'Goods Type:', ['class' => 'control-label']) }}<br>
                    <input type="radio" value="Flammable" name='flame'> Flammable &nbsp;
                    <input type="radio" value="Non-Flammable" name='flame'> Non-Flammable
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('shipment_cost', 'Shipment Cost(USD):', ['class' => 'control-label']) }}
                    {{ Form::text('shipment_cost', null, ['class' => 'form-control', 'placeholder'=>'$'])}}
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('goods_description', 'Description of Goods:', ['class' => 'control-label']) }}
                    {{ Form::textarea('goods_description', null, ['class' => 'form-control','rows'=>2])}}
                  </div>
                </div>
                {{-- <div class="col-md-6">
                  <div class="form-group">
                    <label for='dispatcher_commission' class='control-label'> Dispatcher Commission: <input type="radio" name="discom" id="dispfix"> Fixed &nbsp; / &nbsp; <input type="radio" name="discom" id="dispcom"> Percentage</label>
                    {{ Form::text('dispatcher_commission', null, ['class' => 'form-control', 'style'=>'max-width:70%;float:left', 'placeholder'=>'Fixed amount', 'id'=> 'dispvalue']) }}
                    <input type="text" name="dispatcher_percent" id="dispercent" class="form-control" style="max-width:30%" placeholder="Percentage %">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for='driver_commission' class='control-label'> Driver Commission: <input type="radio" name="drivecom" id="drivfix"> Fixed &nbsp; / &nbsp; <input type="radio" name="drivecom" id="drivcom"> Percentage</label>
                    {{ Form::text('driver_commission', null, ['class' => 'form-control', 'style'=>'max-width:70%;float:left', 'placeholder'=>'Fixed amount', 'id'=>'drivalue']) }}
                    <input type="text" name="driver_percent" id="dripercent" class="form-control" style="max-width:30%" placeholder="Percentage %">
                  </div>
                </div> --}}
                <div class="clearfix"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('loading_point', 'Origin (loading point):', ['class' => 'control-label']) }}
                    {{ Form::text('loading_point', null, ['class' => 'form-control', 'placeholder' => 'Enter starting point address or GPS coordinates'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('loading_date', 'Loading Date:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_date', null, ['class' => 'form-control datepicker'])}}
                  </div>
                </div>
                <div class="col-md-3 bootstrap-timepicker">
                  <div class="form-group">
                    {{ Form::label('loading_time', ' Loading Time:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_time', null, ['class' => 'form-control timepicker'])}}
                  </div>
                </div>
                <div class="col-md-12">
                  <h4 style="color: #800">Unload Information:</h4>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('unload_point', 'Destination (unload point):', ['class' => 'control-label']) }}
                    {{ Form::text('unload_point', null, ['class' => 'form-control', 'placeholder' => 'Enter destination address or GPS coordinates'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('details', 'Notes:', ['class' => 'control-label']) }}
                    {{ Form::textarea('details', null, ['class' => 'form-control','rows' => 2 ])}}
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_date', 'Unload Date:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_date', null, ['class' => 'form-control datepicker', 'disabled' => ''])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_time', 'Unload Complete Time:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_time', null, ['class' => 'form-control timepicker', 'disabled' => ''])}}
                  </div>
                </div> --}}
                <div class="col-md-6">
                </div>
                <div class="col-md-6 no-padding">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label" for="">Google Map Route</label><br>
                      @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                      <button type="button" class="btn btn-info btn-block" onclick="calcRoute()"><i class="fa fa-map-marker"></i> Get Route Information</button>
                      @else
                      <a class="btn btn-info btn-block" href="#" onclick="GetFreeRoute()"> Get Route Information</a>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {{ Form::label('distance', 'Approximate Distance (miles):', ['class' => 'control-label']) }}
                      {{ Form::text('distance', null, ['class' => 'form-control', 'readonly'=>''])}}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {{ Form::label('duration', 'Estimated Duration:', ['class' => 'control-label']) }}
                      {{ Form::text('duration', null, ['class' => 'form-control', 'readonly'=>''])}}
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right btn-outline-primary"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div>
                <div class="col-md-12"><br><br>
                  @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
                  <div id="googleMap"></div>
                  @endif
                </div>
              </div> <!-- /.box-body -->
            {!! Form::close() !!}
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsrrM_cjLyueDaFj3qvLwU0KF7ME2TIg&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--script src="/js/jquery-3.1.1.min.js"></script-->
    <script src="/js/map.js"></script>

@endsection

@section('scripts')
<script type="text/javascript">

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    </script>


<!-- show values according to the fleeowner -->
    <script type="text/javascript">
    var owner = document.getElementsByClassName('owner');
    var FleetOwner = document.getElementById('FleetOwner');    
    FleetOwner.addEventListener('change', change);
    function change(){

      // document.getElementById('dispacher').selectedIndex = 'Select Dispatcher';
      document.getElementById('shipper').selectedIndex = 'Select Shipper';
      document.getElementById('driver').selectedIndex = 'Select Driver';
      document.getElementById('vehicle').selectedIndex = 'Select Vehicle';

      for(var r = 0; owner.length > r; r++){
        if(FleetOwner.value == owner[r].getAttribute('ownerid')){
          owner[r].style.display = 'block';
        }else{
          owner[r].style.display = 'none';
        }
      }
    }
    change();
    </script>
    
    <!-- dispacher and driver commision calculation-->
    <script type="text/javascript">
    var shipment_cost = document.getElementById('shipment_cost');
    var dispfix       = document.getElementById('dispfix');
    var dispcom       = document.getElementById('dispcom');
    var drivfix       = document.getElementById('drivfix');
    var drivcom       = document.getElementById('drivcom');
    var dispvalue     = document.getElementById('dispvalue');
    var drivalue      = document.getElementById('drivalue');
    var dispercent    = document.getElementById('dispercent');
    var dripercent    = document.getElementById('dripercent');

    dispfix.addEventListener('change', function(){
      dispvalue.focus();
    });
    dispcom.addEventListener('change', function(){
      dispercent.focus();
    });
    drivfix.addEventListener('change', function(){
      drivalue.focus();
    });
    drivcom.addEventListener('change', function(){
      dripercent.focus();
    });

    dispercent.addEventListener('keyup', function(){
      dispvalue.value = parseFloat(shipment_cost.value*dispercent.value/100).toFixed(2);
    });

    dripercent.addEventListener('keyup', function(){
      drivalue.value = parseFloat(shipment_cost.value*dripercent.value/100).toFixed(2);
    });

    dispvalue.addEventListener('keyup', function(){
      dispercent.value = parseFloat(dispvalue.value*100/shipment_cost.value).toFixed(2);
    });

    drivalue.addEventListener('keyup', function(){
      dripercent.value = parseFloat(drivalue.value*100/shipment_cost.value).toFixed(2);
    });

    </script>
@endsection