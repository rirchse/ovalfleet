@extends('user')
@section('title', 'View Pending Referrals')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Pending Referrals</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active"> View Pending Referral</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> List of Pending Referrals</h3>

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
              <div class="container">
              <div class=" col-md-offset-10">
                   <a href="/view_vehicles" title="Vehicle Details" class="label label-success"><i class="fa fa-list"></i></a>
                    <a href="/view_vehicles" title="Vehicle Details" class="label label-info"><i class="fa fa-print"></i></a>
                </div>
              </div>
              
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Email Resend Counter</th>
                  <th>First Mail Date</th>
                  <th>Action</th>
                </tr>
                @foreach($users as $user)

                @if( empty(DB::table('users')->where('email', $user->email)->first()) )

                <tr>
                  <td>{{$user->email}}</td>
                  <td>
                    @if($user->status == 1)
                    <span class="label label-success">Active</span>
                    @else
                    <span class="btn btn-warning">Yet to Sign Up</span>
                    @endif
                  </td>
                  <td>{{$user->sending_count}}/5</td>
                  <td>{{ date('d M Y', strtotime($user->created_at))}}</td>
                  <td>
                    {{-- <a href="/pending_referral/{{$user->id}}/details" title="Details" class="label label-info"><i class="fa fa-file-text"></i></a> --}}

                    <a href="/resend_invitation/{{$user->id}}" class="label label-primary" onclick="return confirm('Are you sure you want to resend invitation to this email?')" title="Resend invitation."><i class="fa fa-envelope-o"></i></a>
                    
                  </td>
                </tr>

                @endif

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$users->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection