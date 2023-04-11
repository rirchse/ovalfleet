@extends('user')
@section('title', 'Add Vehicle')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Vehicle</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vehicles</a></li>
        <li class="active">Add Vehicle </li>
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
              <h3 class="box-title">Add Vehicle Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'create.vehicle', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-3">
                  <div class="form-group">
                    {{ Form::label('vehicle_status', 'Status:', ['class' => 'control-label']) }}
                    {{ Form::select('vehicle_status',[''=>'Select Status', 'Active'=> 'Active', 'Out of service'=> 'Out of service'], null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('name_type', 'Vehicle Name/Type:', ['class' => 'control-label']) }}
                    {{ Form::select('name_type', [''=>' Select Vehicle Name/Type', 'Box Truck' => 'Box Truck', 'Covered Van/Cargo Van'=>'Covered Van/Cargo Van', 'Flatbed Truck' => 'Flatbed Truck', 'Heavy Hauler' => 'Heavy Hauler','Pick up Truck'=>'Pick up Truck','Semi Truck/18-Wheeler'=>'Semi Truck/18-Wheeler'], null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('vinsn', 'VIN/SN:', ['class' => 'control-label']) }}
                    {{ Form::text('vinsn', null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group ">
                    {{ Form::label('license_plate', 'License Plate:', ['class' => 'control-label']) }}
                    {{ Form::text('license_plate', null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group ">
                    {{ Form::label('reg_state', 'Registration State/Province:', ['class' => 'control-label']) }}
                    {{ Form::text('reg_state', null, ['class' => 'form-control']) }}
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('capacity', 'Load/Carrying Capacity(tons):', ['class' => 'control-label']) }}
                        {{ Form::text('capacity', null, ['class' => 'form-control'])}}
                      </div>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('purchase_date', 'Purchase Date:', ['class' => 'control-label']) }}
                        {{ Form::text('purchase_date', null, ['class' => 'form-control datepicker'])}}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('mileage', 'Mileage (when purchased):', ['class' => 'control-label']) }}
                        {{ Form::text('mileage', null, ['class' => 'form-control'])}}
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('make', 'Make:', ['class' => 'control-label']) }}
                        {{ Form::text('make', null, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        {{ Form::label('model_no', 'Model No:', ['class' => 'control-label']) }}
                        {{ Form::text('model_no', null, ['class' => 'form-control']) }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        {{ Form::label('body_type', 'Body Type:', ['class' => 'control-label']) }}
                        {{ Form::text('body_type', null, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group ">
                        {{ Form::label('year', 'Year:', ['class' => 'control-label']) }}
                        {{ Form::text('year', null, ['class' => 'form-control'])}}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {{ Form::label('color', 'Vehicle Color:', ['class' => 'control-label']) }}
                        {{ Form::text('color', null, ['class' => 'form-control'])}}
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
                        {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows'=>'3']) }}
                      </div>
                    </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right btn-outline-primary"><i class="fa fa-save"></i> Save</button>
              </div>
            {!! Form::close() !!}
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!--/.col (left) -->
      </div><!-- /.row -->
    </section><!-- /.content -->
@endsection