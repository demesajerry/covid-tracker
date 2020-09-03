       <style type="text/css">
         .scrollable{
          width: inherit;
          height: inherit;
          overflow: scroll;
         }
        .green {
          border: 1px solid green !important;
          background: green url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x !important;
          color: #fff;
          font-weight: bold;
        }
        .black {
          border: 1px solid gray !important;
          background: gray url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x !important;
          color: #fff;
          font-weight: bold;
        }
        .ic {
          border: 1px maroon !important;
          background: maroon url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x !important;
          color: #fff;
          font-weight: bold;
        }
        .oc {
          border: 1px #93FEED !important;
          background: #13CCAF url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x !important;
          color: #93FEED;
          font-weight: bold;
        }
        .icl{
          color: maroon;
        }
        .ocl{
          color: #13CCAF;
        }
        .dcl{
          color: gray;
        }
        .acl{
          color: #f6a828;
        }
        .rcl{
          color: green;
        }
        .cc{
          color: rgba(203, 110, 44, 1);
        }
        .nc{
          color: rgba(255, 72, 44, 1);
        }
        .tr{
          color: rgba(78, 115, 223, 1);
        }
        .nr{
          color: rgba(0, 63, 192, 1);
        }
        .td{
          color: rgba(105, 101, 101, 1);
        }
        .nd{
          color: rgba(0, 0, 0, 1);
        }
        .puil1{
          color: rgba(255,99,132,1);
        }
        .puil2{
          color: rgba(54, 162, 235, 1);
        }
        .puml1{
          color: rgba(255, 206, 86, 1);
        }
        .puml2{
          color: rgba(75, 192, 192, 1);
        }
        .test1{
          color: rgba(153, 102, 255, 1);
        }
        .test2{
          color: rgba(255, 159, 64, 1);
        }
        .test3{
          color: rgba(200,99,132,1);
        }
        .test4{
          color: rgba(253, 102, 255, 1);
        }
        .chart-pie {
          position: relative;
          height: 22rem;
          width: 100%;
        }
        .total{
          font-size: 46pt;
          color: blue !important;
        }
        .total_c{
          font-size: 56pt;
          color: blue !important;
        }
        .cleared{
          font-size: 46pt;
          color: red !important;
        }
        .right_border{
          border-right: 1px solid black;
        }
        .table td, .table th {
            padding: 0px !important;
            vertical-align: top;
            border-top: 1px solid #e3e6f0;
            text-align: center;
            margin-bottom: 0rem;
        }
        .table{
            margin-bottom: 0rem;
        }
        @media (min-width: 768px){
          .chart-pie {
            height: calc(25rem - 43px)!important;
          }
        }
       </style>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <table class="table">
                      <tr>
                        <td><center><b>COVID19 POSITIVE</b></center></td>
                      </tr>
                      <tr>
                        <td><center>TOTAL CONFIRMED TODAY</center></td>
                      </tr>
                      <tr>
                        <td class="total_c">
                            <center><?= $confirmed ?></center>
                        </td>
                      </tr>
                      <tr>
                        <td><center>TOTAL CONFIRMED YESTERDAY</center></td>
                      </tr>
                      <tr>
                        <td class="total_c">
                            <center><?= $confirmed_yesterday ?></center>
                        </td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>  
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <table class="table">
                      <tr>
                        <td colspan="2"><center><b>PERSONS UNDER INVESTIGATION (PUI)</b></center></td>
                      </tr>
                        <tr>
                          <td colspan="2"><center><b>TODAY</b></center></td>
                        </tr>
                      <tr>
                        <td width="50%"><center>TOTAL</center></td>
                        <td width="50%"><center>CLEARED</center></td>
                      </tr>
                      <tr>
                        <td class="total">
                            <?= $pui ?>
                        </td>
                        <td class="cleared">
                            <?= $pui_cleared ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"><center>YESTERDAY</center></td>
                      </tr>
                      <tr>
                        <td width="50%"><center>TOTAL</center></td>
                        <td width="50%"><center>CLEARED</center></td>
                      </tr>
                      <tr>
                        <td class="total">
                            <?= $pui_yesterday ?>
                        </td>
                        <td  class="cleared">
                            <?= $pui_cyesterday ?>
                        </td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>  

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <td colspan="2"><center><b>PERSONS UNDER MONITORING (PUM)</b></center></td>
                          </tr>
                          <tr>
                            <td colspan="2"><center><b>TODAY</b></center></td>
                          </tr>
                          <tr>
                            <td width="50%"><center>TOTAL</center></td>
                            <td width="50%"><center>CLEARED</center></td>
                          </tr>
                        </thead>
                        <tr>
                          <td class="total">
                              <?= $pum ?>
                          </td>
                          <td class="cleared">
                              <?= $pum_cleared ?>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2"><center>YESTERDAY</center></td>
                        </tr>
                          <tr>
                            <td width="50%"><center>TOTAL</center></td>
                            <td width="50%"><center>CLEARED</center></td>
                          </tr>
                        <tr>
                          <td class="total">
                              <?= $pum_yesterday ?>
                          </td>
                          <td  class="cleared">
                              <?= $pum_cyesterday ?>
                          </td>
                        </tr>
                      </table>
                  </div>
                </div>
              </div>  
            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-default text-uppercase mb-1">Active Confirmed Case Under Quarantine / Recovery</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><i class="fas fa-user-shield fa-2x text-gray-300"></i></div>
                    </div>
                    <div class="col-auto font20">
                      <?= $active_case ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <td colspan="2"><center><b>PERSONS UNDER INVESTIGATION (PUI)</b></center></td>
                          </tr>
                          <tr>
                            <td width="50%"><center>NEW CASE/S</center></td>
                            <td width="50%"><center>CLEARED TODAY</center></td>
                          </tr>
                        </thead>
                        <tr>
                          <td class="total">
                              <?= $pui_today ?>
                          </td>
                          <td class="cleared">
                              <?= $pui_ctoday ?>
                          </td>
                        </tr>
                        </tr>
                      </table>
                  </div>
                </div>
              </div>  

            <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <td colspan="2"><center><b>PERSONS UNDER MONITORING (PUM)</b></center></td>
                          </tr>
                          <tr>
                            <td width="50%"><center>NEW CASE/S</center></td>
                            <td width="50%"><center>CLEARED TODAY</center></td>
                          </tr>
                        </thead>
                        <tr>
                          <td class="total">
                              <?= $pum_today ?>
                          </td>
                          <td class="cleared">
                              <?= $pum_ctoday ?>
                          </td>
                        </tr>
                        </tr>
                      </table>
                  </div>
                </div>
              </div>  
        
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Confirm Case Monitoring</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle cc"></i> Total Confirmed Case
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle nc"></i> New Cases
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle tr"></i> Total Recovered
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle nr"></i> New Recovery
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle td"></i> Total Deaths
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle nd"></i> New Death
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>          

          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">PUI & PUM Monitoring</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="barchart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle puil1"></i> ACTIVE PUI
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle puil2"></i> CLEARED PUI
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle puml1"></i> ACTIVE PUM
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle puml2"></i> CLEARED PUM
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle test1"></i> TOTAL TESTED
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle test2"></i> NEGATIVE RESULTS
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle test3"></i> POSITIVE RESULTS
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle test4"></i> WAITING RESULTS
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Confirmed Case per Barangay</h6>
               </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">PUI per Barangay</h6>
               </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPuiChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">PUM Per Barangay</h6>
               </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPumChart" width="1000" height="5000"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-12">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Patient Links</h6>
               </div>
                <!-- Card Body -->
                <div class="card-body scrollable">
                  <div class="row">
                    <div class="col-xl-4 col-md-12 mb-12">
                      <i class="fas fa-circle acl"></i> ACTIVE CASE RESIDENT OF LOS BAÑOS
                    </div>
                    <div class="col-xl-4 col-md-12 mb-12">
                      <i class="fas fa-circle dcl"></i> DECEASED CASE RESIDENT OF LOS BAÑOS
                    </div>
                    <div class="col-xl-4 col-md-12 mb-12">
                      <i class="fas fa-circle rcl"></i> RECOVERED CASE RESIDENT OF LOS BAÑOS
                    </div>
                    <div class="col-xl-6 col-md-12 mb-12">
                      <i class="fas fa-circle icl"></i> CONFINED CASE NOT RESIDENT OF LOS BAÑOS
                    </div>
                    <div class="col-xl-6 col-md-12 mb-12">
                      <i class="fas fa-circle ocl"></i> CONFIRMED CASE OUTSIDE OF LOS BAÑOS
                    </div>
                  </div>
                  <div class="chart pt-12 pb-12" id="tree">
                  </div>
                  <div class="mt-4 text-center small">
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    <?php  $this->load->view('public_info/charts/chart'); ?>
    <?php  $this->load->view('public_info/charts/area-chart'); ?>
    <?php  $this->load->view('public_info/charts/pie'); ?>    
    <?php  $this->load->view('public_info/charts/piepui'); ?>    
    <?php  $this->load->view('public_info/charts/piepum'); ?>    
    <?php  $this->load->view('public_info/charts/barchart'); ?>    
    <?php  $this->load->view('public_info/charts/tree'); ?>
