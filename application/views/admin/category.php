
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Category
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Categories</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">LIST</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add" >
                                <i  class="fa fa-plus fa-1x"> </i> Add
                            </button>
                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="category_modal" role="dialog" 
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button type="button" class="close" 
                                       data-dismiss="modal">
                                           <span aria-hidden="true">&times;</span>
                                           <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        <p id="modal_title"></p>
                                    </h4>
                                </div>
                                
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    
                                  <form method="POST" id="form1" class="form-horizontal" role="form">
                                    <input type="hidden" name="cat_id" id="cat_id">
                                     <table class="table table-bordered table-hover">
                                      <tr>
                                        <td>
                                          Status
                                        </td>
                                        <td>
                                          <select name="status" class="form-control select2" id="status" style="width: 100%">
                                            <option value="0">ENABLED</option>
                                            <option value="1">DISABLED</option>
                                          </select>
                                        </td>
                                      </tr>
                                       <tr>
                                            <td>Category</td>
                                            <td><input type="text" name="category" id="category" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                    </table>
                                      <!--SUBMIT BUTTON -->
                                    <div class="modal-footer" align="right">
                                      <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">
                                             Close
                                          </button>
                                          <button type="submit" class="btn btn-success btnSubmit" id="submit_add">SAVE</button>
                                        </div>
                                      </div>
                                     </div>
                                    </form>
                                </div><!--end Modal body-->
                            </div><!--end Modal content-->
                        </div><!--end Modal dialog-->
                    </div><!--end modal receive-->
                <hr />
                <?php echo $this->session->flashdata('message'); ?>
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="20%">Category ID</th>
                              <th width="40%">Category</th>
                              <th width="20%">Status</th>
                              <th width="20%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($category_list != false){
                            foreach($category_list as $cat){ 
                        ?>
                        <tr>
                            <td><?php echo $cat->cat_id; ?></td>
                            <td><?php echo $cat->category; ?></td>
                            <td><?php echo ($cat->status=='0')?'ENABLED':'DISABLED'; ?></td>
                            <td>            
                              <a class="edit_modal" href="#" 
                              cat_id="<?php echo $cat->cat_id; ?>" 
                              category="<?php echo $cat->category; ?>" 
                              status="<?php echo $cat->status; ?>" 
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
                            </td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
$(document).ready(function() {
  $("#submit_add").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#form1").submit();
  });

  $("#submit_edit").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#edit_form").submit();
  });

    $("#add").click(function() {
      $('#form1')[0].reset();
      $("#cat_id").val('');
      //set selected value for select2
      $('#status').val('0');
      //trigger change for select2
      $('#status').select2().trigger('status');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_category';
      $("#modal_title").text('Add Category');

      $('#category_modal').modal('show');
});

  $(".edit_modal").click(function() {
      var cat_id = this.getAttribute("cat_id");
      var category = this.getAttribute("category");
      var status = this.getAttribute("status");
      $("#modal_title").text('Edit Category');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_category';
      //set selected value for select2
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      $("#cat_id").val(cat_id);
      $("#category").val(category);
      $('#category_modal').modal('show');
  });

    $('#viewresult').DataTable({
            responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10
    });


    $( "#datepicker" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
    $( "#birthday" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
  
});

</script>



<script>
const captureVideoButton =
  document.querySelector('#screenshot .capture-button');
const screenshotButton = document.querySelector('#screenshot-button');
const img = document.querySelector('#screenshot img');
const video = document.querySelector('#screenshot video');

const canvas = document.createElement('canvas');

captureVideoButton.onclick = function() {
  navigator.mediaDevices.getUserMedia(constraints).
    then(handleSuccess).catch(handleError);
};

screenshotButton.onclick = video.onclick = function() {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  // Other browsers will fall back to image/png
  img.src = canvas.toDataURL('image/webp');
};

function handleSuccess(stream) {
  screenshotButton.disabled = false;
  video.srcObject = stream;
}
</script>