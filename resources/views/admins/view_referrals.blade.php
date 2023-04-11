@extends('admin')
@section('title', 'View Referrals')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Referrals</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active"> View Referral</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> List of Referrals</h3>

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
                  <th>Referral Sent By</th>
                  <th>Referral Sent To</th>
                  <th>Account Type</th>
                  <th>Account No.</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th>Action</th>
                </tr>
                @foreach($users as $user)

                <tr>
                  <td>{{App\User::find($user->referral)?App\User::find($user->referral)->first_name.' '.App\User::find($user->referral)->first_name:''}}</td>
                  <td>{{$user->first_name.' '.$user->last_name}}</td>
                  <td>{{$user->user_role}}</td>
                  <td>{{$user->account_number}}</td>
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
                    <a href="/admin/referral/{{$user->id}}/details" title="Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/admin/user/{{strtolower($user->user_role)}}/{{$user->id}}/add" class="label label-success" title=" Add to My {{$user->user_role}}s"> Add to My {{$user->user_role}}s</a> --}}
                    
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
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection