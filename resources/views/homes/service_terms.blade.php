@extends('home')
@section('title', 'Service Terms')
@section('content')
<style type="text/css">
 .service-terms{margin-top:100px; margin-bottom:35px; border: 1px solid #ddd;}
 .service-terms h3{text-align: center;border-bottom: 1px solid #ddd;padding-bottom: 10px;margin-top: 10px; font-size: 22px}
 .service-terms ul{padding-left: 25px; padding-top: 25px;padding-bottom: 25px}
 .service-terms ul li{text-align: justify;padding-right: 30px;margin-bottom: 10px;}
 </style>
<div class="main-wrapper" stlye="width:100%;">
	<div class="row">
   <div class="col-md-8 col-md-offset-2">
     <div class="service-terms">
     	@include('homes.service-terms-text')
     	{{-- <br>
      <div class="col-md-12" style="text-align:center">
        <a class="btn btn-warning" href="#" style="margin-top:-50px" onclick="window.history.back();">I agree</a>
      </div> --}}
     		<div class="clearfix"></div>     	
     </div>
   </div>
</div>
@endsection