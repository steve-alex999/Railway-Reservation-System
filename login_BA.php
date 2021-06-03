<?php
require_once 'pdo.php';
session_start();
if ( isset($_POST["BA_name"]) && isset($_POST["BA_pass"]) ) {
unset($_SESSION["BA_name"]); // Logout current user
 
$sql = "SELECT name FROM booking_agent
WHERE name = :em AND password = :pw";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
':em' => $_POST['BA_name'],
':pw' => $_POST['BA_pass']));

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
$_SESSION["error"] = "Incorrect password.";
header( 'Location: login_BA.php' ) ;
return;
} else {
$_SESSION["success"] = "Logged in.";
$_SESSION["BA_name"] = $_POST["BA_name"];

header( 'Location: Booking_portal.php' ) ;
return;
}
}


?>
<html>











<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Booking-Agent Login</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="css/style.css" />


</head>

<body>
  <div id="booking" class="section">
    <div class="section-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-push-7">
            <div class="booking-cta">
              <h1>Login for Booking-Agent</h1>
              </p>
            </div>

          </div>
          <div class="col-md-6 col-md-pull-6">
            <div class="booking-form">

              <?php
                if ( isset($_SESSION["error"]) ) {
                  echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
                  unset($_SESSION["error"]);
                }
                if ( isset($_SESSION["success"]) ) {
                  echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
                  unset($_SESSION["success"]);
                }
              ?>
              
              <form method="post">

                <div class="form-group">
                      <span class="form-label">Account Name</span>
                      <input class="form-control" name="BA_name" type="text" required>

                </div>
                
                


                <div class="form-group">
                      <span class="form-label">Password</span>
                      <input class="form-control" name="BA_pass" type="password" required>
                </div>

                
                <div class="form-btn">
                  <button class="submit-btn">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>