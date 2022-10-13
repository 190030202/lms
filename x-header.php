<?php 
require_once("class.user.php");

  
$header = new USER();
?>
<header class=" fixed-bottom ">
  <nav class="navbar navbar-expand-md navbar-light bg-light ">
    <a class="navbar-brand" href="index"><img src="assets/img/logo/logo.png" width="20%" style="max-width:80px; margin-top: -7px; padding: 0px;"> CvSU E-learning</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
    
      	
    </div>

  </nav>
  	<div class="w-100 bg-dark text-center">
  		<center class="text-white">
          Cavite State University - Information System<br>
All Rights Reserved<br>Copyright &copy; 2019 <?php 
												if (date('Y') !== "2019") 
												{
													echo " - " . date('Y');
												}
												else 
												{
												
												}
											?>
      </center>
  	</div>
</header>