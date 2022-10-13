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
                <div class="col-sm-12 text-center " style="min-height: 100px;">
                     <img src="../assets/img/logo/logo.png" height="80" style="margin-left: -450px;"> <H3 style="margin-top: -50px;">CAVITE STATE UNIVERSITY</H3>
                </div>
            </div>
            <div class="row">
               <div class="col-12 col-sm-12">
                <img src="../assets/img/background/index.png" height="300"  width="100%">
                <br><br>
               </div>
              <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                   <strong>UNIVERSITY MISSION</strong>
                  </div>
                  <div class="card-body text-center"  style="min-height: 250px">
                    CAVITE STATE UNIVERSITY shall provide
                    <br>excellent equitable and relevant educational
                    <br>opportunities in the arts, sciences
                    <br>and technology through quality instruction
                    <br>and responsive research 
                    <br>and development activitis. 
                    <br>It shall produce professional,skilled 
                    <br>and morally upright individuals for 
                    <br>global competitiveness
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-6">
                <div class="card " style="border:solid 0.9px ;">
                  <div class="card-header text-center" style=" border-bottom: 5px solid ;">
                    <strong>UNIVERSITY VISION</strong>
                  </div>
                  <div class="card-body text-center"  style="min-height: 250px">
                    The Premier University in historic Cavite recognized
                    <br>for excellence in the development of globally 
                    <br>competitive and morally upright individuals.
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

  
      </body>
</html>
