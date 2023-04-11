@extends('admin')
@section('title', 'View Active Users')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Users Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Users Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Active User Accounts</h3>

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
                  <th>Account Number</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>SignUp Date</th>
                  <th>Type</th>
                  <th width="100">Action</th>

                </tr>

                @foreach($users as $user)

                <tr>
                  <td>{{$user->account_number}}</td>
                  <td>{{$user->first_name.' '.$user->middle_name.' '.$user->last_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->contact}}</td>
                  <td>
                    @if($user->status == 1)
                    <span class="label label-success">Verified</span>
                    @elseif($user->status == 0)
                    <span class="label label-warning">Unverified</span>
                    @elseif($user->status == 3)
                    <span class="label label-danger">Deleted</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($user->created_at))}}</td>
                  <td>{{ $user->user_role }}</td>
                  <td>
                    <a href="/admin/user/{{$user->id}}/details" class="label label-info" title="User Details"><i class="fa fa-file-text"></i></a>
                    <a href="/admin/user/{{$user->id}}/edit" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
                    <a href="/admin/loginto/{{$user->id}}" target="_blank" contact="" email="" token="" class="label label-success" title="Login to this account"><i class="fa fa-search-plus"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$users->links()}}
              </div>
            </div>

            {{-- {{dd(Auth::user())}} --}}


            {{-- {!! Form::open(['route' => 'loginby.admin', 'method' => 'POST', 'role' => 'form', 'id' => 'userform' ]) !!} --}}
            {{-- <div class="form-group has-feedback">
              {{ Form::email('email', 'driver@driver.com', ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Email Address', 'id'=> 'Email'])}}
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              {{ Form::text('contact', '1234567899', ['class' => 'form-control', 'required' =>'', 'placeholder' => 'Password', 'id'=> 'Contact'])}}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-submit">Login</button>
              </div>
            </div> --}}
          {{-- {!! Form::close() !!} --}}

          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->

    <script type="text/javascript">
    function loginbyadmin(elm){
      document.getElementById('Email').value = elm.getAttribute('email');
      document.getElementById('Contact').value = elm.getAttribute('contact');

      document.getElementById('userform').submit();

      // console.log(elm.getAttribute('contact'));

    }
    
    </script>
@endsection