@extends('user')
@section('title', 'View Shipments')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View All Shipments</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Shipments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Shipments</h3>

              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Shipper</th>
                  <th>Driver</th>
                  <th>Dispatcher</th>
                  <th>Loading Point</th>
                  <th>Unload Point</th>
                  <th>Shipment Cost</th>
                  <th>Extra Charge</th>
                  <th>Goods</th>
                  <th>Created On</th>
                  <th>Action</th>
                </tr>

                @foreach($shipments as $shipment)

                <tr>
                  <td>{{$shipment->id}}</td>
                  <td>
                    @if(App\User::find($shipment->shipper_id))
                    {{App\User::find($shipment->shipper_id)->first_name}}
                    @endif
                  </td>
                  <td>
                    @if(App\User::find($shipment->driver_id))
                    {{App\User::find($shipment->driver_id)->first_name}}
                    @endif
                  </td>
                  <td>
                    @if(App\User::find($shipment->dispatcher_id))
                    {{App\User::find($shipment->dispatcher_id)->first_name}}
                    @endif
                  </td>
                  <td>{{$shipment->loading_point}}</td>
                  <td>{{$shipment->unload_point}}</td>
                  <td>{{number_format($shipment->shipment_cost, 2)}}</td>
                  <td>{{$shipment->extra_charge?number_format($shipment->extra_charge, 2)}}</td>
                  <td>{{$shipment->goods_description}}</td>
                  <td>{{ date('d M Y', strtotime($shipment->created_at))}}</td>
                  <td>
                    <a href="/shipment/{{ $shipment->id }}/details" class="label label-info"><i class="fa fa-file-text"></i></a>
                    <a href="/shipment/{{$shipment->id}}/edit" class="label label-warning"><i class="fa fa-edit"></i></a>
                    <a href="/shipment/{{$shipment->id}}/delete" class="label label-danger" onclick="return confirm('Are you sure you want to delete this shipment?');"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$shipments->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection