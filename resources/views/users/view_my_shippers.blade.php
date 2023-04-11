@extends('user')
@section('title', 'Showing My Shipper Accounts')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My Shipper Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">My Shipper Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of My Shippers</h3>

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
                  <th>First Name</th>
                  <th>Middle I</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th>Action</th>
                </tr>

                @foreach($shippers as $user)

                <tr>
                  <td>{{$user->account_number}}</td>
                  <td>{{$user->first_name}}</td>
                  <td>{{$user->middle_name}}</td>
                  <td>{{$user->last_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->contact}}</td>
                  <td>
                    @if($user->status == 1)
                    <span class="label label-success">Active</span>
                    @else
                    <span class="label label-warning">Unverified</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($user->created_at))}}</td>
                  <td>
                    <a href="/my_shipper/{{$user->id}}/details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/user/{{$user->id}}/edit" class="label label-warning"><i class="fa fa-edit"></i></a> --}}
                    <a href="/my_shipper/{{$user->id}}/remove" title="Remove from My Shippers" class="label label-danger" onclick="return confirm('Are you sure, you want to remove this account from your panel?');"><i class="fa fa-remove"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$shippers->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection