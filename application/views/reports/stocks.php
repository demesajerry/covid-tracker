
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
        <li class="active"> Stocks per Exp Date</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
              <form method="POST" action="<?php echo base_url().'reports/search_stocks'; ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="col-lg-3">
                            <div class="col-lg-4"> Exp Date from: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="date_from" id="date_from" class="form-control" autocomplete="false">
                                </div>
                                <br><hr>
                                <div class="col-lg-4"> Exp Date to: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="date_to" id="date_to" class="form-control" autocomplete="false">
                                </div>
                                <br><hr>
                            </div>
                        <div class="col-lg-3">
                            <div class="col-lg-4"> Disposal Date from: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="sdate_from" id="sdate_from" class="form-control" autocomplete="false">
                                </div>
                                <br><hr>
                                <div class="col-lg-4"> Disposal Date to: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="sdate_to" id="sdate_to" class="form-control" autocomplete="false">
                                </div>
                                <br><hr>
                            </div>
                            <div class="col-lg-5">
                                <div class="col-lg-2"> Product Name: </div>
                                <div class="col-lg-4"><input type="text" name="product_name" class="form-control"></div>
                                <div class="col-lg-2">Stock Station:</div>
                                <div class="col-lg-4">
                                  <select name="station_id" id="station_id" class="select2 form-control" style="width:100%;">
                                  <?php if(!empty(array_intersect(array('Admin'), $userdata->access))){ ?>
                                      <option selected disabled>Select Health Station</option>
                                      <?php foreach($station_list as $station){ ?>
                                          <option value="<?= $station->station_id; ?>"><?= $station->brgy; ?></option>
                                      <?php } ?>
                                  <?php }else{ ?>
                                      <option value="<?= $userdata->station ?>"><?= $userdata->station_name ?></option>
                                  <?php } ?>
                                  </select>
                                </div>
                                <br><hr>
                                <div class="col-lg-3"> Stocks Remaining is less than: </div>
                                <div class="col-lg-3" align="left"><input type="number" name="remaining_stock" class="form-control"> </div>
                                <div class="col-lg-2"> Category: </div>
                                <div class="col-lg-4" align="left">
                                  <select name="cat_id" class="select2 form-control">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php foreach($cat_list as $cat){ ?>
                                      <option value="<?= $cat->cat_id; ?>"><?= $cat->category; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <br><hr>
                            </div>
                       <div class="col-lg-1">
                            <div class="col-lg-4">  </div>
                              <div class="col-lg-8"> 
                              </div>
                            <br><hr>
                            <div class="col-lg-2"> </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"><input type="submit" name="submit" value="Search" class="btn btn-primary"></div>
                                                      <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </form>
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Stock List</h3>
                        <div class="box-tools">
                        </div>
                    </div>
                <hr />
                
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th>source</th>
                              <th>Type</th>
                              <th>Category</th>
                              <th>Medicine</th>
                              <th>Preparation</th>
                              <th>Original Quantity</th>
                              <th>Investment</th>
                              <th>Stock Station</th>
                              <th>Expiration</th>
                              <th>Stock Date</th>
                              <th>Disposed</th>
                              <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($stocks_list)){
                            foreach($stocks_list as $stocks){ 
                              $remaining_stocks = $stocks->stock_quantity - $stocks->quantity_sold;
                        ?>
                        <tr>
                            <td><?php echo $stocks->source; ?></td>
                            <td><?php echo $stocks->type; ?></td>
                            <td><?php echo $stocks->category; ?></td>
                            <td><?php echo $stocks->product_name; ?></td>
                            <td><?php echo $stocks->preparation; ?></td>
                            <td><?php echo $stocks->stock_quantity; ?></td>
                            <td><?php echo"&#8369;".number_format( $stocks->investment); ?></td>
                            <td><?php echo $stocks->station; ?></td>
                            <td><?php echo $stocks->exp_date; ?></td>
                            <td><?php echo $stocks->stock_date; ?></td>
                            <td><?php echo $stocks->quantity_sold; ?></td>
                            <td><?php echo $remaining_stocks; ?></td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="edit_stock" tabindex="-1" role="dialog" 
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
                    Edit Product
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
              <form method="POST" class="form-horizontal" role="form" action="<?php echo base_url()."product/edit_stock"; ?>">
              <input type="hidden" name="stock_id" id="stock_id" class="form-control"  />
              <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_details->product_id; ?>" class="form-control"  />
              <input type="hidden" name="old_stock" id="old_stock" class="form-control"  />
                   <table class="table table-bordered table-hover">
                   <tr>
                        <td>Supplier Price: </td>
                        <td><input type="number" value="<?php echo $stocks->supplier_price; ?>" name="supplier_price" id="esupplier_price" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td>Stock Quantity: </td>
                        <td><input type="number" value="<?php echo $stocks->stock_quantity; ?>" name="stock_quantity" id="estock_quantity" class="form-control" /></td>
                    </tr>
                   <tr>
                        <td>Investment: </td>
                        <td><input type="text" value="<?php echo $stocks->investment; ?>" name="investment" id="einvestment" class="form-control" readonly="readonly" /></td>
                    </tr>
                   <tr>
                        <td>Expiration Date: </td>
                        <td><input type="text" value="<?php echo $stocks->exp_date; ?>" name="exp_date" id="eexp_date" class="form-control" /></td>
                    </tr>
               </table>
                  
                  <!--SUBMIT BUTTON -->
                <div class="modal-footer" align="right">
                  <div class="form-group">
                    <div class="col-sm-12" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">
                         Close
                      </button>
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
                 </div>
                </form>
            </div><!--end Modal body-->
        </div><!--end Modal content-->
    </div><!--end Modal dialog-->
  </div><!--end modal receive-->
<!--SALE PRODUCT -->
<div class="modal fade" id="sale_modal" tabindex="-1" role="dialog" 
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
                   Sale Product
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
              <form method="POST" class="form-horizontal" role="form" action="<?php echo base_url()."product/sale_stock"; ?>">
              <input type="hidden" name="sstock_id" id="sstock_id" class="form-control"  />
              <input type="hidden" name="pproduct_id" id="pproduct_id" value="<?php echo $product_details->product_id; ?>" class="form-control"  />
                   <table class="table table-bordered table-hover">
                   <tr>
                        <td>Sale Price: </td>
                        <td><input type="number" name="sale_price" id="sale_price" class="form-control" /></td>
                    </tr>
               </table>
                  
                  <!--SUBMIT BUTTON -->
                <div class="modal-footer" align="right">
                  <div class="form-group">
                    <div class="col-sm-12" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">
                         Close
                      </button>
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
                 </div>
                </form>
            </div><!--end Modal body-->
        </div><!--end Modal content-->
    </div><!--end Modal dialog-->
  </div><!--end modal sale-->
<!--ARCHIVE PRODUCT -->
<div class="modal fade" id="archive_modal" tabindex="-1" role="dialog" 
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
                   Archive Product
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="alert alert-primary" role="alert"><h3><p id="archive_text"></p></h3></div>
              <form method="POST" class="form-horizontal" role="form" action="<?php echo base_url()."product/archive_stock"; ?>">
              <input type="hidden" name="stock_id" id="astock_id" class="form-control"  />
              <input type="hidden" name="product_id" id="pproduct_id" value="<?php echo $product_details->product_id; ?>" class="form-control"  />
              <input type="hidden" name="archive" value="1" class="form-control"  />
                  <!--SUBMIT BUTTON -->
                <div class="modal-footer" align="right">
                  <div class="form-group">
                    <div class="col-sm-12" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">
                         Close
                      </button>
                      <button type="submit" id="archive_button" class="btn btn-success">Archive</button>
                    </div>
                  </div>
                 </div>
                </form>
            </div><!--end Modal body-->
        </div><!--end Modal content-->
    </div><!--end Modal dialog-->
  </div><!--end modal archive-->
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
    "iDisplayLength": 10,
    "buttons":[
                {
                  extend: 'print',
                  text: 'Print all',
                  title:"Medicine Stocks List per Expiration Date",
                  messageTop:"",
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'print',
                  text: 'Print Selected',
                  title:"Medicine Stocks List per Expiration Date",
                  messageTop:"",
                  exportOptions:{
                    modifier: {
                      selected: true
                    },
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Pdf',
                  title:"Medicine Stocks List per Expiration Date",
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  title:"Medicine Stocks List per Expiration Date",
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
              ],    
    });
    
var dateFormat = "yy-mm-dd",
      from = $( "#date_from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          dateFormat: 'yy-mm-dd' 
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate",getDate( this ) );
        }),
      to = $( "#date_to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate",getDate( this ) );
      });
          function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
    
var dateFormat = "yy-mm-dd",
      from = $( "#sdate_from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          dateFormat: 'yy-mm-dd' 
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate",getDate( this ) );
        }),
      to = $( "#sdate_to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate",getDate( this ) );
      });
          function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
});
</script>

