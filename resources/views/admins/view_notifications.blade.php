@extends('admin')
@section('title', 'View Notifications')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Notifications</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> View Notifications</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-10">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Notifications</h3>

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
              <div class="col-md-5 col-md-offset-10">
                   <a href="/view_vehicles" title="Vehicle Details" class="label label-success"><i class="fa fa-list"></i></a>
                    <a href="/view_vehicles" title="Vehicle Details" class="label label-info"><i class="fa fa-print"></i></a>
              </div>
              
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Title</th>
                  <th>Created By</th>
                  <th>Created On</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($alerts as $alert)
                <?php $r++; ?>

                <tr>
                  <td>{{$alert->title}}</td>
                  <td>
                    <?php $createdby = App\User::find($alert->created_by); ?>
                    {{$createdby?$createdby->first_name.' '.$createdby->last_name:''}}
                  </td>
                  <td>{{$alert->created_at?date('d M Y', strtotime($alert->created_at)):''}}</td>
                  <td>
                    @if($alert->status == 1)
                    <label class="label label-default">Read</label>
                    @else
                    <label class="label label-warning">Unread</label>
                    @endif
                  </td>
                  <td>
                    <a href="/notification/{{$alert->id}}/details" title="Notification Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/alert/{{$alert->id}}/edit" class="label label-warning" title="Edit alert"><i class="fa fa-edit"></i></a>
                    <a href="/alert/{{$alert->id}}/delete" class="label label-danger" title="Delete alert" onclick="return confirm('Are you sure you want to delete this alert?');"><i class="fa fa-trash"></i></a> --}}

                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$alerts->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection