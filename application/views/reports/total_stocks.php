
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

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
        <li class="active">Total Stocks per Medicine</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
      <div class="box">
      <form id="form1" method="POST" action="<?php echo base_url().'reports/total_stocks'; ?>">
              <div class="box-body table-responsive">
                    <div class="col-lg-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8">
                          
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8">
                        </div>
                    </div>
                    <div class="col-lg-12 pull-right">
                        <div class="col-lg-2">
                          <label>Category: </label>
                            <select name="cat_id" id="cat_id" class="select2 form-control">
                              <option value="" disabled selected>Select Category</option>
                              <option value="">ALL</option>
                              <?php foreach($cat_list as $cat){ ?>
                                <option value="<?= $cat->cat_id; ?>"><?= $cat->category; ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                          <label>Date Disposed: </label>
                          <input type="text" name="date" class="form-control daterange get_data"/>
                        </div>  
                        <div class="col-lg-2">
                          <label>Medicine Source: </label>
                            <select name="source_id" id="source_id" class="form-control select2">
                              <option selected disabled>Select Source</option>
                              <option value="">ALL</option>
                              <?php 
                              foreach($source_list as $p){
                              ?>
                                  <option value="<?php echo $p->source_id; ?>">
                                      <?php echo $p->source; ?>
                                  </option>
                              <?php } ?>
                            </select> 
                        </div>  
                        <div class="col-lg-3">
                          <label>Health Station: </label>
                          <select name="station_id" id="station_id" class="select2 form-control" style="width:100%;">
                            <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                                <option selected disabled>Select Health Station</option>
                                <option value="">ALL</option>
                              <?php foreach($station_list as $station){ ?>
                                  <option value="<?= $station->station_id; ?>"><?= $station->brgy; ?></option>
                              <?php } ?>
                              <?php }else{ ?>
                                  <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                              <?php } ?>
                          </select>
                        </div>  
                        <div class="col-lg-2">
                          <label>Quantity count Less than:</label>
                          <input type="number" name="remaining_stock" value="" id="remaining_stock" class="form-control input-sm">
                        </div>
                        <div class="col-lg-1">
                          <br>
                            <input type="button" name="button" value="Search" class="btn btn-primary submit_btn">
                        </div>
                    </div>
                </div>
            </form>
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Total Stocks Remaining / Gender Aggregated Disposal</h3>
                    <h5>Filters: <span id='filters'></span></h5>
                        <div class="box-tools">
                        </div>
                    </div>
                    <hr />
                
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th>Type</th>
                              <th>Category</th>
                              <th>Medicine</th>
                              <th>Preparation</th>
                              <th>Disposed to Male</th>
                              <th>Disposed to Female</th>
                              <th>Total Disposed</th>
                              <th>Remaining  Stocks</th>
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
var dates,filters;
$(document).ready(function() {
  $(".submit_btn").click(function() {
    var array = []
    $('#cat_id').val()!=null?array.push($('#cat_id option:selected').text()):array.push('ALL')

    $('#source_id').val()!=null?array.push($('#source_id option:selected').text()):array.push('ALL')
    $('#station_id').val()!=null?array.push($('#station_id option:selected').text()):array.push('ALL');
    $('#remaining_stock').val()!=''?array.push($('#remaining_stock').val()):array.push('No Filter');
    if($('.daterange').val()!=''){
      date = $('.daterange').val().split(' - ');
      
      var from = convert_date(date[0]);
      var to = convert_date(date[1]);
      dates = from + ' To ' + to;

      array.push(dates)
    }else{
      dates ='';
    }

            $.ajax({
              type: "POST",
              url: "<?php echo base_url().'reports/get_total_stock'; ?>",
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
                  var total_disposed;
                    table.clear();
                    var tr ='';
                        $.each(data.list, function(key, val){
                        total_disposed = val.total_disposed==''?0:val.total_disposed;
                        table.row.add([ val.type,
                                        val.category,
                                        val.product_name,
                                        val.preparation,
                                        val.male_quantity,
                                        val.female_quantity,
                                        total_disposed,
                                        val.rstock,
                                       ]).draw( false );
                    })
                   table.page( 'first' ).draw( 'page' );
                    filters='';
                  $.each(array, function(key, val){
                    if(key==0){
                        filters +='Category: '+val;
                    }
                    if(key==1){
                        filters +=" | Source: "+val;
                    }
                    if(key==2){
                        filters +=" | Station: "+val;
                    }
                    if(key==3){
                        filters +=" | Quantity Count: "+val;
                    }
                    if(key==4){
                        filters +=" | Disposed Date: "+val;
                    }
                    $('#filters').html(filters);
                  })
                }
            });
    });
    var table = $('#viewresult').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 10,
    'select': true,
    "buttons":[
                {
                  extend: 'print',
                  text: 'Print all',
                  title:"Disposed Medicines And Remaining stocks",
                  messageTop: function(){
                              return '<b>FILTERS</b>:' + filters;
                  },
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'print',
                  text: 'Print Selected',
                  title:"Disposed Medicines And Remaining stocks",
                  messageTop: function(){
                              return '<b>FILTERS</b>:' + filters;
                  },
                  exportOptions:{
                    modifier: {
                      selected: true
                    },
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Pdf',
                  title:"Disposed Medicines And Remaining stocks",
                  messageTop: function(){
                              return '<b>FILTERS</b>:' + filters;
                  },
                   alignment: 'center',
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  title:"Disposed Medicines And Remaining stocks",
                  messageTop: function(){
                              return '<b>FILTERS</b>:' + filters;
                  },
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
              ],    
    });
});
</script>

