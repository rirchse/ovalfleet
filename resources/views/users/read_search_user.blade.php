@extends('user')
@section('title', 'User Details')
@section('content')
<?php 
$authuser = Auth::user();
$connecteduser = DB::table('relations')->where('user_id', $user->id)->where('owner_id', $authuser->id)->get();
?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{ $user->user_role }} Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{$user->user_role}}</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-9"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">{{ $user->user_role }} Information &nbsp;
              @if(count($connecteduser) > 0)
              <label class="label" style="background:#000;font-weight:0!important">This user is associated with your account.</label>
              @else
                <a href="/user/{{strtolower($user->user_role)}}/{{$user->id}}/add" class="small text-success" title=" Add to My {{$user->user_role}}s">Add this {{ $user->user_role }} to My {{ $user->user_role }}s</a>
              @endif
            </h4>
          </div>
                <div class="col-md-12 text-right toolbar-icon">
                    <a href="/search/{{strtolower($user->user_role)}}" title="Search {{ $user->user_role }}s" class="label label-warning"><i class="fa fa-search-plus"></i></a>
                    <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
                    <a href="/user/{{strtolower($user->user_role)}}/{{$user->id}}/add" class="label label-success" title=" Add to My {{$user->user_role}}s"><i class="fa fa-plus"></i></a>
                </div>
                <div class="col-md-6">
                  <table class="table">
                      <tbody>
                        <tr>
                          <th>Account Number:</th>
                          <td>{{$user->account_number}}</td>
                        </tr>
                        <tr>
                          <th>Account Type:</th>
                          <td>{{$user->user_role}}</td>
                        </tr>
                        <tr>
                          <th>First Name:</th>
                          <td>{{$user->first_name}}</td>
                        </tr>
                        <tr>
                          <th>Middle I:</th>
                          <td>{{$user->middle_name}}</td>
                        </tr>
                        <tr>
                          <th>Last Name:</th>
                          <td>{{$user->last_name}}</td>
                        </tr>
                        <tr>
                          <th>Email:</th>
                          <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                          <th>Contact:</th>
                          <td>{{$user->contact}}</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table">
                    <tbody>
                        <tr>
                          <th>Address:</th>
                          <td>{{$user->address}}</td>
                        </tr>
                        <tr>
                          <th>State:</th>
                          <td>{{$user->state}}</td>
                        </tr>
                        <tr>
                          <th>Zip Code:</th>
                          <td>{{$user->zip_code}}</td>
                        </tr>
                        <tr>
                          <th>Country:</th>
                          <td>{{$user->country}}</td>
                        </tr>
                        @if($user->user_role == 'Driver')
                        <tr>
                          <th>Driver License:</th>
                          <td>{{$user->driver_license}}</td>
                        </tr>
                        @else
                        <tr>
                          <th>Organization:</th>
                          <td>{{$user->organization}}</td>
                        </tr>
                        @endif
                         <tr>
                          <th>Status:</th>
                          <td>
                            @if($user->status == 0)
                            <span class="label label-warning">Unverified</span>
                            @elseif($user->status == 1)
                            <span class="label label-success">Active</span>
                            @elseif($user->status == 2)
                            <span class="label label-danger">Disabled</span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Record Created On:</th>
                          <td>{{date('d M Y h:i A',strtotime($user->created_at) )}} </td>
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
