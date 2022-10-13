<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Topic";
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
      #rm_card a{
        color:white;
      }
      #rm_card_btn a{
        color:black;
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
        <h1 class="h2" style="font-size:16px;">Manage Topic</h1>
        
      </div>
      <nav aria-label="breadcrumb" >
        <ol class="breadcrumb bcrum" >
          <li class="breadcrumb-item " ><a href="index" class="bcrum_i_a">Home</a></li>
          <li class="breadcrumb-item  active bcrum_i_ac" aria-current="page" ><?php 
          if($auth_user->admin_level())
          {
            echo "Classroom Management";
          }
          else{
            echo "Classroom";
          }
            ?></li>
        </ol>
      </nav>
      <div class="table-responsive">
        <?php 
         if($auth_user->student_level()) { 
            ?>
            <button type="button" class="btn btn-sm btn-outline-success float-right join_classroom" data-toggle="modal" data-target="#join_classroom_modal">Join Topic</button>
            <?php
          }
          else{
            ?>
            <button type="button" class="btn btn-sm btn-outline-success add" data-toggle="modal" data-target="#classroom_modal">Add</button>
            <?php
          }
        ?>
         
         <br><br>
        <table class="table table-borderless  table-sm" id="classroom_data" >
  <!--         <thead>
            <tr>
              <th>#</th>
              <th>Course Code</th>
              <th>Course Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody> -->
        </table>


<div class="modal fade" id="classroom_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="classroom_modal_title">Add New Classroom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
    
      <form method="post" id="classroom_form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="classroom_course">Couse Name</label>
                  <input type="text" class="form-control" id="classroom_course" name="classroom_course" placeholder="" value=""  required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="classroom_descr">Description:</label>
                  <textarea class="form-control" id="classroom_descr" name="classroom_descr" placeholder="" value="" required=""></textarea>
                </div>
                <div class="form-group col-md-12">
                  <label for="classroom_password">Password</label>
                  <input type="text" class="form-control" id="classroom_password" name="classroom_password" placeholder="" value=""  required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="student_sex">Status<span class="text-danger">*</span></label>
                  <select class="form-control" id="class_status" name="class_status" required="">
                  <?php 
                   $auth_user->ref_status();
                  ?>
                </select>
                </div>
              </div>   
      </div>

      <div class="modal-footer">
          <input type="hidden" name="classroom_ID" id="classroom_ID" />
          <input type="hidden" name="action" id="action" />
        <div class="" id='sbtng'>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="submit_teacher">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="join_classroom_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Join Topic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="joinclass_form" enctype="multipart/form-data">
        
        <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="join_code">Topic Code</label>
                  <input type="text" class="form-control" id="join_code" name="join_code" placeholder="" value=""  required="">
                </div>

                <div class="form-group col-md-12">
                  <label for="join_section">Section</label>
                  <input type="text" class="form-control" id="join_section" name="join_section" placeholder="" value=""  required="">
                </div>
                <div class="form-group col-md-12">
                  <label for="classroom_course">Password</label>
                  <input type="text" class="form-control" id="join_password" name="join_password" placeholder="" value=""  required="">
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary" id="joinclass_submit"  value="joinclass_submit">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="classroom_modal_delete" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="classroom_modal_title">Delete this Classroom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="classroom_delform">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        
        </div>
        <input type="hidden" id="classroom_delete_id" name="classroom_delete_id" value="" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
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
        <script type="text/javascript">
   


          $(document).ready(function() {
             
            var dataTable = $('#classroom_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
               "bAutoWidth": false,
            "searching": true,
            // "paging":   false,
            "ordering": false,
            "info":     false,
            "ajax":{
              url:"datatable/classroom/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],
            

          });

          

          $(document).on('submit', '#classroom_form', function(event){
            event.preventDefault();
             var formData = new FormData(this);
              // formData.append('action', "classroom_add");
              $.ajax({
                url:"datatable/classroom/insert.php",
                method:'POST',
                data:formData,
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Classroom');
                  $('#classroom_form')[0].reset();
                  $('#classroom_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });


          $(document).on('submit', '#joinclass_form', function(event){
            event.preventDefault();
      

             var formData = new FormData(this);
              formData.append('action', "joinclass_submit");
              $.ajax({
                url:"datatable/classroom/insert.php",
                method:'POST',
                data:formData,
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alert(data);
                  $('#join_classroom_modal').modal('hide');
                  $('#joinclass_form')[0].reset();
                  
                }
              });
           
          });


          

          $(document).on('click', '.add', function(){
            $('#classroom_modal_title').text('Add New Classroom');

            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");

            $('#classroom_form')[0].reset();
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('classroom_add');
            $('#action').val("classroom_add");
          });

          $(document).on('click', '.view', function(){
            var classroom_ID = $(this).attr("id");
            $('#classroom_modal_title').text('View Classroom');
            $('#classroom_modal').modal('show');


            $('#submit_input').hide();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\bbtn-group\b/g, "");
            // btng.classList.add("btng_null");
            
             $.ajax({
                url:"datatable/classroom/fetch_single.php",
                method:'POST',
                data:{action:"classroom_view",classroom_ID:classroom_ID},
                dataType    :   'json',
                success:function(data)
                {



                $("#classroom_course").prop("disabled", true);
                $("#classroom_descr").prop("disabled", true);
                $("#classroom_password").prop("disabled", true);
                $("#class_status").prop("disabled", true);

                  $('#classroom_course').val(data.class_Name);
                  $('#classroom_descr').val(data.class_Description);
                  $('#classroom_password').val(data.class_Password);
                  $('#class_status').val(data.class_status).change();
        

                  $('#submit_input').hide();
                  $('#classroom_ID').val(classroom_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('classroom_view');
                
                  $('#action').val("classroom_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var classroom_ID = $(this).attr("id");
            $('#classroom_modal_title').text('Edit Classroom');
            $('#classroom_modal').modal('show');
          
            $('#submit_input').show();
            // var btng = document.getElementById("sbtng");
            // btng.className = btng.className.replace(/\btng_null\b/g, "");
            // btng.classList.add("btn-group");
            
             $.ajax({
                url:"datatable/classroom/fetch_single.php",
                method:'POST',
                data:{action:"classroom_edit",classroom_ID:classroom_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $("#classroom_course").prop("disabled", false);
                  $("#classroom_descr").prop("disabled", false);
                  $("#classroom_password").prop("disabled", false);
                  $("#class_status").prop("disabled", false);

                  $('#classroom_course').val(data.class_Name);
                  $('#classroom_descr').val(data.class_Description);
                  $('#classroom_password').val(data.class_Password);
                  $('#class_status').val(data.class_status).change();

                  $('#submit_input').show();
                  $('#classroom_ID').val(classroom_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('classroom_edit');   
                  $('#action').val("classroom_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var classroom_ID = $(this).attr("id");
           
             $('#classroom_modal_delete').modal('show');
          
             
             $('#classroom_delete_id').val(classroom_ID);
            });

            $(document).on('click', '.enable_class', function(){
            var classroom_ID = $(this).attr("id");
          
           alertify.confirm(
            'Are you sure you want to enable this classroom?', 
            function(){ 
               $.ajax({
               type        :   'POST',
               url:"datatable/classroom/insert.php",
                data:{action:"enable_classroom",classroom_ID:classroom_ID},
               dataType    :   'json',
               complete     :   function(data) {

                  alertify.alert(data.responseText).setHeader('Classroom');
                 dataTable.ajax.reload();
               }
              });
              alertify.success('Ok') 
            }, 
            function(){ 
              alertify.error('Cancel')
            }).setHeader('Classroom');
            
            });


            $(document).on('click', '.disable_class', function(){
            var classroom_ID = $(this).attr("id");
           

            alertify.confirm(
            'Are you sure you want to disable this classroom?', 
            function(){ 
               $.ajax({
               type        :   'POST',
               url:"datatable/classroom/insert.php",
                data:{action:"disabled_classroom",classroom_ID:classroom_ID},
               dataType    :   'json',
               complete     :   function(data) {

                  alertify.alert(data.responseText).setHeader('Classroom');
                 dataTable.ajax.reload();
               }
              });
              alertify.success('Ok') 
            }, 
            function(){ 
              alertify.error('Cancel')
            }).setHeader('Classroom');

            });
                        

           


          $(document).on('click', '#classroom_delform', function(event){
             var classroom_ID =  $('#classroom_delete_id').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/classroom/insert.php",
             data        :   {action:"classroom_delete",classroom_ID:classroom_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#classroom_modal_delete').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Classroom');
               dataTable.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
