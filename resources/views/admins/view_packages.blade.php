@extends('admin')
@section('title', 'Service Plan List')
@section('content')
<?php $admin = Auth::guard('admin')->user() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Service Plans</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Service Plans</a></li>
        <li class="active"> View Service Plans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Service Plans</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            {{-- <div class="row">
              <div class="col-md-5 col-md-offset-10">
                   <a href="/view_packages" title="package Details" class="label label-success"><i class="fa fa-list"></i></a>
                    <a href="/view_packages" title="package Details" class="label label-info"><i class="fa fa-print"></i></a>
              </div>
              
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="" class="table table-hover">
                <thead>
                <tr>
                  <th>Service Plans</th>
                  <th>Plan Charges</th>
                  <th>Max Dispatchers</th>
                  <th>Max Drivers</th>
                  <th>Duration</th>
                  <th>Free Trial</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
                <?php $r = 0; ?>

                @foreach($packages as $package)
                <?php $r++; ?>

                <tr>
                  <td>{{$package->package_name}}</td>
                  <td>${{number_format($package->package_price, 2)}}</td>
                  <td>{{$package->max_dispatcher}}</td>
                  <td>{{$package->max_driver}}</td>
                  <td>{{ucfirst($package->duration)}}</td>
                  <td>{{ucfirst($package->slug)}}</td>
                  <td>
                    @if($package->status == 1)
                    <label class="label btn-success">Active</label>
                    @else
                    <label class="label btn-danger">Inactive</label>
                    @endif

                  </td>
                  <td>
                    <a href="/admin/package/{{$package->id}}" title="Service Plan Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    @if($admin->user_role == 'SUPER-ADMIN')
                    <a href="/admin/package/{{$package->id}}/edit" class="label label-warning" title="Edit Service Plan"><i class="fa fa-edit"></i></a>
                    @endif
                    {{-- <a href="/package/{{$package->id}}/delete" class="label label-danger" title="Delete package" onclick="return confirm('Are you sure you want to delete this package?');"><i class="fa fa-trash"></i></a> --}}
                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <div class="pagination-sm no-margin pull-right">
                {{$packages->links()}}
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection