
           <?php 
              if($auth_user->student_level()) 
              {
              }
               else{
                ?><button type="button" class="btn btn-sm btn-outline-success add" >
            Add 
          </button><?php
               }
              ?>
         <br><br>
        <table class="table table-striped table-sm" id="studentlist_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Student ID</th>
              <th width="50%">Name</th>
              <th width="10%">Sex</th>
              <?php 
              if($auth_user->student_level()) 
              {
              }
               else{
                ?> <th>Action</th><?php
               }
              ?>
             
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>









<div class="modal fade" id="studentlist_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_modal_title">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
      <button type="button" class="btn btn-sm float-right btn-outline-success " data-toggle="modal" data-target="#browse_student">
            Browse Student 
        </button>
        <br><br>
      <form method="post" id="studentlist_form" enctype="multipart/form-data">
            <div class="form-row">
            <div class="form-group col-md-12">
              <label for="studentlist_name">Name<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="studentlist_name" name="studentlist_name" placeholder="" value="" required="">
            </div>
          
      </div>
    </div>
      <div class="modal-footer">
        <input type="hidden" name="rsd_ID" id="rsd_ID" />
        <input type="hidden" name="crs_ID" id="crs_ID" />
        <input type="hidden" name="class_ID" id="class_ID" value="<?php echo $classroom_ID?>"/>
        <input type="hidden" name="section_ID" id="section_ID" value="<?php echo $section_ID?>"/>
        <input type="hidden" name="operation" id="operation" />
        <div class="">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary submit" id="submit_input" value="studentlist_submit">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
</div>

<div class="modal fade" id="browse_student" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="post_modal_title">Student List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product_modal_content">
       <table class="table table-striped table-sm" id="student_data">
            <thead>
              <tr>
                <th>#</th>
                <th>Student ID</th>
                <th >Name</th>
                <th>Sex</th>
              </tr>
            </thead>
          </table>
      </div>
      <div class="modal-footer">
        <div class="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>








<div class="modal fade" id="delstudentlist_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentlist_modal_title">Delete this Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <div class="btn-group">
        <button type="submit" class="btn btn-danger" id="studentlist_delform">Delete</button>
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
             
            var dataTable = $('#studentlist_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "searching": true,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "ajax":{
              url:"datatable/classroom_student/fetch.php?classroom_ID="+<?php echo $classroom_ID?>+"&section_ID="+<?php echo $section_ID?>,
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

          var student_dataTable = $('#student_data').DataTable({
            "processing":true,
            "serverSide":true,
            "bAutoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/student/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

            //JQUERY FOR SELECTING  TEACHER FOR ROOM  WHEN BROWSING
  //----------------------------------------------------------------
    var stud_Rec = '#student_data tbody';

    $(stud_Rec).on('click', 'tr', function(){
      
      var cursor = student_dataTable.row($(this));//get the clicked row
      var data=cursor.data();// this will give you the data in the current row.
       if(confirm("Are you sure you want to use ("+data[2]+") for this classroom?"))
        {

          $('#studentlist_form').find("input[name='rsd_ID'][type='hidden']").val(data[0]);
          $('#studentlist_form').find("input[name='studentlist_name'][type='text']").val(data[2]);

          jQuery('#rsd_ID').val(data[0]) ;

        }
          else
        {
          return false; 
        }
      $('#browse_student').modal('hide');
      
    });




          $(document).on('submit', '#studentlist_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/classroom_student/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('Student');
                  $('#studentlist_form')[0].reset();
                  $('#studentlist_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#studentlist_modal_title').text('Add Student');
            $("#studentlist_name").prop("disabled", true);
            $('#studentlist_form')[0].reset();
            $('#studentlist_modal').modal('show');
            $('#submit_input').show();
            $('#submit_input').text('Submit');
            $('#submit_input').val('studentlist_submit');
            $('#operation').val("studentlist_submit");
          });

  
  
            $(document).on('click', '.delete', function(){
            var crs_ID = $(this).attr("id");
             $('#delstudentlist_modal').modal('show');
             $('.submit').hide();
             
             $('#crs_ID').val(crs_ID);
            });

            $(document).on('click', '.student_approve', function(){
            var crs_ID = $(this).attr("id");
          
        
              alertify.confirm('Are you sure you want to approve this student?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_student/insert.php",
                 data        :   {operation:"student_approve",crs_ID:crs_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Classroom Student');
                   dataTable.ajax.reload();
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Classroom Student');

            });

              $(document).on('click', '.student_disable', function(){
            var crs_ID = $(this).attr("id");
            
              alertify.confirm('Are you sure you want to disable this student?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_student/insert.php",
                 data        :   {operation:"student_disable",crs_ID:crs_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Classroom Student');
                   dataTable.ajax.reload();
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Classroom Student');

            });

            $(document).on('click', '.student_enable', function(){
            var crs_ID = $(this).attr("id");
          
             alertify.confirm('Are you sure you want to enable this student?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/classroom_student/insert.php",
                 data        :   {operation:"student_enable",crs_ID:crs_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Classroom Student');
                   dataTable.ajax.reload();
                    
                 }
                })

                
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Classroom Student');
              
            });
            
            

           


          $(document).on('click', '#studentlist_delform', function(event){
             var crs_ID =  $('#crs_ID').val();
            $.ajax({
             type        :   'POST',
             url:"datatable/classroom_student/insert.php",
             data        :   {operation:"studentlist_delete",crs_ID:crs_ID},
             dataType    :   'json',
             complete     :   function(data) {
               $('#delstudentlist_modal').modal('hide');
               alertify.alert(data.responseText).setHeader('Remove this Student');
               dataTable.ajax.reload();
                
             }
            })
           
          });
          
          } );


        </script>
        </body>