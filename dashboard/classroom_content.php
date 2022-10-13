<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);

$pageTitle = " Classroom";
?>
<!doctype html>
<html lang="en">
  <head>
    <?php 
      include('x-meta.php');
    ?>


  <?php 
  include('x-css.php');
  ?>
 



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
      ul#myTab.nav.nav-tabs a{
        color:black !important;
      }
      ul#myTab.nav.nav-tabs .nav-link:hover{
           color:white !important;
      }
      ul#myTab.nav.nav-tabs .nav-link.active:hover{
       
        color:black !important;
      }
       ul#myTab.nav.nav-tabs .nav-link.active{
        background-color:#e9ecef !important;
        /*color:white!important;*/
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
    $rtab_n = "active_room";
    include('x-sidenav.php');

    if(isset($_GET["classroom_ID"])){
        $classroom_ID = $_GET["classroom_ID"];
      }
      
      if(isset($_GET["section"])){
        $section_ID = $_GET["section"];
      }


    if(isset($_GET["type"])){
      $type = $_GET["type"];
      if ($type == "stream"){
          $rtab = "room_stream";
          $rtab_c = "Announcement";
          $rhz = "Announcement Board";
      }
      if ($type == "student"){
          $rtab = "room_student";
          $rtab_c = "student";
      $rhz = "Student List";
      }
      if ($type == "activity"){
          $rtab = "room_student";
          $rtab_c = "Activity";
          $rhz = "Activity Board";
      }
    }
    else{
      $type = "stream";
      $rtab = "room_stream";
      $rtab_c = "Announcement";
      $rhz = "Announcement Board";
    }
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <h1 class="h2" style="font-size:16px;">  <?php echo $rhz?></h1>
        
      </div>

      <div class="table-responsive">
       
      <?php 
      include('x-roomtab.php');
      ?>

    <?php 
    if ($type == "stream"){
        include ('x-classroom-stream.php');
    }
    if ($type == "student"){
        include ('x-classroom-student.php');
    }
    if ($type == "activity"){
        include ('x-classroom-activity.php');
    }
   
   
    ?>

</html>
