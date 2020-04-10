<style type="text/css">
@media print{
    @page{
        size: 216mm 356mm;
        size: landscape;
    }
}
</style>
<body onload="window.print()" onfocus="window.close()">
    <h2><b>IMMUNIZATION REPORT FOR THE MONTH OF <?= $month ?></U></b></h2><h3>Health Station: <u><b><?= ($poc!='')?$station->brgy:'ALL STATIONS'; ?> </U></b></h3>
    <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <td rowspan="3" width="15%" align="center">Name of Disease</td>
        <td colspan="7" align="center">By Age Group and by Sex</td>
      </tr>
      <tr>
        <td colspan="2">Under 1</td>
        <td colspan="2">1 & Above</td>
        <td colspan="3" bgcolor="grey">Total</td>
      </tr>
      <tr>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>T</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach($immunization_list as $value){
      ?>
      <tr>
        <td><?= $value->vaccine ?></td>
        <td><?= $value->m0 ?></td>
        <td><?= $value->f0 ?></td>
        <td><?= $value->m1 ?></td>
        <td><?= $value->f1 ?></td>
         <td><?= $value->mtotal ?></td>
        <td><?= $value->ftotal ?></td>
        <td><?= $value->total ?></td>
      </tr>
      <?php
      }
      ?>
    </tbody>
    </table>
</body>