<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Subject";
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
        <h1 class="h2">Manage Subject</h1>
        
      </div>

      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-success add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="subject_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Code</th>
              <th>Title</th>
              <th>Abbreviation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>

<!--modal subject -->
<div class="modal fade" id="subject_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subject_modal_title">Add Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="subject_form" enctype="multipart/form-data">
        <div class="modal-body" id="product_modal_content">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="subject_title">Title<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="subject_title" name="subject_title" placeholder="" value="" required="">
            </div>
            <div class="form-group col-md-12">
              <label for="subject_abbreviation">Abbreviation</label>
              <input type="text" class="form-control" id="subject_abbreviation" name="subject_abbreviation" placeholder="" value="" required="">
            </div>
          </div>
         </div>
        <div class="modal-footer">
          <input type="hidden" name="subject_ID" id="subject_ID" />
          <input type="hidden" name="operation" id="operation" />
          <div class="">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_subject">Submit</button>
          </div>
        </div>
       </form>
    
    </div><!-- modal content -->
  </div><!--/modal dialog content -->
</div><!--/modal subject -->

<!--delete modal -->
<div class="modal fade" id="delsubject_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subject_modal_title">Delete this Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="subject_delform">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!--/delete modal -->

    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>
        <script type="text/javascript">
   


          $(document).ready(function() {
             
            var dataTable = $('#subject_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/subject/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#subject_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/subject/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Subject');
                  $('#subject_form')[0].reset();
                  $('#subject_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#subject_modal_title').text('Add Subject');
            $("#subject_title").prop("disabled", false);
            $("#subject_abbreviation").prop("disabled", false);

            $('#subject_form')[0].reset();
            $('#subject_modal').modal('show');
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_subject');
            $('#operation').val("submit_subject");
          });

          $(document).on('click', '.view', function(){
            var subject_ID = $(this).attr("id");
            $('#subject_modal_title').text('View News');
            $('#subject_modal').modal('show');
            $("#submit_input").hide();
            
             $.ajax({
                url:"datatable/subject/fetch_single.php",
                method:'POST',
                data:{action:"subject_view",subject_ID:subject_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#subject_title").prop("disabled", true);
                $("#subject_abbreviation").prop("disabled", true);

                  $('#subject_title').val(data.subject_Title);
                  $('#subject_abbreviation').val(data.Abbreviation);

                  $('#submit_input').hide();
                  $('#subject_ID').val(subject_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('subject_view');
                  $('#operation').val("subject_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var subject_ID = $(this).attr("id");
            $('#subject_modal_title').text('Edit Subject');
            $('#subject_modal').modal('show');
            $("#submit_input").show();

            
             $.ajax({
                url:"datatable/subject/fetch_single.php",
                method:'POST',
                data:{action:"subject_view",subject_ID:subject_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                $("#subject_title").prop("disabled", false);
                $("#subject_abbreviation").prop("disabled", false);

                  $('#subject_title').val(data.subject_Title);
                  $('#subject_abbreviation').val(data.Abbreviation);

                  $('#submit_input').show();
                  $('#subject_ID').val(subject_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('subject_update');
                  $('#operation').val("subject_update");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var subject_ID = $(this).attr("id");
             $('#delsubject_modal').modal('show');
             $('.submit').hide();
             
             $('#subject_ID').val(subject_ID);
            });

           


          $(document).on('click', '#subject_delform', function(event){
             var subject_ID =  $('#subject_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/subject/insert.php",
             data        :   {operation:"delete_subject",subject_ID:subject_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delsubject_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Subject');
               dataTable.ajax.reload();
               dataTable_product_data.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
