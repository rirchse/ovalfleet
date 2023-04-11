@extends('admin')
@section('title', 'Subscription Plan Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Subscription Plan Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Subscription Plans</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Subscription Plan Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            {{-- <a href="/admin/view_plans" class="label label-success" title="View Subscription Plans"><i class="fa fa-list"></i></a> --}}
            {{-- <a href="/admin/plan/{{$plan->id}}/edit" class="label label-warning" title="Edit Subscription Plan"><i class="fa fa-edit"></i></a> --}}
            @if($plan->status == 1)
            {{-- <a href="/admin/plan/{{$plan->id}}/disable" class="label label-danger" onclick="return confirm('Are you sure want to disable this Subscription Plan!');" title="Disable this Subscription Plan"><i class="fa fa-close"></i></a> --}}
            @else
            {{-- <a href="/admin/plan/{{$plan->id}}/restore" class="label label-success" onclick="return confirm('Are you sure want to restore this Subscription Plan!');" title="Restore this Subscription Plan"><i class="fa fa-undo"></i></a> --}}
            @endif
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Subscription Plan Name:</th>
                    <td>{{$plan->name}}</td>
                  </tr>
                  <tr>
                    <th>Plan ID:</th>
                    <td>{{$plan->id}}</td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td>{{$plan->state}}</td>
                  </tr>
                  <tr>
                    <th>Type:</th>
                    <td>{{$plan->type}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$plan->description}}</td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($plan->create_time) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
