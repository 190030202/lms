<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();

$query = '';
$output = array();

if($account->student_level()) { 
	$query .= "SELECT *,
	(SELECT count(class_ID) 
	FROM `class_room_student` `crs1` 
	WHERE `crs1`.`class_ID` = `crs`.`class_ID`) 
	as `crsx_count` ";
	$query .= " FROM `class_room_student` `crs`
LEFT JOIN `class_room` `cr` ON `cr`.`class_ID` = `crs`.`class_ID`
LEFT JOIN `record_student_details` `rsd` ON `rsd`.`rsd_ID` = `crs`.`rsd_ID`
LEFT JOIN `user_account` `ua` ON `ua`.`user_ID` = `rsd`.`user_ID`
LEFT JOIN `ref_status` `rs` ON `rs`.`status_ID` = `cr`.`status_ID`";

	if (isset($_SESSION['user_ID'])) {
		$user_ID = $_SESSION['user_ID'];
	 	$query .= '  WHERE `rsd`.`user_ID` = '.$user_ID.' AND crs.`status_ID` = 2 AND ';
	}
	else{
		 $query .= ' WHERE';
	}
	if(isset($_POST["search"]["value"]))
	{
	 $query .= '(crs.class_ID LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR cr.class_Code LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR cr.class_Name LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR rs.status_Name LIKE "%'.$_POST["search"]["value"].'%" )';
	}



	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY crs.crs_ID DESC ';
	}
	if($_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

}
else
{
	$query .= "SELECT *,
	(SELECT count(class_ID) 
	FROM `class_room_student` `crs1` 
	WHERE `crs1`.`class_ID` = `cr`.`class_ID`) 
	as `crsx_count` ";
	$query .= "FROM `class_room` `cr`
	LEFT JOIN `ref_status` `rs` ON `rs`.`status_ID` = `cr`.`status_ID`";

	if (isset($_SESSION['user_ID'])) {
		$user_ID = $_SESSION['user_ID'];
	 	$query .= '  WHERE `cr`.`user_ID` = '.$user_ID.' AND ';
	}
	else{
		 $query .= ' WHERE';
	}
	if(isset($_POST["search"]["value"]))
	{
	 $query .= '(class_ID LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR class_Code LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR class_Name LIKE "%'.$_POST["search"]["value"].'%" ';
	    $query .= 'OR status_Name LIKE "%'.$_POST["search"]["value"].'%" )';
	}



	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY class_ID DESC ';
	}
	if($_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}


}




	$statement = $account->runQuery($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	
	if($row["status_ID"] == 1){
		$span = "<div class='btn btn-sm btn-success' style='min-width:65px;'>".$row["status_Name"]."</div>";
		$abtn = '<a class="dropdown-item disable_class"  id="'.$row["class_ID"].'">Disable</a>';
	}
	else{
		$span = "<div class='btn btn-sm btn-danger' style='min-width:65px;'>".$row["status_Name"]."</div>";
		$abtn = '<a class="dropdown-item enable_class"  id="'.$row["class_ID"].'">Enable</a>';
	}

	$sub_array = array();

	$class_Description = $row['class_Description'];	
    $cdesc_c = strlen($class_Description );
    $class_Description = substr($class_Description,0,250);
    if($cdesc_c > 100){
    	$ddot = "..";
    }
    else{
    	$ddot = "";
    }

     
     
     if($row["crsx_count"] <= 1)
     {
     	 $crsx_count = $row["crsx_count"]." Student";
     }
     else
     {
     	 $crsx_count = $row["crsx_count"]." Students";
     }

    if($account->student_level()) { 
    	$fbtn ='';
    }
    else{
    	$fbtn = '<div class="btn-group float-right" id="rm_card_btn">
		 '.$span.'
		  <button type="button" class="btn btn-light btn-sm  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <i class="icon-more"></i>
		  </button>
		  <div class="dropdown-menu">
		  <a class="dropdown-item view"  id="'.$row["class_ID"].'">View</a>
		    <a class="dropdown-item edit"  id="'.$row["class_ID"].'">Edit</a>
		      '.$abtn.'
		     <div class="dropdown-divider"></div>
		    <a class="dropdown-item delete" id="'.$row["class_ID"].'">Delete</a>
		  </div>
		</div>';

    }

	  // <a href="classroom_content?classroom_ID='.$row["class_ID"].'&type=stream">'.$row["class_Name"].'</a>
    // '.$crsx_count.'

    if($account->student_level()) { 
    	
    	$za = '<a href="classroom_content?classroom_ID='.$row["class_ID"].'&type=stream&section='.$row["section_ID"].'">'.$row["class_Name"].'</a>';
    }
    else{
    	$za = '<a href="classroom_section?classroom_ID='.$row["class_ID"].'">'.$row["class_Name"].'</a>';
    }
	$sub_array[] = '
	<div class="card " id="rm_card">
	  <div class="card-header text-white" style="background-color:#495057">
	  	'.$za.'
	   <br>
	 

		 '.$fbtn.'

	  </div>
	  <div class="card-body">
	    
	   	'.$class_Description.$ddot.'
	  </div>
	  <div class="card-footer text-muted" style="background-color:#6c757d">
	    
	  </div>
	</div>

	';
	// $sub_array[] = $row["class_ID"];
	// $sub_array[] = $row["class_Code"];
	// $sub_array[] = $row["class_Name"];
	// $sub_array[] = $span;

	$data[] = $sub_array;
}

if (isset($_SESSION['user_ID'])) {
		$q = "SELECT * FROM `class_room_student` `crs`
		LEFT JOIN `class_room` `cr` ON `cr`.`class_ID` = `crs`.`class_ID`
		LEFT JOIN `record_student_details` `rsd` ON `rsd`.`rsd_ID` = `crs`.`rsd_ID`
		LEFT JOIN `user_account` `ua` ON `ua`.`user_ID` = `rsd`.`user_ID`
		LEFT JOIN `ref_status` `rs` ON `rs`.`status_ID` = `cr`.`status_ID`
		 WHERE `rsd`.`user_ID` = '$user_ID'";
}
else{
	$q = "SELECT * FROM `class_room_student`";
}

$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
