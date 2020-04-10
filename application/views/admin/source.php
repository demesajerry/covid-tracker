
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Source
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Source</li>
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
                    <div class="modal fade" id="source_modal" role="dialog" 
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
                                    <input type="hidden" name="source_id" id="source_id">
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
                                            <td>Source</td>
                                            <td><input type="text" name="source" id="source" class="form-control uppercase" required="required"/></td>
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
                              <th width="20%">Source ID</th>
                              <th width="40%">Source</th>
                              <th width="20%">Status</th>
                              <th width="20%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($source_list != false){
                            foreach($source_list as $source){ 
                        ?>
                        <tr>
                            <td><?php echo $source->source_id; ?></td>
                            <td><?php echo $source->source; ?></td>
                            <td><?php echo ($source->status=='0')?'ENABLED':'DISABLED'; ?></td>
                            <td>            
                              <a class="edit_modal" href="#" 
                              source_id="<?php echo $source->source_id; ?>" 
                              source="<?php echo $source->source; ?>" 
                              status="<?php echo $source->status; ?>" 
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
      $("#source_id").val('');
      //set selected value for select2
      $('#status').val('0');
      //trigger change for select2
      $('#status').select2().trigger('status');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_source';
      $("#modal_title").text('Add Source');

      $('#source_modal').modal('show');
});

  $(".edit_modal").click(function() {
      var source_id = this.getAttribute("source_id");
      var source = this.getAttribute("source");
      var status = this.getAttribute("status");
      $("#modal_title").text('Edit Category');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_source';
      //set selected value for select2
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      $("#source_id").val(source_id);
      $("#source").val(source);
      $('#source_modal').modal('show');
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

