<?php 
    require_once('connect.php');
    
    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $surname = isset($_POST['surname']) ? $_POST['surname'] : false;
    $userName = isset($_POST['username']) ? $_POST['username'] : false;
    $password = isset($_POST['password']) ? $_POST['password'] : false;
    $repeatPass = isset($_POST['repeatPass']) ? $_POST['repeatPass'] : false;
    
    if($name && $surname && $userName && $password && $repeatPass){
        if($password === $repeatPass){
            $val = "SELECT * FROM users WHERE username = '$userName'";
            $rs = mysqli_query($connection, $val) or die(mysqli_error($connection));
            
            if(mysqli_num_rows($rs) == 0){
                $query = "INSERT INTO users (name, surname, username, password) VALUES ('$name', '$surname', '$userName', '$password')";
                if ($connection->query($query) === TRUE) header("Location: ".BASE_URL."login.php?msg=Account created successfuly");
                else header("Location: ".BASE_URL."login.php?msg=Some error occoured in the database");
            } else header("Location: ".BASE_URL."login.php?msg=Username already exists");
        }else header("Location: ".BASE_URL."login.php?msg=Passwords must match");
    } else header("Location: ".BASE_URL."login.php?msg=Incorrect Input");
?>