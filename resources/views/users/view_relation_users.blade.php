@extends('user')
@section('title', 'View Users')
@section('content')

<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View All Users</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Users</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Account No.</th>
                  <th>Account Type</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th>Joined with me</th>
                </tr>

                @foreach($relations as $relation)

                <tr>
                  <td>{{$relation->account_number}}</td>
                  <td>{{$relation->user_role}}</td>
                  <td>{{$relation->first_name.' '.$relation->middle_name.' '.$relation->last_name}}</td>
                  <td>{{$relation->email}}</td>
                  <td>{{$relation->contact}}</td>
                  <td>
                    @if($relation->status == 1)
                    <span class="label label-success">Active</span>
                    @else
                    <span class="label label-warning">Unverified</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($relation->created_at))}}</td>
                  <td>{{ date('d M Y', strtotime($relation->joined))}}</td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$relations->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection