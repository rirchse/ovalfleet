@extends('user')
@section('title', 'Google Map')
@section('content')
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/map.css" rel="stylesheet" />

    <div class="jumbotron">
        <div class="container-fluid">
            <h1>Distance between cities App.</h1>
            <p>Our app will help you calculate travelling distances.</p>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="from" class="col-xs-2 control-label">From:</label>
                    <div class="col-xs-10">
                        <input type="text" id="from" placeholder="Origin" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="to" class="col-xs-2 control-label">To:</label>
                    <div class="col-xs-10">
                        <input type="text" id="to" placeholder="Destination" class="form-control">
                    </div>
                </div>
            </form>

            <div class="col-xs-offset-2 col-xs-10">
                <button class="btn btn-info btn-lg" onclick="calcRoute();">Submit</button>
            </div>
        </div>
        <div class="container-fluid">
            <div id="googleMap">

            </div>
            <div id="output">

            </div>
        </div>

    </div>

    <!-- AIzaSyCwJ2Vepe9L2Miuh7QH87SR_RItIXHlX6Q -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWsrrM_cjLyueDaFj3qvLwU0KF7ME2TIg&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/map.js"></script>

@endsection