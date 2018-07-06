<?php 
    require_once('connect.php');
    
    $user = isset($_POST['user']) ? $_POST['user'] : false;
    $pass = isset($_POST['pass']) ? $_POST['pass'] : false;
    
    if($user && $pass){
        $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
        $rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
        
        if(mysqli_num_rows($rs)>0){
            $row = $rs->fetch_assoc();
            $_SESSION['userName'] = $row['username'];
            $_SESSION['fName'] = $row['name']." ".$row['surname'];
            header("Location: ".BASE_URL);
        } else header("Location: ".BASE_URL."login.php?msg=notAuser");
        
    } else header("Location: ".BASE_URL."login.php?msg=incorrectInput");
    
?>