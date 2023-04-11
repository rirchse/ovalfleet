@extends('user')
@section('title', 'Ticket Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Ticket Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Ticket</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> <!-- left column -->
      <div class="col-md-4"> <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Ticket Number <b>[{{$ticket->ticket_id}}]</b></h4>
          </div>

          <div class="col-md-12 text-right toolbar-icon">
            <a href="/ticket" title="View Tickets" class="label label-success"><i class="fa fa-list"></i></a>

            @if($ticket->status == 0)
            <a href="/ticket/{{$ticket->id}}/edit" class="label label-warning" title="Edit ticket"><i class="fa fa-edit"></i></a>

            {{ Form::open(['route' => ['ticket.destroy', $ticket->id], 'method' => 'DELETE', 'class' => ' pull-right no-border']) }}
            <button type="submit" class="label label-danger" title="Delete ticket" onclick="return confirm('Are you sure you want to delete this ticket?');"><i class="fa fa-trash"></i></button>
            {{ Form::close() }}
            @endif
          </div>

          <div class="col-md-12">
            <table class="table">
              <tr>
                <th>Created On:</th>
                <td>{{$ticket->created_at?date('d M Y h:i A', strtotime($ticket->created_at)):''}}</td>
              </tr>
              <tr>
                <th>Updated On:</th>
                <td>{{$ticket->updated_at?date('d M Y h:i A', strtotime($ticket->updated_at)):''}}</td>
              </tr>
              <tr>
                <th>Status:</th>
                <td>
                  @if($ticket->status == 0)
                  <label class="label label-danger">Open</label>
                  @elseif($ticket->status == 1)
                  <label class="label label-warning">Awaiting Customer</label>
                  @elseif($ticket->status == 2)
                  <label class="label label-success">Closed</label>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Closed On:</th>
                <td>{{$ticket->closed_at?date('d M Y h:i A', strtotime($ticket->closed_at)):''}}</td>
              </tr>
            </table>
          </div>
                
          <div class="clearfix"></div>
          <div class="box-footer">
            {{-- <button class="btn btn-info pull-right" data-target="#modal-default" data-toggle="modal">Give a feedback</button> --}}
          </div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
      <div class="col-md-8">
        <div class="box box-info collapsed-box">
            <div class="box-header">
              <i class="fa fa-pencil"></i>

              <h3 class="box-title">Quick Reply</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse"data-toggle="tooltip" title="Reply"> <i class="fa fa-plus"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">

              {!! Form::open(['route' => ['ticket.reply', $ticket->id], 'method' => 'POST']) !!}
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" value="{{$ticket->reason}}" disabled>
                </div>
                <div>
                  <textarea name="message" class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                </div>
            </div>

            <div class="box-footer">
              <button type="submit" class="pull-right btn btn-info" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
            {!! Form::close() !!}
          </div>

          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-info direct-chat direct-chat-primary">

              <!--main message-->
              {{-- <div class="col-xs-12"> --}}
                <div class="panel panel-warning">
                  <div class="panel-heading"><b>Nature of Inquiry: </b> {{$ticket->reason}}</div>
                  <div class="panel-body"><b>Details:</b> {!!$ticket->details!!}</div>
                  @if($ticket->file !== null)
                    <div class="panel-body"><b>File:</b> <a href="{{asset('support_ticket/'.$ticket->file)}}" target="_blank">File</a> </div>
                  @endif
                  <div class="panel-body">
                    <style type="text/css">
                      .feedback a{color: #FFD500;font-size:20px}
                    </style>
                    <div class="feedback clearfix text-left" title="Feedback">
                      @for($f = 1; $f <= 5; $f++)
                      @if($ticket->feedback >= $f)
                      <a href="/ticket/{{$ticket->id}}/feedback/{{$f}}"><i class="fa fa-star"></i></a>
                      @else
                      <a href="/ticket/{{$ticket->id}}/feedback/{{$f}}"><i class="fa fa-star-o"></i></a>
                      @endif
                      @endfor
                      <br><small>Rate and close the ticket. You can always change the rating.</small>
                    </div>
                  </div>
                </div>
              {{-- </div> --}}
            <!--/main message closed-->

            <div class="box-header with-border">
              <i class="fa fa-comments-o"></i>
              <h3 class="box-title">Messages </h3>
              <div class="box-tools pull-right">
                <a class="btn btn-info" href=""><i class="fa fa-refresh"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->

                @foreach($messages as $msg)
                @if($msg->user_type == 'User')
                <?php
                $msguser = [];
                if(App\User::find($msg->user_id)){
                  $msguser = App\User::find($msg->user_id);
                }
                ?>

                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$msguser->first_name.' '.$msguser->last_name}} <label class="label label-info">{{$msg->user_type}}</label></span>
                    <span class="direct-chat-timestamp pull-right">{{$msg->created_at?date('d M Y h:i:s a', strtotime($msg->created_at)):''}}</span>
                  </div>
                  <!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="/img/{{$msguser->image?'profile/'.$msguser->image:'avatar.png'}}" alt="Message User Image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    {!!$msg->message!!}
                  </div> <!-- /.direct-chat-text -->
                </div> <!-- /.direct-chat-msg -->
                <hr>

                @else
                <?php
                $msguser = [];
                if(App\Admin::find($msg->user_id)){
                  $msguser = App\Admin::find($msg->user_id);
                }
                ?>

                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">{{$msguser->first_name.' '.$msguser->last_name}} <label class="label label-info">{{$msg->user_type}}</label></span>
                    <span class="direct-chat-timestamp pull-left">{{$msg->created_at?date('d M Y h:i:s a', strtotime($msg->created_at)):''}}</span>
                  </div> <!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="/img/{{$msguser->image?'profile/'.$msguser->image:'avatar.png'}}" alt="Message User Image"> <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    {!!$msg->message!!}
                  </div> <!-- /.direct-chat-text -->
                </div> <!-- /.direct-chat-msg -->
                <hr>

                @endif
                @endforeach

              </div> <!--/.direct-chat-messages-->
            </div> <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
      </div><!--/.col-->
    </div><!--/.row-->
  </section><!-- /.content -->

  <!-- Shipment Confirmation Dialogue Box -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        {!! Form::model($ticket, ['route' => ['ticket.feedback', $ticket->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Give a Feedback</h4>
        </div>
        <div class="modal-body">
          <div class="form-group ">
            {{ Form::label('comment', 'Note:', ['class' => 'control-label']) }}
            {{ Form::textarea('comment', $ticket->feedback, ['class' => 'form-control', 'rows'=>'3', 'placeholder'=>'Please write details here.', 'required'=>'']) }}
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">&times;</button> --}}
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->
   
@endsection
