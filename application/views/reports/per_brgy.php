
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
        <li class="active">Disposal per Brgy</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
      <div class="box">
      <form method="POST" action="<?php echo base_url().'reports/per_brgy'; ?>">
              <div class="box-body table-responsive">
                <div class="col-lg-2">
                  <label>Date Disposed From:</label>
                  <input type="text" class="form-control" name="disposed_from" id="disposed_from">
                </div>
                <div class="col-lg-2">
                  <label>Date Disposed To:</label>
                  <input type="text" class="form-control" name="disposed_to" id="disposed_to">
                </div>
                <div class="col-lg-3">
                  <label>Disposed From Health Station: </label>
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
                <div class="col-lg-4">
                  <label>Barangay:</label>
                    <select name="brgy[]" class="select2 form-control" multiple="multiple">
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
                    <h3 class="box-title">Disposal per Barangay(<?php echo (isset($station_name))?$station_name:"ALL Station"; ?>)</h3>
                        <div class="box-tools">
                        </div>
                    </div>
                <div class="box-body table-responsive">

                
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="10%">Medicine</th>
                              <th width="10%">Preparation</th>
                              <?php if(empty($brgy)){ ?>
                              <th width="5%">Anos</th>
                              <th width="5%">Bagong Silang</th>
                              <th width="5%">Bambang</th>
                              <th width="5%">Batong Malake</th>
                              <th width="5%">Baybayin</th>
                              <th width="5%">Bayog</th>
                              <th width="5%">Lalakay</th>
                              <th width="5%">Maahas</th>
                              <th width="5%">Malinta</th>
                              <th width="5%">Mayondon</th>
                              <th width="5%">Tuntungin-Putho</th>
                              <th width="5%">San Antonio</th>
                              <th width="5%">Tadlac</th>
                              <th width="5%">Timugan</th>
                            <?php } 
                            else{
                            ?>
                            <?php foreach($brgy as $val){?>
                              <th width="5%"><?php echo $val ;?></th>
                          <?php }
                        }
                        ?>
                              <th width="5%">Total Disposed</th>
                              <th width="5%">Remaining  Stocks</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks_list != false){
                            foreach($stocks_list as $stocks){ 
                              //$remaining_stocks = $stocks->stock_quantity - $stocks->quantity_sold;
                        ?>
                        <tr>
                            <td><?php echo $stocks->product_name; ?></td>
                            <td><?php echo $stocks->preparation; ?></td>
                            <?php if(empty($brgy)){ ?>
                              <td><?php echo $stocks->anos; ?></td>
                              <td><?php echo $stocks->bs; ?></td>
                              <td><?php echo $stocks->bambang; ?></td>
                              <td><?php echo $stocks->bm; ?></td>
                              <td><?php echo $stocks->baybayin; ?></td>
                              <td><?php echo $stocks->bayog; ?></td>
                              <td><?php echo $stocks->lalakay; ?></td>
                              <td><?php echo $stocks->maahas; ?></td>
                              <td><?php echo $stocks->malinta; ?></td>
                              <td><?php echo $stocks->mayondon; ?></td>
                              <td><?php echo $stocks->tp; ?></td>
                              <td><?php echo $stocks->sa; ?></td>
                              <td><?php echo $stocks->tadlac; ?></td>
                              <td><?php echo $stocks->timugan; ?></td>
                            <?php }
                             else { 
                              $total_disposed = 0;
                              ?> 
                              <?php if (in_array('Anos', $brgy)){ echo '<td>'. $stocks->anos . '</td>'; 
                              $total_disposed += $stocks->anos; } ?>
                              <?php if (in_array('Bagong Silang', $brgy)){ echo '<td>'. $stocks->bs . '</td>'; 
                              $total_disposed += $stocks->bs; } ?>
                              <?php if (in_array('Bambang', $brgy)){ echo '<td>'. $stocks->bambang . '</td>'; 
                              $total_disposed += $stocks->bambang; } ?>
                              <?php if (in_array('Batong Malake', $brgy)){ echo '<td>'. $stocks->bm . '</td>'; 
                              $total_disposed += $stocks->bm; } ?>
                              <?php if (in_array('Baybayin', $brgy)){ echo '<td>'. $stocks->baybayin . '</td>'; 
                              $total_disposed += $stocks->baybayin; } ?>
                              <?php if (in_array('Bayog', $brgy)){ echo '<td>'. $stocks->bayog . '</td>'; 
                              $total_disposed += $stocks->bayog; } ?>
                              <?php if (in_array('Lalakay', $brgy)){ echo '<td>'. $stocks->lalakay . '</td>'; 
                              $total_disposed += $stocks->lalakay; } ?>
                              <?php if (in_array('Maahas', $brgy)){ echo '<td>'. $stocks->maahas . '</td>'; 
                              $total_disposed += $stocks->mahaas; } ?>
                              <?php if (in_array('Malinta', $brgy)){ echo '<td>'. $stocks->malinta . '</td>'; 
                              $total_disposed += $stocks->malinta; } ?>
                              <?php if (in_array('Mayondon', $brgy)){ echo '<td>'. $stocks->mayondon . '</td>'; 
                              $total_disposed += $stocks->mayondon; } ?>
                              <?php if (in_array('Tuntungin-Putho', $brgy)){ echo '<td>'. $stocks->tp . '</td>'; 
                              $total_disposed += $stocks->tp; } ?>
                              <?php if (in_array('San Antonio', $brgy)){ echo '<td>'. $stocks->sa . '</td>'; 
                              $total_disposed += $stocks->sa; } ?>
                              <?php if (in_array('Tadlac', $brgy)){ echo '<td>'. $stocks->tadlac . '</td>'; 
                              $total_disposed += $stocks->tadlac; } ?>
                              <?php if (in_array('Timugan', $brgy)){ echo '<td>'. $stocks->timugan . '</td>'; 
                              $total_disposed += $stocks->timugan; } ?>
                            <?php }  ?>
                            <td><?php echo (empty($brgy))?$stocks->total_disposed:$total_disposed; ?></td>
                            <td><?php echo $stocks->total_stocks; ?></td>
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
                  extend: 'excel',
                  text: 'Excel',
                  title:"<?php echo (isset($station_name))?$station_name:'ALL'; ?> Medicine Disposal per Barangay",
                  messageTop:"<?php 
                  if(!empty($from)){echo 'Disposed From '.date("F j, Y", strtotime($from)).' To '.date("F j, Y", strtotime($to));} 
                  ?>",
                  orientation:'landscape',
                  exportOptions:{
                    modifier: {
                      selected: null
                    },
                  }
                },
              ],    
    });
    $( "#disposed_from" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2018:2030",
    dateFormat: 'yy-mm-dd'
    });
    $( "#disposed_to" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2018:2030",
    dateFormat: 'yy-mm-dd'
    });

});
</script>

