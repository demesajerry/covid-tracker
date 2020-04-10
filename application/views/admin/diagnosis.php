
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Diagnosis
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Diagnosis</li>
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
                <hr />
                <?php echo $this->session->flashdata('message'); ?>
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="10%">Diagnosis ID</th>
                              <th width="40%">Diagnosis</th>
                              <th width="10%">ICD Code</th>
                              <th width="20%">Group</th>
                              <th width="10%">Status</th>
                              <th width="10%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($diagnosis_list != false){
                            foreach($diagnosis_list as $diag){ 
                        ?>
                        <tr>
                            <td><?php echo $diag->diagnosis_id; ?></td>
                            <td><?php echo $diag->diagnosis; ?></td>
                            <td><?php echo $diag->icd_code; ?></td>
                            <td><?php echo $diag->icd_group; ?></td>
                            <td><?php echo ($diag->status=='0')?'ENABLED':'DISABLED'; ?></td>
                            <td>            
                              <a class="edit_modal" href="#"  title="Edit"
                              diagnosis_id="<?php echo $diag->diagnosis_id; ?>" 
                              diagnosis="<?php echo $diag->diagnosis; ?>" 
                              icd_code="<?php echo $diag->icd_code; ?>" 
                              icd_group="<?php echo $diag->icdGroup_id; ?>" 
                              status="<?php echo $diag->status; ?>" 
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
                              <a class="delete_modal" href="#" title="Delete"
                              diagnosis_id="<?php echo $diag->diagnosis_id; ?>" 
                              diagnosis="<?php echo $diag->diagnosis; ?>" 
                              icd_code="<?php echo $diag->icd_code; ?>" 
                              icd_group="<?php echo $diag->icdGroup_id; ?>" 
                              status="<?php echo $diag->status; ?>" 
                              >
                                   <i class="fa fa-remove"></i> 
                               </a> 
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
<!--MODAL-->
<div class="modal fade" id="diagnosis_modal" role="dialog" 
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
              <input type="hidden" name="diagnosis_id" id="diagnosis_id">
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
                      <td>Diagnosis</td>
                      <td><input type="text" name="diagnosis" id="diagnosis" class="form-control uppercase" required="required"/></td>
                  </tr>
                 <tr>
                      <td>ICD Code</td>
                      <td><input type="text" name="icd_code" id="icd_code" class="form-control uppercase" required="required"/></td>
                  </tr>
                 <tr>
                      <td>
                        ICD Group
                        <a href="#" class="addIcdGroup" href="#" title="Add ICD Group" >
                            <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>
                        </a>
                      </td>
                      <td>
                        <select name="icd_group" id="icd_group" class="select2" style="width: 100%">
                          <option value="" selected disabled>SELECT ICD GROUP</option>
                          <?php
                          foreach($icd_group as $group){
                          ?>
                          <option value="<?= $group->id; ?>"><?= $group->icd_group; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </td>
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

<!--MODAL ADD ICD GROUP-->
<div class="modal fade" id="icdGroup_modal" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <button type="button" class="close" 
                 data-dismiss="modal">
                     <span aria-hidden="true">&times;</span>
                     <span class="sr-only">Close</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">
                  ADD ICD GROUP
              </h4>
          </div>
          
          <!-- Modal Body -->
          <div class="modal-body">
              
            <form method="POST" id="icdGroup_form" class="form-horizontal" role="form">
              <input type="hidden" name="table" value="icd_group">
               <table class="table table-bordered table-hover">
                <tr>
                  <td>
                    ICD GROUP
                  </td>
                  <td>
                    <input type="text" name="new_item" id="icdGroup_text" class="form-control uppercase">
                  </td>
                </tr>
              </table>
                <!--SUBMIT BUTTON -->
              <div class="modal-footer" align="right">
                <div class="form-group">
                  <div class="col-sm-12" align="right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                       Close
                    </button>
                    <button type="submit" class="btn btn-success" id="icdGroup_submit">SAVE</button>
                  </div>
                </div>
               </div>
              </form>
          </div><!--end Modal body-->
      </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<script>
var baseurl = "<?php echo base_url();?>"; 
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
      $("#diagnosis_id").val('');
      //set selected value for select2
      $('#status').val('0');
      //trigger change for select2
      $('#status').select2().trigger('status');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_diagnosis';
      $("#modal_title").text('Add Diagnosis');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Save');

      $('#diagnosis_modal').modal('show');
});

  $(".edit_modal").click(function() {
      var diagnosis_id = this.getAttribute("diagnosis_id");
      var diagnosis = this.getAttribute("diagnosis");
      var icd_code = this.getAttribute("icd_code");
      var status = this.getAttribute("status");
      var icd_group = this.getAttribute("icd_group");
      $("#modal_title").text('Edit Diagnosis');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Edit');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_diagnosis';
      //set selected value for select2
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      //set selected value for select2
      $('#icd_group').val(icd_group);
      //trigger change for select2
      $('#icd_group').select2().trigger('icd_group');
      $("#diagnosis_id").val(diagnosis_id);
      $("#diagnosis").val(diagnosis);
      $("#icd_code").val(icd_code);
      $('#diagnosis_modal').modal('show');
  });

  $(".delete_modal").click(function() {
      var diagnosis_id = this.getAttribute("diagnosis_id");
      var diagnosis = this.getAttribute("diagnosis");
      var icd_code = this.getAttribute("icd_code");
      var status = this.getAttribute("status");
      var icd_group = this.getAttribute("icd_group");
      $("#modal_title").text('Delete Diagnosis');
      $("#modal_title").removeClass('alert alert-info');
      $("#modal_title").addClass('alert alert-danger');
      $("#submit_add").removeClass('btn btn-success');
      $("#submit_add").addClass('btn btn-danger');
      $("#submit_add").text('Delete');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/delete_diagnosis';
      //set selected value for select2
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      //set selected value for select2
      $('#icd_group').val(icd_group);
      //trigger change for select2
      $('#icd_group').select2().trigger('icd_group');
      $("#diagnosis_id").val(diagnosis_id);
      $("#diagnosis").val(diagnosis);
      $("#icd_code").val(icd_code);
      $('#diagnosis_modal').modal('show');
  });

  $(".addIcdGroup").click(function() {
    $("#icdGroup_form")[0].reset();
    $('#icdGroup_modal').modal('show');
  });

  $("#icdGroup_submit").click(function(e) {
    e.preventDefault();
   $('input[type=text]').val(function () {
        return this.value.toUpperCase();
      });
      e.preventDefault();
      var new_item = $('#icdGroup_text').val();
      if(new_item){
      $.ajax({
        type: "POST",
        url: baseurl + "general/add",
        data: $("#icdGroup_form").serializeArray(),
        //data:formData,
        success: function(data){ 
          var option;
          if(data.id==0){
              alert(`${data.new_item} is already in the ${data.table} list!`);
          }else{
              option +=`<option selected value='${data.id}'>${data.new_item}</option>`;
              $('#icd_group').append(option);
              $('#icd_group').select2().trigger('icd_group');
              $('#icdGroup_modal').modal('hide');
          }
        }
      });   
      }else{
        alert('ICD Group field cannot be empty!');
      }
    });

    $('#viewresult').DataTable({
    responsive: true,
    select: true,
    dom: 'Blfrtip',
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
    "buttons":[
                {
                  extend: 'print',
                  text: 'Print all',
                  title:"Diagnosis List",
                  messageTop:"",
                  exportOptions:{
                    columns: [ 1,2,3 ],
                    modifier: {
                      selected: null,
                    },
                  }
                },
                {
                  extend: 'print',
                  text: 'Print Selected',
                  title:"Diagnosis List",
                  columns: [ 1,2,3 ],
                  messageTop:"",
                  exportOptions:{
                    columns: [ 1,2,3 ],
                    modifier: {
                      selected: true,
                    },
                  }
                },
              ],
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
