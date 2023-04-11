@extends('admin')
@section('title', 'View Admins Accounts')
@section('content')
    
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create a Account</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Create a Account</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Create a New Account</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="material-datatables">
                    <table id="" class="table table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Permission</th>
                                <th>Join Date</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Permission</th>
                                <th>Join Date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php $r = 0; ?>

                            @foreach($users as $user)

                            <?php $r++; ?>

                            @if($user->user_role != 'SUPER-ADMIN')

                            <tr>
                                <td>{{$r}}</td>
                                <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->user_role }}</td>
                                <td title="{{ date('h:i:s', strtotime($user->created_at)) }}">{{ date('d M Y', strtotime($user->created_at)) }}</td>
                                <td class="text-right">
                                    {{-- <a href="/admin/admin/{{ $user->id }}/edit" class="label label-info btn-icon"><i class="fa fa-file-text"></i></a> --}}
                                    <a href="/admin/admin/{{$user->id}}/edit" class="label label-warning btn-icon" title="Edit the record"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            @endif

                            @endforeach

                        </tbody>
                    </table>
                </div><!-- material datatable -->
            </div>

            </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection

@section('scripts')

@endsection

@section('scripts')
    <script type="text/javascript">
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(function () {
      swal(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    })
    </script>
@endsection