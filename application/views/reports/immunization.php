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
    .txt-bottom{
        vertical-align:bottom !important;
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
        <li class="active">IMMUNIZATION</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_immunization" id="form1" method="post" target="_blank" >
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-1">
                            <label>NAME OF ANTIGEN:</label>
                        </div>
                            <div class="col-xs-4">
                                <select name="selected_antigen[]" id="selected_antigen" class="select2" multiple="multiple">
                                    <?php foreach ($vaccine as $key => $value) {
                                    ?>
                                            <option value="<?= $value->vac_id ?>" ><?= $value->vaccine ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="col-xs-2">
                            <select name="poi" class="select2">
                              <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                                  <option selected disabled>PLACE OF CONSULTATION</option>
                                  <option value="ALL">ALL</option>
                                  <?php foreach ($health_station as $key => $value) {
                                  ?>
                                          <option value="<?= $value->station_id ?>" ><?= $value->brgy ?></option>
                                  <?php
                                  } ?>
                              <?php }else{ ?>
                                  <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                              <?php } ?>
                            </select>
                            </div>
                            <div class="col-xs-2">
                            <input type="text" class="form-control" name="date" id="date" required="required" placeholder="Select Month">
                            </div>
                          </form>
                       </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">IMMUNIZATION REPORT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead>
                      <tr>
                        <td rowspan="3" class="txt-bottom" width="20%"><b>Antigen</b></td>
                        <td colspan="7"><b>By Age Group and by Sex</b></td>
                      </tr>
                      <tr>
                        <td colspan="2"><b>Under 1</b></td>
                        <td colspan="2"><b>1 & Above</b></td>
                        <td colspan="3"><b>Total</b></td>
                      </tr>
                      <tr>
                        <td><b>Male</b></td>
                        <td><b>Female</b></td>
                        <td><b>Male</b></td>
                        <td><b>Female</b></td>
                        <td><b>Male</b></td>
                        <td><b>Female</b></td>
                        <td><b>Total</b></td>
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
$('#loader').hide();
$("#date").change(function() {

  });

    $( "#date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            $.ajax({
              type: "POST",
              url: "<?php echo base_url().'reports/get_immunization'; ?>",
              data: $("#form1").serializeArray(),
              beforeSend: function() {
                tr = `<tr id="loader">
                            <td colspan="41">
                              <div class="callout callout-info"><p><i class="fa fa-circle-o-notch fa-spin"></i> Loading Data...</p></div>
                            </td>
                        </tr>`;
                $('#tbody').html(tr);
              },
              complete: function(){
                $('#loader').hide();
              },
              //data:formData,
                success: function(data){ 
                    table.clear();
                    var tr ='';
                        $.each(data.immunization_list, function(key, val){
                        table.row.add([ val.vaccine,
                                        val.m0,
                                        val.f0,
                                        val.m1,
                                        val.f1,
                                        val.mtotal,
                                        val.ftotal,
                                        val.total,
                                    ]).draw( false );
                    })

                }
            });
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
            }
        ]
    });


  });
</script>