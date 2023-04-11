@extends('admin')
@section('title', 'Show Users')
@section('content')
    
<div class="row">
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
        </div>
        <h4 class="card-title">Showing User List</h4>
        <div class="card-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Contact</th>
                            <th>Job Position</th>
                            <th>Since</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $r = 0; ?>

                        @foreach($users as $user)

                        <?php $r++ ?>

                        <tr>
                            <td class="text-center">{{ $r }}</td>
                            <td>{{ $user->first_name. ' ' .$user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ $user->job_title }}</td>
                            <td>{{ date('m/d/Y', strtotime($user->created_at)) }}</td>
                            <td class="td-actions text-right">
                                <a href="/admin/user/{{$user->id}}" rel="tooltip" class="btn btn-info btn-simple">
                                    <i class="material-icons">person</i>
                                </a>
                                <a href="/admin/user/{{$user->id}}" rel="tooltip" class="btn btn-success btn-simple">
                                    <i class="material-icons">edit</i>
                                </a>
                                <a href="button" rel="tooltip" class="btn btn-danger btn-simple">
                                    <i class="material-icons">close</i>
                                </a>
                            </td>
                        </tr>

                        

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>  
@endsection