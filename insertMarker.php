<?php
    require_once('connect.php');
    $data = isset($_POST['array']) ? $_POST['array'] : false;
    
    if ($data) {
        $query = "INSERT INTO markers (marker_user_id,marker_type,marker_lat,marker_lng,marker_imgSrc,marker_desc,marker_tel) 
                  VALUES('".$_SESSION['userName']."','$data[0]',$data[1],$data[2],'$data[3]','$data[4]','$data[5]')";
        
        if(mysqli_query($connection,$query)){
            echo 'Success';
        }else echo 'Failure';
        
        $connection->close();
    } else echo 'Invalid';
?>