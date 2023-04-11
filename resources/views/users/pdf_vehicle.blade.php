<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vehicle PDF</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
</head>
<body>
<div id="print_header" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">

  <table style="width:100%">
      <tr>
        <td style="vertical-align:top"><img src="{{ asset('img/logo.png') }}" alt="" style="width: 221px;"></td>
        <td>
          <div style="text-align:right!important; vertical-align:top">
            Record Created On: {{date('d M Y h:i:s',strtotime($vehicle->created_at) )}}<br>
            Record Updated On: {{$vehicle->updated_at?date('d M Y h:i:s',strtotime($vehicle->updated_at) ):'..................'}}<br>
            Created By: {{$vehicle->created_by?App\User::find($vehicle->created_by)->user_role:'..................'}}<br>
            Updated By: {{$vehicle->updated_by?App\User::find($vehicle->updated_by)->user_role:'..................'}}<br>
          </div>
        </td>
      </tr>
    </table>
    <br>
    <table>
      <tr>
        <td style="vertical-align:top;padding-right:15px">
          <table class="table">
            <tr>
                  <th>Vehicle Name:</th>
                  <td>{{$vehicle->name}}</td>
                </tr>
                <tr>
                  <th>VIN/SN:</th>
                  <td>{{$vehicle->vinsn}}</td>
                </tr>
                <tr>
                  <th>License Plate:</th>
                  <td>{{$vehicle->license_plate}}</td>
                </tr>
                <tr>
                  <th>Vehicle Type:</th>
                  <td>{{$vehicle->vehicle_type}}</td>
                </tr>
                <tr>
                  <th>Year:</th>
                  <td>{{$vehicle->year}}</td>
                </tr>
                <tr>
                  <th>make:</th>
                  <td>{{$vehicle->make}}</td>
                </tr>
                <tr>
                  <th>Model No:</th>
                  <td>{{$vehicle->model_no}}</td>
                </tr>
                <tr>
                  <th>Registration State/Province:</th>
                  <td>{{$vehicle->province}}</td>
                </tr>
                <tr>
                  <th>Vehicle Color:</th>
                  <td>{{$vehicle->color}}</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align:top">
          <table class="table">
             <tr>
              <th>Status:</th>
              <td>{{$vehicle->vehicle_status}}</td>
            </tr>
            <tr>
              <th>Body Type:</th>
                  <td>{{$vehicle->body_type}}</td>
                </tr>
                <tr>
                  <th>Purchase Date:</th>
                  <td>{{$vehicle->purchase_date}}</td>
                </tr>
                <tr>
                  <th>Mileage (when Purchased):</th>
                  <td>{{$vehicle->mileage}}</td>
                </tr>
                <tr>
                  <th>Record Created On:</th>
                  <td>{{date('d M Y h:i:s',strtotime($vehicle->created_at) )}} </td>
                </tr>
                <tr>
                  <th>Comment:</th>
                  <td>{{$vehicle->comments}}</td>
                </tr>
          </table>
        </td>
      </tr>
    </table>
</div>
  
</body>
</html>
