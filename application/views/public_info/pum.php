<style>
  .col{
    flex-basis:100px !important;
  }
  a.disable {
  pointer-events: none;
  cursor: default;
}
#pagination .active{
  background-color: #c7d0f3;
}
</style>
<?php $classification = '2'; ?>
<!-- Begin Page Content -->
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ACTIVE PUM</h1>
          </div>
          <!-- Content Row -->
          <div class="row  display">
            <!--DISPLAY LIST-->
          </div>
           <!-- Paginate -->
          <div class="row">
            <div style='margin-top: 10px;' id='pagination'></div>
          </div>

          <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    <?php  $this->load->view('public_info/charts/chart'); ?>
<script>
var baseurl = "<?php echo base_url();?>"; 
var classification = "<?php echo $classification;?>"; 
$(document).ready(function() {
$('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       loadPagination(pageno);
     });

loadPagination(0);
function loadPagination(pageno){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url('public_info/patient_data/')?>"+pageno,
  data: {classification:classification},
  //data:formData,
  success: function(data){ 
    $('#pagination').html(data.pagination);
    createDisplay(data.result,data.row);
    }
  });
}

function createDisplay(result,sno){
    var display='', icon, id, color;
    sno = Number(sno);
    $.each(result, function( key, val ) {
      icon = val.gender=='MALE'?'user':'female';
      color = val.status == 'DECEASED'?'dark':'info';
      id = val.id<10?'0'+val.id:val.id;
      sno+=1;
      display += `<div class="col-xl-6 col-md-6 mb-4">
                  <div class="card border-left-${color} shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-3">
                          <div class="text-lg font-weight-bold text-primary text-uppercase mb-1 text-title text-center">
                           <i class="fas fa-${icon} fa-3x text-gray-300"></i>${val.patient_id}
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1 text-center">
                            ${val.gender}, ${val.age} ${val.age_type} 
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1 text-center">
                           <hr>
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1 text-center">
                          Barangay: <br><p class="text-info">${val.brgy}</p>
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"> </div>
                        </div>
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1">
                            Travel History: ${val.travel_history}<hr>
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1">
                            Current Status: ${val.status}<hr>
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1">
                            Current Condition / Location:  ${val.current_condition}, ${val.current_location}<hr>
                          </div>
                          <div class="text-xs font-weight-bold text-default text-uppercase mb-1">
                            Symptoms: ${val.symptoms}<hr>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                `;
      $('.display').html(display);
    });
}
});  
</script>
