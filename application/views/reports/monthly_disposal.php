<style>
  .ui-datepicker-calendar {
        display: none;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
function compute() {
    var a = $('#supplier_price').val();
    var b = $('#stock_quantity').val();
    var total = a * b;
    $('#investment').val(total);
}
function compute2() {
    var esupplier_price = $('#esupplier_price').val();
    var estock_quantity = $('#estock_quantity').val();
    var einvestment = esupplier_price * estock_quantity;
    $('#einvestment').val(einvestment);
}

  $('#supplier_price, #stock_quantity').change(compute);
  $('#esupplier_price, #estock_quantity').change(compute2);
    
    });
</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Report
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Monthly Disposal</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
      <div class="box">
      <form method="POST" action="<?php echo base_url().'reports/monthly_disposal'; ?>">
              <div class="box-body table-responsive">
                <div class="col-lg-2">
                  <label>Date Disposed From:</label>
                  <input type="text" class="form-control" name="disposed_from" id="disposed_from" required="required">
                </div>
                <div class="col-lg-2">
                  <label>Date Disposed To:</label>
                  <input type="text" class="form-control" name="disposed_to" id="disposed_to" required="required">
                </div>
                <div class="col-lg-3">
                  <label>Disposed From Health Station: </label>
                    <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                    <select name="station_id[]" id="station_id" class="select2 form-control" style="width:100%;"  required="required" multiple="multiple">
                      <?php foreach($station_list as $station){ ?>
                          <option value="<?= $station->station_id; ?>"><?= $station->brgy; ?></option>
                      <?php } ?>
                    <?php }else{ ?>
                      <select name="station_id[]" id="station_id" class="select2 form-control" style="width:100%;"  required="required">
                        <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label>Medicine:</label>
                  <select name="product_id[]" class="form-control select2" multiple="multiple">
                      <?php 
                      foreach($product_list as $p){
                      ?>
                          <option value="<?php echo $p->product_id; ?>">
                              <?php echo $p->product_name." | ".$p->preparation; ?>
                          </option>
                      <?php } ?>
                  </select>
                </div>
                <div class="col-lg-1">
                  <br>
                    <input type="submit" name="submit" value="Search" class="btn btn-primary">
                </div>
            </div>
          </form>
        </div>
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Monthly Disposal</h3>
                        <div class="box-tools">
                        </div>
                    </div>
                <div class="box-body table-responsive">
                  <?php if($total_list){ 
                    //get all months in date range
                    $start    = (new DateTime($from))->modify('first day of this month');
                    $end      = (new DateTime($to))->modify('first day of next month');
                    $interval = DateInterval::createFromDateString('1 month');
                    $period   = new DatePeriod($start, $interval, $end);
                  ?>
                    <table class="table table-striped table-bordered table-hover" id="viewresult">
                      <thead>
                        <th>Product</th>
                        <th>Station</th>
                        <?php 
                        if(!empty($from)){
                        foreach ($period as $dt) {
                          echo "<th>".$dt->format("M Y")."</th>";
                          }
                        }
                       ?>
                      </thead>
                      <tbody>
                        <?php
                        foreach($total_list as $list){
                        ?>
                        <tr>
                          <td><?= $list->product_name.'('.$list->preparation.')'; ?></td>
                          <td><?= $list->brgy; ?></td>
                          <?php
                          foreach ($period as $dt) {
                          echo "<td>".$list->{$dt->format('My')}."</td>";
                          }
                          ?>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <?php } ?>
                    <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 
if($station_count==1){
    $messageTop = 'Disposed From '.date("F Y", strtotime($from)).' To '.date("F Y", strtotime($to)).' of '.$total_list[0]->brgy;
}
else{
  $messageTop = 'Disposed From '.date("F Y", strtotime($from)).' To '.date("F Y", strtotime($to)).' of different stations';
} 
$title_station = ($station_count==1)?$total_list[0]->brgy:"Different Stations";
?>
<script>
$(document).ready(function() {
  $(".edit_stock").click(function() {
      var stock_id = this.getAttribute("stock_id");
      var supplier_price = this.getAttribute("supplier_price");
      var stock_quantity = this.getAttribute("stock_quantity");
      var investment = this.getAttribute("investment");
      var exp_date = this.getAttribute("exp_date");

      $("#stock_id").val(stock_id);
      $("#esupplier_price").val(supplier_price);
      $("#old_stock").val(stock_quantity);
      $("#estock_quantity").val(stock_quantity);
      $("#old_stock").val(stock_quantity);
      $("#einvestment").val(investment);
      $("#eexp_date").val(exp_date);
      $('#edit_stock').modal('show');
  });
  $(".sale_a").click(function() {
      var stock_id = this.getAttribute("stock_id");
      var sale_price = this.getAttribute("sale_price");

      $("#sstock_id").val(stock_id);
      $("#sale_price").val(sale_price);
      $('#sale_modal').modal('show');
  });
  $(".archive").click(function() {
      var stock_id = this.getAttribute("stock_id");
      var sale_price = this.getAttribute("sale_price");
      var remaining_stock = parseInt(this.getAttribute("remaining_stock"));
      if(remaining_stock < 1)
      {
      $("#archive_text").empty();
      $("#archive_text").append("Are you sure you want to archive this stock?");
        $("#archive_button").removeAttr("disabled");
    }
    else{
      $("#archive_text").empty();
      $("#archive_text").append("Cannot archive Stock. "+remaining_stock+" stocks left");
      $("#archive_button").attr("disabled", "disabled");

    }
      $("#astock_id").val(stock_id);
      $('#archive_modal').modal('show');
  });

    $('#viewresult').DataTable({
            responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 5,
    "buttons":[
                {
                  extend: 'excel',
                  text: 'Excel',
                  <?php if($med_count!=1 OR $med_count == 0){ ?>
                  title: "Medicine Monthly Disposal",
                  <?php } else{ ?>
                  title: "Disposal of <?php echo $total_list[0]->product_name.' '.$total_list[0]->preparation; ?>",
                  <?php } ?>
                  messageTop: "<?php echo $messageTop;  ?>",
                  orientation:'landscape',
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  text: 'Download Chart',
                  attr: { id: 'exportChart' }
                },
              ],    
    });
    $( "#disposed_from" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      }
    });
    $( "#disposed_to" ).datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      }
    });
});
<?php if($total_list){ ?>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2",
  title:{
    <?php if($med_count!=1){ ?>
    text: "Medicine Monthly Disposal"
    <?php } else{ ?>
    text: "Disposal of <?= $total_list[0]->product_name.' '.$total_list[0]->preparation; ?>"
    <?php } ?>
  },
subtitles:[
    {
      text: "From <?php echo $from; ?> to <?php echo $to; ?> of <?php echo $title_station; ?>"
      //Uncomment properties below to see how they behave
      //fontColor: "red",
      //fontSize: 30
    }
    ],
      axisY:{
    includeZero: false
  },
  axisX: {
    interval: 1
  },
  toolTip: {
    shared: true
  },
  data: [
    <?php
    if(!empty($total_list)){
      foreach($total_list as $list){
        if($station_count>1 AND $med_count!=1){
          $legend = $list->brgy.'-'.$list->product_name.'('.$list->preparation.')';
        }
        if($station_count>1 AND $med_count==1){
          $legend = $list->brgy;
        }
        if($station_count==1){
          $legend = $list->product_name.'('.$list->preparation.')';
        }
    ?>
    {        
    type: "line",
    name: "<?php echo $legend; ?>",
    showInLegend: true,
    dataPoints: [
        <?php 
            foreach ($period as $dt) {
            echo "{ y:".$list->{$dt->format('My')}.", label:'".$dt->format('M-Y')."'},";
            }
       ?>      
    ]
  },
<?php 
   }
  } 
?>
  ]
});
chart.render();
  document.getElementById("exportChart").addEventListener("click",function(){
      chart.exportChart({format: "jpg"});
    }); 
} 
<?php } ?>
</script>