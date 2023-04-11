@extends('admin')
@section('title', 'Edit Service Plan')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Edit Service Plan</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Service Plans</a></li>
        <li class="active">Edit Service Plan</li>
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
              <h3 style="color: #800" class="box-title">Update Service Plan Information</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/admin/package/{{$package->id}}" title="Service Plan Details" class="label label-info"><i class="fa fa-file-text"></i></a>
              <a href="/admin/package" class="label label-success" title="View Service Plans"><i class="fa fa-list"></i></a>
            </div>
            <div class="clearfix"></div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($package, ['route' => ['package.update', $package->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('package_name', 'Service Plan Name:', ['class' => 'control-label']) }}
                    {{ Form::text('package_name', $package->package_name, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                      {{ Form::label('package_price', 'Service Plan Charge(USD):', ['class' => 'control-label']) }}
                      {{ Form::text('package_price', $package->package_price, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('max_dispatcher', 'Max Dispatchers:', ['class' => 'control-label']) }}
                      {{ Form::text('max_dispatcher', $package->max_dispatcher, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('max_driver', 'Max Drivers:', ['class' => 'control-label']) }}
                      {{ Form::text('max_driver', $package->max_driver, ['class' => 'form-control'])}}
                  </div>                  
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  {{ Form::label('duration', 'Duration:', ['class' => 'control-label']) }}
                  {{ Form::select('duration', ['day' => 'Daily', 'week' => 'Weekly', 'month' => 'Monthly', 'year' => 'Yearly'], $package->duration, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      {{ Form::label('status', 'Status:', ['class' => 'control-label']) }}<br>
                      <input type="checkbox" value="1" name="status" {{$package->status?'checked':''}}> &nbsp; Active
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">

                      {{ Form::label('trial', ' &nbsp; Free Trial:', ['class' => 'control-label text-right']) }}<br>

                      <input type="checkbox" value="Trial" name="slug" {{$package->slug?'checked':''}}> &nbsp; Trial

                  </div>
                  <br>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('bg_color', 'Background Color:', ['class' => 'control-label']) }}
                      {{ Form::select('bg_color',['purple'=>'Purple', 'green'=>'Green', 'aqua'=>'Aqua', 'yellow'=>'Yellow', 'red'=>'Red', 'blue'=>'Blue', 'brown'=>'Brown'], $package->bg_color, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      {{ Form::label('btn_color', 'Action Button Color:', ['class' => 'control-label']) }}
                      {{ Form::select('btn_color', ['primary' => 'Blue', 'info'=>'Light Blue', 'success'=>'Green', 'warning'=>'Yellow', 'danger'=>'Red', 'default'=>'White'], $package->btn_color, ['class' => 'form-control'])}}
                  </div>                  
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                    {{ Form::textarea('details', $package->details, ['class' => 'form-control','rows'=>'3'])}}
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
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    </script>
@endsection