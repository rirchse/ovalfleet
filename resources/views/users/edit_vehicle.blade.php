@extends('user')
@section('title', 'Edit Vehicle')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Vehicle</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update New Vehicle</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">        <!-- left column -->
        <div class="col-md-10">          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update New Vehicle</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/vehicle/{{$vehicle->id}}/details" title="Vehicle Details" class="label label-info"><i class="fa fa-file-text"></i></a>
              <a href="/view_vehicles" title="View Vehicles" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <!-- /.box-header -->
            {{-- {{dd($vehicle->vehicle_type)}} --}}
            <!-- form start -->
            {!! Form::model($vehicle,['route' =>['update.vehicle', $vehicle->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('vehicle_status', 'Status:', ['class' => 'control-label']) }}
                    {{ Form::select('vehicle_status',[''=>'Select Status', 'Active'=> 'Active', 'Out of service'=> 'Out of service'], $vehicle->vehicle_status, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('name_type', 'Vehicle Name/Type:', ['class' => 'control-label']) }}
                    {{ Form::select('name_type', [''=>' Select Vehicle Name/Type', 'Box Truck' => 'Box Truck', 'Covered Van/Cargo Van'=>'Covered Van/Cargo Van', 'Flatbed Truck' => 'Flatbed Truck', 'Heavy Hauler' => 'Heavy Hauler','Pick up Truck'=>'Pick up Truck','Semi Truck/18-Wheeler'=>'Semi Truck/18-Wheeler'], $vehicle->name_type, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('vinsn', 'VIN/SN:', ['class' => 'control-label']) }}
                    {{ Form::text('vinsn', $vehicle->vinsn, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('license_plate', 'License Plate:', ['class' => 'control-label']) }}
                    {{ Form::text('license_plate', $vehicle->license_plate, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('reg_state', 'Registration State/Province:', ['class' => 'control-label']) }}
                    {{ Form::text('reg_state', $vehicle->reg_state, ['class' => 'form-control']) }}
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('capacity', 'Load/Carrying Capacity(tons):', ['class' => 'control-label']) }}
                        {{ Form::text('capacity', $vehicle->capacity, ['class' => 'form-control'])}}
                      </div>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('purchase_date', 'Purchase Date:', ['class' => 'control-label']) }}
                        {{ Form::text('purchase_date', date('m/d/Y', strtotime($vehicle->purchase_date)), ['class' => 'form-control datepicker'])}}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('mileage', 'Mileage (when purchased):', ['class' => 'control-label']) }}
                        {{ Form::text('mileage', $vehicle->mileage, ['class' => 'form-control'])}}
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('make', 'Make:', ['class' => 'control-label']) }}
                        {{ Form::text('make', $vehicle->make, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('model_no', 'Model No:', ['class' => 'control-label']) }}
                        {{ Form::text('model_no', $vehicle->model_no, ['class' => 'form-control']) }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('body_type', 'Body Type:', ['class' => 'control-label']) }}
                        {{ Form::text('body_type', $vehicle->body_type, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group ">
                        {{ Form::label('year', 'Year:', ['class' => 'control-label']) }}
                        {{ Form::text('year', $vehicle->year, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {{ Form::label('color', 'Vehicle Color:', ['class' => 'control-label']) }}
                        {{ Form::text('color', $vehicle->color, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('photo', 'Photo: Add Photo', ['class' => 'control-label']) }}
                        {{ Form::file('photo', null, ['class' => 'form-control']) }}
                      </div>                  
                      <div class="form-group ">
                        {{ Form::label('document', 'Document: Add Document', ['class' => 'control-label']) }}
                        {{ Form::file('document', null, ['class' => 'form-control']) }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('comment', 'Comment:', ['class' => 'control-label']) }}
                        {{ Form::textarea('comment', $vehicle->comments, ['class' => 'form-control', 'rows'=>'3']) }}
                      </div>
                    </div>
              
              <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary">Update</button>
              </div>
            {!! Form::close() !!}
          </div> <!-- /.box -->

        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection