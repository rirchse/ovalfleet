@extends('user')
@section('title', 'View Tickets')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Tickets</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Support</a></li>
        <li class="active"> View Tickets</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-10">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Tickets</h3>

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
                  <th>Ticket No.</th>
                  <th>Opened</th>
                  <th>Status</th>
                  <th>Subject</th>
                  <th>Details</th>
                  <th>Updated</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($tickets as $ticket)
                <?php $r++; ?>

                <tr>
                  <td>{{$ticket->ticket_id}}</td>
                  <td>{{$ticket->created_at?date('d M Y', strtotime($ticket->created_at)):''}}</td>
                  <td>
                    @if($ticket->status == 1)
                    <label class="label label-warning">Awaiting Customer</label>
                    @elseif($ticket->status == 2)
                    <label class="label label-success">Closed</label>
                    @else
                    <label class="label label-danger">Open</label>
                    @endif
                  </td>
                  <td>{{$ticket->reason}}</td>
                  <td>
                    @if(strlen($ticket->details) > 20)
                    {!!substr($ticket->details, 0, 20).'...'!!}
                    @else
                    {!!$ticket->details!!}
                    @endif
                  </td>
                  <td>{{$ticket->updated_at?date('d M Y', strtotime($ticket->updated_at)):''}}</td>
                  <td>
                    <a href="/ticket/{{$ticket->id}}" title="Ticket Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    
                    @if($ticket->status == 0)
                    <a href="/ticket/{{$ticket->id}}/edit" class="label label-warning" title="Edit ticket"><i class="fa fa-edit"></i></a>
                    @endif
                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$tickets->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection