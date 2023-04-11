@extends('user')
@section('title', 'Notification Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Notification Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Notification</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Notification Details</h4>
          </div>

          <div class="col-md-12">
            <table class="table">
              <tr>
                <th>Title:</th>
                <td>{{$alert->title}}</td>
              </tr>
              {{-- <tr>
                <th>Details</th>
                <td>{{$alert->message}}</td>
              </tr> --}}
              <tr>
                <th>Created By:</th>
                <td>{{$alert->first_name.' '.$alert->last_name.' ('.$alert->user_role.')'}}</td>
              </tr>
              <tr>
                <th></th>
                <td><a href="{{$alert->url}}">Read more...</a></td>
              </tr>
            </table>
          </div>
                
          <div class="clearfix"></div>
          </div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
