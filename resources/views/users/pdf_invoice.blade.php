<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice PDF</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
</head>
<body>
<div id="print_header" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">

  <table style="width:100%">
      <tr>
        <td style="vertical-align:top"><img src="{{ asset('img/logo.png') }}" alt="" style="width: 221px;"></td>
        <td>
          <div style="text-align:right!important; vertical-align:top">
            Record Created On: {{date('d M Y h:i:s',strtotime($invoice->created_at) )}}<br>
            Record Updated On: {{$invoice->updated_at?date('d M Y h:i:s',strtotime($invoice->updated_at) ):'..................'}}<br>
            Created By: {{$invoice->created_by?App\User::find($invoice->created_by)->user_role:'..................'}}<br>
            Updated By: {{$invoice->updated_by?App\User::find($invoice->updated_by)->user_role:'..................'}}<br>
          </div>
        </td>
      </tr>
    </table>
    <br>
    <table style="width:100%">
      <tr>
        <td style="vertical-align:top;padding-right:15px">
          <table class="table">
            <tr>
              <th>Name:</th>
              <td>{{$invoice->first_name.' '.$invoice->middle_name.' '.$invoice->last_name}}</td>
            </tr>
            <tr>
              <th>Company:</th>
              <td>{{$invoice->organization}}</td>
            </tr>
            <tr>
              <th>Address:</th>
              <td>{{$invoice->address.' '.$invoice->city.' '.$invoice->state.' '.$invoice->zip_code.' '.$invoice->country}}</td>
            </tr>
            <tr>
              <th>Email:</th>
              <td>{{$invoice->email}}</td>
            </tr>
            <tr>
              <th>VAT ID:</th>
              <td>{{$invoice->vat_id}}</td>
            </tr>
            <tr>
              <th>Phone:</th>
              <td>{{$invoice->contact}}</td>
            </tr>
            </table>
        </td>
        <td style="vertical-align:top">
          <table class="table">
            <tr>
              <th>Plan Name:</th>
              <td>{{$invoice->package_name}}</td>
            </tr>
            <tr>
              <th>Amount Paid:</th>
              <td>{{$invoice->paid_amount?'$'.$invoice->paid_amount:''}}</td>
            </tr>
            <tr>
              <th>Valid Until:</th>
              <td>{{date('d M Y', strtotime($invoice->valid_until))}}</td>
            </tr>
            <tr>
              <th>Status:</th>
              <td>
                @if($invoice->status == 0)
                <span class="label label-warning">Unpaid</span>
                @elseif($invoice->status == 1)
                <span class="label label-success">Paid</span>
                @elseif($invoice->status == 2)
                <span class="label label-danger">Unpaid</span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Invoice Delivery:</th>
              <td>Email Only</td>
            </tr>
            <tr>
              <th>Record Created On:</th>
              <td>{{date('d M Y h:i:s A',strtotime($invoice->created_at) )}} </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</div>
  
</body>
</html>
