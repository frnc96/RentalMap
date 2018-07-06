<?php
if(!empty($_POST["id"])){
//$rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
    // Include the database configuration file
    require_once('connect.php');
    
    // Count all records except already displayed
    $q1 = "SELECT COUNT(*) as num_rows FROM markers WHERE marker_user_id = '".$_SESSION['userName']."' AND marker_id > ".$_POST['id']." ORDER BY marker_id DESC";
    $query = mysqli_query($connection, $q1) or die(mysqli_error($connection));
    $row = $query->fetch_assoc();
    $totalRowCount = $row['num_rows'];
    
    $showLimit = 3;
    
    // Get records from the database
    $q2 = "SELECT * FROM markers WHERE marker_user_id = '".$_SESSION['userName']."' AND marker_id > ".$_POST['id']." ORDER BY marker_id DESC LIMIT $showLimit";
    $query = mysqli_query($connection, $q2) or die(mysqli_error($connection));

    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){
            $postID = $row['marker_id'];
            
            echo '
	                <div class="wrap list-group-item list-group-item-action">
	                    <div class="media">
	                        <div class="media-left">
	                            <img src="'.$row["marker_imgSrc"].'" height="90" width="140" style="border-radius: 2%">
	                        </div>
	                        <div class="media-body">
	                            <h4 class="media-heading">'.$row["marker_desc"].'</h4>
	                            <p>'.$row["marker_tel"].'</p>
	                            <input type="button" onclick="fly('.$row["marker_lng"].','.$row["marker_lat"].');" class="btn btn-default" value="Locate"/>
	                        </div>
	                    </div>
	                </div>
	            ';
        }
        echo '<div id="loadBtn" class="wrap list-group-item list-group-item-action" style="text-align: center; color: white;">
	              <input id="'.$id.'" type="button" class="btn btn-default btn-block loadMore" value="Load More"/>
	          </div>';
    } else{
        echo "<script>alert('No more photos to show :(')</script>";
        echo '<div id="loadBtn" class="wrap list-group-item list-group-item-action" style="text-align: center; color: white;">
	             <input id="'.$id.'" type="button" class="btn btn-default btn-block loadMore" value="Load More"/>
	          </div>';
    } 
} else{
    echo "<script>alert('No more photos to show :(')</script>";
    echo '<div id="loadBtn" class="wrap list-group-item list-group-item-action" style="text-align: center; color: white;">
	            <input id="'.$id.'" type="button" class="btn btn-default btn-block loadMore" value="Load More"/>
	      </div>';
}
?>