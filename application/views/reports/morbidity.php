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
                      <form action="<?php echo base_url(); ?>reports/print_morbidity" id="form1" method="post" target="_blank" >
                        <div class="col-xs-1">
                            <label>NAME OF DISEASES:</label>
                        </div>
                            <div class="col-xs-4">
                                <select name="selected_diagnosis[]" id="selected_diagnosis" class="select2" multiple="multiple">
                                    <?php foreach ($diagnosis as $key => $value) {
                                    ?>
                                            <option value="<?= $value->diagnosis_id ?>" ><?= $value->diagnosis ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                            <div  class="col-xs-3">
                                <select name="icd_group[]" id="icd_group" class="select2" multiple="multiple">
                                    <option value="">ICD GROUP: ALL</option>
                                    <?php foreach ($icd_group as $key => $value) {
                                    ?>
                                            <option value="<?= $value->id ?>" ><?= $value->icd_group ?></option>
                                    <?php
                                    } ?>                                </select>
                            </div>
                            <div class="col-xs-2">
                            <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                            <select name="poc" class="select2">
                                <option selected disabled>PLACE OF CONSULTATION</option>
                                <option value="ALL">ALL</option>
                                <?php foreach ($health_station as $key => $value) {
                                ?>
                                        <option value="<?= $value->station_id ?>" ><?= $value->brgy ?></option>
                                <?php
                                } ?>
                            </select>
                            <?php }else{ ?>
                            <select name="poc" class="select2">
                                <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                            </select>
                            <?php } ?>
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
                    <h3 class="box-title">MORBIDITY DISEASE REPORT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead>
                      <tr>
                        <td rowspan="3">Name of Disease</td>
                        <td rowspan="3">ICD Code</td>
                        <td colspan="35">By Age Group and by Sex</td>
                      </tr>
                      <tr>
                        <td colspan="2">Under 1</td>
                        <td colspan="2">1-4</td>
                        <td colspan="2">5-9</td>
                        <td colspan="2">10-14</td>
                        <td colspan="2">15-19</td>
                        <td colspan="2">20-24</td>
                        <td colspan="2">25-29</td>
                        <td colspan="2">30-34</td>
                        <td colspan="2">35-39</td>
                        <td colspan="2">40-44</td>
                        <td colspan="2">45-49</td>
                        <td colspan="2">50-54</td>
                        <td colspan="2">55-59</td>
                        <td colspan="2">60-64</td>
                        <td colspan="2">65-69</td>
                        <td colspan="2">70&Over</td>
                        <td colspan="3">Total</td>
                      </tr>
                      <tr>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>M</td>
                        <td>F</td>
                        <td>T</td>
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
              url: "<?php echo base_url().'reports/get_morbidity'; ?>",
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
                        $.each(data.morbidity_list, function(key, val){
                        table.row.add([ val.diagnosis,
                                        val.icd_code,
                                        val.m0,
                                        val.f0,
                                        val.m1,
                                        val.f1,
                                        val.m5,
                                        val.f5,
                                        val.m10,
                                        val.f10,
                                        val.m15,
                                        val.f15,
                                        val.m20,
                                        val.f20,
                                        val.m25,
                                        val.f25,
                                        val.m30,
                                        val.f30,
                                        val.m35,
                                        val.f35,
                                        val.m40,
                                        val.f40,
                                        val.m45,
                                        val.f45,
                                        val.m50,
                                        val.f50,
                                        val.m55,
                                        val.f55,
                                        val.m60,
                                        val.f60,
                                        val.m65,
                                        val.f65,
                                        val.m70,
                                        val.f70,
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