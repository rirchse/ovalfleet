@extends('admin')
@section('title', 'View Tickets')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Open Tickets</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Support</a></li>
        <li class="active"> View Open Tickets</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box col-md-12">
            <div class="box-header">
              <h3 class="box-title">List of Open Tickets</h3>

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
              <table id="datatables" class="table table-hover">
                <thead>
                  <tr>
                    <th>User Information</th>
                    <th>Ticket No.</th>
                    <th>Opened</th>
                    <th>Status</th>
                    <th>Subject</th>
                    <th>Details</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <?php $r = 0; ?>

                @foreach($tickets as $ticket)
                <?php $r++; ?>

                <tr style="background: #fd9">
                  <td>
                    @if(App\User::find($ticket->created_by))
                    <?php $ticketUser = App\User::find($ticket->created_by); ?>
                    {{$ticketUser->user_role}}
                    @endif
                  </td>
                  <td>{{$ticket->ticket_id}}</td>
                  <td>{{$ticket->created_at?date('d M Y', strtotime($ticket->created_at)):''}}</td>
                  <td>
                    @if($ticket->status == 1)
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
                    <a href="/admin/ticket/{{$ticket->id}}" title="Ticket Details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/ticket/{{$ticket->id}}/edit" class="label label-warning" title="Edit ticket"><i class="fa fa-edit"></i></a>
                    <a href="/ticket/{{$ticket->id}}/delete" class="label label-danger" title="Delete ticket" onclick="return confirm('Are you sure you want to delete this ticket?');"><i class="fa fa-trash"></i></a> --}}

                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$tickets->links()}} --}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->

    <input type="hidden" id="tickets" value="{{count($tickets)}}">

@endsection

@section('scripts')
    <script type="text/javascript">
    var tickets = document.getElementById('tickets');
    if( tickets.value > 0){
      //text to voice 
      // responsiveVoice.speak("Open ticket available", "US English Female");
    }

    setTimeout(function(){
      window.location = '/admin/view_opened_tickets';
    }, 30000);

    </script>
@endsection