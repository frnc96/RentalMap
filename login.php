<?php require_once('connect.php'); $_SESSION = array() ?>
<!DOCTYPE html>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="./styles/login.css">
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
</head>
<body>

<div class="container">
	<div class="row">
		
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>Rental Map Login Form</h1>
</div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    
    <form method="post" action="loginValidator.php">
      <div class="input-container">
        <input type="text" name="user" id="Username" required="required"/>
        <label for="Username">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" name="pass" id="Password" required="required"/>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span>Go</span></button>
      </div>
      <div class="footer"><a href="<?php echo BASE_URL;?>">Sign in as Guest</a></div>
      <div class="footer" style="color: red;"><?php if(isset($_GET['msg'])) echo $_GET['msg']; ?></div>
    </form>
    
  </div>
  <div class="card alt">
    <div class="toggle"></div>
    <h1 class="title">Register
      <div class="close"></div>
    </h1>
    
    <form method="post" action="registerValidator.php">
      <div class="input-container">
        <input type="text" name="name" id="name" required="required"/>
        <label for="name">Name</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" name="surname" id="surname" required="required"/>
        <label for="surname">Surname</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" name="username" id="registerUsername" required="required"/>
        <label for="registerUsername">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" name="password" id="registerPassword" required="required"/>
        <label for="registerPassword">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" name="repeatPass" id="registerRepeatPassword" required="required"/>
        <label for="registerRepeatPassword">Repeat Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span>Next</span></button>
      </div>
    </form>
    
  </div>
</div>
	</div>
</div>

<script src="./scripts/login.js"></script>
</body>
</html>