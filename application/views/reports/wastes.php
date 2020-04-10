<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Wasted Medicine List
    <?php 
    $message = $this->session->flashdata('message');
    if(isset($message)){ 
        echo $message->disposal_id;
    ?>

    <?php } ?>
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active"> Wasted Medicines</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div >
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">History</h3>
                    </div>
            <div >
        <form method="POST" action="<?php echo base_url().'reports/wastes'; ?>">
                <div class="box">
                <div class="panel-body">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="col-lg-3">
                            <div class="col-lg-4">Date from: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="date_from" id="date_from" class="form-control">
                                </div>
                                <br><hr>
                                <div class="col-lg-4"> Date to: </div>
                                <div class="col-lg-8">
                                    <input type="text" name="date_to" id="date_to" class="form-control">
                                </div>
                                <br><hr>
                            </div>
                            <div class="col-lg-3">
                                <div class="col-lg-4"> Product: </div>
                                <div class="col-lg-8">
                                    <select name="product_id" class="form-control select2">
                                        <option selected disabled>Select Product</option>
                                        <?php 
                                        foreach($product_list as $p){
                                        ?>
                                            <option value="<?php echo $p->product_id; ?>">
                                                <?php echo $p->product_name." | ".$p->preparation; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <br><hr>

                                <br><hr>
                            </div>
                        <div class="col-lg-3">
                            <div class="col-lg-4">Added By: </div>
                                <div class="col-lg-8">
                                    <select name="disposed_by" id="disposed_by" class="form-control">
                                        <option selected disabled="">SELECT USER</option>
                                        <?php foreach ($users_list as $key => $user) { ?>
                                        <option value="<?= $user->userid ?>"><?=  $user->fname." ". $user->lname ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <br><hr>

                                <br><hr>
                            </div>
                        <div class="col-lg-3">
                            <div class="col-lg-4">
                                Wasted From:
                            </div>
                            <div class="col-lg-8">
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
                            <div class="col-lg-8"> </div>
                            <div class="col-lg-2"><input type="submit" name="submit" value="Search" class="btn btn-primary"></div>
                                                      <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </form>
                    <!-- /.END Header search filter-->
                    <div class="box-body table-responsive">
                    <div class="box-body">
                        <div class="row"> 
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="history_table">
                        <thead class="thead-inverse">
                        <tr class="bg-info">
                            <!-- <th>StockID</th>-->
                            <th>Medicine</th>
                            <th>Preparation</th>
                            <th>quantity</th>
                            <th>Date wasted</th>
                            <th>Added By</th>
                            <th>Wasted From</th>
                            <th>Reason</th>
                            <th width="5%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $waste_id = 0; 
                        $bg_color1 = 'warning';
                        $bg_color2 = 'active';
                        $current_color = $bg_color1;
                        ?>
                        <?php 
                        if(isset($history)){
                        foreach($history as $his){ 
                            ?>
                            <?php if($waste_id == $his->waste_id){ 
                            ?>
                            <tr class="<?php echo $current_color; ?>">
                                <!--<td><?php echo $his->stock_id; ?></td>-->
                                <td><?php echo $his->product_name; ?></td>
                                <td><?php echo $his->preparation; ?></td>
                                <td><?php echo $his->quantity; ?></td>
                                <td><?php echo $his->date_wasted; ?></td>
                                <td style="border-top: none;display: none;"></td>
                                <td style="border-top: none;display: none;"></td>
                                <td style="border-top: none;display: none;"></td>
                                <td style="border-top: none;display: none;"></td>
                                <td style="border-top: none;display: none;"></td>
                                <td>
                                    <a href="#"  class="openmodal" title="Void Disposal" disposal_id="<?php echo $his->disposal_id; ?>" stock_id="<?php echo $his->stock_id; ?>" product_id="<?php echo $his->product_id; ?>" quantity="<?php echo $his->quantity; ?>">
                                    <i class="fa fa-remove fa-1x" > </i>
                                    </a>
                                    |
                                    <a href="#" title="View Photo" class="view_photo" trans_id="<?php echo $his->transaction_id; ?>" sold_to="<?php echo $his->sold_to; ?>" >
                                    <i class="fa fa-camera" > </i>
                                    </a>
                                </td>

                            </tr>
                                <?php 
                                    }
                                else{
                                    if($current_color == $bg_color2){
                                        $current_color = $bg_color1;
                                    }
                                    else{
                                        $current_color = $bg_color2;
                                    }
                                    ?>
                            <tr class="<?php echo $current_color; ?>">
                                <!--<td><?php echo $his->stock_id; ?></td>-->
                                <td><?php echo $his->product_name; ?></td>
                                <td><?php echo $his->preparation; ?></td>
                                <td><?php echo $his->quantity; ?></td>
                                <td><?php echo $his->date_wasted; ?></td>
                                <td><?php echo $his->dfname." ".$his->dlname; ?></td>
                                <td><?php echo $his->station; ?></td>
                                <td><?php echo $his->reason; ?></td>
                                <td>
                                    <a href="#"  class="openmodal" title="Void Disposal"  waste_id="<?php echo $his->waste_id; ?>" stock_id="<?php echo $his->stock_id; ?>" product_id="<?php echo $his->product_id; ?>" quantity="<?php echo $his->quantity; ?>" >
                                    <i class="fa fa-remove fa-1x" > </i>
                                    </a>
                                    |
                                    <a href="#"  class="view_photo" waste_id="<?php echo $his->waste_id; ?>">
                                    <i class="fa fa-camera" > </i>
                                    </a>
                                </td>

                            </tr>
                            <?php 
                            } ?>
                        <?php 
                            $waste_id = $his->waste_id;
                            }
                        } ?>
                        </tbody>
                   </table>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="void_modal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-danger">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    VOID SALES TRANSACTION
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <h4>Are you sure you want to Void this transaction? This action is ireversible and will affect the inventory. <hr><p id="disposal_id">Transaction ID no. </p></h4>
              <form id="void_form" method="POST" class="form-horizontal" role="form" action="<?php echo base_url()."disposal/void_trans"; ?>">
              <input type="hidden" name="disposal_id" id="disposal_id_field" value=""/>
              <input type="hidden" name="stock_id" id="stock_id" value=""/>
              <input type="hidden" name="product_id" id="product_id" value=""/>
              <input type="hidden" name="quantity" id="quantity" value=""/>
              <input type="hidden" name="total_price" id="total_price" value=""/>
              <input type="hidden" name="cpass" id="cpass" value="<?php echo $userdata->password; ?>"/>
              Password<font color="red">*</font>:
              <input type="password" id="password" name="password" required="required" class="form-control"/>
                  <!--SUBMIT BUTTON -->
                <div class="modal-footer" align="right">
                  <div class="form-group">
                    <div class="col-sm-12" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">
                         Close
                      </button>
                      <input type="submit" value="Void" class="btn btn-danger">
                    </div>
                  </div>
                 </div>
                </form>
            </div><!--end Modal body-->
        </div><!--end Modal content-->
    </div><!--end Modal dialog-->
</div>
<div class="modal fade" id="photo_modal" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Attached Photo
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div id="display_photo">
                </div>
            </div><!--end Modal body-->
                <div class="modal-footer" align="right">
                  <div class="form-group">
                    <div class="col-sm-12" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">
                         Close
                      </button>
                    </div>
                  </div>
                 </div>
        </div><!--end Modal content-->
    </div><!--end Modal dialog-->
</div>
<script type="text/javascript">
$(document).ready(function() {
$(".openmodal").click(function() {
    var disposal_id = this.getAttribute("disposal_id");
    var stock_id = this.getAttribute("stock_id");
    var product_id = this.getAttribute("product_id");
    var quantity = this.getAttribute("quantity");
    var total_price = this.getAttribute("total_price");

    $("#disposal_id").text("Transaction ID no."+ disposal_id);
    $("#disposal_id_field").val(disposal_id);
    $("#stock_id").val(stock_id);
    $("#product_id").val(product_id);
    $("#quantity").val(quantity);
    $("#total_price").val(total_price);
    $('#void_modal').modal('show');
});
$(".view_photo").click(function() {
    var waste_id = this.getAttribute("waste_id");
    $('#display_photo').html('<img src="<?php echo base_url(); ?>assets/images/upload/waste'+waste_id+'.jpg" class="user-image" width="570px" height="320px">');
    $('#photo_modal').modal('show');
});

$( "#void_form" ).submit(function( event ) {
    var password = $( "#password").val()
    if (password === $( "#cpass" ).val()) {
    this.submit();
     }
    else{
    alert("password did not match!");
    event.preventDefault();
 }

});
    $('#history_table').DataTable({
        responsive: true,
    dom: 'Blfrtip',
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
    "order": [[ 0, "desc" ]],
    "buttons":[
                {
                  extend: 'excel',
                  text: 'Excel',
                  title:"RHU Wasted Medicines<?php 
                  if(!empty($search_data->date_from)){echo ' as of '.date("F j, Y", strtotime($search_data->date_from)).' To '.date("F j, Y", strtotime($search_data->date_to));} 
                  ?>",
                  orientation:'landscape',
                  exportOptions:{
                    columns: [ 0,1,2,3,4,5],
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'pdf',
                  text: 'PDF',
                  title:"RHU Wasted Medicines<?php 
                  if(!empty($search_data->date_from)){echo ' as of '.date("F j, Y", strtotime($search_data->date_from)).' To '.date("F j, Y", strtotime($search_data->date_to));} 
                  ?>",
                  orientation:'landscape',
                  exportOptions:{
                    columns: [ 0,1,2,3,4,5],
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'print',
                  text: 'Print',
                  title:"RHU Wasted Medicines<?php 
                  if(!empty($search_data->date_from)){echo ' as of '.date("F j, Y", strtotime($search_data->date_from)).' To '.date("F j, Y", strtotime($search_data->date_to));} 
                  ?>",
                  orientation:'landscape',
                  exportOptions:{
                    columns: [ 0,1,2,3,4,5],
                    modifier: {
                      selected: null
                    },
                  }
                },
              ],  
    });
});

    $( "#date_from" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2018:2030",
    dateFormat: 'yy-mm-dd'
    });
    $( "#date_to" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2018:2030",
    dateFormat: 'yy-mm-dd'
    });

</script>
