<?php
    session_start();
    $connection = mysqli_connect('localhost','allisfree_map','Rental2018');
    if(!$connection)
        die("Database connection failed " . mysqli_error($connection));

    $select_db = mysqli_select_db($connection, 'allisfree_rental');
    if(!$select_db)
        die("Database selection failed " . mysqli_error($connection));
        
    define('BASE_URL','https://allisfree.al/RentalMap/');

?>