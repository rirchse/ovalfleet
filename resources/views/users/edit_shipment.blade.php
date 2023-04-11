@extends('user')
@section('title', 'Update Shipment')
@section('content')
<?php $user = Auth::user(); ?>
<style type="text/css">
  .wysihtml5-toolbar{display: none!important;}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Shipment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipments</a></li>
        <li class="active">Update Shipment</li>
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
              <h3 style="color: #800" class="box-title">Update Shipment Information:</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/shipment/{{$shipment->id}}/details" title="Shipment Details" class="label label-info"><i class="fa fa-file-text"></i></a>
              <a href="/view_shipments" title="View All Shipments" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <div class="clearfix"></div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($shipment, ['route' => ['update.shipment', $shipment->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                @if($user->user_role != 'Fleet Owner')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('fleet_owner', 'Fleet Owner:', ['class' => 'control-label']) }}
                    <select name="fleet_owner" id="FleetOwner" class="form-control">
                      <option value="">Select Fleet Owner</option>
                      @foreach($fleetowners as $fleetowner)
                      <option value="{{$fleetowner->id}}" {{$fleetowner->id == $shipment->fleetowner_id?'selected':''}}>{{$fleetowner->account_number.' '.$fleetowner->first_name.' '.$fleetowner->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                @if($user->user_role != 'Shipper')
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('shipper', 'Shipper:', ['class' => 'control-label']) }}
                    <a href="/create_user/shipper/shipment"> Add Shipper</a>
                    <select name="shipper" id="shipper" class="form-control">
                      <option value="">Select Shipper</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($shippers as $shipper)
                      <option value="{{$shipper->id}}" {{$shipper->id == $shipment->shipper_id?'selected':''}}>{{$shipper->account_number.' '.$shipper->first_name.' '.$shipper->last_name}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('users')->leftJoin('relations', 'relations.user_id', 'users.id')->where('relations.owner_id', $fleetowner->id)->where('users.user_role', 'Shipper')->select('users.*')->get() as $shipper)
                        <option value="{{$shipper->id}}" class="owner" ownerid="{{$fleetowner->id}}" {{$shipper->id == $shipment->shipper_id?'selected':''}}>{{$shipper->account_number.'-'.$shipper->first_name.' '.$shipper->last_name}}</option>
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
                    {{ Form::label('dispatcher', 'Dispatcher: ', ['class' => 'control-label']) }}<a href="/create_user/dispatcher/shipment"> Add Dispatcher</a>
                    <select name="dispatcher" id="dispatcher" class="form-control">
                      <option value="">Select Dispatcher</option>
                      @foreach($dispatchers as $dispatcher)
                      <option value="{{$dispatcher->id}}" {{$dispatcher->id == $shipment->dispatcher_id?'selected':''}}>{{$dispatcher->account_number.' '.$dispatcher->first_name.' '.$dispatcher->last_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('driver', 'Driver Name:', ['class' => 'control-label']) }}<a href="/create_user/driver/shipment"> Add Driver</a>
                    <select name="driver" id="driver" class="form-control">
                      <option value="">Select Driver</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($drivers as $driver)
                      <option value="{{$driver->id}}" {{$driver->id == $shipment->driver_id?'selected':''}}>{{$driver->account_number.' '.$driver->first_name.' '.$driver->last_name}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('users')->leftJoin('relations', 'relations.user_id', 'users.id')->where('relations.owner_id', $fleetowner->id)->where('users.user_role', 'Driver')->select('users.*')->get() as $driver)
                        <option value="{{$driver->id}}" class="owner" ownerid="{{$fleetowner->id}}" {{$driver->id == $shipment->driver_id?'selected':''}}>{{$driver->account_number.'-'.$driver->first_name.' '.$driver->last_name}}</option>
                        @endforeach
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('vehicle', 'Vehicle', ['class' => 'control-label']) }}<a href="/create_vehicle/shipment"> Add Vehicle</a>
                    <select name="vehicle" id="vehicle" class="form-control">
                      <option value="">Select vehicle</option>
                      @if($user->user_role != 'Dispatcher')
                      @foreach($vehicles as $vehicle)
                      <option value="{{$vehicle->id}}" {{$vehicle->id == $shipment->vehicle_id?'selected':''}}>{{$vehicle->name_type.' '.$vehicle->license_plate.' '.$vehicle->model_no}}</option>
                      @endforeach
                      @else
                      @foreach($fleetowners as $fleetowner)
                        @foreach(DB::table('vehicles')->where('user_id', $fleetowner->id)->where('vehicle_status', 'Active')->get() as $vehicle)
                        <option value="{{$vehicle->id}}" class="owner" ownerid="{{$fleetowner->id}}" {{$vehicle->id == $shipment->vehicle_id?'selected':''}}>{{$vehicle->name_type.' '.$vehicle->license_plate.' '.$vehicle->make}}</option>
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
                  <div class="form-group" style="min-height:55px">
                    {{ Form::label('goods_type', 'Goods Type:', ['class' => 'control-label']) }}<br>
                    <input type="radio" value="Flammable" name='flame' {{$shipment->flame == 'Flammable'? 'checked':''}}> Flammable &nbsp;
                    <input type="radio" value="Non-Flammable" name='flame' {{$shipment->flame == 'Non-Flammable'? 'checked':''}}> Non-Flammable
                  </div>
                  <div class="form-group">
                    {{ Form::label('load_quantity', 'Load Quantity(tons):', ['class' => 'control-label']) }}
                    {{ Form::text('load_quantity', $shipment->load_quantity, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('packing_type', 'Packaging Type:', ['class' => 'control-label']) }}
                    {{ Form::select('packing_type', [''=>'', 'Boxes in Pallet'=>'Boxes in Pallet','Boxes'=>'Boxes','Open'=>'Open'], $shipment->packing_type, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('goods_description', 'Description of Goods:', ['class' => 'control-label']) }}
                    {{ Form::textarea('goods_description', $shipment->goods, ['class' => 'form-control textarea','rows'=>'3'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('shipment_cost', 'Shipment Cost(USD):', ['class' => 'control-label']) }}
                    {{ Form::text('shipment_cost', $shipment->shipment_cost, ['class' => 'form-control', 'placeholder'=>'$'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('extra_charge', 'Extra Charge(USD):', ['class' => 'control-label']) }}
                    {{ Form::text('extra_charge', $shipment->extra_charge, ['class' => 'form-control', 'placeholder'=>'$'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('extra_charge_reason', 'Why the Extra Charge?', ['class' => 'control-label']) }}
                    {{ Form::textarea('extra_charge_reason', $shipment->extra_charge_reason, ['class' => 'form-control','rows'=>'3'])}}
                  </div>
                </div>
                @if($user->user_role == 'Fleet Owner')
                <div class="col-md-6">
                  <div class="form-group">
                    <label for='dispatcher_commission' class='control-label'> Dispatcher Commission: <input type="radio" name="discom" id="dispfix"> Fixed &nbsp; / &nbsp; <input type="radio" name="discom" id="dispcom"> Percentage</label>
                    {{ Form::text('dispatcher_commission', $shipment->dispatcher_commission, ['class' => 'form-control', 'style'=>'max-width:70%;float:left', 'placeholder'=>'Fixed amount', 'id'=> 'dispvalue']) }}
                    <input type="text" name="dispatcher_percent" id="dispercent" class="form-control" style="max-width:30%" placeholder="Percentage %" value="{{$shipment->dispatcher_percent}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for='driver_commission' class='control-label'> Driver Commission: <input type="radio" name="drivecom" id="drivfix"> Fixed &nbsp; / &nbsp; <input type="radio" name="drivecom" id="drivcom"> Percentage</label>
                    {{ Form::text('driver_commission', $shipment->driver_commission, ['class' => 'form-control', 'style'=>'max-width:70%;float:left', 'placeholder'=>'Fixed amount', 'id'=>'drivalue']) }}
                    <input type="text" name="driver_percent" id="dripercent" class="form-control" style="max-width:30%" placeholder="Percentage %" value="{{$shipment->driver_percent}}">
                  </div>
                </div>
                @endif
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('loading_point', 'Origin (loading point):', ['class' => 'control-label']) }}
                    {{ Form::text('loading_point', $shipment->loading_point, ['class' => 'form-control', 'placeholder' => 'Enter starting point address or GPS coordinates'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('loading_date', 'Loading Date:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_date', date('m/d/Y', strtotime($shipment->loading_date)), ['class' => 'form-control datepicker'])}}
                  </div>
                </div>
                <div class="col-md-3 bootstrap-timepicker">
                  <div class="form-group">
                    {{ Form::label('loading_time', ' Loading Time:', ['class' => 'control-label']) }}
                    {{ Form::text('loading_time', $shipment->loading_time, ['class' => 'form-control timepicker'])}}
                  </div>
                </div>
                <div class="col-md-12">
                  <h4 style="color: #800">Unload Information:</h4>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('unload_point', 'Destination (unload point):', ['class' => 'control-label']) }}
                    {{ Form::text('unload_point', $shipment->unload_point, ['class' => 'form-control', 'placeholder' => 'Enter destination address or GPS coordinates'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('details', 'Notes:', ['class' => 'control-label']) }}
                    {{ Form::textarea('details', $shipment->note, ['class' => 'form-control textarea','rows' => 2])}}
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_date', 'Unload Date:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_date', date('m/d/Y', strtotime($shipment->unload_date)), ['class' => 'form-control datepicker'])}}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('unload_time', 'Unload Complete Time:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_time', $shipment->unload_time, ['class' => 'form-control timepicker'])}}
                  </div>
                </div>
                <div class="col-md-6">
                </div> --}}
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
                      {{ Form::text('distance', $shipment->distance, ['class' => 'form-control', 'readonly'=>''])}}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {{ Form::label('duration', 'Estimated Duration:', ['class' => 'control-label']) }}
                      {{ Form::text('duration', $shipment->duration, ['class' => 'form-control', 'readonly'=>''])}}
                    </div>
                  </div>
                </div>
             
              <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right btn-outline-primary"><i class="fa fa-save"></i> Save</button>
            </div>
            <div class="col-md-12"><br><br>
              @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
              <div id="googleMap"></div>
              @endif
            </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

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
    var shipper = document.getElementById('shipper').selectedIndex;
    var driver = document.getElementById('driver').selectedIndex;
    var vehicle = document.getElementById('vehicle').selectedIndex;
    var owner = document.getElementsByClassName('owner');
    var FleetOwner = document.getElementById('FleetOwner');    
    FleetOwner.addEventListener('change', change);
    function change(){

      document.getElementById('shipper').selectedIndex = shipper;
      document.getElementById('driver').selectedIndex = driver;
      document.getElementById('vehicle').selectedIndex = vehicle;

      for(var r = 0; owner.length > r; r++){
        if(FleetOwner.value == owner[r].getAttribute('ownerid')){
          owner[r].style.display = 'block';
          console.log(owner[r]);
        }else{
          owner[r].style.display = 'none';
        }
      }
    }
    </script>
    
    <!-- dispacher and driver commision calculation-->
    <script type="text/javascript">
    var shipment_cost = document.getElementById('shipment_cost');
    var dispfix = document.getElementById('dispfix');
    var dispcom = document.getElementById('dispcom');
    var drivfix = document.getElementById('drivfix');
    var drivcom = document.getElementById('drivcom');
    var dispvalue = document.getElementById('dispvalue');
    var drivalue = document.getElementById('drivalue');
    var dispercent = document.getElementById('dispercent');
    var dripercent = document.getElementById('dripercent');

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

    <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    // CKEDITOR.replace('details')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()

    // var wysi = document.getElementsByClassName('wysihtml5-toolbar');
    // for(var x = 0; wysi.length > x; x++){
    //   wysi[x].style.display = 'none';
    // }
  })
</script>
@endsection