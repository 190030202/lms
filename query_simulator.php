<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Query Simulator";
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
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"  style="font-size:16px;">Query Simulator</h1>
        
      </div>
      <nav aria-label="breadcrumb" >
        <ol class="breadcrumb bcrum" >
          <li class="breadcrumb-item " ><a href="index" class="bcrum_i_a">Home</a></li>
          <li class="breadcrumb-item  active bcrum_i_ac" aria-current="page" >Query Simulator</li>
        </ol>
      </nav>
  <div class="col-sm-12 sql_simulator">
  <link rel="stylesheet" href="../assets/plugins/sql_simulator/css/codemirror.css">
  <link rel="stylesheet" href="../assets/plugins/sql_simulator/css/demo.css">
  <script src="../assets/plugins/sql_simulator/css/codemirror.js"></script>            
               <main>
   <label for='commands'>Enter some SQL</label> 
   <div class="btn-group float-right">
    <a class="btn btn-outline-info " href="query_simulator?req_sample=1">Load sample</a>
  </div>
   <br>   <br>
<style type="text/css">
    table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px;
}

table tr:nth-child(even){background-color: #f2f2f2;}

table tr:hover {background-color: #ddd;}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;


}

</style>
    <textarea id="commands" >
      <?php 
      if (isset($_REQUEST["req_sample"])) {
        ?>DROP TABLE IF EXISTS cvsu_college;
DROP TABLE IF EXISTS cvsu_course;
DROP TABLE IF EXISTS cvsu_department;
CREATE TABLE `cvsu_college` (
  `college_ID` int(11)  NOT NULL,
  `college_Name` varchar(150) DEFAULT NULL,
  `college_Acronym` varchar(25) DEFAULT NULL
) ;

INSERT INTO `cvsu_college` (`college_ID`, `college_Name`, `college_Acronym`) VALUES
(1, 'College of Engineering and Information Technology', 'CEIT'),
(2, 'College of Art and Sciences', 'CAS');



CREATE TABLE `cvsu_course` (
  `course_ID` int(11)  NOT NULL,
  `department_ID` int(11)  DEFAULT NULL,
  `course_Name` varchar(100) DEFAULT NULL,
  `course_Acronym` varchar(10) DEFAULT NULL
) ;


INSERT INTO `cvsu_course` (`course_ID`, `department_ID`, `course_Name`, `course_Acronym`) VALUES
(1, 2, 'Bachelor of Science in Information Technology', 'BSIT'),
(2, 2, 'Bachelor of Science in Computer Science', 'BSCS'),
(3, 2, 'Bachelor of Science in Office Administration', 'BSOA');



CREATE TABLE `cvsu_department` (
  `department_ID` int(11)  NOT NULL,
  `college_ID` int(11)  DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `department_acronym` varchar(25) DEFAULT NULL
);



INSERT INTO `cvsu_department` (`department_ID`, `college_ID`, `department_name`, `department_acronym`) VALUES
(1, 1, 'Computer Science', 'COMSCI'),
(2, 1, 'Information Technology', 'IT'),
(3, 1, 'Office Administration', 'OA');

SELECT cc.course_ID, cd.department_name as Department, ccc.college_Name as College FROM cvsu_course cc
LEFT JOIN cvsu_department cd ON cd.department_ID = cc.department_ID
LEFT JOIN cvsu_college ccc ON ccc.college_ID = cd.college_ID
;
        <?php
      }
      ?>
    </textarea>

<!--   <button id="execute" class="btn btn-success btn-sm" >Execute</button>
  <button id="savedb"  class="btn btn-success btn-sm" >Save DB</button> -->
  <br>
<div class="form-inline ">
    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
      <div class=" mr-2" role="group" aria-label="First group">
        <button type="button" id="execute" class="btn btn-outline-secondary">Execute</button>
        <button type="button" class="btn btn-outline-danger"  id="clear_textarea">Clear</button>
        <button type="button" id="savedb" class="btn btn-outline-success">Save DB</button>
      </div>
     
    </div>
    <div >
        <input type='file' id='dbfile' class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
        <small id="emailHelp" class="form-text text-muted">Load an SQLite database file.</small>
    </div>
</div>
<div id="error" class="error"></div>

<pre id="output">Results will be displayed here</pre>
</main>
               </div>

    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>

  <script src="../assets/plugins/sql_simulator/js/sql.js"></script>
  <script type="text/javascript" src="../assets/plugins/sql_simulator/css/gui.js"></script>
  <script type="text/javascript">
  // $(document).on('click', '#load_sample_command', function(){
  
  // var x = document.querySelectorAll(".CodeMirror-code div pre span");
  
  //   console.log ( x[0].innerHTML);
  //   $(".CodeMirror-code div pre span").html("heey");
  //   });
   $(document).on('click', '#clear_textarea', function(){
    window.location.assign("query_simulator");
  });
  

  </script>
  </body>

</html>
