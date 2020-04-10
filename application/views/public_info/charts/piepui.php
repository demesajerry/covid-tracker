<script>
$.ajax({
type: "POST",
url: "<?php echo base_url()."public_info/pie_data"; ?>",
data:{classification:1},
success: function(data){ 
  var labels = [];
  var num = [];
  var color = [];
  var bgcolor = [];
    $.each( data.pie_data, function( key, val ) {
      labels.push(val.brgy+'('+val.confirmed_count+')');
      num.push(val.confirmed_count);
      if(val.brgy == 'Anos'){
        color.push('#FF0000');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Bagong Silang'){
        color.push('#800000');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Bambang'){
        color.push('#FFFF00');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Batong Malake'){
        color.push('#808000');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Baybayin'){
        color.push('#00FF00');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Bayog'){
        color.push('#008000');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Lalakay'){
        color.push('#00FFFF');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Maahas'){
        color.push('#008080');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Malinta'){
        color.push('#0000FF');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Mayondon'){
        color.push('#000080');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Tuntungin-Putho'){
        color.push('#FF00FF');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'San Antonio'){
        color.push('#800080');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Tadlac'){
        color.push('#FA8072');
        bgcolor.push('#999999');
      }
      if(val.brgy == 'Timugan'){
        color.push('#FFA07A');
        bgcolor.push('#999999');
      }
    });
  // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
// Pie Chart Example
var ctx = document.getElementById("myPuiChart");
ctx.width = 10000;
ctx.height = 10000;
var myPuiChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: labels,
    datasets: [{
      data:num,
      backgroundColor: color,
      hoverBackgroundColor: bgcolor,
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
 options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 50,
      yPadding: 50,
      displayColors: false,
      caretPadding: 50,
    },
    legend: {
      display: true
    },
     responsive: true,
        legend: {
          position: 'left'
        },
    cutoutPercentage: 30,
  },
});  
}
});

</script>
