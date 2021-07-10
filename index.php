<?php
  $api_key = 'at_SSqNQP7l0fuO9Tm7bQb1SUL0K0cp6';
  $api_url = 'https://geo.ipify.org/api/v1';

  $url = "{$api_url}?apiKey={$api_key}&ipAddress";

   $newContents = file_get_contents($url);

  //  echo $newContents;

   $newResults = json_decode($newContents);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png">
  
  <title>Frontend Mentor | IP Address Tracker</title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@1,300&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<link rel="stylesheet" href="css/style.css"></head>
<body id="body">

  <!-- IP Address Tracker

  Search for any IP address or domain

  IP Address
  Location
  Timezone
    UTC 
    add offset value dynamically using the API
  ISP -->

  <div class="container">
    <div class="attribution">
      Challenge by <a href="https://www.frontendmentor.io?ref=challenge" target="_blank">Frontend Mentor</a>. 
      Coded by <a href="#">Daramola Olorunfemi</a>.
    </div>
    
      <h2>IP ADDRESS TRACKER</h2>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form" align = "center">
            <input id="input" name="ip" type="text" placeholder="Search for any ip address or domain"  onFocus="if (this.value !== ' ') this.style.color = 'grey';">
            <button type="submit" name="submit"> <img class="img" src="images/icon-arrow.svg" alt=""></button>
      </form>

      <?php
         error_reporting(E_ALL & ~E_NOTICE);

          if(isset($_POST['submit'])){
            $ip = htmlspecialchars(strip_tags($_POST['ip']));

            if($ip == " "){
              alert("Enter ip address"); 
            }

         
          $ip = htmlspecialchars(strip_tags($_POST['ip']));
          $api_key = 'at_SSqNQP7l0fuO9Tm7bQb1SUL0K0cp6';
          $api_url = 'https://geo.ipify.org/api/v1';
      
          $url = "{$api_url}?apiKey={$api_key}&domain={$ip}";

           $contents = file_get_contents($url);

          //  echo $contents;

           $results = json_decode($contents);

           

        //    if ($results !== null) {
        //     echo $results->ip;
        //     echo $results->location->city;
        //     echo $results->location->country;
        //     echo $results->location->postalCode;
        //     echo $results->location->timezone;
        //     echo $results->location->lat;
        //     echo $results->location->lng;
        //     echo $results->isp;
        //  } else {
        //     echo "<h1>ERR_timeout</h1>";
        //  }
        }
          
      ?>

      <div class="house">
        <div class="con-ipaddress">
            <p>ip address</p>
            <h1 id="ipaddress"><?php if($results->ip){echo $results->ip;}else {echo $newResults->ip;;} ?></h1>
        </div>
        <div class="con-city">
            <p>Location</p>
            <h1 id="city"><?php if($results->location->city && $results->location->country && $results->location->postalCode){echo $results->location->city.","." ".$results->location->country." ".$results->location->postalCode;}else { echo $newResults->location->city.","." ".$newResults->location->country." ".$newResults->location->postalCode;}?></h1>
        </div>
        <div class="con-time">
          <p>time</p>
          <h1 id="timezone"><?php if($results->location->timezone) {echo "UTC ".$results->location->timezone;}else{echo "UTC ".$newResults->location->timezone;}?></h1>
      </div>
        <div class="con-isp">
            <p>Isp</p>
            <h1 id="isp"><?php if($results->isp){echo $results->isp;}else{echo $newResults->isp;}?> </h1>
        </div>
      </div>

      <div  id="premap">
        <div id='map'></div>
      </div>
  
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script>
     var map = document.getElementById('map');
       
       if(map != undefined || map != null){
           map.remove();
          $("#map").html("");
          $("#preMap").empty();
          $( "<div id=\"map\" style=\"height: 70vh; width: 100%;\"></div>" ).appendTo("#premap");
       }

       var latitude = <?php echo $results->location->lat;?>;

       var longitude = <?php echo $results->location->lng;?>;
       console.log(latitude, longitude);

       
       var mymap = L.map('map').setView([latitude, longitude], 13);
       L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
           maxZoom: 30,
           attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
               'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
           id: 'mapbox/streets-v11',
           tileSize: 512,
           zoomOffset: -1
       }).addTo(mymap);

       L.marker([latitude, longitude]).addTo(mymap)
       .bindPopup("<b>This is the location</b>").openPopup();
       
       L.circle([latitude, longitude], 500, {
   color: 'red',
   fillColor: '#f03',
   fillOpacity: 0.5
       }).addTo(mymap).bindPopup("It's located in this vicinity");
       
       var popup = L.popup();

 function onMapClick(e) {
   popup
     .setLatLng(e.latlng)
     .setContent("You clicked the map at " + e.latlng.toString())
     .openOn(mymap);
 }

   mymap.on('click', onMapClick);
  </script>

  
  <script src="app.js"></script>

</body>
</html>

