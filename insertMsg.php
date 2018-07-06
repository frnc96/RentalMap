<?php
    require_once('connect.php');
    $data = isset($_POST['array']) ? $_POST['array'] : false;
    
    if ($data) {
        $query = "INSERT INTO messages (msg_sender, msg_reciever, msg_content, msg_read) VALUES('".$_SESSION['userName']."','$data[0]','$data[1]',0)";
        
        if(mysqli_query($connection,$query)){
            echo 'Success';
        }else echo 'Failure';
        
        $connection->close();
    } else echo 'Invalid';
?>