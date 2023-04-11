@extends('user')
@section('title', 'Shipment Expense')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Shipment Expense</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Shipments Expense</a></li>
        <li class="active">Edit Shipment Expense</li>
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
              <h3 style="color: #800" class="box-title">Edit Shipment Expense</h3>
            </div>
            <!-- /.box-header -->
            <div class="col-md-12 text-right toolbar-icon">
              <a href="/shipment/{{$shipment->id}}/expense/{{$expense->id}}/details" title="Shipment Expense Details" class="label label-info"><i class="fa fa-file-text"></i></a>
              <a href="/view_shipment/{{$shipment->id}}/expenses" title="View All Shipment Expenses" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <!-- form start -->
            {!! Form::model($expense, ['route' => ['update.shipment.expense', $expense->id], 'method' => 'PUT', 'files' => true]) !!}
            {{ Form::hidden('shipment_id', $shipment->id) }}
            {{ Form::hidden('driver_id', Auth::user()->id) }}
              <div class="box-body">
                
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('cause', 'Expense Type:', ['class' => 'control-label']) }}
                    {{ Form::select('cause', [''=>' Select One', 'Fuel' =>'Fuel', 'Hotel' => 'Hotel', 'Internet Access' => 'Internet Access', 'Meals & Snacks' => 'Meals & Snacks', 'Medical / Vaccinations' => 'Medical / Vaccinations', 'Parking' => 'Parking', 'Postage' => 'Postage', 'Taxi' => 'Taxi', 'Tolls' => 'Tolls', 'Rest'=>'Rest', 'Gas'=>'Gas', 'Other' => 'Other'], $expense->cause, ['class' => 'form-control'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('date', 'Expense Date:', ['class' => 'control-label']) }}
                    {{ Form::text('date', $expense->date?date('m/d/Y', strtotime($expense->date)):date('m/d/Y'), ['class' => 'form-control datepicker'])}}
                  </div>
                </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('start_time', 'Start Time:', ['class' => 'control-label']) }}
                        {{ Form::text('start_time', $expense->start_time, ['class' => 'form-control timepicker'])}}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('end_time', 'End Time:', ['class' => 'control-label']) }}
                        {{ Form::text('end_time', $expense->end_time, ['class' => 'form-control timepicker'])}}
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('expense', 'Amount(USD):', ['class' => 'control-label']) }}
                        {{ Form::text('expense', $expense->expense, ['class' => 'form-control', 'placeholder'=> '$'])}}
                    </div>
                    <div class="form-group">
                      {{ Form::label('notes', 'Notes:', ['class' => 'control-label']) }}
                      {{ Form::textarea('notes', $expense->notes, ['class' => 'form-control','rows'=>2])}}
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