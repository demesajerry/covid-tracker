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
                      <form action="<?php echo base_url(); ?>reports/print_client_count" id="form1" method="post" target="_blank" >
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-2">
                        </div>
                        <div class="col-xs-1">
                          <label>Select View Type:</label>
                        </div>
                        <div class="col-xs-2">
                          <select name="group_by" class="select2 get_data">
                            <option value="day">DAILY</option>
                            <option value="month">MONTHLY</option>
                          </select>
                        </div>
                        <div class="col-xs-2">
                        <select name="poc" class="select2 get_data">
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
                        <input type="text" name="date" class="form-control daterange get_data"/>
                        </div>
                      </form>
                     </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title date_title">CLIENT COUNT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>DAY</td>
                        <td>MALE</td>
                        <td>FEMALE</td>
                        <td>TOTAL</td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
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
  url: "<?php echo base_url().'reports/get_client_count'; ?>",
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
      $('.date_title').html(`CLIENT COUNT FROM ${data.date.from} TO ${data.date.to}`);
      var tr ='',total_male=0,total_female=0,total_all=0;
      table.clear();
      chart.options.data[0].dataPoints = [];
      chart.options.data[1].dataPoints = [];
      chart.options.data[2].dataPoints = [];
      if(data.view == 'day'){
        for (var d = new Date(data.date.date1); d <= new Date(data.date.date2); d.setDate(d.getDate() + 1)){
          day = d.getFullYear()+'-'+("0" + (d.getMonth()+1)).slice(-2)+'-'+("0" + (d.getDate())).slice(-2);
          val = jQuery.grep(data.client_count, function( n, i ) {
            return (n.dov == day);
          });
          if(val.length == 1){
            table.row.add([ val[0].dov_text,
                          val[0].count_male,
                          val[0].count_female,
                          val[0].total
                      ]).draw( false );

            total_male += parseInt(val[0].count_male);
            total_female += parseInt(val[0].count_female);
            total_all += parseInt(val[0].total);

            chart.options.data[0].dataPoints.push({label: val[0].dov,  y: parseInt(val[0].count_male) });
            chart.options.data[1].dataPoints.push({label: val[0].dov,  y: parseInt(val[0].count_female) });
            chart.options.data[2].dataPoints.push({label: val[0].dov,  y: parseInt(val[0].total) });
          }else{
            chart.options.data[0].dataPoints.push({label: day,  y: 0 });
            chart.options.data[1].dataPoints.push({label: day,  y: 0 });
            chart.options.data[2].dataPoints.push({label: day,  y: 0 });
          }
        }
      }else{
       $.each(data.client_count, function(key, val){
        total_male += parseInt(val.count_male);
        total_female += parseInt(val.count_female);
        total_all += parseInt(val.total);
        table.row.add([ val.dov_text,
                      val.count_male,
                      val.count_female,
                      val.total
                  ]).draw( false );
        chart.options.data[0].dataPoints.push({label: val.dov,  y: parseInt(val.count_male) });
        chart.options.data[1].dataPoints.push({label: val.dov,  y: parseInt(val.count_female) });
        chart.options.data[2].dataPoints.push({label: val.dov,  y: parseInt(val.total) });
        })
      }

      table.row.add([ 'TOTAL',
                    total_male,
                    total_female,
                    total_all
                ]).draw( false );
      chart.options.title.text=`Client Count from ${data.date.from} to ${data.date.to} `;
      chart.render();                    
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
                  text: 'Download Chart',
                  attr: { id: 'exportChart' }
                },
        ]
    });

  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
      text: "CLIENT DAILY COUNT",
    },
    subtitles:[
      {
        text: '',
        //Uncomment properties below to see how they behave
        //fontColor: "red",
        //fontSize: 30
      },
      ],
/*    axisY:{
      includeZero: false
    },
    axisX: {
      interval: 5
    },
*/    
    toolTip: {
      shared: true
    },
    data: [
      {        
      type: "line",
      showInLegend: true,
    name: "MALE",
    markerType: "square",
      showInLegend: true,
      dataPoints: [
      ]
    }, 
    {        
      type: "line",
      showInLegend: true,
    name: "Female",
    markerType: "square",
    lineColor: "#F4C2C2",
    markerColor: "#F4C2C2",
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
    name: "Total count",
    markerType: "square",

      showInLegend: true,
      dataPoints: [
      ]
    },
    ]
  });
  $("#exportChart").on("click",function(){
      chart.exportChart({format: "jpg"});
    }); 
});
</script>
