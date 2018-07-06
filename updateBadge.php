<?php
    require_once('connect.php');
    
        $query = "SELECT COUNT(*) as num_rows FROM messages WHERE msg_reciever = '".$_SESSION['userName']."' AND msg_read = 0 ORDER BY msg_id DESC";
        $rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
        if($row = $rs->fetch_assoc())
           $totalRowCount = $row['num_rows'];
        
        echo $totalRowCount;
        
        $connection->close();
?>