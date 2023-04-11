@extends('print')
@section('title', 'vehicle print')
@section('content')

<div class="col-md-12 text-right toolbar-icon">
  <a href="#" title="Print" class="label label-info" onclick="window.print();"><i class="fa fa-print"></i></a>
</div>
<div id="print_header" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">
  <div class="head">
    <div class="col-md-6">
      <img src="{{ asset('img/logo.png') }}" alt="" style="width: 221px;  ">
    </div>
    <div class="col-md-6">
      <p style="float: right;border-left: 2px solid #000;padding: 11px;margin-top: -24px;">
        <i class="fa fa-clock-o"></i> Time: 04:20 pm <br>
          <i class="fa fa-phone"></i> Phone:1234567890 <br>
          <i class="fa fa-envelope"></i> Email:ovalfleet.com
      </p>
    </div>
  
    
  </div>
  <div class="col-md-6">
    <table class="table">
      <tbody>
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
              <th>vehicle Type:</th>
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
              <th>vehicle Color:</th>
              <td>{{$vehicle->color}}</td>
            </tr>
          </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table">
        <tbody>
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
              <th>vehicle Type:</th>
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
              <th>vehicle Color:</th>
              <td>{{$vehicle->color}}</td>
            </tr>        
      </tbody>
    </table>

  </div>
  <div class="clearfix"></div>
</div>
@endsection
