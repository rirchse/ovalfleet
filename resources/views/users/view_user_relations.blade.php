@extends('user')
@section('title', 'List of User Accounts')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My {{ucwords($usertype)}}s</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($usertype)}}s</a></li>
        <li class="active">My {{ucwords($usertype)}}s</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of My {{ucwords($usertype)}}s</h3>

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

                {{-- {{dd($users)}} --}}

                @foreach($users as $user)

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
                    <a href="/my/{{strtolower($user->user_role)}}/{{$user->id}}/details" title="My {{$user->user_role}} Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/user/{{$user->id}}/edit" class="label label-warning"><i class="fa fa-edit"></i></a> --}}
                    
                    @if(Auth::user()->user_role == 'Fleet Owner' || Auth::user()->user_role == 'Shipper')
                    <a href="/my/{{strtolower($user->user_role)}}/{{$user->id}}/remove" title="Remove from My {{$user->user_role}}s" class="label label-danger" onclick="return confirm('Are you sure you want to remove this account from your panel?');"><i class="fa fa-remove"></i></a>
                    @endif
                    @if($user->status == 0)
                    <a href="/my/{{strtolower($user->user_role)}}/{{$user->id}}/resend_email_verification" class="label label-primary" onclick="return confirm('Are you sure you want to resend email verification to this user?')" title="Resend verification email."><i class="fa fa-envelope-o"></i></a>
                    @endif
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$users->links()}} --}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection