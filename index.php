<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>trainspot</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="icon" type="image/png" href="img/favicon.png" sizes="512x512">
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--FontAwesome-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/> <!--Leaflet-->
    <link rel="stylesheet" href="css/css.css">
    <script src="js/bootstrap.min.js"></script>
    <meta name="description" content="" />
    <meta name="robots" content="nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-providers@1.9.0/leaflet-providers.min.js"></script>
    <!--Eigene Scripts-->
    <script src="js/markerColoured.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm navbar-default fixed-top">
        <ul class="nav navbar-nav">
          <a class="navbar-brand" href="#" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Trainspot</a>
        </ul>
        <ul class="nav navbar-expand-sm navbar-right">
          <li class="nav-item">
            <a class="nav-link" href="new.html">Neu</a>
          </li>
        </ul>
      </nav>
            <div id="map">
                <!--<h1 class="text-center">Karte</h1>-->
                <div id="mymap" style="height: 100%; width: auto;"></div>
            <!--</div>-->
  </body>
  <script>
    var mymap = L.map('mymap').setView([50.885708708915175, 10.409545898437498], 7);
    //var mymap = L.map('mymap').fitWorld();
    
        L.tileLayer.provider('OpenStreetMap.DE', {
                'attribution':  'Kartendaten &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Mitwirkende',
                'useCache': true
        }).addTo(mymap);
        L.tileLayer.provider('OpenRailwayMap', {
                'attribution':  'Kartendaten &copy; <a href="https://www.openstreetmap.org/copyright">OpenRailwayMap</a> Mitwirkende',
                'useCache': true
        }).addTo(mymap);

      window.onload = function() { mymap.invalidateSize(); };
      //var marker1 = L.marker([50.1040056, 8.6386071]).addTo(mymap);
  //var frankfurtMarker = L.marker([50.1040056, 8.6386071]).addTo(mymap);
  //frankfurtMarker.bindPopup("<b>BillBack Frankfurt</b><br>Kriegkstraße 73, Frankfurt am Main").openPopup();
  /*var dietzenbachMarker = L.marker([50.0103836, 8.775848]).addTo(mymap);
  dietzenbachMarker.bindPopup("<b>BillBack Dietzenbach</b><br>Babenhäuser Str. 47, Dietzenbach");
  var oberRodenMarker = L.marker([49.9792395, 8.8244755,17]).addTo(mymap);
  oberRodenMarker.bindPopup("<b>BillBack Dietzenbach</b><br>Frankfurter Straße 16, Ober-Roden");*/

  /*var data = { "name": "Bild 1", "locationX": 51.0312957, "locationY": 11.5062509};
  console.log(data["name"]);
  var entry = {
    name: data["name"],
    x: data["locationX"],
    y: data["locationY"]
  }
  var entryMarker = L.marker([entry.x, entry.y]).addTo(mymap);
  entryMarker.bindPopup(entry.name);*/

  /*for (var i = 0, len = 100; i < len; i++) {
    var min = 50,
        max = 53,
        x = Math.random() * (max - min) + min;
    var min = 7,
        max = 13,
        y = Math.random() * (max - min) + min;
    var entry = {
        x: x,
        y: y,
        name: i
    }
    this["entryMarker"+i] = L.marker([entry.x, entry.y], {icon: greenMarker}).addTo(mymap);
    this["entryMarker"+i].bindPopup(entry.name.toString());
  }*/

<?php
  require_once('mysql.php');

  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  $sql="SELECT * FROM entries";
  $result = $db->query($sql);

  while($row=mysqli_fetch_array($result)){
    $ID = $row['ID'];
    $title = $row['title'];
    $subtitle = $row['subtitle'];
    $br1 = $row['br1'];
    $br2 = $row['br2'];
    $lat = $row['lat'];
    $long = $row['lng'];
    $date = $row['date'];

    $name = "marker" . $ID;
    $br = $br1 . "-" . $br2;
    $datetime = date("d.m.y", strtotime($date));
    echo "var $name = L.marker([$lat, $long], {icon: greenMarker}).addTo(mymap);\n";
    echo "$name.bindPopup('<a href=" . '"image.php?ID=' . "$ID" . '"' . ">$title</a><br>$br, $datetime');\n";
  }
?>

  </script>
  <style>
    body {
      padding: 0;
      margin: 0;
      padding-top: 50px;
    }
    html, body, #map {
      height: 100%;
      width: 100%;
      overflow: hidden;
    }
  </style>
</html>