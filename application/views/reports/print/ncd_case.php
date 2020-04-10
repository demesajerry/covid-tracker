<style type="text/css">
    hr {
      margin-top: 5px;
      margin-bottom: 5px;
      border-top: 1px solid #000;
    }
@media print{
    @page{
        size: 216mm 356mm;
        size: landscape;
    }
}
</style>
<body onload="window.print()" onfocus="window.close()">
    <h2><b>NEW NCD CASE  <?= $month ?></U></b></h2><h3>Health Station: <u><b><?= ($poc!='')?$station->brgy:'ALL STATIONS'; ?> </U></b></h3>
    <table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="5%">No.</th>
            <th width="25%">Name</th>
            <th width="5%">Sex</th>
            <th width="5%">Age</th>
            <th width="10%">Birthday</th>
            <th width="10%">Address</th>
            <th width="10%">Philhealth</th>
            <th width="15%">Hypertension</th>
            <th width="15%">Diabetes</th>
        </tr>
    </thead>
    <tbody>
      <?php 
      foreach($ncd_list as $key => $value){
        $birthday =  date('F d, Y', strtotime($value->birthday));
        $age = date_diff(date_create($value->birthday), date_create('now'))->y."y";
        $yr_old = date_diff(date_create($value->birthday), date_create('now'))->y;
        $m = date_diff(date_create($value->birthday), date_create('now'))->m."m";
        $d = date_diff(date_create($value->birthday), date_create('now'))->d."d";
        $hypertension = ($value->hypertension!="")?$value->hypertension.'<hr>'.$value->station_h:'';
        $diabetes = ($value->diabetes!="")?$value->diabetes.'<hr>'.$value->station_d:'';
      ?>
      <tr>
        <td><?= $key+1 ?></td>
        <td><?= $value->fullname ?></td>
        <td><?= $value->gender ?></td>
        <td><?= $age ?></td>
        <td><?= $birthday ?></td>
        <td><?= $value->brgy ?></td>
        <td><?= $value->philhealth_no ?></td>
        <td><?= $hypertension ?></td>
        <td><?= $diabetes ?></td>
      </tr>
      <?php
      }
      ?>
    </tbody>
    </table>
</body>