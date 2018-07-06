<?php require_once('connect.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rental Map</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="./styles/frnc.css">
  <!--<link rel="stylesheet" href="./styles/msg.css"> -->
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.css' rel='stylesheet' />
  <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.css' type='text/css' />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.js'></script>
  <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.min.js'></script>
  
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: calc(100vh - 52px)}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
	.navbar{
		margin-bottom: 0px;
	}
	
	nav{
	    font-family: 'Lato', sans-serif;
	}
	
	#rBlock{
	    position: absolute;
        width: 100% !important;
        top: 52px;
	}
	
	#lNav{
	    opacity: 0.9;
	}
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">

	<!--Navigator-->
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				<a href="<?php echo BASE_URL ?>" class="navbar-brand"><img src="./images/user.png"></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
				    <?php
				        if(isset($_SESSION['userName'])){
				            echo '<li class="active"><a href="'.BASE_URL.'">'.$_SESSION['fName'].'\'s Home</a></li>';
				            echo '<li class=""><a href="'.BASE_URL.'messages.php">Messages</a></li>';
				        }else echo '<li class="active"><a href="'.BASE_URL.'">Home</a></li>';
				    ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				    <?php
				        if(isset($_SESSION['userName'])){
                            
                            $query = "SELECT * FROM messages WHERE msg_reciever = '".$_SESSION['userName']."' AND msg_read = 0 ORDER BY msg_id DESC";
                            $rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
				            
				            echo '<li>
				            <a id="ntf"><span class="glyphicon glyphicon-bell"><span class="badge top"></span></span></a>
                                    <div class="dropdown">
                                      <button id="tgl" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" style="display: none"></button>
                                      <ul class="dropdown-menu wrap" role="menu" aria-labelledby="dropdownMenu1" style="max-width: 400px; min-width: 250px">
                                      
                                      <li style="text-align: center"><strong>Notification Tab</strong></li>
                                      <li class="divider"></li>';
                                      
                                      while($row = $rs->fetch_assoc()){
                                          echo '<li><a href="https://allisfree.al/RentalMap/messages.php?senderId='.$row["msg_sender"].'"><span class="glyphicon glyphicon-user"></span> '.$row["msg_sender"].': '.$row["msg_content"].'</a></li>
                                          <li class="divider"></li>';
                                      }
                                      echo '<li style="text-align: center"><a style="color: lightgray" href="'.BASE_URL.'messages.php">Show all...</a></li>';
                                        
                                echo '</ul>
                                    </div>
				                  </li>';
				                  
				            echo '<li><a href="'.BASE_URL.'login.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>';
				        }else echo '<li><a href="'.BASE_URL.'login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
				    ?>
				</ul>
			</div>
		</div>
	</nav>
	
	<!--Left Navigator-->
    <div id="lNav" class="col-sm-3 sidenav">
      <img src="./images/rentalMap.png" width="100%"></img>
	  
		<div class="dropdown leftNav">
			<button id="citiesBtn" class="btn btn-info btn-block dropdown-toggle wrap" type="button" data-toggle="dropdown">Select the city you want to browse<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li class="dropdown-header">Cities-Albania</li>
				<li><a class="city ptr">Tirana</a></li>
				<li><a class="city ptr">Durres</a></li>
				<li><a class="city ptr">Vlore</a></li>
				<li><a class="city ptr">Elbasan</a></li>
				<li><a class="city ptr">Shkoder</a></li>
				<li><a class="city ptr">Fier</a></li>
				<li><a class="city ptr">Korce</a></li>
				<li><a class="city ptr">Berat</a></li>
				<li><a class="city ptr">Lushnje</a></li>
				<li><a class="city ptr">Pogradec</a></li>
				<li><a class="city ptr">Kavaje</a></li>
				<li><a class="city ptr">Gjirokaster</a></li>
				<li><a class="city ptr">Sarande</a></li>
			</ul>
		</div>
		
	  <div class="list-group leftNav">
	    <div class="wrap list-group-item list-group-item-action">
		    <img src="./images/marker.png" height="24" width="24"></img>
		    <a id="general" class="ptr link"> Click to add new general marker</a><br>
	    </div>
	  
	    <div class="wrap list-group-item list-group-item-action">
		    <img src="./images/house.png" height="24" width="24"></img>
		    <a id="house" class="ptr link"> Click to add new household marker</a><br>
	    </div>
	  
	    <div class="wrap list-group-item list-group-item-action">
		    <img src="./images/office.png" height="24" width="24"></img>
		    <a id="office" class="ptr link"> Click to add new office marker</a><br>
	    </div>
	  </div>
	  
	  <?php 
	    if(isset($_SESSION['userName'])){
	        echo '<div id="markerList" class="list-group leftNav">';
	        echo '<div class="wrap list-group-item list-group-item-action" style="background-color: #5bc0de; text-align: center; color: white;">Your Markers</div>';
	        
	        $query = "SELECT * FROM markers WHERE marker_user_id = '".$_SESSION['userName']."' LIMIT 3";
	        $rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
	        while($row = $rs->fetch_assoc()){
	            $id = $row['marker_id'];
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
	        echo '</div>';
	    }
	  ?>
	  
    </div>
	
	<!--Right big block-->
    <div id="rBlock" class="col-sm-9">
	  
	  <div id="map"></div>
	  
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="location.reload()">&times;</button>
        <h4 class="modal-title">Please fill the form to add new location on the map</h4>
      </div>
      <div class="modal-body">
	  
        <form id="addMarkerForm">
		
			<div class="form-group">
                <label for="desc"><span class="hidden-xs">Name:</label>
                <input 
					id="descr"
                    class="form-control" 
                    name="desc"
                    placeholder="The description..."
                    required 
                />
            </div>
			
			<div class="form-group">
                <label for="phone"><span class="hidden-xs">Phone:</label>
                <input 
                    id="tel"
                    type="tel" 
                    class="form-control" 
                    name="phone"
                    placeholder="+355691213153"
                    required 
                />
            </div>
            
            <div class="form-group">
                <label for="phone"><span class="hidden-xs">Image:</label>
                <input 
                    id="img"
                    type="file" 
                    class="form-control" 
                    name="img"
                    accept="image/*"
                    required 
                />
            </div>
			
			<!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="https://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
                                        <input 
                                            type="tel"
                                            class="form-control"
                                            name="cardNumber"
                                            placeholder="Valid Card Number"
                                            autocomplete="cc-number"
                                            required autofocus 
                                        />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        name="cardExpiry"
                                        placeholder="MM / YY"
                                        autocomplete="cc-exp"
                                        required 
                                    />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">CV CODE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control"
                                        name="cardCVC"
                                        placeholder="CVC"
                                        autocomplete="cc-csc"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
                </div>
            </div>            
            <!-- CREDIT CARD FORM ENDS HERE -->
		</form>
		
      </div>
      <div class="modal-footer">
        <button type="button" onclick="location.reload()" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" onclick="addPopup()" class="btn btn-success">Save</button>
      </div>
    </div>

  </div>
</div>

<script src="./scripts/gMaps.js"></script>
<script>
    <?php 
        $markersArray = array();
        $query = "SELECT * FROM markers";
        
        $rs = mysqli_query($connection, $query) or die(mysqli_error($connection));
        while($row = mysqli_fetch_array($rs)){
            $actualRow = [$row['marker_type'],$row['marker_lat'],$row['marker_lng'],$row['marker_imgSrc'],$row['marker_desc'],$row['marker_tel'],$row["marker_user_id"]];
            $markersArray[] = $actualRow;
        }
        
        $connection->close();
    ?>
    var markersArray = <?php echo json_encode($markersArray)?>;
    var isLogged = <?php echo json_encode(isset($_SESSION['userName'])) ?>;
    
    markersArray.forEach(function(row){
        var el = document.createElement('div');
	    el.id = row[0];
	    marker = new mapboxgl.Marker(el).setLngLat([row[2],row[1]]).addTo(map);
	    var html = '<div class="card">'+
	            '<img src="'+row[3]+'" title="Click to send a message to this user" class="popImg">'+
	            '<div class="container" style="width: 100%;padding-left: 0px;padding-right: 0px;">'+
	            '<h5><b>'+row[4]+'</b></h5> '+
	            '<p>'+row[5]+'</p>'+
	            '<p style="display: none">'+row[6]+'</p>'+
	            '</div></div>';
	    var popup = new mapboxgl.Popup({ offset: 25 }).setHTML(html);
	    marker.setPopup(popup);
    });
    
    $(document).ready(function(){
            $('#general').click(function(){
                if(isLogged)
		        {general = true;
		        house = false;
		        office = false;}
		        else alert('Please login first!!!');
	        });

	        $('#house').click(function(){
	            if(isLogged)
		        {general = false;
		        house = true;
		        office = false;}
		        else alert('Please login first!!!');
	        });

	        $('#office').click(function(){
	            if(isLogged)
		        {general = false;
		        house = false;
		        office = true;}
		        else alert('Please login first!!!');
	        });
    });
</script>
</body>
</html>