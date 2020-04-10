
 <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/admin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/admin2/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/admin2/js/sb-admin-2.min.js"></script>
  <!-- Page level plugins -->
  <script src="<?php echo base_url(); ?>assets/admin2/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
	 function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function getDates(startDate, stopDate) {
    var dateArray = new Array();
    var currentDate = startDate;
    while (currentDate <= stopDate) {
    	current_datetime = new Date (currentDate);
    	var current_day = current_datetime.getDate()<10?'0'+current_datetime.getDate():current_datetime.getDate();
    	var current_month = ("0" + (current_datetime.getMonth() + 1)).slice(-2);
    	formatted_date = current_datetime.getFullYear() + "-" + current_month + "-" + current_day;
        dateArray.push(formatted_date);
        currentDate = currentDate.addDays(1);
    }
    return dateArray;
}

</script>