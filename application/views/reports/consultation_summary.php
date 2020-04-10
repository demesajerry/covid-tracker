<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script>
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
    .tfoottr{
      background-color: #FFFFE0;
    }
    .free{
      background-color: #FFA07A !important; 
    }
    .discounted{
      background-color: #F0F8FF !important;
    }
    .red{
      color: red;
    }
    hr {
      display: block;
      margin-top: 0.1em;
      margin-bottom: 0.1em;
      margin-left: auto;
      margin-right: auto;
      border-width: 1px;
    }
    .hidden{
      body{
        visibility: hidden;
      }
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
                      <form action="<?php echo base_url(); ?>reports/print_consultation_summary" id="form1" method="post" target="_blank" >
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-2">
                        </div>
                        <div class="col-xs-1">
                          <label>Payment Received:</label>
                        </div>
                        <div class="col-xs-2">
                          <select name="payment_type" class="select2 get_data">
                            <option value="" selected disabled>Select Payment Received</option>
                            <option value="ALL">ALL</option>
                            <option value="FREE">Free of charge</option>
                            <option value="PAYED">With Complete PF</option>
                            <option value="DISCOUNTED">Discounted PF</option>
                          </select>
                        </div>
                        <div class="col-xs-2">
                          <select name="mop_id" class="select2 get_data">
                            <option value="ALL">ALL</option>
                            <option value="" selected disabled>Select Mode of Payment</option>
                            <?php foreach ($mop_list as $key => $val){ ?>
                              <option value="<?= $val->mop_id ?>"><?= $val->mop ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-xs-2">
                        <input type="text" name="date" class="form-control daterange get_data"/>
                        </div>
                      </form>
                     </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title date_title">Consultation Summary</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>#</td>
                        <td>Client Name</td>
                        <td>Gender</td>
                        <td>Date of Visit</td>
                        <td>PF Asked(Cash)</td>
                        <td>PF Asked(HMO)</td>
                        <td>Actual Payment(Cash)</td>
                        <td>Actual Payment(HMO)</td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                    </tfoot>
                  </table>
                </div>
                </div>
                <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
$('#loader').hide();

function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'reports/get_cs'; ?>",
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
      if(data.date.from!=""){
        var from = convert_date(data.date.from);
        var to = convert_date(data.date.to);
        $('.date_title').html(`CONSULTAITON SUMMARY FROM ${from} TO ${to}`);
      }
      var tr ='',total_male=0,total_female=0,total_all=0, total_pf=0, total_ap=0, total_pfh=0, total_aph=0,num=0,tfoot;
      table.clear();

       $.each(data.cs_list, function(key, val){
        if(val.gender == 'MALE'){
          total_male++;
        }else if(val.gender == 'FEMALE'){
        total_female++;
        }
        total_all ++;
        console.log(val.consultation_fee);
        total_pf +=parseInt(val.consultation_fee!=null?val.consultation_fee:0);
        total_ap +=parseInt(val.actual_payment!=null?val.actual_payment:0);
        total_pfh +=parseInt(val.hmo_fee!=null?val.hmo_fee:0);
        total_aph +=parseInt(val.hmo_payment!=null?val.hmo_payment:0);
        num++;
        var hmo_fee = val.hmo_fee!=null?val.hmo_fee:'';
        var consultation_fee = val.consultation_fee!=null?val.consultation_fee:'';
        var actual_payment = val.actual_payment!=null?val.actual_payment:'';
        var hmo_payment = val.hmo_payment!=null?val.hmo_payment:'';
        var rowNode =  table.row.add([num,
                      val.fullname,
                      val.gender,
                      val.dov,
                      '&#8369;'+consultation_fee,
                      '&#8369;'+hmo_fee,
                      '&#8369;'+actual_payment,
                      '&#8369;'+hmo_payment
                  ]).draw().node();
        if(val.consultation_fee=='0'){
          $( rowNode ).addClass('free'); 
        }

        if(val.consultation_fee>val.actual_payment){
          $( rowNode ).addClass('discounted'); 
        }
        })
        //add value to end of table
        var rowNode2 = table.row.add(['',
                      'Total:'+num,
                      'Male:'+total_male+' '+'female:'+total_female,
                      '',
                      '&#8369;'+total_pf,
                      '&#8369;'+total_pfh,
                      '&#8369;'+total_ap,
                      '&#8369;'+total_aph
                  ]).draw().node();
       //add hidden class to hide last value of the table(display only on download of excel)
       $( rowNode2 ).addClass('hidden'); 
       //create tfoot
                tfoot += `<tr class='tfoottr'>
                <td colspan='2'>Total Clients:${num}</td>
                <td>Male: ${total_male}<hr>Female: ${total_female}</td>
                <td></td>
                <td>Total Pf Asked(Cash): <span class='red'>&#8369;${total_pf}</span></td>
                <td>Total Pf Asked(HMO): <span class='red'>&#8369;${total_pfh}</span></td>
                <td>Total Actual Payment(Cash): <span class='red'> &#8369;${total_ap}<span></td>
                <td>Total Actual Payment(HMO): <span class='red'> &#8369;${total_aph}<span></td>
              </tr>`;
              //display created tfoot
        $('#tfoot').html(tfoot);
    }

});
}

$('.get_data').change(function(){
  get_data();
})

$('.daterange').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('Y-MM-D') + ' - ' + picker.endDate.format('Y-MM-D'));
    get_data();
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
                  },
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  title:"Consultation Summary",
                  messageTop:"",
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
