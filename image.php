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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
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
          <a class="navbar-brand" href="index.php" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Trainspot</a>
        </ul>
        <ul class="nav navbar-expand-sm navbar-right">
          <li class="nav-item">
            <a class="nav-link" href="new.html">Neu</a>
          </li>
        </ul>
      </nav>
      <!--body-->
      <?php
        if (empty($_GET['ID']))
        {
            header("Location: index.php");
            die();
        }
        require_once('mysql.php');

        $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
        $db->set_charset("utf8");
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
      
        $id = mysqli_real_escape_string($db, $_GET['ID']);
        $sql= "SELECT * FROM entries WHERE ID = $id";
        $result = $db->query($sql);
        //print_r($result);
        //print_r($id);
      
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
          //echo "var $name = L.marker([$lat, $long], {icon: greenMarker}).addTo(mymap);\n";
         // echo "$name.bindPopup('<b>$title</b><br>$br, $datetime');\n";
        }
        //print_r($row);
      ?>
      <section class="jumbotron text-center" style="margin-top: 50px;">
        <div class="container">
          <h1 class="jumbotron-heading"><?php echo $title; ?></h1>
          <p class="lead text-muted"><?php echo $subtitle; ?></p>
        </section>
        <img src='uploads/<?php echo $ID;?>.jpg' class="mx-auto d-block" style='max-height: 1080px; margin-bottom: 32px;'>
        
<?php //TODO: allow multiple filetypes, maybe store the extension in MySQL or convert all images into the same format

?>
</html>

<style>
    body {
      padding: 0;
      margin: 0;
      /*padding-top: 50px;*/
    }
    html, body, #map {
      height: 100%;
      width: 100%;
      /*overflow: hidden;*/
    }
  </style>