@extends('admin')
@section('title', 'User Details')
@section('content')
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
            <h4 class="box-title">{{ $user->user_role }} Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="/admin/user/{{$user->id}}/subscribe" title="Add a Subscription" class="label label-primary"><i class="fa fa-plus"></i></a> &nbsp; &nbsp; 
            <a href="/admin/view_users/{{Session::get('_types')}}" title="View {{Session::get('_types')}} users" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="/admin/user/{{$user->id}}/edit" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
            <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
            @if($user->status == 3)
            <a href="/admin/user/{{$user->id}}/restore" class="label label-success" title="Restore the account"><i class="fa fa-undo"></i></a>
            @else
            <a href="/admin/user/{{$user->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a>
            @endif
          </div>
          <div class="col-md-6">
            <table class="table">
                <tbody>
                  <tr>
                    <th>Account Number:</th>
                    <th>{{$user->account_number}}</th>
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
                  <tr>
                    <th>VAT ID:</th>
                    <td>{{$user->vat_id}}</td>
                  </tr>
                  <tr>
                    <th>VAT Image:</th>
                    <td>
                      @if($user->vat_image)
                      <a class="btn btn-info btn-xs" target="_blank" href="/img/vat_image/{{$user->vat_image}}">View</a>
                      @endif
                    </td>
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
                    <th>City:</th>
                    <td>{{$user->city}}</td>
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
                    <th>Sign Up Date:</th>
                    <td>{{date('d M Y',strtotime($user->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Registration Date:</th>
                    <td>{{ $user->verify_date?date('d M Y', strtotime($user->verify_date)):""}}</td>
                  </tr>
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
                    <td>{{date('d M Y h:i:s A',strtotime($user->created_at) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          <p><a href="/admin/user/{{$user->id}}/delete_permanently" onclick="return confirm('Are sure you want to permanently delete this user?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
