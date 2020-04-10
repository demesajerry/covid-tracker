
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Report
    <?php 
    $message = $this->session->flashdata('message');
    if(isset($message)){ 
        echo $message->clients_id;
    ?>

    <?php } ?>
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Disposal To Client</li>
        </ol>
    </section>

    <section class="content">
    	<div class="box">
			<form method="POST" action="<?php echo base_url().'reports/sales_reports'; ?>">
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
                    <div class="col-lg-4 pull-right">
                        <div class="col-lg-4">
                        	<input type="text" name="date_from" value="<?php echo ($date_from!='') ? $date_from:''; ?>" id="date_from" class="form-control">
                        </div>
                        <div class="col-lg-4">
                        	<input type="text" name="date_to" value="<?php echo ($date_to!='') ? $date_to:''; ?>" id="date_to" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <input type="submit" name="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>
          	</form>
              <div class="box">
                <div class="panel-body">

	<ul  class="nav nav-pills">
			<li class="active">
        	<a  href="#1a" data-toggle="tab">Sales report</a>
			</li>
			<li><a href="#2a" data-toggle="tab">Expenses Report</a>
			</li>

		</ul>
    <div class="box-body table-responsive">
		<div class="box-body">			
			<div class="tab-content clearfix">
			  	<div class="tab-pane active" id="1a">
                    <table class="table table-bordered table-hover" id="history_table">
                        <thead class="thead-inverse">
                        <tr class="bg-info">
                            <th>SalesID</th>
                            <th>TransID</th>
                            <th>StockID</th>
                            <th>Brand</th>
                            <th>Product</th>
                            <th>Unit</th>
                            <th>quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Date sold</th>
                            <th>Sold to</th>
                            <th>Points</th>
                            <th>Remarks</th>
                            <!--<th>Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $transaction_id = 0; 
                        $bg_color1 = 'bg-warning';
                        $bg_color2 = 'bg-active';
                        $current_color = $bg_color1;
                        ?>
                        <?php 
                        $gross = 0;
                        $total_points = 0;
                        if(isset($search_history)){
                        foreach($search_history as $his){ 
                        	$his->used_points;
                            $full_name = $his->fname ." ". $his->lname;
                            $price_sold =  $his->price_sold / $his->quantity;
                            $gross += $his->price_sold;
                            ?>
                            <?php if($transaction_id == $his->transaction_id){ 
                            ?>
                            <tr class="<?php echo $current_color; ?>">
                                <td><?php echo $his->clients_id; ?></td>
                                <td style="border-top: none;"></td>
                                <td><?php echo $his->stock_id; ?></td>
                                <td><?php echo $his->brand_name; ?></td>
                                <td><?php echo $his->product_name; ?></td>
                                <td><?php echo $his->unit; ?></td>
                                <td><?php echo $his->quantity; ?></td>
                                <td><?php echo "&#8369;".number_format($price_sold); ?></td>
                                <td><?php echo "&#8369;".number_format($his->price_sold); ?></td>
                                <td><?php echo $his->date_sold; ?></td>
                                <td style="border-top: none;"></td>
                                <td style="border-top: none;"></td>
                                <td style="border-top: none;"></td>
                                <!--<td>
                                    <a href="#"  class="openmodal" clients_id="<?php echo $his->clients_id; ?>" stock_id="<?php echo $his->stock_id; ?>" product_id="<?php echo $his->product_id; ?>" quantity="<?php echo $his->quantity; ?>" total_price="<?php echo $his->price_sold; ?>">
                                    <i class="fa fa-remove fa-1x" > </i>
                                    </a>
                                </td>-->

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
                                    $total_points += $his->used_points;

                                    ?>
                            <tr class="<?php echo $current_color; ?>">
                                <td><?php echo $his->clients_id; ?></td>
                                <td><?php echo $his->transaction_id; ?></td>
                                <td><?php echo $his->stock_id; ?></td>
                                <td><?php echo $his->brand_name; ?></td>
                                <td><?php echo $his->product_name; ?></td>
                                <td><?php echo $his->unit; ?></td>
                                <td><?php echo $his->quantity; ?></td>
                                <td><?php echo "&#8369;".number_format($price_sold)?></td>
                                <td><?php echo "&#8369;".number_format($his->price_sold); ?></td>
                                <td><?php echo $his->date_sold; ?></td>
                                <td><?php echo $full_name ?></td>
                                <td><?php echo $his->used_points; ?></td>
                                <td><?php echo $his->remarks; ?></td>
                                <!--<td>
                                    <a href="#"  class="openmodal" clients_id="<?php echo $his->clients_id; ?>" stock_id="<?php echo $his->stock_id; ?>" product_id="<?php echo $his->product_id; ?>" quantity="<?php echo $his->quantity; ?>" total_price="<?php echo $his->price_sold; ?>">
                                    <i class="fa fa-remove fa-1x" > </i>
                                    </a>
                                </td>-->

                            </tr>
                            <?php 
                            } ?>
                        <?php 
                        $transaction_id = $his->transaction_id;
                        } ?>
                        </tbody>
                        <?php } ?>
                   </table>
 				</div>
                <!-- END TAB SALES -->
                <!-- START EXPENSES TAB -->
				<div class="tab-pane" id="2a">
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="25%">Type</th>
                              <th width="30%">Details</th>
                              <th width="25%">Amount</th>
                              <th width="20%">date</th>
                            </tr>
                        </thead>
                        <?php 
                        $total_expenses = 0;;
                        if($expenses_list != false){
                            foreach($expenses_list as $expenses){ 
                              $total_expenses += $expenses->amount;
                        ?>
                        <tr>
                            <td><?php echo $expenses->type; ?></td>
                            <td><?php echo $expenses->details; ?></td>
                            <td><?php echo $expenses->amount; ?></td>
                            <td><?php echo $expenses->date; ?></td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                    </table>
				</div>
			</div>
            </div>
            </div>
                   <?php 
                   $total_spended = 0;
                   $highest_spender = 0;
                   foreach($sum_history as $sum){
                   	if($sum->total_per_user > $total_spended)
                   	{
                   		$total_spended = $sum->total_per_user;
                   		$highest_spender = $sum->fname." ".$sum->lname;
                   	}
                   }
                   $total_price = 0;
                   $most_quantity = 0;
                   foreach($sum_product as $sum){
                   	if($sum->total_price > $total_price)
                   	{
                   		$total_price = $sum->total_price;
                   		$product = $sum->brand_name."-".$sum->product_name."(".$sum->unit.")";
                   	}
                   	if($sum->total_quantity > $most_quantity)
                   	{
                   		$most_quantity = $sum->total_quantity;
                   		$qproduct = $sum->brand_name."-".$sum->product_name;
                   		$unit = $sum->unit;
                   	}
                   }
                   $most_used_points = 0;
                   $highest_points_spender = 0;

                   foreach($sum_points as $sum){
                   	if($sum->most_used_points > $most_used_points)
                   	{
                   		$most_used_points = $sum->most_used_points;
                   		$highest_points_spender = $sum->fname." ".$sum->lname;
                   	}
                   }
                   ?>
                <div class="col-lg-12">
                	<div class="col-lg-6">
	                	<table class="table table-striped table-bordered table-hover">
	                		<tr>
	                			<td>Date From:</td>
	                			<td><?php echo date('M d, Y',strtotime($date_from)); ?></td>
                			</tr>
                			<tr>
	                			<td>Date To:</td>
	                			<td><?php echo date('M d, Y',strtotime($date_to));  ?></td>
	                		</tr>
	                		<tr>
	                			<td>Gross profit:</td>
	                			<td><?php echo "&#8369;".number_format($gross); ?></td>
                			</tr>
                			<tr>
	                			<td>Total Expenses:</td>
	                			<td><?php echo "&#8369;".number_format($total_expenses); ?></td>
	                		</tr>
	                		<tr>
	                			<td>Total Points Used:</td>
	                			<td><?php echo $total_points; ?></td>
                			</tr>
                      <?php $net = $gross - $total_expenses; ?>
                			<tr>
	                			<td <?php echo ($net < 0)? "class = 'text-center col-md-4 danger'":"class = 'text-center col-md-4 success'"; ?>>Net Profit:</td>
	                			<td <?php echo ($net < 0)? "class = 'text-center col-md-4 danger'":"class = 'text-center col-md-4 success'"; ?>><?php echo "<i class='glyphicon glyphicon-thumbs-up'></i> "."&#8369;".number_format($net,2); ?></td>
	                		</tr>
	                	</table>
                	</div>
                 	<div class="col-lg-6">
	                	<table class="table table-striped table-bordered table-hover">
	                		<tr>
	                			<td>Most Spender:</td>
	                			<td><?php echo ($highest_spender!='')?$highest_spender . " has spended ". "&#8369;".number_format($total_spended):'N/A'; ?></td>
                			</tr>
                			<tr>
	                			<td>Most points Used:</td>
	                			<td><?php echo ($highest_points_spender!='')?$highest_points_spender . " has spended ". $most_used_points . " points":'N/A'; ?></td>
	                		</tr>
	                		<tr>
	                			<td>Highest Product sale:</td>
	                			<td><?php echo (isset($product))?$product ." has sold "."&#8369;".number_format($total_price):'N/A'; ?></td>
                			</tr>
	                		<tr>
	                			<td>Most quantity sold:</td>
	                			<td><?php echo (isset($qproduct))? $qproduct." has sold ".$most_quantity." ". $unit."/s":'N/A'; ?></td>
                			</tr>
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
                <h4>Are you sure you want to Void this transaction? This action is ireversible and will affect the inventory. <hr><p id="clients_id">Sales ID no. </p></h4>
              <form id="void_form" method="POST" class="form-horizontal" role="form" action="<?php echo base_url()."sales/void_trans"; ?>">
              <input type="hidden" name="clients_id" id="sales_id_field" value=""/>
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

<div class="modal" tabindex="-1" role="dialog" id="sad">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-danger">
        <h3 class="modal-title">LUGE KA SIR!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="center">
          <img src="<?php echo base_url('assets/images/leo.jpg'); ?>" height="350" width="250"/>
          <img src="<?php echo base_url('assets/images/ray.jpg'); ?>" height="350" width="250"/>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><?php if($net < 0) { ?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#sad').modal('show');
    });
</script>
<?php }?>
<script type="text/javascript">
$(document).ready(function() {
$(".openmodal").click(function() {
    var clients_id = this.getAttribute("clients_id");
    var stock_id = this.getAttribute("stock_id");
    var product_id = this.getAttribute("product_id");
    var quantity = this.getAttribute("quantity");
    var total_price = this.getAttribute("total_price");

    $("#clients_id").text("Transaction ID no."+ clients_id);
    $("#sales_id_field").val(clients_id);
    $("#stock_id").val(stock_id);
    $("#product_id").val(product_id);
    $("#quantity").val(quantity);
    $("#total_price").val(total_price);
    $('#void_modal').modal('show');
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
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 5,
    "order": [[ 0, "desc" ]]
    });} );


var dateFormat = "yy-mm-dd",
      from = $( "#date_from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          dateFormat: 'yy-mm-dd' 
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate",getDate( this ) );
        }),
      to = $( "#date_to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
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

</script>