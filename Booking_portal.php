<?php
require_once "pdo.php";
session_start();

 //echo("<pre>BA_name\n".$_SESSION["BA_name"]."\n</pre>\n");



if ( isset($_POST['no_of_pass']) && isset($_POST['names']) && isset($_POST['train_no']) && isset($_POST['date']) && isset($_POST['choice'])) {

    if($_POST['choice']=='AC'){
      $cnt_q="select count_ac from count where train_number=:tn and day=:day";
    }
    else{
     $cnt_q="select count_sleeper from count where train_number=:tn and day=:day"; 
    }

    $cnt = $pdo->prepare($cnt_q);
    $cnt->execute(array(
    ':tn' => $_POST['train_no'],
    ':day' => $_POST['date']));



     $row = $cnt->fetch(PDO::FETCH_ASSOC);
       if ( $row<$_POST['no_of_pass']) {
        $_SESSION["error"] = "Berths unavailable...";
        header( 'Location: Booking_portal.php' ) ;
        return;
      } 
        else {


 //          $_SESSION["BA_name"] = $_POST["BA_name"];
          $i=0;
          foreach($_POST['names'] as $curr ){
              if($i==0){
                $_SESSION["F_PASSEN"]=$curr;
              }
              $i=$i+1;
          }

        //  echo("<pre><b>fpasennnn\n".$_SESSION["F_PASSEN"]."\n</b></pre>\n");
          
          $ins_bookagent = "INSERT INTO booking_by_agent(name,day,fpassen)
           VALUES (:name,:day,:fpassen)";
          $stmt4 = $pdo->prepare($ins_bookagent);
          $stmt4->execute(array(
          ':name' => $_SESSION["BA_name"],
          ':day' => $_POST['date'],
          ':fpassen' => $_SESSION["F_PASSEN"] ));

          $search_pnr = "select pnr from booking_by_agent where day=:day and name=:name and fpassen=:fpassen";
          $stmt8 = $pdo->prepare($search_pnr);
          $stmt8->execute(array(
          ':day' => $_POST['date'],
          ':name' => $_SESSION["BA_name"],
          ':fpassen' => $_SESSION["F_PASSEN"]));

          $row = $stmt8->fetch(PDO::FETCH_ASSOC);
          $_SESSION["PNR"]=$row["pnr"];

         // echo("<pre><b>pnrrrrr\n".$_SESSION["PNR"]."\n</b></pre>\n");

          $ins_booking = "INSERT INTO bookings(pnr,day)
          VALUES (:pnr,:day)";
          $stmt3 = $pdo->prepare($ins_booking);
          $stmt3->execute(array(
          ':pnr' => $_SESSION["PNR"],
          ':day' => $_POST['date']));




            foreach($_POST['names'] as $curr ){
                 
                 // echo("<pre>curr_namee\n".$curr."\n</pre>\n");   
              
              

                   

                        if($_POST['choice']=='AC'){
                          $sel_berth="SELECT coach_number,berth_type,berth_no 
                          FROM berths_in_ac
                          where train_number=:tno and day=:day
                          ORDER BY berth_no ASC, berth_type ASC LIMIT 1";


                          $stmt5 = $pdo->prepare($sel_berth);
                          $stmt5->execute(array(
                          ':tno' => $_POST['train_no'],
                          ':day' => $_POST['date']));


                           $row = $stmt5->fetch(PDO::FETCH_ASSOC);

                        }

                        else{
                          $sel_berth="SELECT coach_number,berth_type,berth_no 
                          FROM berths_in_sleeper
                          where train_number=:tno and day=:day
                          ORDER BY berth_no ASC, berth_type ASC LIMIT 1";


                          $stmt5 = $pdo->prepare($sel_berth);
                          $stmt5->execute(array(
                          ':tno' => $_POST['train_no'],
                          ':day' => $_POST['date']));


                           $row = $stmt5->fetch(PDO::FETCH_ASSOC);
                        }



                         // echo("<pre>&&&&&berth\n".$row["berth_no"]."&&&&&berth_type\n".$row["berth_type"]."&&&&&coach_no\n".$row["coach_number"]."\n</pre>\n");
                        
                          

                          $ins_ticket = "INSERT INTO ticket(PNR,name,coach_type,berth_no,berth_type,coach_number,train_number,day) VALUES (:PNR,:name,:coach_type,:berth_no,:berth_type,:coach_number,:train_number,:day)";
                          
                           $stmt6 = $pdo->prepare($ins_ticket);
                          
                          $stmt6->execute(array(
                          ':PNR' =>$_SESSION["PNR"],
                          ':name' => $curr,
                          ':coach_type' => $_POST['choice'],
                          ':berth_no' => $row["berth_no"],
                          ':berth_type' => $row["berth_type"],
                          ':coach_number' => $row["coach_number"],
                          ':train_number' => $_POST['train_no'],
                          ':day' => $_POST['date']));

                    
                            
               }




}



}
?>











<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ticket Booking Portal</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="css/style.css" />

  <script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
var counter = 1;
$(function(){
 $('b#add_field').click(function(){
 counter += 1;
 if(counter<=6){
 $('#container').before(
 '<div class="col-xs-4"><label class="form-label">Passenger No.'+counter+'</label><input class="form-control" name="names[]" type="text"></div>' );
  }

 if(counter==6){
    $('#container').empty();
 }
 });

});

</script>

</head>

<body>
  <div id="booking" class="section">
    <div class="section-center">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-push-7">
            <div class="booking-cta">
              <h1>Train Ticket Booking</h1>
              </p>
            </div>

          </div>
          <div class="col-md-6 col-md-pull-6">
            <div class="booking-form">
              <form method="post">

                <?php
                    if ( isset($_SESSION["error"]) ) {
                      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
                      unset($_SESSION["error"]);
                    }
                    
                ?>

                <div class="form-group">
                      <span class="form-label">Number of Passengers</span>
                      <input class="form-control" name="no_of_pass" type="number" required>

                </div>
                
                
                <div class="form-group">

                      <div class="form-label">Add Passengers List</div>
                      
                      
                        <div class="form-group row">
                          <div class="col-xs-4">
                          <label class="form-label">Passenger No.1</label>
                          <input class="form-control" name="names[]" type="text">
                          </div>

                          <div id="container">
                            <div>
                            <b id="add_field"><a href="#"><span>&nbsp&nbspAdd</span></a></b>
                            </div>
                          </div>
                        </div>
                      
                </div>


                <div class="form-group">
                      <span class="form-label">Train Number</span>
                      <input class="form-control" min="0" name="train_no" type="number" required>
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <span class="form-label">Date of journey</span>
                    <input class="form-control" type="text" name="date" required>
                  </div>
                </div>
                
                
                <div class="form-group">
                  <div class="form-group">
                    <span class="form-label">Class</span>
                    <select class="form-control" type='text' name="choice">
                      <option>AC</option>
                      <option>Sleeper</option>
                    </select>
                    <span class="select-arrow"></span>
                  </div>
                  
                  
                </div>
                <div class="form-label form-btn">
                  <p><input type="submit" class="submit-btn" value="Book Tickets"/></p>
                  <!--<button class="submit-btn">Book Tickets</button>-->
                </div>

              </form>

              <div class="form-label">
                   <a href="logout_BA.php">Logout</a>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>