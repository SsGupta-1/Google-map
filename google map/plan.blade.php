@extends('web.layouts.web_master_after_login')

@section('content')

<section class="py-60">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <div class="my-plan-heading">
            <h1>My Plans</h1>
            <p>My Subscription Plan</p>
          </div>
      </div>
      @php  $lang=Helper::getlang(); 
        $today = strtotime(date('Y-m-d'));
        $delivery_date = isset($plan['delivery_date']) ? $plan['delivery_date'] : date('Y-m-d'); 
        $delivery = strtotime($delivery_date);
        $days = (int)(($delivery - $today)/86400);
        
       @endphp

      @if(!empty($plan))
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="meat-plan-box">
                <img src="{{isset($plan['images']) ? url('').$plan['images'] : ''}}" alt="plan">

                <span>{{$plan['meal_name'] ?? ''}}</span>
              </div>
              <ul class="shiping-details">
                <li>
                  <span>Box Price</span>
                  <span>SAR {{$plan['box_price'] ?? ''}}</span>
                </li>
                <li>
                  <span>Shipping Charges</span>
                  <span>SAR {{$plan['shipping'] ?? ''}}</span>
                </li>
              </ul>
              <!-- <div class="apply-promo-code">
                <a href="javascript:void(0);">
                  Apply Promo Code
                  <img src="{{asset('web/assets/image/icons/down-icon.svg')}}" alt="down-icon">
                </a>
                <div class="form-group mt-3 promo-code-field">
                  <input type="text" placeholder="Apply Promo Code">
                  <button type="button" class="btn btn-primary"> Apply</button>
                </div>
              </div> -->
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="plan-details">
                <h4>{{$plan['meal_name'] ?? '' }}</h4>
                <span>{{$plan['total_no_of_meals'] ?? ''}} Meals For {{$plan['no_of_people'] ?? ''}} People Per Week</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="delivery-details-wrap mb-5">
            <img src="{{asset('web/assets/image/icons/order-details.svg')}}" alt="order">
            <div class="delivery-info">
              <h4>Delivery Date</h4>
             
              <span id="delivery-date">{{isset($plan['delivery_date']) ? date('j M, Y', strtotime($plan['delivery_date'])) : ''}}</span><span> From {{$plan['delivery_time_from'] ?? ''}} - {{$plan['delivery_time_to'] ?? ''}}</span>
              <span><img src="{{asset('web/assets/image/icons/rotate-icon.svg')}}" alt=""> Every Week</span>
            </div>
              @if($days > 2)
                <a href="javascript:void(0);" data-toggle="modal" data-target="#datePickerModal3">Change</a>
              @endif

          </div>
          <div class="delivery-details-wrap mb-5">
            <img src="{{asset('web/assets/image/icons/order-details.svg')}}" alt="order">
            <div class="delivery-info">
              <h4>Delivery To</h4>
              <span>Address: {{$plan['flat_no'] ?? ''}}, {{$plan['area'] ?? ''}}<br> {{$plan['nearby'] ?? ''}}, {{$plan['home_address'] ?? ''}}</span>
            </div>
            <a href="javascript:void(0);" class="change-address" data-toggle="modal" data-target="#addressModal">Change</a>
          </div>
        </div>
        <div class="col-md-12 mt-5">
          <div class="my-plan-btn-group">
            <button type="button" class="btn btn-secondary w-40" data-toggle="modal" data-target="#skipAWeekModal">You Can Skip A Week At Any Time</button>
           <!--  <button type="button" class="btn btn-secondary w-40" data-toggle="modal" data-target="#cancel-plan-modal">Cancel The Plan</button> -->
            @if($days > 2)
              <a href="{{route('make-a-plan')}}" class="btn btn-primary w-40" style="pointer-events:{{($days <= 2) ? 'none;' : ''}}">Change The Plan</a>
            @endif
          </div>
        </div>
      @else
        <div> You Have not any active Plan</div>
      @endif
    </div>
  </div>
</section>


<!-- The Modal -->
<div class="modal" id="datePickerModal3">
    <div class="modal-dialog modal-655 modal-dialog-centered">
      <div class="modal-content p-45">
    
        <!-- Modal body -->
        <div class="modal-body">
            <div>
                <input id="daterangepicker3" value="{{date('Y-m-d')}}" type="hidden">
                <div id="daterangepicker3-container" class="embedded-daterangepicker"></div>
            </div>
              <input type="hidden" name="time_for" value="{{date('Y-m-d')}}" id="time_for">
            <div class="next-btn-wrapper">
                <a class="btn btn-square" href="#" data-dismiss="modal" data-toggle="modal" data-target="#timePickerModal">Next</a>
            </div>   
        </div>
    
      </div>
    </div>
</div>

<div class="modal" id="timePickerModal">
    <div class="modal-dialog modal-655 modal-dialog-centered">
      <div class="modal-content p-26-45-45">
        <!-- Modal body -->
        <div class="modal-body">
            <div class="time-grid">
                <a href="javascript:void();"><img src="{{asset('web/assets/image/left-arrow.svg')}}"/></a>
                <h5 class="text-center mb-0">Time</h5>
                <a href="javascript:void();"><img src="{{asset('web/assets/image/right-arrow.svg')}}"/></a>
            </div>
            <input type="hidden" name="time_for_deliver" id="time_for_deliver" value="{{isset($time_slot) && isset($time_slot[0]) ? $time_slot[0]->slot : '' }}">
            <div class="time-list-wrapper">
                @if(!empty($time_slot))
                    @foreach($time_slot as $key=>$time)
                        <span data-id="{{$time->id}}" class="time-pick {{(isset($time) && ($key==0)) ? 'active' : ''}}">{{$time->slot}}</span>
                    @endforeach
                @else
                    <span>Time Slot Not Found</span>
                @endif
                
            </div>
  
            <div class="next-btn-wrapper">
                <a class="btn btn-square" href="#" data-dismiss="modal" id="save_time_change" >Save</a>
            </div>   
      </div>
    
      </div>
    </div>
</div>

<div class="modal" id="MapModal">
    <div class="modal-dialog modal-655 modal-dialog-centered">
      <div class="modal-content p-0-0-45">
        <!-- Modal body -->
        <div class="modal-body">
            <!-- <div class="time-grid address-grid" id="pac-card">
                <span></span>
                <h5 class="text-center mb-0" id="title">Address</h5>
                <a class="cross-btn" href="javascript:void();" data-dismiss="modal"><img src="{{asset('web/assets/image/cross-circle.svg')}}" /></a>
            </div> -->
            <!-- <div class="location-input " id="pac-container">
                <input  class="controls" id="pac-input" type="text" placeholder="Enter Your Address" />
                <a href="javascript:void();" class="location-grab"><img src="{{asset('web/assets/image/location-grey.svg')}}" /></a>
            </div> -->

           <div class="pac-card" id="pac-card">
     
                <div id="title" class="title">Search location</div>
                
              <div id="pac-container">
                <input id="pac-input" type="text" placeholder="Enter a location" />
              </div>
            </div>

            <div class="location-map" id="map" style="height: 500px; width: 100%"></div>
            <div id="infowindow-content">
              <span id="place-name" ></span><br />
              <span id="place-address"></span>
              <span id="latitude"></span>
              <span id="longitude"></span>
            </div>
  
            <div class="next-btn-wrapper">
                <a class="btn btn-square" href="#" id="confirm_location">Confirm Location</a>
            </div>   
      </div>
    
      </div>
    </div>
  </div>


  <div class="modal" id="addressModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{url('delivery-address-update')}}" method="post">
          @csrf
          <h5 class="text-center ">Address</h5>
          <div>
            <div class="form-group float-label col-sm-6 col-12 px-2">
              <label>Home Address</label>
              <input type="text" value="{{old('address')}}" name="address" id="address">
               <a class="location-access" id="open_map_modal" ><img src="{{asset('web/assets/image/location.svg')}}"/></a>
            </div>
            <input type="hidden" name="lat" id="lati" value="">
            <input type="hidden" name="lon" id="longi" value="">
            <div class="form-group float-label col-sm-6 col-12 px-2">
              <label>Home No./ Flat No.</label>
              <input type="text" value="{{old('home_no')}}" name="home_no" id="home_no">
            </div>
            <div class="form-group float-label col-sm-6 col-12 px-2">
              <label>Nearby</label>
              <input type="text" value="{{old('Nearby')}}" name="Nearby" id="near_by">
            </div>
            <input type="hidden" value="" id="plan_id" name="user_plan_id">
            <div class="form-group float-label col-sm-6 col-12 px-2">
              <label>Area</label>
              <input type="tetextl" value="{{old('full_address')}}" name="full_address" id="full_address">
            </div>
          </div>

          <div class="row m-0 modal-btn-wrap">
          <button type="button" class="btn btn-secondary ml-0 col-md-6" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary mr-0 col-md-6">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@php
  $week_from = isset($plan['week_date_from']) ? $plan['week_date_from'] : '';
  $week_to = isset($plan['week_date_to']) ? $plan['week_date_to'] : '';
  $user_plan_id = isset($plan['user_plan_id']) ? $plan['user_plan_id'] : '';
@endphp

@endsection

@section('script')
<script type="text/javascript">

    var week_from = "<?php echo $week_from; ?>" 
    var week_to    = "<?php echo $week_to; ?>"
    var user_plan_id = "<?php echo $user_plan_id; ?>" 
    $('#plan_id').val(user_plan_id);

      $('#daterangepicker3').on('apply.daterangepicker', function (ev, picker) {
         console.log(picker.startDate.format('YYYY/MM/DD'));
         var datenew = picker.startDate.format('YYYY/MM/DD');
         var dd = picker.startDate.format('YYYY/MM/DD');
      // date format change code
          var options = { day:'numeric', month:'short', year:'numeric' };
          var today  = new Date(dd);
          var bookDate = today.toLocaleDateString("en-US", options).replace(',','')
           console.log(bookDate)
         $('#delivery-date').html(bookDate);
         $('#time_for').val(picker.startDate.format('YYYY-MM-DD'))
      });

    $('.time-pick').on('click',function(){
        $('.time-pick').removeClass('active');
        $(this).addClass('active');
        var time = $(this).html();
        $('#time_for_deliver').val(time);
        //var bookDate = $('#daterangepicker3').val();
        
    });

    $('#save_time_change').on('click',function(){
      alert('hello');
      var bookDate = $('#time_for').val();
      var time = $('#time_for_deliver').val();
      //$('#addressModal').modal('show');

        $.ajax({
            url: "{{url('/delivery-date-update')}}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                  user_plan_id  : user_plan_id ,
                  time          : time,
                  delivery_date : bookDate,
                  week_from     : week_from,
                  week_to       : week_to,
                  
                },
            success:function(response){
                if (response.status == 200) { 
                    console.log(response);
                    window.location.reload();
                    
                }           
            },
        });
    });

    $('#open_map_modal').on('click',function(){
     // alert('hello');
      $('#addressModal').modal('hide');
      $('#MapModal').modal('show');
    });

    $('#confirm_location').on('click',function(){
      //alert('hello');
      $('#MapModal').modal('hide');
      $('#addressModal').modal('show');
    });
    

</script>

// <!-- ********** google map function staging *********--> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjG5AYmxU3g_UWQZznM4ay0Fe33FhnpMM&callback=initMap&libraries=places,geometry&v=weekly" defer></script>

<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&v=3.exp&sensor=true&libraries=places,geometry"></script> -->

<script type="text/javascript">
    /**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
var lat ="28.5018106";
var lon ="77.0836571";  
var map, infoWindow;
var gmarkers = [];

function initMap() {
  
  const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");

  map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: parseFloat(lat), lng: parseFloat(lon) },
        zoom: 13,
        mapTypeControl: true,
      });
  
 
  var options = {
    fields: ["address_components" ,"formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ['establishment'],
    //componentRestrictions: {country: 'SA'}
  };

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  var autocomplete = new google.maps.places.Autocomplete(input, options);

  autocomplete.bindTo("bounds", map);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  var marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
     draggable: true,
  });        

  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }
    marker.addListener("click", () => {
      map.setZoom(8);
      map.setCenter(marker.getPosition());
    });

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    
   
    var components = place.address_components,city='Gurgaon',country='INDIA',sublocality='Udyog vihar',sublocality2='phase V',postal='122015',administrative_area='Haryana';
    console.log(components);
      if(components){
        for(var c=0;c<components.length;++c){
        //console.log(components[c].types.join('|'))
          if(components[c].types.indexOf('sublocality_level_1')>-1){

            sublocality=components[c].long_name;
            //break;
          }
          
          if(components[c].types.indexOf('sublocality_level_2')>-1){

            sublocality2=components[c].long_name;
            //break;
          }
          if(components[c].types.indexOf('locality')>-1
              &&
             components[c].types.indexOf('political')>-1
            ){
            city=components[c].long_name;
            //break;
          }
          if(components[c].types.indexOf('administrative_area_level_1')>-1){

            administrative_area=components[c].long_name;
            //break;
          }
          if(components[c].types.indexOf('country')>-1
              &&
             components[c].types.indexOf('political')>-1
            ){
            country=components[c].long_name;
            //break;
          }
          if(components[c].types.indexOf('postal_code')>-1){
            postal=components[c].long_name;
            //break;
          }
        }
      }
      //alert(sublocality)
     // alert(sublocality2)

    var location = place.geometry.location;
    var lat = location.lat();
    var lng = location.lng();
   // console.log(lat);
    //console.log(lng);
    document.getElementById('near_by').value=city;
    document.getElementById('address').value=sublocality+', '+sublocality2;
    document.getElementById('full_address').value=administrative_area+', '+postal+' , '+country;
    document.getElementById('lati').value=location.lat();
    document.getElementById('longi').value= location.lng();
    document.getElementById('lat_lon').value= lat+', '+lng;

    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =place.formatted_address;
    infowindowContent.children["latitude"].textContent =lat;
    infowindowContent.children["longitude"].textContent =lng;
    infowindow.open(map, marker);
  });

  google.maps.event.addListener(map, 'click', function(event) {
      //alert(gmarkers.length);
     
     // console.log(gmarkers.length);
      //setTimeout(function(){marker.setMap(null); alert();}, 5000);
      //marker.setPosition(event.latLng);
      // if (marker && marker.setMap) {
      //   marker.setMap(null);
      // }
      // console.log(event.latLng.lat());
      // console.log(event.latLng.lng());
      removeMarkers();
      setnewLocation(event.latLng.lat(),event.latLng.lng());

      // latLng = event.latLng;
      // marker = new google.maps.Marker({
      //   position: latLng,
      //   map: map
      // });

      gmarkers.push(marker);

      displayLocation(event.latLng.lat(),event.latLng.lng());
  
      //marker.setMap(null);
  });

}

function removeMarkers(){
    for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}
function setnewLocation(newLat,newLng)
{
    CentralPark = new google.maps.LatLng(newLat, newLng);
    addMarker(CentralPark);

}

///******* current location *********
var current_location = navigator.geolocation.getCurrentPosition(getCoor, errorCoor, {maximumAge:60000, timeout:5000, enableHighAccuracy:true});

function getCoor(position){
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    var userLocation = lat + ', ' + lon;
    //console.log(userLocation);
    displayLocation(lat,lon);
   newLocation(lat,lon);
}
function errorCoor(){
    //console.log('errorCoor');
     lat = parseFloat(lat);
    lon = parseFloat(lon);
    newLocation(lat,lon);

}
function newLocation(newLat,newLng)
{
    map.setCenter({
        lat : newLat,
        lng : newLng,
    });
    
    //map.remove();

    CentralPark = new google.maps.LatLng(newLat, newLng);
    addMarker(CentralPark);

}
// Function for adding a marker to the page.
function addMarker(location) {
    marker = new google.maps.Marker({
        position: location,
        title : 'hello',
        map: map
    });
   marker.setVisible(true);
   gmarkers.push(marker);


    $('#latitude').html(location.lat());
    $('#longitude').html(location.lng());
    // displayLocation(location.lat(),location.lng());
}
//********** end current location*******

window.initMap = initMap;



$('#confirm').on('click',function(){
  //alert('clicked');
  var latit = $('#latitude').html();
    var longit = $('#longitude').html();
   //var city = $('#place-name').html();
   //alert(city);
  $('#lati').val(latit);
  $('#longi').val(longit);
  
  var Location = latit + ', ' + longit;
  $('#lat_lon').val(Location);
  
  // const geocoder = new google.maps.Geocoder();
  // const infowindow = new google.maps.InfoWindow();
  // geocodeLatLng(geocoder, map, infowindow);

 $('#map_modal').modal('hide');
});

// function geocodeLatLng(geocoder, map, infowindow) {
//   var latit = $('#latitude').html();
//   var longit = $('#longitude').html();
//   const latlng = {
//     lat: parseFloat(latit),
//     lng: parseFloat(longit),
//   };

//     geocoder
//     .geocode({ location: latlng })
//     .then((response) => {
//       if (response.results[0]) {
//         map.setZoom(11);

//         const marker = new google.maps.Marker({
//           position: latlng,
//           map: map,
//         });

//         infowindow.setContent(response.results[0].formatted_address);
//         infowindow.open(map, marker);
//       } else {
//         window.alert("No results found");
//       }
//     })
// }

function displayLocation(latitude,longitude){
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitude, longitude);

    geocoder.geocode(
        {'latLng': latlng}, 
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    // var add= results[0].formatted_address ;
                    // var  value=add.split(",");

                    // count=value.length;
                    // country=value[count-1];
                    // state=value[count-2];
                    // city=value[count-3];
                    // area = value[count-4];
                    // address = value[count-5]+','+value[count-6];
                    // home = value[count-7];
                    // $('#near_by').val(area+','+city);
                    // $('#address').val(address);
                    // $('#full_address').val(state+', '+country);
                    // // $('#home_no').val(latitude+', '+longitude);
                    // $('#lati').val(latitude);
                    // $('#longi').val(longitude);
                    // $('#home_no').val(home);
                    
                    // $('#pac-input').val(address+''+area+''+city+''+state+''+country);
                    // console.log(value);
                    //  console.log(state); 

                  var home = "";
                  var street = "";
                  var city = "";
                  var state = "";
                  var country = "";
                  var zipcode = "";
                  for (var i = 0; i < results.length; i++) {
                    if (results[i].types[0] === "locality") {
                        city = results[i].address_components[0].long_name;
                        state = results[i].address_components[2].long_name;

                    }
                    if (results[i].types[0] === "postal_code" && zipcode == "") {
                        zipcode = results[i].address_components[0].long_name;

                    }
                    if (results[i].types[0] === "country") {
                        country = results[i].address_components[0].long_name;

                    }
                    if (results[i].types[0] === "route" && street == "") {

                        for (var j = 0; j < 4; j++) {
                            if (j == 0) {
                               
                                home = results[i].address_components[j].long_name;
                            } else {
                                street += results[i].address_components[j].long_name+", " ;
                            }
                        }

                    }
                    // console.log(street);
                    if (results[i].types[0] === "street_address") {
                        for (var j = 0; j < 4; j++) {
                            if (j == 0) {
                                
                                home = results[i].address_components[j].long_name;
                            } else {
                                street += results[i].address_components[j].long_name+", " ;
                            }
                        }

                    }
                  }
                  if (zipcode == "") {
                      if (typeof results[0].address_components[8] !== 'undefined') {
                          zipcode = results[0].address_components[8].long_name;
                      }
                  }
                  if (country == "") {
                      if (typeof results[0].address_components[7] !== 'undefined') {
                          country = results[0].address_components[7].long_name;
                      }
                  }
                  if (state == "") {
                      if (typeof results[0].address_components[6] !== 'undefined') {
                          state = results[0].address_components[6].long_name;
                      }
                  }
                  if (city == "") {
                      if (typeof results[0].address_components[5] !== 'undefined') {
                          city = results[0].address_components[5].long_name;
                      }
                  }

                  $('#near_by').val(city);
                  $('#address').val(street);
                  $('#full_address').val(state+', '+zipcode+','+country);
                  // $('#home_no').val(latitude+', '+longitude);
                  $('#lati').val(latitude);
                  $('#longi').val(longitude);
                  $('#home_no').val(home);
                  $('#pac-input').val(home+','+street+','+city+','+state+','+zipcode+','+country);
                }
                else  {
                     console.log("address not found");
                }
            }
            else {
                 console.log("Geocoder failed due to: " + status);
            }
        }
    );
}

</script>
<!-- ****** end map function ******-->


   
@endsection