@extends('user')
@section('title', 'Update Shipment')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Shipment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Shipment</li>
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
              <h3 style="color: #800" class="box-title">Update Shipment</h3>
            </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="/shipment/{{ $shipment->id }}/details" class="label label-info" title="View Details"><i class="fa fa-file-text"></i></a>
              <a href="/view_shipment/{{$shipment->id}}/expenses" title="View Shipment Expenses" class="label label-primary"><i class="fa fa-usd"></i></a>
              <a href="/view_shipments" title="Veiw Shipments" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="/shipment/{{$shipment->id}}/print" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
          </div>
            <!-- /.box-header -->
            <style type="text/css">table td{text-align: left;}</style>
            <!-- form start -->
            {!! Form::model($shipment, ['route' => ['update.shipment.driver', $shipment->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('start_mileage', 'Mileage of Vehicle at Start (miles):', ['class' => 'control-label']) }}
                    {{ Form::text('start_mileage', $shipment->start_mileage, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('starting_gas', 'Starting Gas (before the load starts):', ['class' => 'control-label']) }}
                    {{ Form::select('starting_gas',[''=>'Select One', '1/8'=>'1/8', '1/4'=>'1/4', '1/2'=>'1/2', '3/8'=>'3/8', 'Full'=>'Full'], $shipment->starting_gas, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('load_start_time', 'Arrived at Loading point:', ['class' => 'control-label']) }}
                    {{ Form::text('load_start_time', $shipment->load_start_time, ['class' => 'form-control timepicker'])}}
                  </div>
                {{-- </div> --}}
                {{-- <div class="col-md-6"> --}}
                  <div class="form-group">
                    {{ Form::label('load_complete_time', 'Load Complete Time:', ['class' => 'control-label']) }}
                    {{ Form::text('load_complete_time', $shipment->load_complete_time, ['class' => 'form-control timepicker'])}}
                  </div>
                {{-- </div> --}}
                {{-- <div class="col-md-6"> --}}
                  <div class="form-group">
                    {{ Form::label('reached_unload_point', 'Reached Unload Point:', ['class' => 'control-label']) }}
                    {{ Form::text('reached_unload_point', $shipment->reached_unload_point, ['class' => 'form-control timepicker'])}}
                  </div>
                {{-- </div> --}}
                {{-- <div class="col-md-6"> --}}
                  <div class="form-group">
                    {{ Form::label('unload_complete_time', 'Unload Complete Time:', ['class' => 'control-label']) }}
                    {{ Form::text('unload_complete_time', $shipment->unload_complete_time, ['class' => 'form-control timepicker'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('end_mileage', 'Mileage of Vehicle at Destination (in miles):', ['class' => 'control-label']) }}
                    {{ Form::text('end_mileage', $shipment->end_mileage, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('details', 'Notes:', ['class' => 'control-label']) }}
                    {{ Form::textarea('details', $shipment->details, ['class' => 'form-control','rows' => 3 ])}}
                  </div>
                </div>
              </div><!-- /.box-body -->
            <div class="box-footer">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-outline-primary pull-right"><i class="fa fa-save"></i> Save</button>
              </div>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div><!--/.col (left) -->
      </div><!-- /.row -->
    </section><!-- /.content -->

@endsection
@section('scripts')
<script type="text/javascript">

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    </script>
@endsection