@extends('admin')
@section('title', 'Service Plan Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Service Plan Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Service Plans</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Service Plan Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="/admin/package/create" class="label label-info" title="Create Service Plan"><i class="fa fa-plus"></i></a>
            <a href="/admin/package" class="label label-success" title="View Service Plans"><i class="fa fa-list"></i></a>
            @if(Auth::user()->user_role == 'SUPER-ADMIN')
            <a href="/admin/package/{{$package->id}}/edit" class="label label-warning" title="Edit Service Plan"><i class="fa fa-edit"></i></a>
            @endif
            {{-- <a href="/admin/package/{{$package->id}}/edit" class="label label-warning" title="Edit Service Plan"><i class="fa fa-edit"></i></a> --}}
            @if($package->status == 1)
            <a href="/admin/package/{{$package->id}}/disable" class="label label-danger" onclick="return confirm('Are you sure want to disable this Service Plan!');" title="Disable this Service Plan"><i class="fa fa-close"></i></a>
            @else
            <a href="/admin/package/{{$package->id}}/restore" class="label label-success" onclick="return confirm('Are you sure want to restore this Service Plan!');" title="Restore this Service Plan"><i class="fa fa-undo"></i></a>
            @endif
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Service Plan Name:</th>
                    <td>{{$package->package_name}}</td>
                  </tr>
                  <tr>
                    <th>Service Plan Charge:</th>
                    <td>${{number_format($package->package_price, 2)}}</td>
                  </tr>
                  <tr>
                    <th>Max Dispatchers:</th>
                    <td>{{$package->max_dispatcher}}</td>
                  </tr>
                  <tr>
                    <th>Max Drivers:</th>
                    <td>{{$package->max_driver}}</td>
                  </tr>
                  <tr>
                    <th>Duration:</th>
                    <td>{{$package->duration}}</td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td>
                      @if($package->status == 1)
                      <span class="label label-success">Active</span>
                      @else
                      <span class="label label-danger">Inactive</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$package->details}}</td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($package->created_at) )}} </td>
                  </tr>

                  <tr>
                    <td colspan=2></td>
                  </tr>
                  <tr>
                    <th colspan=2 class="box-title"><h4>Subscription Plan Details
                     {{-- <a href="/paypal/createPlan/{{$package->id}}" class="btn btn-info pull-right" onclick="return confirm('Are you sure you want to create new plan?')">Create a Plan</a> --}}
                   </h4></th>
                  </tr>

                  @if($package->stripe_plan_id)

                  <tr>
                    {{-- <th>Plan Status:</th> --}}
                    {{-- <td>{{$package->plan_status?$package->plan_status:'Not created'}}</td> --}}
                  </tr>
                  <tr>
                    <th>Plan ID:</th>
                    <td>
                      {{$package->stripe_plan_id}}
                      @if($package->plan_id && $package->plan_status != 'ACTIVE')
                      {{-- <a href="/paypal/activatePlan/{{$package->plan_id}}" class="btn btn-info pull-right">Activate Plan</a> --}}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    {{-- <td><a href="/paypal/getPlan/{{$package->plan_id}}">Subscription Details</a></td> --}}
                  </tr>
                  @endif
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
