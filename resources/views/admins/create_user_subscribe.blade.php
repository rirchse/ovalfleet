@extends('admin')
@section('title', 'Add a Subscription')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add a Subscription</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User Subscription</a></li>
        <li class="active">Create a Subscription for User</li>
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
              <h3 style="color: #800" class="box-title">Create a New Subscription <b>[{{$user->account_number}}]</b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'user_subscribe.store', 'method' => 'POST', 'files' => true]) !!}
              <div class="box-body">
                
                <div class="col-md-12">
                  {{-- {{ Form::label('user_account', 'User Account Number:', ['class' => 'control-label']) }} --}}
                  <div class="form-group">
                    {{ Form::label('plan_id', 'Yearly Service Plan:', ['class' => 'control-label']) }}
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <select class="form-control" name="plan_id">
                      <option value="">Select a Plan</option>
                      @foreach($packages as $package)
                      <option value="{{$package->id}}">{{$package->package_name}} - ${{$package->package_price}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table">
                    <tr>
                      <th>Subscription Date:</th>
                      <td>{{date('d M Y')}}</td>
                    </tr>
                    <tr>
                      <th>Expire Date:</th>
                      <td>{{date('d M Y', strtotime('+1 year'))}}</td>
                    </tr>
                  </table>
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