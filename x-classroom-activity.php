<button type="button" class="btn btn-sm btn-outline-info float-right material" data-toggle="modal" data-target="#material_modal" style="margin-top:-25px;">Class  Materials</button>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tabx_quiz" role="tab" aria-controls="home" aria-selected="true">Quiz</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tabx_ass" role="tab" aria-controls="profile" aria-selected="false">Assignment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tabx_proj" role="tab" aria-controls="contact" aria-selected="false">Project</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
 
  <div class="tab-pane fade show active" id="tabx_quiz" role="tabpanel" aria-labelledby="home-tab">
        <br>
   <?php 
              if($auth_user->student_level()) 
              {
              }
               else{
                ?> <button type="button" class="btn btn-sm btn-outline-success add quiz" data-toggle="modal" data-target="#test_modal">Add Quiz</button><?php
               }
              ?>
                 <br><br>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="activity_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Type</th>
              <th>Date Added</th>
              <th>Date Expired</th>
              <th>Timer</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
        </div>
  </div>

  <div class="tab-pane fade" id="tabx_ass" role="tabpanel" aria-labelledby="profile-tab">
     <br>
      <?php 
              if($auth_user->student_level()) 
              {
              }
               else{
                ?> <button type="button" class="btn btn-sm btn-outline-success add_ass" data-toggle="modal" data-target="#assignment_modal">Add Assignment</button><?php
               }
              ?>
    <br><br>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="activity_data_ass">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Date Added</th>
              <th>Date Expired</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
  </div>
</div>
  <div class="tab-pane fade" id="tabx_proj" role="tabpanel" aria-labelledby="contact-tab">
        <br>
        
      <?php 
              if($auth_user->student_level()) 
              {
              }
               else{
                ?> <button type="button" class="btn btn-sm btn-outline-success add_project" data-toggle="modal" data-target="#projectx">Add Project</button><?php
               }
              ?>
    <br><br>
        <div class="table-responsive">
        <table class="table table-striped table-sm" id="activity_project">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Date Added</th>
              <th>Date Expired</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
  </div>
  </div>
</div>



<div class="modal fade" id="test_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="test_modal_title">Add New Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
    
      <form method="post" id="test_form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="test_name">Name</label>
                  <input type="text" class="form-control" id="test_name" name="test_name" placeholder="" value=""  required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="test_expired">Expired</label>
                  <input type="datetime-local" class="form-control" id="test_expired" name="test_expired"  value=""  required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="test_timer">Timer(Min):</label>
                  <input type="text" class="form-control" id="test_timer" name="test_timer" placeholder="00" value="" maxlength="4" minlength="1"required="">
                </div>
              </div>  

                <div class="form-group">
             <!--    <label for="prod_category">Type</label>
                <select class="form-control" id="test_type" name="test_type">
                  <?php 
                   $auth_user->ref_test_type();
                  ?>
                </select> -->
                  <input type="hidden" class="form-control" id="test_type" name="test_type"  value="1">
                
                <label for="prod_category">Status</label>
                <select class="form-control" id="test_status" name="test_status">
                  <?php 
                   $auth_user->ref_status();
                  ?>
                </select>
              </div>
      </div>
      <div class="modal-footer">

        <input type="hidden" name="class_ID" id="class_ID" />
        <input type="hidden" name="test_ID" id="test_ID" />
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <input type="hidden" name="operation" id="operation" />
        <div class="" id="sbtng">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="test_submit">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="material_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Class Materials</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
          
        <?php 
        if($auth_user->student_level()) 
        {
        }
         else{
          ?><button type="button" class="btn btn-sm btn-outline-success add_materials" >Add Materials</button><?php
         }
        ?>
          <br><br>
          <table class="table table-striped table-sm" id="material_data">
           <thead>
            <tr>
              <th>#</th>
              <th width="70%">Name</th>
              <th>Type</th>
              <th >Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="material_submit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Materials</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <form method="post" id="material_form" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group row">
          <label for="material_name" class="col-sm-2 col-form-label">Material Name:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="material_name" name="material_name" >
          </div>
        </div>
        <div class="form-group row">
          <label for="material_file" class="col-sm-2 col-form-label">File:</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="material_file" name="material_file" >
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="m_operation" id="m_operation" value="material_submit"/>
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input_m" value="material_submit">Submit</button>
      </div>
      </form>
    </div>
</div>
</div>

  <div class="modal fade" id="deltest_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="test_modal_title">Delete this Quiz</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
          <div class="btn-group">
          <button type="submit" class="btn btn-danger" id="test_delform">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
   <!-- VIEW STUDENT SCORES -->
<div class="modal fade" id="student_scores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">STUDENT SCORES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table table-striped table-sm" id="scorestudent_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Student ID</th>
              <th>Name</th>
              <th>Score</th>
              <th>
              <select id="score_filter">
                  <option value="All">All</option>
                  <option value="NotYet">Not Yet Taken</option>
                  <option value="Failed">Failed</option>
                  <option value="Passed">Passed</option>
              </select>
            </th>
      
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="student_projects" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Projects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
            <table class="table table-striped table-sm" id="projectstudent_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Student ID</th>
              <th>Name</th>
              <th>Name</th>
              <th>Submitted File</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="student_assignments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Assignments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
            <table class="table table-striped table-sm" id="assignmentstudent_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Student ID</th>
              <th>Name</th>
              <th>Name</th>
              <th>Submitted File</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="projectx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="projectx_modal_title">Add Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
        <form method="post" id="project_form" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="proj_name">Project Name:</label>
            <input type="text" class="form-control" id="proj_name" name="proj_name" placeholder="" value=""  required="">
          </div>
          <div class="form-group col-md-12">
            <label for="proj_desc">Project Description:</label>
            

          <textarea class="form-control" id="proj_desc" name="proj_desc" placeholder="" value=""  required=""></textarea>
          </div>
          <div class="form-group col-md-12">
            <label for="proj_expired">Expired</label>
            <input type="datetime-local" class="form-control" id="proj_expired" name="proj_expired"  value=""  required="">
          </div>
        </div>
      </div>
        <div class="modal-footer">
        <input type="hidden" name="proj_ID" id="proj_ID" value=""/>
        <input type="hidden" name="attachment_IDx" id="attachment_IDx" value=""/>
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="operation" id="p_operation" value="submit_project"/>
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input_p" value="submit_project">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="assignment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignemtnx_modal_title">Add Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
        <form method="post" id="assignment_form" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="assg_name">Assignment Name:</label>
            <input type="text" class="form-control" id="assg_name" name="assg_name" placeholder="" value=""  required="">
          </div>
          <div class="form-group col-md-12">
            <label for="assg_desc">Assignment Description:</label>
            

          <textarea class="form-control" id="assg_desc" name="assg_desc" placeholder="" value=""  required=""></textarea>
          </div>
          <div class="form-group col-md-12">
            <label for="assg_expired">Expired</label>
            <input type="datetime-local" class="form-control" id="assg_expired" name="assg_expired"  value=""  required="">
          </div>
        </div>
      </div>
        <div class="modal-footer">
        <input type="hidden" name="ca_ID" id="ca_ID" value=""/>
        <input type="hidden" name="attachment_IDca" id="attachment_IDca" value=""/>
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="operation" id="a_operation" value="submit_assignment"/>
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input_a" value="submit_assignment">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="sp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sp_title">Submit Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <form method="post" id="sproj_form" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group col-md-12">
            <label for="proj_name">Project Name:</label>
            
            <div id="proj_namex"></div>
          </div>
          <div class="form-group col-md-12">
            <label for="proj_desc"> Description:</label>
            <div id="proj_descx"></div>
          
          </div>
        <div class="form-group row">
          <!-- <label for="sproj_Desc" class="col-sm-2 col-form-label">Description:</label> -->
          <div class="col-sm-12">
            <textarea class="form-control" id="sproj_Desc" name="sproj_Desc" ></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="sproj_file" class="col-sm-2 col-form-label">Attachment:</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="sproj_file" name="sproj_file" >
          </div>
        </div>
        <div id="attachment_cont"></div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="sp_operation" id="sp_operation" value="sproject_submit"/>
        <input type="hidden" name="projx_ID" id="projx_ID" value=""/>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input_sp" value="submit_input_sp">Submit</button>
      </div>
      </form>
    </div>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="sa_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sa_title">Submit Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <form method="post" id="sassignment_form" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group col-md-12">
            <label for="sassg_name">Project Name:</label>
            
            <div id="sassg_namex"></div>
          </div>
          <div class="form-group col-md-12">
            <label for="sassg_desc"> Description:</label>
            <div id="sassg_descx"></div>
          
          </div>
        <div class="form-group row">
          <!-- <label for="sproj_Desc" class="col-sm-2 col-form-label">Description:</label> -->
          <div class="col-sm-12">
            <textarea class="form-control" id="sassg_Desc" name="sassg_Desc" ></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="sassg_file" class="col-sm-2 col-form-label">Attachment:</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="sassg_file" name="sassg_file" >
          </div>
        </div>
        <div id="sassgattachment_cont"></div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="sa_operation" id="sa_operation" value="sassignment_submit"/>
        <input type="hidden" name="sassg_ID" id="sassg_ID" value=""/>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input_sa" value="submit_input_sa">Submit</button>
      </div>
      </form>
    </div>
</div>
</div>

    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>
        <script type="text/javascript">
   


          $(document).ready(function() {
             
            var dataTable = $('#activity_data').DataTable({
            "processing":true,
            "serverSide":true,
            "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/classroom_activity/fetch.php?class_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>+"&type=1",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            var dataTable_ass = $('#activity_data_ass').DataTable({
            "processing":true,
            "serverSide":true,
            "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/classroom_assignment/fetch.php?class_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            var dataTable_proj = $('#activity_project').DataTable({
            "processing":true,
            "serverSide":true,
            "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/classroom_project/fetch.php?class_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            <?php 
            if($auth_user->student_level()) 
            { 
              ?>
              dataTable.columns( [6] ).visible( false );
              <?php
            }
            ?>
            var materials_dataTable = $('#material_data').DataTable({
            "processing":true,
            "serverSide":true,
            "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/classroom_materials/fetch.php?class_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            function scorestudent_test($test_ID,$filter){
              var scorestud_dataTable = $('#scorestudent_data').DataTable({
              "processing":true,
              "serverSide":true,
              "order":[],
              "ordering": false,
              "bAutoWidth": false,
              "searching": false,
              "paging":     false,
              "ajax":{
                url:"datatable/classroom/fetch_studentscore.php?test_ID="+$test_ID+"&class_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>+"&filterx="+$filter,
                type:"POST"
              },
              "columnDefs":[
                {
                  "targets":[0],
                  "orderable":false,
                },
              ],

            });
         
    
          }
           $("#score_filter").change(function () {
              var filter = this.value;
              var test_ID = $('#test_ID').val();
             scorestudent_test(test_ID,filter);
             $('#scorestudent_data').DataTable().destroy();
             
          });

            function projectstudent_files($proj_ID){
              var projstud_dataTable = $('#projectstudent_data').DataTable({
              "processing":true,
              "serverSide":true,
              "order":[],
              "ordering": false,
              "bAutoWidth": false,
              "searching": false,
              "paging":     false,
              "ajax":{
                url:"datatable/classroom_project/fetch_projectfiles.php?proj_ID="+$proj_ID+"&classroom_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
                type:"POST"
              },
              "columnDefs":[
                {
                  "targets":[0],
                  "orderable":false,
                },
              ],

            });
          }



          
          function qestionaire(test_ID){
               var questionaire_dataTable = $('#questionaire_data').DataTable({
              "processing":true,
              "serverSide":true,
              "order":[],
              "ajax":{
                url:"datatable/classroom_activity/fetch_questionaire.php?test_ID="+test_ID,
                type:"POST"
                
              },
              "columnDefs":[
                {
                  "targets":[0],
                  "orderable":false,
                },
              ],

            });
          }
       



         $(document).on('submit', '#test_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_activity/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Quiz');
                  $('#test_form')[0].reset();
                  $('#test_modal').modal('hide');
                  dataTable.ajax.reload();
                  dataTable_ass.ajax.reload();
                  
                }
              });
           
          });
          $(document).on('submit', '#material_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_materials/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Material');
                  $('#material_form')[0].reset();
                  $('#material_submit_modal').modal('hide');
                  materials_dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('submit', '#project_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_project/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Project');
                  $('#project_form')[0].reset();
                  $('#projectx').modal('hide');
                  dataTable_proj.ajax.reload();
                }
              });
           
          });

            $(document).on('submit', '#assignment_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_assignment/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Assignment');
                  $('#assignment_form')[0].reset();
                  $('#assignment_modal').modal('hide');
                  dataTable_ass.ajax.reload();
                }
              });
           
          });

          

         

          $(document).on('click', '.add', function(){
            $('#test_modal_title').text('Add Activity');
            $("#test_name").prop("disabled", false);
            $('#test_form')[0].reset();

            //   var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");


            $('#submit_input').show();
            jQuery('#class_ID').val(<?php echo $classroom_ID ?>) ;

            $('#submit_input').text('Submit');
            $('#submit_input').val('test_submit');
            $('#operation').val("test_submit");
          });

          $(document).on('click', '.view', function(){
            var test_ID = $(this).attr("id");
            $('#test_modal_title').text('View Quiz');
            $('#test_modal').modal('show');
     

            $('#submit_input').hide();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\bbtn-group\b/g, "");
            // btng.classList.add("btng_null");
            
             $.ajax({
                url:"datatable/classroom_activity/fetch_single.php",
                method:'POST',
                data:{action:"test_view",test_ID:test_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#test_name").prop("disabled", true);
                $("#test_expired").prop("disabled", true);
                $("#test_timer").prop("disabled", true);
                $("#test_type").prop("disabled", true);
                $("#test_status").prop("disabled", true);

                  $('#test_name').val(data.test_Name);
                  $('#test_expired').val(data.test_Expired);
                  $('#test_timer').val(data.test_Timer);
                  $('#test_type').val(data.tstt_ID).change();
                  $('#test_status').val(data.status_ID).change();

                  $('#submit_input').hide();
                  $('#test_ID').val(test_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('test_view');
                  $('#operation').val("test_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var test_ID = $(this).attr("id");
            $('#test_modal_title').text('Edit Quiz');
            $('#test_modal').modal('show');
          
            $('#submit_input').show();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\bbtng_null\b/g, "");
            // btng.classList.add("btn-group");
           jQuery('#class_ID').val(<?php echo $classroom_ID ?>) ;
            
             $.ajax({
                url:"datatable/classroom_activity/fetch_single.php",
                method:'POST',
                data:{action:"test_view",test_ID:test_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#test_name").prop("disabled", false);
                $("#test_expired").prop("disabled", false);
                $("#test_timer").prop("disabled", false);
                $("#test_type").prop("disabled", false);
                $("#test_status").prop("disabled", false);

                  $('#test_name').val(data.test_Name);
                  $('#test_expired').val(data.test_Expired);
                  $('#test_timer').val(data.test_Timer);
                  $('#test_type').val(data.tstt_ID).change();
                  $('#test_status').val(data.status_ID).change();

                  $('#submit_input').show();
                  $('#test_ID').val(test_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('test_edit');
                  $('#operation').val("test_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var test_ID = $(this).attr("id");
             $('#deltest_modal').modal('show');
             $('.submit').hide();
             
             $('#test_ID').val(test_ID);
            });

            $(document).on('click', '.view_questionaire', function(){
            var test_ID = $(this).attr("id");
             $('#questionaire_modal').modal('show');
       
         
             qestionaire(test_ID);    
             $('#questionaire_data').DataTable().destroy();
         
          
            });
            $(document).on('click', '.view_score', function(){
            var test_ID = $(this).attr("id");
             $('#test_ID').val(test_ID);
             $('#student_scores').modal('show');
       
         
             scorestudent_test(test_ID,"");
             $('#scorestudent_data').DataTable().destroy();
         
          
            });

          $(document).on('click', '.edit_question', function(){
            var question_ID = $(this).attr("id");
             $('#question_modal').modal('show');
          
            });

            $(document).on('click', '.add_question', function(){
            var question_ID = $(this).attr("id");
             $('#question_modal').modal('show');
              questionaire_dataTable.ajax.reload();
          
            });

            $(document).on('click', '.add_materials', function(){
          
             $('#material_submit_modal').modal('show');
              questionaire_dataTable.ajax.reload();
          
            });
            
             $(document).on('click', '.delete_material', function(){
              var material_ID = $(this).attr("id");
        
               alertify.confirm('Are you sure you want to delete this material?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_materials/insert.php",
                 data        :   {m_operation:"material_delete",material_ID:material_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Classroom Materials');
                   materials_dataTable.ajax.reload();
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Classroom Materials');
             
          
            });

            
           
           

           




          $(document).on('click', '#test_delform', function(event){
             var test_ID =  $('#test_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/classroom_activity/insert.php",
             data        :   {operation:"test_delete",test_ID:test_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#deltest_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Quiz');
               
                dataTable.ajax.reload();
                dataTable_ass.ajax.reload();
          
                
             }
            })
           
          });


          

           $(document).on('click', '.studview_score', function(event){

              var test_ID =  $(this).attr("id");
              $('#test_ID').val(test_ID);

               $.ajax({
                url:"datatable/classroom_activity/insert.php",
                method:'POST',
                data:{operation:"test_view",test_ID:test_ID},
                dataType    :   'json',
                complete:function(data)
                {
                  alertify.alert(data.responseText).setHeader('Test Score');
                  
                  
                }
              });
           
          });


           $(document).on('click', '.quiz', function(){
            // alert("quiz");
            
            $('#test_type').val("1");
            });
           $(document).on('click', '.ass', function(){
            // alert("Ass");
            $('#test_type').val("3");
            });

           $(document).on('click', '.add_project', function(){
              
              $("#proj_name").prop("disabled", false);
              $("#proj_desc").prop("disabled", false);
              $("#proj_expired").prop("disabled", false);

              $('#projectx_modal_title').html("Add Project");
              $('#p_operation').val("submit_project");
              $('#submit_input_p').val("submit_project");
              $('#submit_input_p').text("Submit");
               
                  
            });
            $(document).on('click', '.view_proj', function(){
            var proj_ID = $(this).attr("id");
            $('#projectx_modal_title').text('View Project');
            $('#projectx').modal('show');
            
             $.ajax({
                url:"datatable/classroom_project/fetch_single.php",
                method:'POST',
                data:{action:"project_view",proj_ID:proj_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#proj_name").prop("disabled", true);
                  $("#proj_desc").prop("disabled", true);
                  $("#proj_expired").prop("disabled", true);

                  $('#proj_name').val(data.proj_Name);
                  $('#proj_desc').val(data.proj_Name);

                  $('#p_operation').hide();
                  $('#submit_input_p').hide();


                  
                }
              });


            });

            $(document).on('click', '.edit_proj', function(){
            var proj_ID = $(this).attr("id");
            $('#projectx_modal_title').text('View Project');
            $('#projectx').modal('show');
            
             $.ajax({
                url:"datatable/classroom_project/fetch_single.php",
                method:'POST',
                data:{action:"project_view",proj_ID:proj_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#proj_name").prop("disabled", false);
                  $("#proj_desc").prop("disabled", false);
                  $("#proj_expired").prop("disabled", false);

                  $('#proj_name').val(data.proj_Name);
                  $('#proj_desc').val(data.proj_Name);
                  $('#proj_expired').val(data.proj_expired);
                  $('#proj_ID').val(proj_ID);
                  
                  $('#p_operation').show();
                  $('#submit_input_p').show();
                  $('#p_operation').val("edit_project");
                  $('#submit_input_p').val("edit_project");
                  $('#submit_input_p').text("Update");


                  
                }
              });


            });

            $(document).on('click', '.delete_proj', function(){
                var proj_ID = $(this).attr("id");
        
                 alertify.confirm('Are you sure you want to delete this project?', 
                function(){
                  $.ajax({
                   type        :   'POST',
                   url:"datatable/classroom_project/insert.php",
                   data        :   {operation:"proj_delete",proj_ID:proj_ID},
                   dataType    :   'json',
                   complete     :   function(data) {
                     alertify.alert(data.responseText).setHeader('Project');
                     dataTable_proj.ajax.reload();
                      
                   }
                  })

                  
                   alertify.success('Ok') 
                 },
                function(){ 
                  alertify.error('Cancel')
                }).setHeader('Project');
            
            });


     $(document).on('submit', '#sproj_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_project/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Project');
                  $('#sproj_form')[0].reset();
                  $('#sp_modal').modal('hide');
                  dataTable_proj.ajax.reload();
                }
              });
           
          });
        $(document).on('click', '.submit_proj', function(){
          var proj_ID = $(this).attr("id");
          $("#sp_modal").modal('show');

            $.ajax({
                url:"datatable/classroom_project/fetch_single.php",
                method:'POST',
                data:{action:"project_view",proj_ID:proj_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $('#proj_namex').html(data.proj_Name);
                  $('#proj_descx').html(data.proj_Name);
                  $('#projx_ID').val(proj_ID);

                  
                  $('#sp_operation').val("sproject_submit");

                  $('#submit_input_sp').val("submit_input_sp");
                  $('#submit_input_sp').text("Submit");


                  
                }
              });

          
          

         });

         $(document).on('click', '.update_proj', function(){
          var proj_ID = $(this).attr("id");

          $("#sp_modal").modal('show');

            $.ajax({
                url:"datatable/classroom_project/fetch_single.php",
                method:'POST',
                data:{action:"project_view",proj_ID:proj_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $('#proj_namex').html(data.proj_Name);
                  $('#proj_descx').html(data.proj_Name);
                  $('#projx_ID').val(proj_ID);
                  $('#sproj_Desc').html(data.sproj_desc);
                  $('#attachment_cont').html(data.sproj_attch);
                  
                  $('#sp_operation').val("sproject_update");
                  
                  $('#submit_input_sp').val("submit_input_sp");
                  $('#submit_input_sp').text("Update");


                  
                }
              });

          
          

         });

         $(document).on('click', '.delete_sproj_s', function(){
          // alert("delete");
           var attch_ID = $(this).attr("id");
           alertify.confirm('Are you sure you want to remove this attachment?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_project/insert.php",
                 data        :   {sp_operation:"sproject_delete",attch_ID:attch_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Project Attachment');
                  
                   $("#sp_modal").modal('hide');
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Project Attachment');
         });

 	$(document).on('click', '.view_subproj', function(){
 		var proj_ID = $(this).attr("id");
 		$("#student_projects").modal('show');
 		projectstudent_files(proj_ID);
 		$('#projectstudent_data').DataTable().destroy();
 	 });
         
         
            
            
//NEWWWW 



$(document).on('click', '.add_ass', function(){
              
              $("#assg_name").prop("disabled", false);
              $("#assg_desc").prop("disabled", false);
              $("#assg_expired").prop("disabled", false);

              $('#assignemtnx_modal_title').html("Add Assignment");
              $('#a_operation').val("submit_assignment");
              $('#submit_input_a').val("submit_assignment");
              $('#submit_input_a').text("Submit");
               
                  
            });

            $(document).on('click', '.view_assg', function(){
            var ca_ID = $(this).attr("id");
            $('#assignemtnx_modal_title').text('View Assignment');
            $('#assignment_modal').modal('show');
            
             $.ajax({
                url:"datatable/classroom_assignment/fetch_single.php",
                method:'POST',
                data:{action:"assignment_view",ca_ID:ca_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#assg_name").prop("disabled", true);
                  $("#assg_desc").prop("disabled", true);
                  $("#assg_expired").prop("disabled", true);

                  $('#assg_name').val(data.assg_Name);
                  $('#assg_desc').val(data.assg_Desc);
                  $('#assg_expired').val(data.assg_expired);

                  $('#a_operation').hide();
                  $('#submit_input_a').hide();


                  
                }
              });


            });

            $(document).on('click', '.edit_assg', function(){
            var ca_ID = $(this).attr("id");
            $('#assignemtnx_modal_title').text('View Assignment');
            $('#assignment_modal').modal('show'); 

              $.ajax({
                url:"datatable/classroom_assignment/fetch_single.php",
                method:'POST',
                data:{action:"assignment_view",ca_ID:ca_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#assg_name").prop("disabled", false);
                  $("#assg_desc").prop("disabled", false);
                  $("#assg_expired").prop("disabled", false);

                  $('#assg_name').val(data.assg_Name);
                  $('#assg_desc').val(data.assg_Desc);
                  $('#assg_expired').val(data.assg_expired);
                  $('#ca_ID').val(ca_ID);

                  $('#ca_ID').show();
                  $('#submit_input_a').show();
                  $('#a_operation').val("edit_assg");
                  $('#submit_input_a').val("edit_assg");
                  $('#submit_input_a').text("Update");


                  
                }
              });


            });

            $(document).on('click', '.delete_assg', function(){
                var ca_ID = $(this).attr("id");
        
                 alertify.confirm('Are you sure you want to delete this assignment?', 
                function(){
                  $.ajax({
                   type        :   'POST',
                   url:"datatable/classroom_assignment/insert.php",
                   data        :   {operation:"assignment_delete",ca_ID:ca_ID},
                   dataType    :   'json',
                   complete     :   function(data) {
                     alertify.alert(data.responseText).setHeader('Assignment');
                     dataTable_ass.ajax.reload();
                      
                   }
                  })

                  
                   alertify.success('Ok') 
                 },
                function(){ 
                  alertify.error('Cancel')
                }).setHeader('Assignment');
            
            });




          
          
          } );

  $(document).on('click', '.view_subassg', function(){
    var ca_IDc = $(this).attr("id");

    $("#student_assignments").modal('show');
      assgfiles(ca_IDc);
    $('#assignmentstudent_data').DataTable().destroy();
   });

          function assgfiles(aaaaaaaaa)
          {
              var assignmentstudf_dataTable = $('#assignmentstudent_data').DataTable({
              "processing":true,
              "serverSide":true,
              "order":[],
              "ordering": false,
              "bAutoWidth": false,
              "searching": false,
              "paging":     false,
              "ajax":{
                url:"datatable/classroom_assignment/fetch_assignmentfiles.php?ca_ID="+aaaaaaaaa+"&classroom_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
                type:"POST"
              },
              "columnDefs":[
                {
                  "targets":[0],
                  "orderable":false,
                },
              ],

            });
          }


           $(document).on('submit', '#sassignment_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_assignment/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Assignment');
                  $('#sassignment_form')[0].reset();
                  $('#sa_modal').modal('hide');
                  dataTable_ass.ajax.reload();
                }
              });
           
          });
        $(document).on('click', '.submit_assignment', function(){
          var ca_ID = $(this).attr("id");
          $("#sa_modal").modal('show');

            $.ajax({
                url:"datatable/classroom_assignment/fetch_single.php",
                method:'POST',
                data:{action:"assignment_view",ca_ID:ca_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $('#sassg_namex').html(data.assg_Name);
                  $('#sassg_descx').html(data.assg_Desc);
                  $('#sassg_ID').val(ca_ID);

                  
                  $('#sassgattachment_cont').html('');
                  $('#sa_operation').val("sassignment_submit");

                  $('#submit_input_sa').val("submit_input_sa");
                  $('#submit_input_sa').text("Submit");

                  

                  projectstudent_files(ca_ID);
                  $('#assignmentstudent_data').DataTable().destroy();

                  
                }
              });

          
          

         });

         $(document).on('click', '.update_assignment', function(){
          var ca_ID = $(this).attr("id");

          $("#sa_modal").modal('show');
            $.ajax({
                url:"datatable/classroom_assignment/fetch_single.php",
                method:'POST',
                data:{action:"assignment_view",ca_ID:ca_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $('#sassg_namex').html(data.assg_Name);
                  $('#sassg_descx').html(data.assg_Desc);
                  $('#sassg_Desc').html(data.sassg_desc);
                  
                  $('#sassg_ID').val(ca_ID);
                  $('#sassgattachment_cont').html(data.sassg_attch);
                  
                  $('#sa_operation').val("sassigment_update");
                  
                  $('#submit_input_sa').val("submit_input_sa");
                  $('#submit_input_sa').text("Update");


                  
                }
              });

          
          

         });

         $(document).on('click', '.delete_sassigment_s', function(){
          // alert("delete");
           var attch_ID = $(this).attr("id");
           alertify.confirm('Are you sure you want to remove this attachment?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_assignment/insert.php",
                 data        :   {sa_operation:"sassignment_delete",attch_ID:attch_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Assignment Attachment');
                  
                   $("#sa_modal").modal('hide');
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Assignment Attachment');
         });

        </script>
        </body>