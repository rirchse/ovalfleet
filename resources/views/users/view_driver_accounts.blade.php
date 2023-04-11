@extends('user')
@section('title', 'Home')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Accounts
        <small>Showing all driver accounts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Driver Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Showing Driver Accounts</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th>Action</th>
                </tr>

                @foreach($drivers as $driver)

                <tr>
                  <td>{{$driver->id}}</td>
                  <td>{{$driver->first_name}}</td>
                  <td>{{$driver->middle_name}}</td>
                  <td>{{$driver->last_name}}</td>
                  <td>{{$driver->email}}</td>
                  <td>{{$driver->contact}}</td>
                  <td>
                    @if($driver->status == 1)
                    <span class="label label-success">Approved</span>
                    @else
                    <span class="label label-warning">Pending</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($driver->created_at))}}</td>
                  <td>
                    {{-- <a href="" class="label label-info"><i class="fa fa-file-text"></i></a> --}}
                    <a href="/driver/{{$driver->id}}/edit" class="label label-warning"><i class="fa fa-edit"></i></a>
                    <a href="/driver/{{$driver->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
              </ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection