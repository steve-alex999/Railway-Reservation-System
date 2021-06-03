
<?php
require_once "pdo.php";

 if ( isset($_POST['train_no']) && isset($_POST['train_date']) && isset($_POST['num_AC']) && isset($_POST['num_Sleeper'])) {

  // $_POST['train_date'] = date("d-m-Y", strtotime($$_POST['train_date']));

$ins_train = "INSERT INTO available_trains(num_of_AC, num_of_Sleeper,day, train_number)
VALUES (:num_of_AC, :num_of_Sleeper,:day, :train_number)";

// echo("<pre>\n".$_POST['train_date']."\n</pre>\n");
$stmt = $pdo->prepare($ins_train);


$stmt->execute(array(
':num_of_AC' => $_POST['num_AC'],
':num_of_Sleeper' => $_POST['num_Sleeper'],
':day' => $_POST['train_date'],
':train_number' => $_POST['train_no']));
}

 

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Release Train</title>

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
              <h1>Release Train</h1>
              </p>
            </div>

          </div>
          <div class="col-md-6 col-md-pull-6">
            <div class="booking-form">
              <form method="post">

                <div class="form-group">
                      <span class="form-label">Train Number</span>
                      <input class="form-control" min="0" name="train_no" type="number" required>
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <span class="form-label">Date of journey</span>
                    <input class="form-control" name="train_date" type="text" required>
                  </div>
                </div>
                
                
                <div class="form-group">                                 
                        <div class="form-group row">
                          <div class="col-xs-4">
                          <label class="form-label">No. of AC coaches </label>
                          <input class="form-control" name="num_AC" type="number">
                          </div>

                          <div class="col-xs-4">
                          <label class="form-label">No. of Sleeper coaches </label>
                          <input class="form-control" name="num_Sleeper" type="number">
                          </div>
                        </div>
                      
                </div>

                
                <div class="form-btn">
                  <button class="submit-btn form-label">Add Train</button>
                </div>

               

              </form>

                <div class="form-label">
                   <a href="logout_Admin.php">Logout</a>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>