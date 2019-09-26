<?php
$host = "localhost";
$userName = "root";
$password = "";
$dbName = "reminder";
// Create database connection
$conn = new mysqli($host, $userName, $password, $dbName);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql="select city_id,city_name from cities order by city_name asc";
if(!$city = $conn->query($sql)){
die('There was an error running the query [' . $conn->error . ']');
}
while ($row = mysqli_fetch_array($city)) {
	$cityArr[$row['city_id']] = $row['city_name'];
}


//print_r($statesArr);exit;



?>
<!DOCTYPE html>
<html>
    <head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
         <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKGacPvp2TQrhTqBb7Yr1T3dD39VXQFdM&v=3.exp&sensor=false&libraries=places"></script>
        <script type="text/javascript">
        function initialize() {
        var address = (document.getElementById('place'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || ''),
				(place.geometry.location.lat() || '' ),
				(place.geometry.location.lng() || '')
                ].join(' ');
        }
		//codeAddress();
		
		
      });
}
function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("place").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
		  address +=','+results[0].geometry.location.lat()+','+results[0].geometry.location.lng();

     // console.log("Latitude: "+results[0].geometry.location.lat());
     // console.log("Longitude: "+results[0].geometry.location.lng());
	 $('#place').val(address);
      } 

      else {
        console.log("Geocode was not successful for the following reason: " + status);
      }
    });
  }
google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    </head>
    <body>
        
   <!--     <input type="text" id="my-address"><button id="getCords" onClick="codeAddress();">getLat&Long</button>-->
		
		<body>
<div class="container">
<div class="row">
<div class="col-md-8">
<h1>Reminder Form</h1>
<form name="reminder-form" action="" method="post" id="reminder-form">
<div class="form-group">
<label >Todo</label>
<input type="text" class="form-control" name="todo" id="todo" placeholder="Todo" required>
</div>
<div class="form-group">
<label >Place</label>
<input type="text" class="form-control" name="place" id="place" placeholder="Place" required>
</div>
<div class="form-group">
<label >City</label>
<select  class="form-control selectpicker"   name="city" id="city" data-live-search="true" required>
<option value="">---select---</option>
<?php foreach($cityArr as $key => $value){?>
<option value="<?php echo isset($key)? $key : '' ;?>"><?php echo isset($value)? $value : '' ;?></option>
<?php } ?>
</select>
</div>
<div class="form-group">
<label >Month</label>
<select  class="form-control" name="month" id="month" placeholder="Phone" required>
<option value="">---select---</option>
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
</div>
<div class="form-group">
<label >Time</label>
<input name="time" id="time" class="form-control" type="time" >
</div>
<button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form">Submit</button>
<img src="loader.png" id="loading-img" style="display:none;">
</form>
<div class="response_msg"></div>
</div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> 
<script>
$(document).ready(function(){
	
$("#reminder-form").on("submit",function(e){
e.preventDefault();
$("#loading-img").css("display","block");
var sendData = $( this ).serialize();
$.ajax({
type: "POST",
url: "db_conn.php",
data: sendData,
success: function(data){
$("#loading-img").css("display","none");
$(".response_msg").text(data);
$(".response_msg").slideDown().fadeOut(3000);
}
});

});

});
</script>
</body>
    </body>
</html>
