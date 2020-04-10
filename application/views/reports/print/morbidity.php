<style type="text/css">
@media print{
    @page{
        size: 216mm 356mm;
        size: landscape;
    }
}
</style>
<body onload="window.print()" onfocus="window.close()">
    <h2><b>3.14 MORBIDITY DISEASE REPORT FOR THE MONTH OF <?= $month ?></U></b></h2><h3>Health Station: <u><b><?= ($poc!='')?$station->brgy:'ALL STATIONS'; ?> </U></b></h3>
    <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <td rowspan="3" width="15%" align="center">Name of Disease</td>
        <td rowspan="3" width="8%" align="center">ICD Code</td>
        <td colspan="35" align="center">By Age Group and by Sex</td>
      </tr>
      <tr>
        <td colspan="2">Under 1</td>
        <td colspan="2">1-4</td>
        <td colspan="2">5-9</td>
        <td colspan="2">10-14</td>
        <td colspan="2">15-19</td>
        <td colspan="2">20-24</td>
        <td colspan="2">25-29</td>
        <td colspan="2">30-34</td>
        <td colspan="2">35-39</td>
        <td colspan="2">40-44</td>
        <td colspan="2">45-49</td>
        <td colspan="2">50-54</td>
        <td colspan="2">55-59</td>
        <td colspan="2">60-64</td>
        <td colspan="2">65-69</td>
        <td colspan="2">70&Over</td>
        <td colspan="3" bgcolor="grey">Total</td>
      </tr>
      <tr>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
        <td>M</td>
        <td>F</td>
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
      <?php foreach($morbidity_list as $value){
      ?>
      <tr>
        <td><?= $value->diagnosis ?></td>
        <td><?= $value->icd_code ?></td>
        <td><?= $value->m0 ?></td>
        <td><?= $value->f0 ?></td>
        <td><?= $value->m1 ?></td>
        <td><?= $value->f1 ?></td>
        <td><?= $value->m5 ?></td>
        <td><?= $value->f5 ?></td>
        <td><?= $value->m10 ?></td>
        <td><?= $value->f10 ?></td>
        <td><?= $value->m15 ?></td>
        <td><?= $value->f15 ?></td>
        <td><?= $value->m20 ?></td>
        <td><?= $value->f20 ?></td>
        <td><?= $value->m25 ?></td>
        <td><?= $value->f25 ?></td>
        <td><?= $value->m30 ?></td>
        <td><?= $value->f30 ?></td>
        <td><?= $value->m35 ?></td>
        <td><?= $value->f35 ?></td>
        <td><?= $value->m40 ?></td>
        <td><?= $value->f40 ?></td>
        <td><?= $value->m45 ?></td>
        <td><?= $value->f45 ?></td>
        <td><?= $value->m50 ?></td>
        <td><?= $value->f50 ?></td>
        <td><?= $value->m55 ?></td>
        <td><?= $value->f55 ?></td>
        <td><?= $value->m60 ?></td>
        <td><?= $value->f60 ?></td>
        <td><?= $value->m65 ?></td>
        <td><?= $value->f65 ?></td>
        <td><?= $value->m70 ?></td>
        <td><?= $value->f70 ?></td>
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