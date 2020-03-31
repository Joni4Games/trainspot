<?php
if (empty($_POST))
{
    header("Location: index.php");
    die();
}
    //TODO: seperate br and br-type DONE
    require_once('mysql.php');

    $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
    $db->set_charset("utf8");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    if (isset($_POST['title'])) { //title *
        $title=mysqli_real_escape_string($db, $_POST['title']);
    }
    if (isset($_POST['subtitle'])) { //subtitle
        $subtitle=mysqli_real_escape_string($db, $_POST['subtitle']);
    }
    if (isset($_POST['br1'])) { //br *
        $br1=mysqli_real_escape_string($db, $_POST['br1']);
    }
    if (isset($_POST['br2'])) { //br
        $br2=mysqli_real_escape_string($db, $_POST['br2']);
    }
    if (isset($_POST['address'])) { //address *
        $address=mysqli_real_escape_string($db, $_POST['address']);
    }
    if (isset($_POST['lat'])) { //lat *
        $lat=mysqli_real_escape_string($db, $_POST['lat']);
    }
    if (isset($_POST['long'])) { //lat *
        $long=mysqli_real_escape_string($db, $_POST['long']);
    }

    //insert into db
    $stmt = $db->prepare("INSERT INTO entries (title, subtitle, br1, br2, address, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisdd", $s_title, $s_subtitle, $s_br1, $s_br2, $s_address, $s_lat, $s_lng);

    $s_title = $title;
    $s_subtitle = $subtitle;
    $s_br1 = $br1;
    $s_br2 = $br2;
    $s_address = $address;
    $s_lat = $lat;
    $s_lng = $long;

    $stmt->execute();
    ///echo "Erfolgreich.";
    $maxID = $stmt->insert_id;
    $stmt->close();
    //end
    //$db->close();

    /*$sql = "SELECT max(ID) FROM entries";
    $result = $db->query($sql);
    $row=mysqli_fetch_array($result);
    $maxID = $row['ID'];*/

    $db->close();

    //process image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]); //replace with image number and userID
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $finalName = $target_dir . $maxID . "." . $imageFileType;
    //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //$target_file = $target_dir . $maxID . $imageFileType; //replace with image number and userID
    print_r($target_file);
    print_r($imageFileType);
    $uploadOk = 1;
    
    ///print_r($imageFileType);
    $check = getimagesize($_FILES["file"]["tmp_name"]);

    if($check !== false) {
        ///echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["file"]["size"] > 10000000) { //10MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    //Check image rotation
    $exif = exif_read_data($_FILES["file"]["tmp_name"]);
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        //if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $finalName)) {
            echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";

            if (!empty($exif['Orientation'])) {
                $image = imagecreatefromjpeg($finalName);
                switch ($exif['Orientation']) {
                    case 3:
                        $image = imagerotate($image, 180, 0);
                        break;
        
                    case 6:
                        $image = imagerotate($image, -90, 0);
                        break;
        
                    case 8:
                        $image = imagerotate($image, 90, 0);
                        break;
                }
        
                imagejpeg($image, $finalName, 90);
                echo "Some turning was needed.";
            } else {
                echo "No turning was needed.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }   


?>
