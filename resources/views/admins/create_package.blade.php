@extends('admin')
@section('title', 'Create Service Plan')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create a Service Plan</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Service Plans</a></li>
        <li class="active">Create a Service Plan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Create a New Service Plan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'package.store', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('package_name', 'Service Plan Name:', ['class' => 'control-label']) }}
                    {{ Form::text('package_name', null, ['class' => 'form-control'])}}
                  </div>                  
                  <div class="form-group">
                      {{ Form::label('package_price', 'Service Plan Charge(USD):', ['class' => 'control-label']) }}
                      {{ Form::text('package_price', null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('max_dispatcher', 'Max Dispatchers:', ['class' => 'control-label']) }}
                      {{ Form::text('max_dispatcher', null, ['class' => 'form-control', 'placeholder' => 'Min:1 and Max: 100'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('max_driver', 'Max Drivers:', ['class' => 'control-label']) }}
                      {{ Form::text('max_driver', null, ['class' => 'form-control', 'placeholder' => 'Min:1 and Max: 100'])}}
                  </div>                  
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('duration', 'Duration:', ['class' => 'control-label']) }}
                      {{ Form::select('duration', ['day' => 'Daily', 'week' => 'Weekly', 'month' => 'Monthly', 'year' => 'Yearly'], null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('status', 'Status:', ['class' => 'control-label']) }}<br>
                      <input type="checkbox" name="status" value="1">
                      {{ Form::label('status', ' &nbsp; Active:', ['class' => 'control-label']) }}
                  </div><br>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('bg_color', 'Background Color:', ['class' => 'control-label']) }}
                      {{ Form::select('bg_color', ['purple'=>'Purple', 'green'=>'Green', 'aqua'=>'Aqua', 'yellow'=>'Yellow', 'red'=>'Red', 'blue'=>'Blue', 'brown'=>'Brown'], null, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('btn_color', 'Action Button Color:', ['class' => 'control-label']) }}
                      {{ Form::select('btn_color', ['primary' => 'Blue', 'info'=>'Light Blue', 'success'=>'Green', 'warning'=>'Yellow', 'danger'=>'Red', 'default'=>'White'], null, ['class' => 'form-control'])}}
                  </div>                  
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                    {{ Form::textarea('details', null, ['class' => 'form-control','rows'=>'3'])}}
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
@endsection

@section('scripts')
<script type="text/javascript">

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    </script>
@endsection