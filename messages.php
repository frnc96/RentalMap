<?php require_once('connect.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rental Map</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="./styles/frnc.css">
  <link rel="stylesheet" href="./styles/msg.css">
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
				            echo '<li class=""><a href="'.BASE_URL.'">'.$_SESSION['fName'].'\'s Home</a></li>';
				            echo '<li class="active"><a href="'.BASE_URL.'messages.php">Messages</a></li>';
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
    <div class="col-sm-3 sidenav">
        <?php
            if(isset($_GET["senderId"])){
                $sender = $_GET["senderId"];
                $update = "UPDATE messages SET msg_read = 1 WHERE msg_sender = '$sender' AND msg_reciever = '".$_SESSION['userName']."' AND msg_read = 0";
                $connection->query($update);
            }
        
            $userUnreadMsg = "SELECT name, surname, msg_sender, COUNT(*) AS msg_unread, msg_time FROM messages JOIN users ON msg_sender = username WHERE msg_reciever = '".$_SESSION['userName']."' AND msg_read = 0 GROUP BY msg_sender ORDER BY msg_id DESC";
            $rs = mysqli_query($connection, $userUnreadMsg) or die(mysqli_error($connection));
            
            while($row = $rs->fetch_assoc()){
                echo '
                    <div class="wrap list-group-item list-group-item-action">
            	       <div class="media">
            	           <div class="media-left">
            	               <img src="images/conversation.svg" height="64" width="64" style="border-radius: 50%">
            	           </div>
            	           <div class="media-body">
            	               <h4 class="media-heading">'.$row["name"].' '.$row["surname"].' <span class="badge left" style="float:right">'.$row["msg_unread"].'</span></h4>
            	               
            	               <span style="float:right; color:gray">'.$row["msg_time"].'</span>
            	               <p>'.$row["msg_sender"].'</p> 
            	           </div>
            	       </div>
            	   </div>
                ';
            }
            
            $userReadMsg = "SELECT name, surname, msg_sender, msg_time FROM messages JOIN users ON msg_sender = username WHERE msg_reciever = '".$_SESSION['userName']."' AND msg_read = 1 AND msg_sender NOT IN (SELECT msg_sender FROM messages WHERE msg_reciever = '".$_SESSION['userName']."' AND msg_read = 0) GROUP BY msg_sender ORDER BY msg_id DESC";
            $rs = mysqli_query($connection, $userReadMsg) or die(mysqli_error($connection));
            
            while($row = $rs->fetch_assoc()){
                echo '
                    <div class="wrap list-group-item list-group-item-action">
            	       <div class="media">
            	           <div class="media-left">
            	               <img src="images/conversation.svg" height="64" width="64" style="border-radius: 50%">
            	           </div>
            	           <div class="media-body">
            	               <h4 class="media-heading">'.$row["name"].' '.$row["surname"].' <span class="badge left" style="float:right">'.$row["msg_unread"].'</span></h4>
            	               
            	               <span style="float:right; color:gray">'.$row["msg_time"].'</span>
            	               <p>'.$row["msg_sender"].'</p> 
            	           </div>
            	       </div>
            	   </div>
                ';
            }
            
        ?>
    </div>
	
	<!--Right big block-->
    <div id="rBlock" class="col-sm-9">
        
        <div class="container">
            <section id="chat">
                <p id="sender" style="display: none"><?php echo $_GET['senderId'] ?></p>
                <?php
                    if(isset($_GET["senderId"])){
                        $sender = $_GET["senderId"];
                        $messages = "SELECT msg_id, msg_content, msg_time, 1 AS msg_isSent FROM messages WHERE msg_sender = '".$_SESSION['userName']."' AND msg_reciever = '$sender' UNION ALL SELECT msg_id, msg_content, msg_time, 0 AS msg_isSent FROM messages WHERE msg_sender = '$sender' AND msg_reciever = '".$_SESSION['userName']."' ORDER BY msg_id ASC";
                        
                        $rs = mysqli_query($connection, $messages) or die(mysqli_error($connection));
                        
                        while($row = $rs->fetch_assoc()){
                            if($row['msg_isSent']==1){
                                echo '
                                    <div class="from-me">
                                      <p>'.$row["msg_content"].'</p>
                                    </div>
                                    <div class="clear"></div>
                                ';
                            }else{
                                echo '
                                    <div class="from-them">
                                      <p>'.$row["msg_content"].'</p>
                                    </div>
                                    <div class="clear"></div>
                                ';
                            }
                        }
                    }
                ?>
              </section>
      
              <div class="input-group">
                <input id="msg" type="text" class="form-control" placeholder="Message...">
                <div class="input-group-btn">
                  <button id="sendBtn" onclick="sendMsg()" class="btn btn-default">Send</button>
                </div>
              </div>
        </div>
      
    </div>
    
  </div>
</div>


<script src="./scripts/gMaps.js"></script>
<script src="./scripts/msg.js"></script>
<script>
    var isLogged = <?php echo json_encode(isset($_SESSION['userName'])) ?>;
    
    
</script>
</body>
</html>