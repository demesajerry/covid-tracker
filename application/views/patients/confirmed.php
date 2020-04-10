<!--<script src="<?php echo base_url(); ?>assets/js/confetti/confetti.js"></script>-->
<?php $classification = '0'; ?>
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
  background-color: red !important;
}
input:invalid {
  background-color: #ffdddd;
}
input:required {
  border-color: red;
  border-width: 2px;
}
select:invalid {
  background-color: #ffdddd !important;
}
select:required {
  border-color: red !important;
  border-width: 2px !important;
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
                    <h3 class="box-title">Confirmed Cases</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add_patients" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Confirmed Case
                            </button>
                        </div>
                    </div>
                <hr />
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="5%">Patient ID</th>
                              <th width="35%">Name</th>
                              <th width="15%">Brgy</th>
                              <th width="15%">Status</th>
                              <th width="15%">Current Location</th>
                              <th width="10%">Age</th>
                              <th width="10%">Transmission</th>
                              <th width="5%">Action</th>
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
                          <td>Patient Name:</td>
                          <td><input type="text" name="name" id="name" class="form-control"></td>
                        </tr>
                        <tr>
                          <td>Patient Age:</td>
                          <td>
                            <div class="col-sm-6">
                              <input type="text" name="age" id="age" class="form-control">
                            </div>
                            <div class="col-sm-6">
                              <select name="age_type" id="age_type" class="form-control">
                                <option value="Year/s Old"> Year/s Old</option>
                                <option value="Month/s Old"> Month/s Old</option>
                              </select>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Gender</td>
                          <td>
                            <select name="gender" id="gender" class="select2 form-control" style="width: 100%">
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Barangay</td>
                          <td class="red">
                            <select name="brgy" class="select2" id="brgy" style="width: 100%"  required="required">
                              <option value="" selected disabled>Select Brgy</option>
                                <option value="Anos">Anos</option>
                                <option value="Bagong Silang">Bagong Silang</option>
                                <option value="Bambang">Bambang</option>
                                <option value="Batong Malake">Batong Malake</option>
                                <option value="Baybayin">Baybayin</option>
                                <option value="Bayog">Bayog</option>
                                <option value="Lalakay">Lalakay</option>
                                <option value="Maahas">Maahas</option>
                                <option value="Malinta">Malinta</option>
                                <option value="Mayondon">Mayondon</option>
                                <option value="Tuntungin-Putho">Tuntungin-Putho</option>
                                <option value="San Antonio">San Antonio</option>
                                <option value="Tadlac">Tadlac</option>
                                <option value="Timugan">Timugan</option>                              
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Travel History</td>
                          <td>
                            <textarea class="form-control" name="travel_history" id="travel_history"></textarea>
                          </td>
                        </tr>
                         <tr>
                          <td>Status</td>
                          <td>
                            <select name="status" id="status" class="select2 form-control" style="width: 100%" required="required">
                              <option value="QUARANTINED">QUARANTINED</option>
                              <option value="ADMITTED">ADMITTED</option>
                              <option value="RECOVERED">RECOVERED</option>
                              <option value="DECEASED">DECEASED</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Current Location</td>
                          <td>
                            <select name="current_location" id="current_location" class="select2 form-control" style="width: 100%" required="required">
                              <option value="N/A">N/A</option>
                              <option value="HOME">HOME</option>
                              <option value="HOSPITAL IN LOS BAÑOS">HOSPITAL IN LOS BAÑOS</option>
                              <option value="HOSPITAL OUTSIDE LOS BAÑOS">HOSPITAL OUTSIDE LOS BAÑOS</option>
                              <option value="QUARANTINE FACILITY">QUARANTINE FACILITY</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Symptoms</td>
                          <td>
                            <select name="symptoms[]" id="symptoms" class="select2 form-control" style="width: 100%" multiple="multiple">
                              <option value="ASYMPTOMATIC">ASYMPTOMATIC</option>
                              <option value="FEVER">FEVER</option>
                              <option value="COUGH">COUGH</option>
                              <option value="DIFFICULTY BREATHING">DIFFICULTY BREATHING</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Symptoms Started</td>
                          <td><input type="text" name="symptoms_started" id="symptoms_started" class="form-control date"> </td>
                        </tr>
                        <tr>
                          <td>Quarantine Start Date</td>
                          <td><input type="text" name="qdate" id="qdate" class="form-control date"> </td>
                        </tr>
                        <tr>
                          <td>Confirmation Date</td>
                          <td><input type="text" name="result_date" id="result_date" class="form-control date" required="required"> </td>
                        </tr>
                        <tr id="recoveryTr" class="hideTr">
                          <td>Recovery Date</td>
                          <td><input type="text" name="date_recovered" id="date_recovered" class="form-control date"> </td>
                        </tr>
                        <tr id="diedTr" class="hideTr">
                          <td>Date Died</td>
                          <td><input type="text" name="date_died" id="date_died" class="form-control date"> </td>
                        </tr>
                        <tr>
                          <td>Current Condition</td>
                          <td>
                            <select name="current_condition" id="current_condition" class="select2 form-control" style="width: 100%">
                              <option value="">N/A</option>
                              <option value="STABLE">STABLE</option>
                              <option value="MONITORED">MONITORED</option>
                              <option value="CRITICAL">CRITICAL</option>
                              <option value="RECOVERING">RECOVERING</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Transmission Type</td>
                          <td>
                            <select name="transmission" id="transmission" class="select2 form-control" style="width: 100%">
                              <option value="">N/A</option>
                              <option value="UNKNOWN">UNKNOWN</option>
                              <option value="LOCAL">LOCAL</option>
                              <option value="OUTSIDE LOS BAÑOS">OUTSIDE LOS BAÑOS</option>
                              <option value="IMPORTED">IMPORTED</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Possible Link</td>
                          <td>
                            <select class="select2" name="possible_link" id="possible_link" style="width: 100%">
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
                          <button type="button" class="btn btn-success" id="submit_add">Save</button>
                        </div>
                      </div>
                     </div>
                    </form>
                </div><!--end Modal body-->
            </div><!--end Modal content-->
        </div><!--end Modal dialog-->
    </div><!--end modal receive-->
<!--MODAL-->
    <div class="modal fade" id="test_results_modal" role="dialog" 
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
                        <p id="test_title"></p>
                    </h4>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body">   
                 <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td>Test Date</td>
                      <td>Result Date</td>
                      <td width="35%">Result</td>
                      <td width="5%">Action</td>
                    </tr>
                    <form id="form-add_test">
                      <input type="hidden" name="p_id" id="p_id">
                      <tr>
                        <td><input type="text" name="test_date" class="form-control date" required="required"></td>
                        <td><input type="text" name="result_date"  class="form-control date"></td>
                        <td>
                          <select name="result" id="result" class="form-control">
                            <option value="" selected disabled>Select Result</option>
                            <option value="0">NEGATIVE</option>
                            <option value="1">POSITIVE</option>
                          </select>
                        </td>
                        <td>
                          <button type="button" class="btn btn-light" id="save_test" title="Save Test"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </form>
                  </thead>
                  <tbody id="test_tbody">
                  </tbody>
                 </table>
                      <!--SUBMIT BUTTON -->
                    <div class="modal-footer" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" align="right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">
                             Close
                          </button>
                        </div>
                      </div>
                     </div>
                    </form>
                </div><!--end Modal body-->
            </div><!--end Modal content-->
        </div><!--end Modal dialog-->
    </div><!--end modal receive-->
<!--MODAL-->
    <div class="modal fade" id="confirm_modal" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                </div>              
                <!-- Modal Body -->
                <div class="modal-body">
                  <div id="modal_message"></div>   
                      <!--SUBMIT BUTTON -->
                    <div class="modal-footer" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" align="right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">
                             Close
                          </button>
                          <button type="button" class="btn btn-success" data-dismiss="modal" id="confirm_btn">
                             Save
                          </button>
                        </div>
                      </div>
                     </div>
                    </form>
                </div><!--end Modal body-->
            </div><!--end Modal content-->
        </div><!--end Modal dialog-->
    </div><!--end modal receive-->

<!--MODAL-->
    <div class="modal fade" id="confirm_modal2" role="dialog" 
         aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                </div>              
                <!-- Modal Body -->
                <div class="modal-body">
                  <div id="modal_message2"></div>   
                      <!--SUBMIT BUTTON -->
                    <div class="modal-footer" align="right">
                      <div class="form-group">
                        <div class="col-sm-12" align="right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">
                             Close
                          </button>
                          <button type="button" class="btn btn-success" data-dismiss="modal" id="confirm_btn2">
                             Save
                          </button>
                        </div>
                      </div>
                     </div>
                    </form>
                </div><!--end Modal body-->
            </div><!--end Modal content-->
        </div><!--end Modal dialog-->
    </div><!--end modal receive-->

<!--OPEN QUEUE MODAL IF FLASH DATA IS SET-->
<?php 
  if($this->session->flashdata('message')){
  ?>
  <script>
    $(document).ready(function() {
      $('#queue_modal').modal('show');
      $('#div_number').fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500);
    });
  </script>
<?php } ?>
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
  function get_required(val){
    var status = val;
    if(status == 'DECEASED'){
      $('#current_condition').val('');
      $('#current_condition').select2().trigger('current_condition');
      $('#date_died').prop('required',true);
      $('#diedTr').show();
    }else{
      $('#date_died').prop('required',false);
      $('#date_died').val('');
      $('#diedTr').hide();
    }
    if(status == 'RECOVERED'){
      $('#current_condition').val('');
      $('#current_condition').select2().trigger('current_condition');
      $('#date_recovered').prop('required',true);
      $('#recoveryTr').show();
    }else{
      $('#date_recovered').prop('required',false);
      $('#date_recovered').val('');
      $('#recoveryTr').hide();
    }
  }

  function edit_test(test_id,p_id,test_date,result_date,result){
    $.ajax({
    type: "POST",
    url: "<?php echo base_url()."patients/add_testResults"; ?>",
    data: {test_id:test_id,p_id:p_id,test_date:test_date,result_date:result_date,result:result},
    //data:formData,
    success: function(data){ 
      $("#form-add_test")[0].reset();
      generate_testTr(data);
      }
    });
  }
  function save_test(data){
    $.ajax({
    type: "POST",
    url: "<?php echo base_url()."patients/add_testResults"; ?>",
    data: data,
    //data:formData,
    success: function(data){ 
      $("#form-add_test")[0].reset();
      generate_testTr(data);
      }
    });
  }

  function generate_testTr(data){
    var tr='',result_date;
      $.each(data, function( key, val ) {
    var neg='',pos='',empt='';
        if(val.result_date=='0000-00-00'){
          result_date = '';
        }else{
          result_date = val.result_date;
        }

        if(val.result == '0'){
          neg = 'selected';
        }
        if(val.result == '1'){
          pos = 'selected';
        }
        if(val.result == null){
          empt = 'selected';
        }
        tr+=`<form id='form-edit_test${val.test_id}'>
            <tr class='editTr'>
            <input type='hidden' name='test_id' class='test_id' value='${val.test_id}'>
            <input type='hidden' name='p_id' class='p_id' value='${val.p_id}'>
              <td>
                <input type='text' class='form-control date2 test_date' name='test_date' value='${val.test_date}' required='required'>
              </td>
              <td>
                <input type='text' class='form-control date2 result_date' name='result_date' value='${result_date}'>
              </td>
              <td>
                <select class='form-control result' name='result'>
                  <option value='' ${empt}>Select Result</option>
                  <option value='0' ${neg}>NEGATIVE</option>
                  <option value='1' ${pos}>POSITIVE</option>
                </select>
              </td>
              <td>
                <button type="button" class="btn btn-light edit_test" title="Edit Test"><i class="fa fa-save"></i></button>
              </td>
            </tr>
            </form>`
      });
      $('#test_tbody').html(tr);
    }

  $("#status").change(function(){
    get_required($(this).val());
  })

  $("#add_patients").click(function() {
    disableBtn();
    $('#form1')[0].reset();
    $("#modal_title").text('Add Patient');
    $('#form1 select').select2("").trigger('change');
    $('#action').val("add");
      $("#results").html('<img src="<?php echo base_url(); ?>assets/images/add_image.png?<?php echo time(); ?>" class="user-image" width="190px" height="190pxss">');
    $('#add_patients_modal').modal('show');
    patients_list('0');
  });

$('#viewresult').on('click', '.test_results', function () {
  var id = this.getAttribute("id");
  $('#p_id').val(id);
  $.ajax({
  type: "POST",
  url: "<?php echo base_url()."patients/get_testResults"; ?>",
  data: {id:id},
  success: function(data){ 
      id = id<10?'0'+id:id;
      generate_testTr(data);
      $("#test_title").text('Test Results of Patient LB-'+id);
      $('#test_results_modal').modal('show');
    }
  });
});

$('#viewresult').on('click', '.edit_modal', function () {
    $('#form1')[0].reset();
      disableBtn();
      var id = this.getAttribute("id");
      var name = this.getAttribute("name");
      var age = this.getAttribute("age");
      var age_type = this.getAttribute("age_type");
      var gender = this.getAttribute("gender");
      var brgy = this.getAttribute("brgy");
      var travel_history = this.getAttribute("travel_history");
      var status = this.getAttribute("status");
      var current_location = this.getAttribute("current_location");
      var symptoms = this.getAttribute("symptoms");
      var symptoms_started = this.getAttribute("symptoms_started");
      var qdate = this.getAttribute("qdate");
      var result_date = this.getAttribute("result_date");
      var date_recovered = this.getAttribute("date_recovered");
      var date_died = this.getAttribute("date_died");
      var current_condition = this.getAttribute("current_condition");
      var transmission = this.getAttribute("transmission");
      var possible_link = this.getAttribute("possible_link");
      var symptomsarray = symptoms.split(',');

      get_required(status);
      patients_list(possible_link);

      //get_brgy(citymunCode,brgyCode);
      $("#action").val('edit');
      $("#id").val(id);
      $("#name").val(name);
      $("#age").val(age);
      $("#travel_history").val(travel_history);
      $("#symptoms_started").val(symptoms_started);
      $("#qdate").val(qdate);
      $("#result_date").val(result_date);
      $("#date_recovered").val(date_recovered);
      $("#date_died").val(date_died);

      $('#age_type').val(age_type);
      $('#age_type').select2().trigger('age_type');
      $('#gender').val(gender);
      $('#gender').select2().trigger('gender');
      $('#brgy').val(brgy);
      $('#brgy').select2().trigger('brgy');
      $('#status').val(status);
      $('#status').select2().trigger('status');
      $('#current_location').val(current_location);
      $('#current_location').select2().trigger('current_location');
      $('#symptoms').val(symptomsarray).trigger('change');
      $("select option[value='"+symptoms+"']").attr("selected","selected");
      $('#current_condition').val(current_condition);
      $('#current_condition').select2().trigger('current_condition');
      $('#transmission').val(transmission);
      $('#transmission').select2().trigger('transmission');

      $("#modal_title").text('Edit Patient Details');
      $('#add_patients_modal').modal('show');
  });

$('#save_test').click(function(e){
  e.preventDefault();
  if ($("#form-add_test")[0].checkValidity()) {
    test_data = $("#form-add_test").serializeArray(); // convert form to array
    $('#modal_message').html('<h3>Confirm Add Test</h3>');
    $('#confirm_modal').modal('show');
  }else{
    alert('Test Date Cannot be Empty!');
  }
});

$('#test_results_modal').on('click','.edit_test',function(e){
  e.preventDefault();
  test_id = $(this).closest('.editTr').find('.test_id').val();
  p_id = $(this).closest('.editTr').find('.p_id').val();
  test_date = $(this).closest('.editTr').find('.test_date').val();
  result_date = $(this).closest('.editTr').find('.result_date').val();
  result = $(this).closest('.editTr').find('.result').val();
  if (test_date=='' || test_date=='0000-00-00') {
    alert('Test Date Cannot be Empty!');
  }else{
    $('#modal_message2').html('<h3>Confirm Update Test</h3>');
    $('#confirm_modal2').modal('show');
  }
});

$('#confirm_btn').click(function(e){
  disableBtn();
  e.preventDefault();
  save_test(test_data);
  $('#confirm_modal').modal('hide');
})

$('#confirm_btn2').click(function(e){
  disableBtn();
  e.preventDefault();
  edit_test(test_id,p_id,test_date,result_date,result);
  $('#confirm_modal2').modal('hide');
})

$('#submit_add').click(function(e){
  disableBtn();
  $('.messageBox').remove();
  e.preventDefault();
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
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
        { "data": "name" },
        { "data": "brgy" },
        { "data": "status" },
        { "data": "current_location" },
        { "data": "age" },
        { "data": "transmission" },
        { "data": "action" },
     ]   

});  
});
</script>


