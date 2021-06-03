
<?php
session_start();
if ( isset($_POST["admin_name"]) && isset($_POST["admin_pass"]) ) {
unset($_SESSION["admin_account"]); // Logout current user
if ( $_POST["admin_name"] && $_POST['admin_pass'] == 'adminpass' ) {
$_SESSION["admin_account"] = $_POST["admin_name"];
$_SESSION["success"] = "Logged in.";
header( 'Location: Release_train.php' ) ;
return;
} else {
$_SESSION["error"] = "Incorrect password.";
header( 'Location: login_BA.php' ) ;
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

  <title>Admin Login</title>

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
              <h1>Login for Admin</h1>
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
                      <input class="form-control" name="admin_name" type="text" required>

                </div>
                
                
                <div class="form-group">
                      <span class="form-label">Password</span>
                      <input class="form-control" name="admin_pass" type="password" required>
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