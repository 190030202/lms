
<button type="button" class="btn btn-sm btn-outline-success add" >
            Add Post
          </button>
         <br><br>
        <table class="table table-striped table-sm" id="post_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>














<div class="modal fade" id="post_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_modal_title">Add Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
    
      <form method="post" id="post_form" enctype="multipart/form-data">
            <div class="form-row">
            <div class="form-group col-md-12">
              <label for="post_title">Title<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="post_title" name="post_title" placeholder="" value="" required="">
            </div>
             <div class="form-group col-md-12">
              <textarea class="form-control" id="post_content" name="post_content" placeholder="" value="" required=""></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="post_ID" id="post_ID" />
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <input type="hidden" name="operation" id="operation" />
        <div class="">
        <button type="button" class="btn btn-outline-secondary" id="submit_x" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="submit_section">Submit</button>
        </div>
      </div>
       </form>
       <div id="post_comment">
         <h5>Comment</h5>
          <table class="table table-striped table-sm" id="comment_data">
      
          <tbody>
            
     
          </tbody>
        </table>
          <form method="post" id="comment_form" enctype="multipart/form-data">
            <div class="input-group mb-2 mr-sm-2">
              <input type="text" class="form-control" id="comment_box" placeholder="Type here to comment">
              <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
              <div class="input-group-prepend ">
             <!--    <div class="input-group-text btn-primary" id="send_comment" style="background-color:#007bff !important; color:white!important;">SEND</div> -->
                <input type="submit" class="input-group-text btn-primary" id="send_comment" style="background-color:#007bff !important; color:white!important;"type="" value="SEND">
                
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
       </div>
    </div>
  </div>
</div>


      </div>

<div class="modal fade" id="delpost_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_modal_title">Delete this Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="post_delform">Delete</button>
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
             
            var dataTable = $('#post_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/classroom_stream/fetch.php?class_ID=<?php echo $classroom_ID?>"+"&section_ID="+<?php echo $section_ID?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

            function comment_data(post_ID,section_ID){
                  var comment_dataTable = $('#comment_data').DataTable({
                "processing":true,
                "serverSide":true,
                "bAutoWidth": false,
                "order":[],
                "ajax":{
                  url:"datatable/classroom_comment/fetch.php?post_ID="+post_ID+"&section_ID="+section_ID,
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

            



          $(document).on('submit', '#post_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_stream/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Post');
                  $('#post_form')[0].reset();
                  $('#post_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#post_modal_title').text('Add Post');
            $("#post_title").prop("disabled", false);
            $("#post_content").prop("disabled", false);
            $('#post_form')[0].reset();
            $('#post_modal').modal('show');

            $('#submit_input').show();
            $('#submit_x').show();
            $('#post_comment').hide();

            $('#submit_input').text('Submit');
            $('#submit_input').val('post_submit');
            $('#operation').val("post_submit");
          });

          $(document).on('click', '.view', function(){
            var post_ID = $(this).attr("id");
            $('#post_modal_title').text('View Post');
            $('#post_modal').modal('show');
            $("#submit_input").hide();
            
             $.ajax({
                url:"datatable/classroom_stream/fetch_single.php",
                method:'POST',
                data:{operation:"post_view",post_ID:post_ID},
                dataType    :   'json',
                success:function(data)
                {

                  $("#post_title").prop("disabled", true);
                  $("#post_content").prop("disabled", true);

                  $('#post_title').val(data.post_Name);
                  $('#post_content').val(data.post_Description);


                  $('#submit_input').hide();
                  $('#submit_x').hide();
                  $('#post_comment').show();
                  
                  $('#post_ID').val(post_ID);
                  $('#submit_input').text('View');
                  $('#submit_input').val('post_view');
                  $('#operation').val("post_view");

                  comment_data(post_ID,data.section_ID);
                  $('#comment_data').DataTable().destroy();
                  
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var post_ID = $(this).attr("id");
            $('#post_modal_title').text('Edit Post');
            $('#post_modal').modal('show');
            $("#submit_input").show();
            $('#submit_x').show();
            $('#post_comment').hide();
            
             $.ajax({
                url:"datatable/classroom_stream/fetch_single.php",
                method:'POST',
                data:{operation:"post_edit",post_ID:post_ID},
                dataType    :   'json',
                success:function(data)
                {

                  
                  $("#post_title").prop("disabled", false);
                  $("#post_content").prop("disabled", false);

                  $('#post_title').val(data.post_Name);
                  $('#post_content').val(data.post_Description);

                  $('#submit_input').show();
                  $('#post_ID').val(post_ID);
                  $('#submit_input').text('Update');
                  $('#submit_input').val('post_edit');
                  $('#operation').val("post_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var post_ID = $(this).attr("id");
             $('#delpost_modal').modal('show');
             $('.submit').hide();
             
             $('#post_ID').val(post_ID);
            });

           


          $(document).on('click', '#post_delform', function(event){
             var post_ID =  $('#post_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/classroom_stream/insert.php",
             data        :   {operation:"post_delete",post_ID:post_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delpost_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Delete this Post');
               dataTable.ajax.reload();
                
             }
            })
           
          });

              $(document).on('submit', '#comment_form', function(event){
              // $(document).on('click', '#send_comment', function(){
              event.preventDefault();
              
              var comment_box = $('#comment_box').val();
              var post_ID = $('#post_ID').val();
              var section_ID = $('#section_ID').val();
               $.ajax({
                  url:"datatable/classroom_stream/insert.php",
                  method:'POST',
                  data:{operation:"post_comment",comment:comment_box,post_ID:post_ID,"section_ID":section_ID},
                  dataType    :   'json',
                  complete     :   function(data) {
                  comment_data(post_ID,section_ID);
                  $('#comment_data').DataTable().destroy();
                  }
                });
                
               
              });



          
          } );


        </script>
        </body>