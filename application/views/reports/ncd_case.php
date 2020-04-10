<style>
  .ui-datepicker-calendar {
        display: none;
    }
    .box-tools{
        width: 900px;
        padding: 0;
    }
    .filters{
        padding: 0;
    }
    hr {
      margin-top: 5px;
      margin-bottom: 5px;
      border-top: 1px solid #000;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Report
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Morbidity</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_ncdCase" id="form1" method="post" target="_blank" >
                            <div  class="col-xs-3">
                            </div>
                            <div class="col-xs-1">
                            </div>
                                <div class="col-xs-4">
                                <select name="selected_diagnosis" id="selected_diagnosis" class="select2 getdata">
                                  <option value="" selected disabled> SELECT DIAGNOSIS </option>
                                  <option value="ALL"> ALL </option>
                                  <option value="1"> DIABETES </option>
                                  <option value="2"> hypertension </option>
                                  <option value="1&2"> Hypertension With Diabetes </option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                              <select name="station_id" id="station_id" class="select2 form-control getdata" style="width:100%;">
                                <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                                    <option selected disabled>Select Health Station</option>
                                    <option value="">ALL</option>
                                  <?php foreach($health_station as $station){ ?>
                                      <option value="<?= $station->station_id; ?>"><?= $station->brgy; ?></option>
                                  <?php } ?>
                                  <?php }else{ ?>
                                      <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col-xs-2">
                            <input type="text" class="form-control getdata" name="date" id="date" required="required" placeholder="Select Month">
                            </div>
                          </form>
                       </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">NEW NCD CASE REPORT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="25%">Name</th>
                            <th width="5%">Sex</th>
                            <th width="5%">Age</th>
                            <th width="10%">Birthday</th>
                            <th width="10%">Address</th>
                            <th width="10%">Philhealth</th>
                            <th width="15%">Hypertension</th>
                            <th width="15%">Diabetes</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                  </table>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
function getdata(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url().'reports/get_ncdCase'; ?>",
      data: $("#form1").serializeArray(),
      beforeSend: function() {
        tr = `<tr id="loader">
                    <th colspan="41">
                      <div class="callout callout-info"><p><i class="fa fa-circle-o-notch fa-spin"></i> Loading Data...</p></div>
                    </th>
                </tr>`;
        $('#tbody').html(tr);
      },
      complete: function(){
        $('#loader').hide();
      },
      //data:formData,
        success: function(data){ 
          var diagnosis,date;
            table.clear();
            var tr ='';
                $.each(data.ncd_list, function(key, val){
                  if(val.diabetes!=null && val.hypertension==null){
                    diagnosis = "<li>DIABETES</li>";
                    date = val.diabetes;
                  }else if(val.diabetes==null && val.hypertension!=null){
                    diagnosis = "<li>HYPERTENSION</li>";
                    date = val.hypertension
                  }else if(val.diabetes!=null && val.hypertension!=null){
                    diagnosis = `<li>DIABETES</li>
                                  <hr>
                                <li>HYPERTENSION</li>`;
                    date = `${val.diabetes}
                            <hr>
                            ${val.hypertension}`;
                  }
                dob = new Date(val.birthday);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                
                var birthday = convert_date(val.birthday);
                var hypertension = (val.hypertension!=null)?convert_date(val.hypertension)+' - <hr>'+val.station_h:'';
                var diabetes = (val.diabetes!=null)?convert_date(val.diabetes)+' - <hr>'+val.station_d:'';
                console.log(val.station_h);
                    table.row.add([ key+1,
                                val.fullname,
                                val.gender,
                                age,
                                birthday,
                                val.brgy,
                                val.philhealth_no,
                                hypertension,
                                diabetes
                               ]).draw( false );
            })

        }
    });
}

$('.getdata').change(function(){
    getdata();
})

    $( "#date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        getdata();
      },
    });
    var table = $('#viewresult').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 5,
      "aaSorting": [],
      buttons: [
            {
                text: 'Print',
                action: function ( e, dt, node, config ) {
                  $('#form1').submit();    
                }
            },
            {
              extend: 'excel',
              text: 'Excel',
              title:"New NCD CASE",
              orientation:'landscape',
              exportOptions:{
                modifier: {
                  selected: null
                },
              }
            },
        ]
    });

  });
</script>