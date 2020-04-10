<style type="text/css">
@media print{
    @page{
        size: 216mm 356mm;
        size: landscape;
    }
}
    hr {
      display: block;
      margin-top: 0.1em;
      margin-bottom: 0.1em;
      margin-left: auto;
      margin-right: auto;
      border-width: 1px;
    }
</style>
<body onload="window.print()" onfocus="window.close()">
  <?php
    if($from == $to){
      $date_title = date("F d, Y", strtotime($from));
    }else{
      $date_title = date("F d, Y", strtotime($from)) .' to '. date("F d, Y", strtotime($to));
    }
  ?>
    <h2><b>Consultation Summarya <?= ($from!="")?$date_title:''; ?></U></b></h2>
    <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <td>#</td>
        <td>Client Name</td>
        <td>Gender</td>
        <td>Date of Visit</td>
        <td>PF Asked(Cash)</td>
        <td>PF Asked(HMO)</td>
        <td>Actual Payment(Cash)</td>
        <td>Actual Payment(HMO)</td>
      </tr>
    </thead>
    <tbody>
      <?php 
      $num = 0;
      $total_male = 0;
      $total_female = 0;
      $total_all = 0;
      $total_pf = 0;
      $total_ap = 0;
      $total_pfh = 0;
      $total_aph = 0;
      foreach($cs_list as $value){
        $total_all++;
        $total_pf+=($value->consultation_fee!=null)?$value->consultation_fee:0;
        $total_ap+=($value->actual_payment!=null)?$value->actual_payment:0;
        $total_pfh+=($value->hmo_fee!=null)?$value->hmo_fee:0;
        $total_aph+=($value->hmo_payment!=null)?$value->hmo_payment:0;
        if($value->gender == 'MALE'){
          $total_male++;
        }else if($value->gender == 'FEMALE'){
          $total_female++;
        }
        $consultation_fee = ($value->consultation_fee!=null)?$value->consultation_fee:'';
        $hmo_fee = ($value->hmo_fee!=null)?$value->hmo_fee:'';
        $actual_payment = ($value->actual_payment!=null)?$value->actual_payment:'';
        $hmo_payment = ($value->hmo_payment!=null)?$value->hmo_payment:'';
      ?>
      <tr>
        <td><?= $total_all ?></td>
        <td><?= $value->fullname ?></td>
        <td><?= $value->gender ?></td>
        <td><?= $value->dov ?></td>
        <td><?= $consultation_fee ?></td>
        <td><?= $hmo_fee ?></td>
        <td><?= $actual_payment ?></td>
        <td><?= $hmo_payment ?></td>
      </tr>
      <?php
      }
      ?>
      <tr>
        <td colspan="2">Total Client: <?= $total_all; ?></td>
        <td>Male: <?= $total_male ?><hr>Female: <?= $total_female ?></td>
        <td></td>
        <td>Total Pf Asked(Cash)<hr> <?= $total_pf ?></td>
        <td>Total Pf Asked(HMO)<hr> <?= $total_pfh ?></td>
        <td>Total Actual Payment(Cash)<hr> <?= $total_ap ?></td>
        <td>Total Actual Payment(HMO)<hr> <?= $total_aph ?></td>
      </tr>
    </tbody>
    </table>
</body>