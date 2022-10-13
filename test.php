<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Dashboard";
?>
<!doctype html>
<html lang="en">
  <head>
    <?php 
      include('x-meta.php');
    ?>


    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="../assets/css/icomoon/styles.css" rel="stylesheet" type="text/css">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php 
include('x-nav.php');
?>

<div class="container-fluid">
  <div class="row">
    <?php 
    include('x-sidenav.php');
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
     <!--    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1> 
      </div>-->
 
            <div class="row">
              <div class="col-12 col-sm-12">
                <div class="card ">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                   <strong class="">TEST NAME HERE</strong>
                  </div>

                  <div class="card-body "  style="min-height: 250px">
                    <div id="test_countdown" class="btn btn-primary float-right">00:00</div>
                    <br>
                    <br>
                  <form id="test_form" enctype="multipart/form-data">
                    <?php
                      if(isset($_REQUEST["id"])){
                        $test_ID = $_REQUEST["id"];
                      }
                      $auth_user->test_question($test_ID);

                      $test_timer = 10;
                    ?>
                    <input type="hidden" name="operation" value="submit_answer">
                    <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_subject">Submit</button>
                    </form>
                    
                  </div>
                </div>
              </div>
            </div>





    </main>
  </div>
</div>
<?php 
include('x-script.php');
?>
<script>
  test_timer(<?php echo $auth_user->test_time($test_ID)?>);


  function test_timer(asd){

  var xmin = new Date();
  xmin.setMinutes(xmin.getMinutes() + asd);

  var countDownDate = xmin.getTime();

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("test_countdown").innerHTML =  hours + "h "
    + minutes + "m " + seconds + "s ";
    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
      $('#test_form').submit();
      document.getElementById("test_countdown").innerHTML = "EXPIRED";
    }
  }, 1000);
}



 $(document).on('submit', '#test_form', function(event) {
        event.preventDefault();
      
        $.ajax({
           url:"datatable/classroom_activity/insert.php",
           method:'POST',
           data:new FormData(this),
           contentType:false,
           processData:false,
           success:function(data)
           {

           }
         });

    });
</script>

  
      </body>
</html>
