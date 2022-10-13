<?php 
echo $current_url = $_SERVER['REQUEST_URI'];
$url_explde = explode('/', $current_url);
$pagefile_name = $url_explde[3];

// room_module
// room_student
// room_announcement
// room_activity
if(isset($rtab_n))
{
  $pagefile_name = "room";
}

function navlist($pagefile_name,$name,$link,$icon){
 
  if ($pagefile_name == $link) {
    $active_ul_snav = "active";
    $active_ul_snav_span = '<span class="sr-only">(current)</span>';
    
  }
  else{
     $active_ul_snav = '';
      $active_ul_snav_span = '';
  }
  ?>
   <li class="nav-item">
            <a class="nav-link <?php echo $active_ul_snav;?>" href="<?php echo $link;?>">
              <span data-feather="<?php echo $icon;?>"></span>
              <?php echo $name.' '.$active_ul_snav_span; ?>
            </a>
          </li>
  <?php
}


?>
<style>
  .nav-link{
      color:white !important; 
  }
  svg {
    color:white !important; 
  }
  .nav-link:hover{
    background-color:#4caf50   ;
  }


    ul ul a {
       
        padding-left: 50px !important;
     
    }
    ul ul a:hover {
        background: #eee;
        padding-left: 50px !important;
     
    }
    </style>
<nav class="col-md-2 d-none d-md-block bg-light sidebar" style="

      background: #6c757d !important;
        color: white
  /*   background: url('../assets/img/background/bg-login.png') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      background-size: cover;
      -o-background-size: cover;
*/


        " >
      <div class="sidebar-sticky" style="overflow-x: hidden;
    overflow-y: auto;">
        <div style="height: 130px;" class="text-center">
           <img id="c_img" src="<?php $auth_user->getUserPic();?>" alt="Profile Image"  runat="server"  height="85" width="85" class="rounded-circle" style="border:1px solid;"/>
           <br>
           <h6><?php $auth_user->getSidenavUserInfo();?></h6>
        </div>

        <ul class="nav flex-column">
          
          <div style="background: #383d41;
    font-size: 12px;
    font-weight: 600;
    padding: 8px 16px;">MAIN NAVIGATION</div>
          <?php 
       
          navlist($pagefile_name,"Home","index",'home');
          if($auth_user->student_level() || $auth_user->instructor_level() ) { 
          navlist($pagefile_name,"Topics","classroom",'monitor');
          navlist($pagefile_name,"Query Simulator","query_simulator","database");
          }
          if($auth_user->admin_level()) { 
          navlist($pagefile_name,"Account Management","account","users");
          navlist($pagefile_name,"Admin Management","admin","book");
          navlist($pagefile_name,"Student Management ","student","book");
          navlist($pagefile_name,"Instructor Management","instructor","book");
       
          navlist($pagefile_name,"Query Simulator","query_simulator","database");
          // navlist($pagefile_name,"Classroom","classroom","clipboard");
          }
          ?>
        </ul>
      <div class="text-center " style=" position: absolute;bottom: 0; color:white; padding:5px;">
            <hr>
            <strong>CvSU E-learning for Information Management</strong>
          </div>
      </div>

    </nav>
