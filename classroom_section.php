<?php 
include('../session.php');


require_once("../class.user.php");

  
$auth_user = new USER();
// $page_level = 3;
// $auth_user->check_accesslevel($page_level);
$pageTitle = "Manage Section";
$classroom_ID = "";
if (isset($_REQUEST["classroom_ID"])){

$classroom_ID = $_REQUEST["classroom_ID"];
}
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
        <h1 class="h2">Manage Section</h1>
        
      </div>

      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-outline-success add" >
            Add 
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="section_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<div class="modal fade" id="section_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section_modal_title">Add Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
    
      <form method="post" id="section_form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="section_title">Title<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="section_title" name="section_title" placeholder="" value="" required="">
                </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="section_ID" id="section_ID" />
        <input type="hidden" name="classroom_ID" id="classroom_ID" value="<?php echo $classroom_ID?>" />
        <input type="hidden" name="operation" id="operation" />
        <div class="">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="submit_section">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>


      </div>

<div class="modal fade" id="delsection_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="section_modal_title">Delete this Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="Section_delform">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
             
            var dataTable = $('#section_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/section/fetch.php?classroom_ID="+<?php echo $classroom_ID?>,
              type:"POST"

            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });



          $(document).on('submit', '#section_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/section/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Section');
                  $('#section_form')[0].reset();
                  $('#section_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#section_modal_title').text('Add Section');
            $("#section_title").prop("disabled", false);
            $('#section_form')[0].reset();
            $('#section_modal').modal('show');
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('submit_section');
            $('#operation').val("submit_section");
          });

          $(document).on('click', '.view', function(){
            var section_ID = $(this).attr("id");
            $('#section_modal_title').text('View News');
            $('#section_modal').modal('show');
            $("#submit_input").hide();
            
             $.ajax({
                url:"datatable/section/fetch_single.php",
                method:'POST',
                data:{action:"section_view",section_ID:section_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#section_title").prop("disabled", true);

                  $('#section_title').val(data.section_Name);

                  $('#submit_input').hide();
                  $('#section_ID').val(section_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('section_view');
                  $('#operation').val("section_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var section_ID = $(this).attr("id");
            $('#section_modal_title').text('Edit Section');
            $('#section_modal').modal('show');
            $("#submit_input").show();

            
             $.ajax({
                url:"datatable/section/fetch_single.php",
                method:'POST',
                data:{action:"section_view",section_ID:section_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                $("#section_title").prop("disabled", false);

                  $('#section_title').val(data.section_Name);

                  $('#submit_input').show();
                  $('#section_ID').val(section_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('section_update');
                  $('#operation').val("section_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var section_ID = $(this).attr("id");
             $('#delsection_modal').modal('show');
             $('.submit').hide();
             
             $('#section_ID').val(section_ID);
            });

           


          $(document).on('click', '#Section_delform', function(event){
             var section_ID =  $('#section_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/section/insert.php",
             data        :   {operation:"delete_section",section_ID:section_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delsection_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Section');
               dataTable.ajax.reload();
               dataTable_product_data.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>

</html>
