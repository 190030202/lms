<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
$page_level = 3;
$auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Yearlevel";
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
        <h1 class="h2">Manage Yearlevel</h1>
        
      </div>

      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-success add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="Yearlevel_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>

<!--modal yearlevel -->
<div class="modal fade" id="yearlevel_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="yearlevel_modal_title">Add Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="yearlevel_form" enctype="multipart/form-data">
      <div class="modal-body" id="product_modal_content">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="yearlevel_name">Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="yearlevel_name" name="yearlevel_name" placeholder="" value="" required="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="yl_ID" id="yl_ID" />
        <input type="hidden" name="operation" id="operation" />
        <div class="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit" id="submit_input" value="submit_yearlevel">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>


      </div>
<!--/modal yearlevel -->

<!--delete modal -->
<div class="modal fade" id="delyearlevel_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="yearlevel_modal_title">Delete this Yearlevel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="Yearlevel_delform">Delete</button>
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
             
            var dataTable = $('#Yearlevel_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/yearlevel/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#yearlevel_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/yearlevel/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Yearlevel');
                  $('#yearlevel_form')[0].reset();
                  $('#yearlevel_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#yearlevel_modal_title').text('Add Yearlevel');
            $("#yearlevel_name").prop("disabled", false);
            $('#yearlevel_form')[0].reset();
            $('#yearlevel_modal').modal('show');
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_yearlevel');
            $('#operation').val("submit_yearlevel");
          });

          $(document).on('click', '.view', function(){
            var yl_ID = $(this).attr("id");
            $('#yearlevel_modal_title').text('View Yearlevel');
            $('#yearlevel_modal').modal('show');
            $("#submit_input").hide();
            
             $.ajax({
                url:"datatable/yearlevel/fetch_single.php",
                method:'POST',
                data:{action:"yearlevel_view",yl_ID:yl_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#yearlevel_name").prop("disabled", true);

                  $('#yearlevel_name').val(data.yl_Name);

                  $('#submit_input').hide();
                  $('#yl_ID').val(yl_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('yearlevel_view');
                  $('#operation').val("yearlevel_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var yl_ID = $(this).attr("id");
            $('#yearlevel_modal_title').text('Edit Yearlevel');
            $('#yearlevel_modal').modal('show');
            $("#submit_input").show();

            
             $.ajax({
                url:"datatable/yearlevel/fetch_single.php",
                method:'POST',
                data:{action:"yearlevel_view",yl_ID:yl_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                $("#yearlevel_name").prop("disabled", false);

                  $('#yearlevel_name').val(data.yl_Name);

                  $('#submit_input').show();
                  $('#yl_ID').val(yl_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('yearlevel_update');
                  $('#operation').val("yearlevel_update");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var yl_ID = $(this).attr("id");
             $('#delyearlevel_modal').modal('show');
             $('.submit').hide();
             
             $('#yl_ID').val(yl_ID);
            });

           


          $(document).on('click', '#Yearlevel_delform', function(event){
             var yl_ID =  $('#yl_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/yearlevel/insert.php",
             data        :   {operation:"delete_yearlevel",yl_ID:yl_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delyearlevel_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Yearlevel');
               dataTable.ajax.reload();
               dataTable_product_data.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
