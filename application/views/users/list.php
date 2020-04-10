<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Users
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Users</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add_users" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Users
                            </button>
                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="add_users_modal" tabindex="-1" role="dialog" 
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
                                        <p id="modal_title"></p>
                                    </h4>
                                </div>
                                
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    
                                  <form method="POST" id="form1" class="form-horizontal" role="form" action="<?php echo base_url()."users/add_users"; ?>">
                                    <input type="hidden" name="userid" id="userid">
                                     <table class="table table-bordered table-hover">
                                       <tr>
                                            <td>First Name: <input type="text" name="fname" id="fname" class="form-control uppercase" required="required"/></td>
                                            <td>Last Name: <input type="text" name="lname" id="lname" class="form-control uppercase" required="required"/></td>
                                            <td>Middle Name:<input type="text" name="mname" id="mname" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>username: </td>
                                            <td colspan="3"><input type="text" name="username" id="username" class="form-control" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Password: </td>
                                            <td colspan="3"><input type="password" name="password" id="password"  class="form-control" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Access Type: </td>
                                            <td colspan="3">
                                                <select name="access[]" id="access" class="form-control select2"  multiple="multiple" style="width: 100%">
                                                    <option value="Admin">Administrator</option>
                                                    <option value="Encode">Encoder</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">Client / Patient Photo :</td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <div class="col-sm-12">
                                              <div class="col-sm-6">
                                                <div id="my_camera"></div>
                                                <br/>
                                                <input type=button value="Capture Photo" class="btn btn-info" onClick="take_snapshot()">
                                                <input type="hidden" name="image" class="image-tag">
                                              </div>
                                              <div class="col-sm-6">
                                                <div id="results"></div>
                                              </div>
                                            </div>
                                          </td>
                                        </tr>
                                     </table>
                                      <!--SUBMIT BUTTON -->
                                    <div class="modal-footer" align="right">
                                      <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">
                                             Close
                                          </button>
                                          <button type="submit" class="btn btn-success" id="submit_add">Save</button>
                                        </div>
                                      </div>
                                     </div>
                                    </form>
                                </div><!--end Modal body-->
                            </div><!--end Modal content-->
                        </div><!--end Modal dialog-->
                    </div><!--end modal receive-->
                <hr />
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="10%">Users ID</th>
                              <th width="30%">Full Name</th>
                              <th width="20%">Username</th>
                              <th width="10%">Access</th>
                              <th width="10%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($users_list != false){
                            foreach($users_list as $users){ 
                        ?>
                        <tr>
                            <td><?php echo $users->userid; ?></td>
                            <td><?php echo $users->fname.' '.$users->lname; ?></td>
                            <td><?php echo $users->username; ?></td>
                            <td><?php echo $users->access; ?></td>
                            <td>            
                              <a class="edit_modal" href="#" 
                              userid="<?php echo $users->userid; ?>" 
                              fname="<?php echo $users->fname; ?>" 
                              lname="<?php echo $users->lname; ?>" 
                              mname="<?php echo $users->mname; ?>" 
                              username="<?php echo $users->username; ?>" 
                              password="<?php echo $users->password; ?>" 
                              access="<?php echo $users->access; ?>"    
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
                            </td>
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
    </section>

</div>

<script>
$(document).ready(function() {
  $("#submit_add").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#form1").submit();
  });
  $("#add_users").click(function() {
      webcam();
      $('#form1')[0].reset();
      $("#modal_title").text('Add User');
      //set selected value for select2
      $('#station_id').val("");
      //trigger change for select2
      $('#station_id').select2().trigger('station_id');

      //set selected value for select2
      $('#access').val("");
      //trigger change for select2
      $('#access').select2().trigger('access');

      document.getElementById('form1').action =  '<?php echo base_url()."users/add_users"; ?>';
      $('#add_users_modal').modal('show');
});

  $(".edit_modal").click(function() {
      webcam();
      var dt = new Date();
      $('#form1')[0].reset();
      var userid = this.getAttribute("userid");
      var fname = this.getAttribute("fname");
      var lname = this.getAttribute("lname");
      var mname = this.getAttribute("mname");
      var username = this.getAttribute("username");
      var password = this.getAttribute("password");
      var station_id = this.getAttribute("station_id");
      var access = this.getAttribute("access");
      var room = this.getAttribute("room");
      var accessarray = access.split(',');
      $("#userid").val(userid);
      $("#fname").val(fname);
      $("#lname").val(lname);
      $("#mname").val(mname);
      $("#username").val(username);
      $("#password").val(password);
      $("#room").val(room);
      //set selected value for select2
      $('#station_id').val(station_id);
      //trigger change for select2
      $('#station_id').select2().trigger('station_id');
      $('#access').val(accessarray).trigger('change');
      $("select option[value='"+access+"']").attr("selected","selected");
      $("#modal_title").text('Edit User');
      $("#results").html('<img src="<?php echo base_url(); ?>assets/images/user_photo/user'+userid+'.jpg?<?php echo time(); ?>" class="user-image" width="250px" height="190px">');
      document.getElementById('form1').action =  '<?php echo base_url()."users/edit_users"; ?>';
      $('#add_users_modal').modal('show');
  });

    $('#viewresult').DataTable({
            responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10
    });


    $( "#datepicker" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
    $( "#birthday" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
  
});
</script>

