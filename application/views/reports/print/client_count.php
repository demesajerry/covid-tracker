<style type="text/css">
@media print{
    @page{
        size: 216mm 356mm;
        size: landscape;
    }
}
</style>
<body onload="window.print()" onfocus="window.close()">
    <h2><b>CLIENT COUNT FROM <?= date("F d, Y", strtotime($from)) .' to '. date("F d, Y", strtotime($to)) ?></U></b></h2><h3>Health Station: <u><b><?= ($poc!='')?$station->brgy:'ALL STATIONS'; ?> </U></b></h3>
    <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <td>DAY</td>
        <td>MALE</td>
        <td>FEMALE</td>
        <td>TOTAL</td>
      </tr>
    </thead>
    <tbody>
      <?php 
      $total_male = 0;
      $total_female = 0;
      $total_all = 0;
      foreach($client_count as $value){
      $total_male += $value->count_male;
      $total_female += $value->count_female;
      $total_all += $value->total;
      ?>
      <tr>
        <td><?= $value->dov_text ?></td>
        <td><?= $value->count_male ?></td>
        <td><?= $value->count_female ?></td>
        <td><?= $value->total ?></td>
      </tr>
      <?php
      }
      ?>
      <tr>
        <td>TOTAL</td>
        <td><?= $total_male ?></td>
        <td><?= $total_female ?></td>
        <td><?= $total_all ?></td>
      </tr>
    </tbody>
    </table>
</body>