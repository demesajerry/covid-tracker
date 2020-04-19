<!--<script src="<?php echo base_url(); ?>assets/js/confetti/confetti.js"></script>-->
<?php $classification = '4'; ?>
<style>
.alert {
   width:40%;    
}
#number{
  font-size: 72pt;
  font-weight: bold;
  color: red;
}
.table-left{
  text-align: left;
}
.red{
  color: red;
}
input:invalid {
  background-color: #ffdddd;
}
input:required {
  border-color: red;
  border-width: 2px;
}
.test_results{
  display: none;
}
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Patients
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Patients</a></li>
        </ol>
    </section>

    <section class="content">
      <div class="box-body table-responsive">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Other Possible Links</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add_patients" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Other Case
                            </button>
                        </div>
                    </div>
                <hr />
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="90%">Possible Link Code</th>
                              <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--MODAL-->
    <div class="modal fade" id="add_patients_modal" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                    
                  <form method="POST" id="form1" class="form-horizontal" role="form" action="">
                    <input type="hidden" name="" id="action">
                     <input type="hidden" name="id" id="id">
                     <input type="hidden" name="classification" id="classification" value="<?= $classification ?>">
                     <table class="table table-bordered table-hover">
                        <tr>
                          <td>Link Code:</td>
                          <td><input type="text" name="patient_id" id="patient_id" class="form-control"></td>
                        </tr>
                       </table>
                      <!--SUBMIT BUTTON -->
                    <div class="modal-footer" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" align="right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">
                             Close
                          </button>
                          <button type="button" class="btn btn-success" id="submit_add">Save</button>
                        </div>
                      </div>
                     </div>
                    </form>
                </div><!--end Modal body-->
            </div><!--end Modal content-->
        </div><!--end Modal dialog-->
    </div><!--end modal receive-->

<script>
//confetti.start();
//setTimeout(function() { confetti.stop(); }, 5000);
function disableBtn(){
  $(':button').prop('disabled', true); 
  setTimeout(function(){
  $(':button').prop('disabled', false); 
  }, 1500);

}
var baseurl = "<?php echo base_url();?>"; 
var classification = "<?php echo $classification;?>"; 


$(document).ready(function() {
  //global variable
  var test_data,test_id,p_id,test_date,result_date,result;
  $('.hideTr').hide();


  $("#add_patients").click(function() {
    disableBtn();
    $('#form1')[0].reset();
    $("#modal_title").text('Add Possible Link');
    $('#action').val("add");
    $('#add_patients_modal').modal('show');
  });


$('#viewresult').on('click', '.edit_modal', function () {
    $('#form1')[0].reset();
      disableBtn();
      var id = this.getAttribute("id");
      var patient_id = this.getAttribute("patient_id");

      //get_brgy(citymunCode,brgyCode);
      $("#action").val('edit');
      $("#id").val(id);
      $("#patient_id").val(patient_id);

      $("#modal_title").text('Edit Other Possible Links');
      $('#add_patients_modal').modal('show');
  });

$('#submit_add').click(function(e){
  disableBtn();
  $('.messageBox').remove();
  e.preventDefault();
  /*
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    */
    if ($("#form1")[0].checkValidity()) {
      var action = $('#action').val(), link;
      link = action=='add'?'<?php echo base_url()."patients/add_patients"; ?>':'<?php echo base_url()."patients/edit_patients"; ?>';
      var data = $("#form1").serializeArray(); // convert form to array
      $.ajax({
      type: "POST",
      url: link,
      data: $.param(data),
      //data:formData,
      success: function(data){ 
          $(`<div class='alert alert-info messageBox'>${data.name} has been ${action}ed.</div>`).insertBefore( "#viewresult" );
          $('#add_patients_modal').modal('hide');
          table.ajax.url("<?php echo base_url('patients/get_patients').'?classification=' ?>"+classification).load();
        }
      });
    }else{
      alert("PLEASE FILL OUT ALL REQUIRED DETAILS");
    }
  });  
  
var table = $('#viewresult').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [
          [0, "ASC" ]
        ],
      "ajax":{
   "url": "<?php echo base_url('patients/get_patients').'?classification=' ?>"+classification,
   "dataType": "json",
   "type": "POST",
   "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                 },
"columns": [
        { "data": "patient_id" },
        { "data": "action" },
     ]   

});  
});
</script>


