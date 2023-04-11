@extends('admin')
@section('title', 'View All Users')
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
              <h3 class="box-title">List of User Accounts</h3>
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
              <div class="material-datatables">
              <table id="" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Account Number</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Registration Date</th>
                  <th>Renewal Date</th>
                  <th>Type</th>
                  <th>Subscription</th>
                  <th>Payment Type</th>
                  <th width="110">Action</th>
                </tr>
              </thead>

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
                  <td>{{$user->verify_date?date('d M Y', strtotime($user->verify_date)):""}}</td>
                  <td>
                    <?php
                    $subscription = App\Subscription::where('user_id', $user->id)->first();
                    $mypackage = App\Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first()
                    ?>
                    @if(!empty($mypackage->expires_on) && !empty($subscription))
                    {{ date('d M Y', strtotime($mypackage->expires_on."+1 day")) }}
                    @endif
                  </td>

                  <td>{{ $user->user_role }}</td>                  
                  @if($user->subscription == null)
                  <td> -- </td>
                  @else
                  <td>{{ $user->subscription->name }}</td>
                  @endif
                  @if($user->payment_type == 'CARD_PAYMENT')
                  <td>Card</td>
                  @elseif($user->payment_type == 'ACH_PAYMENT')
                  <td>Bank</td>
                  @elseif(!empty($user->requested_plan_id))
                  <td>Pending Verification</td>
                  @else
                  <td> -- </td>
                  @endif
                  <td>
                    <a href="/admin/user/{{$user->id}}/details" class="label label-info" title="User Details"><i class="fa fa-file-text"></i></a>
                    <a href="/admin/user/{{$user->id}}/edit" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
                    @if($user->status == 1)
                    <a href="/admin/loginto/{{$user->id}}" target="_blank" class="label label-success" title="Login to this account"><i class="fa fa-search-plus"></i></a>
                    @endif
                    @if($user->status == 0)
                    <a href="/admin/resend_email_verification/{{$user->id}}" class="label label-primary" onclick="return confirm('Are you sure you want to resend email verification to this user?')" title="Resend verification email."><i class="fa fa-envelope-o"></i></a>
                    @endif
                    @if($user->status == 3)
                    <a href="/admin/user/{{$user->id}}/restore" class="label label-success" title="Restore the account" onclick="return confirm('Are you sure you want to restore the account?')"><i class="fa fa-undo"></i></a>
                    @endif
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
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
@section('scripts')
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
@endsection