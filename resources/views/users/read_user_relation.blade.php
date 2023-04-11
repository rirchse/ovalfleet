@extends('user')
@section('title', 'User Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My {{ $user->user_role }} Details</h1>
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
            <h4 class="box-title">My {{ $user->user_role }} Information</h4>
          </div>
                <div class="col-md-12 text-right toolbar-icon">
                    <a href="/my/{{strtolower($user->user_role)}}s" title="View {{ $user->user_role }}s" class="label label-success"><i class="fa fa-list"></i></a>
                    {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
                    @if(Auth::user()->user_role == 'Fleet Owner' || Auth::user()->user_role == 'Shipper')
                    <a href="/my/{{strtolower($user->user_role)}}/{{$user->id}}/remove" title="Remove from My {{strtolower($user->user_role)}}" class="label label-danger" onclick="return confirm('Are you sure you want to remove this account from your panel?');"><i class="fa fa-remove"></i></a>
                    @endif
                </div>
                <div class="col-md-6">
                  <table class="table">
                      <tbody>
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
                        <tr>
                          <th>Address:</th>
                          <td>{{$user->address}}</td>
                        </tr>
                        <tr>
                          <th>City:</th>
                          <td>{{$user->city}}</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table">
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
                  </table>
                </div>
                @if(Auth::user()->user_role == 'Dispatcher' && $user->user_role == 'Fleet Owner')
                <div class="col-md-12">

                  <h4>Associated with this Fleet Owner:</h4>
                  <table class="table">
                    <tr>
                      <td><a style="display:block" class="btn btn-warning" href="/view_associated_vehicles/{{$user->id}}">Vehicles</a></td>
                      <td><a style="display:block" class="btn btn-primary" href="/view_associated/{{$user->id}}/driver">Drivers</a></td>
                      <td><a style="display:block" class="btn btn-info" href="/view_associated/{{$user->id}}/shipper">Shippers</a></td>
                      <td><a style="display:block" class="btn btn-success" href="/view_associated_shipments/{{$user->id}}">Shipments</a></td>
                    </tr>
                  </table>
                </div>
                @endif
                <div class="clearfix"></div>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
        </div><!--row-->
        
        <!--if fleet owner-->
        <div class="row">
          <!-- ./col -->
        </div>
  </section><!-- /.content -->
   
@endsection