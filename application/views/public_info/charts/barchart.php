<script>
$.ajax({
type: "POST",
url: "<?php echo base_url()."public_info/bar_data"; ?>",
data:{classification:0},
success: function(data){ 
		var current_cleared_pui = 101;// As of April 10, 200
		var current_cleared_pum = 471;// As of April 10, 200
		var cleared_pui = current_cleared_pui+parseInt(data.pui_cleared);
		var cleared_pum = current_cleared_pum+parseInt(data.pum_cleared);
		var ctx = document.getElementById("barchart");
		var barchart = new Chart(ctx, {
		  type: 'horizontalBar',
		  data: {
		    labels: [`ACTIVE PUI (${data.pui_active})`, `CLEARED PUI (${cleared_pui})`, `ACTIVE PUM (${data.pum_active})`, `CLEARED PUM (${cleared_pum})`, `TOTAL TESTED (${data.test_conducted})`, `NEGATIVE RESULT (${data.test_negative})`, `POSITIVE RESULT (${data.test_positive})`, `WAITING RESULT (${data.test_waiting})`],
		    datasets: [{
		      data: [data.pui_active, cleared_pui, data.pum_active,cleared_pum , data.test_conducted, data.test_negative, data.test_positive, data.test_waiting],
		      backgroundColor: [
		        'rgba(255, 99, 132, 0.2)',
		        'rgba(54, 162, 235, 0.2)',
		        'rgba(255, 206, 86, 0.2)',
		        'rgba(75, 192, 192, 0.2)',
		        'rgba(153, 102, 255, 0.2)',
		        'rgba(255, 159, 64, 0.2)',
		        'rgba(200, 199, 232, 0.2)',
		        'rgba(253, 102, 255, 0.2)',
		      ],
		      borderColor: [
		        'rgba(255,99,132,1)',
		        'rgba(54, 162, 235, 1)',
		        'rgba(255, 206, 86, 1)',
		        'rgba(75, 192, 192, 1)',
		        'rgba(153, 102, 255, 1)',
		        'rgba(255, 159, 64, 1)',
		        'rgba(200,99,132,1)',
		        'rgba(253, 102, 255, 1)',
		      ],
		      borderWidth: 1
		    }]
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
		      display: false
		    },
		   responsive: true,
		    cutoutPercentage: 30,
		  },
		});
	}
});
</script>