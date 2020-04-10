<script>
  function convert_date(date){
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = from.getMonth();
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    converted_date = monthNames[month] + ' ' + day;
    return converted_date;
  }

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
$.ajax({
type: "POST",
url: "<?php echo base_url()."public_info/area_data"; ?>",
//data:formData,
success: function(data){ 
            var labels = [];
            var num = [];
            var new_cases = [];
            var recovered = [];
            var new_recovered = [];
            var death = [];
            var new_death = [];
            var color = [];
            var dateArray = getDates(new Date('03-14-2020'), (new Date()));
            var total =0;
            var total_recovered =0;
            var total_death =0;
            for (i = 0; i < dateArray.length; i ++ ) {
              labels.push(convert_date(dateArray[i]));
              num.push(total);
              new_cases.push(0);
              recovered.push(total_recovered);
              new_recovered.push(0);
              death.push(total_death);
              new_death.push(0);
              color.push(getRandomColor());
              $.each( data.area_data, function( key, val ) {
                if(dateArray[i] == val.result_date){
                  total += parseInt(val.num);
                  num[i] = total;
                  new_cases[i] = val.num;
                  data.area_data.splice(key, 0);                  
                  return false;                
                }
              });
              $.each( data.recoveries_data, function( key, val ) {
                if(dateArray[i] == val.date){
                  total_recovered += parseInt(val.num);
                  recovered[i] = total_recovered;
                  new_recovered[i] = val.num;
                  data.recoveries_data.splice(key, 0);                  
                  return false;                
                }
              });
              $.each( data.death_data, function( key, val ) {
                if(dateArray[i] == val.date){
                  total_death += parseInt(val.num);
                  death[i] = total_death;
                  new_death[i] = val.num;
                  data.death_data.splice(key, 0);                  
                  return false;                
                }
              });
            }   
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: [{
                  label: "Total Confirmed case",
                  lineTension: 0.3,
                  backgroundColor: "rgba(203, 110, 44, 0.1)",
                  borderColor: "rgba(203, 110, 44, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(203, 110, 44, 1)",
                  pointBorderColor: "rgba(203, 110, 44, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(203, 110, 44, 1)",
                  pointHoverBorderColor: "rgba(230, 110, 44, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: num,
                },
                {
                  label: "New Cases",
                  lineTension: 0.3,
                  backgroundColor: "rgba(255, 72, 44, 0.5)",
                  borderColor: "rgba(255, 72, 44, 1",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(255, 72, 44, 1)",
                  pointBorderColor: "rgba(255, 72, 44, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(255, 72, 44, 1)",
                  pointHoverBorderColor: "rgba(255, 100, 44, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: new_cases,
                },
                {
                  label: "Total Recovered",
                  lineTension: 0.5,
                  backgroundColor: "rgba(78, 115, 223, 0.05)",
                  borderColor: "rgba(78, 115, 223, 1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointBorderColor: "rgba(78, 115, 223, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                  pointHitRadius: 15,
                  pointBorderWidth: 5,
                  data: recovered,
                },                {
                  label: "New Recoveries",
                  lineTension: 0.3,
                  backgroundColor: "rgba(0, 63, 192, 0.5)",
                  borderColor: "rgba(0, 63, 192, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(0, 63, 192, 1)",
                  pointBorderColor: "rgba(0, 63, 192, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(0, 63, 192, 1)",
                  pointHoverBorderColor: "rgba(50, 63, 192, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: new_recovered,
                },
               {
                  label: "Total Death",
                  lineTension: 0.3,
                  backgroundColor: "rgba(75, 71, 71, 0.5)",
                  borderColor: "rgba(105, 101, 101, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(105, 101, 101, 1)",
                  pointBorderColor: "rgba(105, 101, 101, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(105, 101, 101, 1)",
                  pointHoverBorderColor: "rgba(145, 101, 101, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: death,
                },                {
                  label: "New Death",
                  lineTension: 0.5,
                  backgroundColor: "rgba(0, 0, 0, 0.5)",
                  borderColor: "rgba(0, 0, 0, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(0, 0, 0, 1)",
                  pointBorderColor: "rgba(0, 0, 0, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(0, 0, 0, 1)",
                  pointHoverBorderColor: "rgba(50, 0, 0, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: new_death,
                },
                  ],
              },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 5,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ' : ' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
            });
  }
});

</script>