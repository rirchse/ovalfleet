//javascript.js
//set map options
var myLatLng = { lat: 39.004271, lng: -97.904961 };
var mapOptions = {
    center: myLatLng,
    zoom: 4,
    mapTypeId: google.maps.MapTypeId.ROADMAP

};

//create map
var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

//create a DirectionsService object to use the route method and get a result for our request
var directionsService = new google.maps.DirectionsService();

//create a DirectionsRenderer object which we will use to display the route
var directionsDisplay = new google.maps.DirectionsRenderer();

//bind the DirectionsRenderer to the map
directionsDisplay.setMap(map);


//define calcRoute function
function calcRoute() {
    //create request
    var request = {
        origin: document.getElementById("loading_point").value,
        destination: document.getElementById("unload_point").value,
        travelMode: google.maps.TravelMode.DRIVING, //WALKING, BYCYCLING, TRANSIT
        unitSystem: google.maps.UnitSystem.IMPERIAL
    }

    //pass the request to the route method
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {

            //Get distance and time
            // $("#output").html("<div class=''>From: " + document.getElementById("from").value + ".<br />To: " + document.getElementById("to").value + ".<br /> Driving distance: " + result.routes[0].legs[0].distance.text + ".<br />Duration: " + result.routes[0].legs[0].duration.text + ".</div>");

            // $("#loadfrom").html(document.getElementById("from").value);
            // $("#unloadto").html(document.getElementById("to").value);
            $("#distance").val(result.routes[0].legs[0].distance.text);
            $("#duration").val(result.routes[0].legs[0].duration.text);
            // $("#distanc_in_modal").html(result.routes[0].legs[0].distance.text);
            // $("#duration_in_modal").html(result.routes[0].legs[0].duration.text);

            //display route
            directionsDisplay.setDirections(result);
        } else {
            //delete route from map
            directionsDisplay.setDirections({ routes: [] });
            //center map in London
            map.setCenter(myLatLng);

            //show error message
            // $("#output").html("<div class='alert-danger'>Could not retrieve driving distance.</div>");
        }
    });

}



//create autocomplete objects for all inputs
var options = {
    types: ['(cities)']
}

var input1 = document.getElementById("loading_point");
var autocomplete1 = new google.maps.places.Autocomplete(input1, options);

var input2 = document.getElementById("unload_point");
var autocomplete2 = new google.maps.places.Autocomplete(input2, options);

//get google map free route for Driver and Shipper
  function GetFreeRoute(){
    var loading_point = document.getElementById('loading_point').value;
    var unload_point = document.getElementById('unload_point').value;
    if(loading_point != '' && unload_point != ''){
      window.open('https://www.google.com/maps/dir/'+loading_point+'/'+unload_point, '_blank');
    }else{
      alert('Please enter load point and unload point');
    }
    
  }