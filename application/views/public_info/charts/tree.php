<script type="text/javascript">
$(function () {
    $("#tree").jHTree({
            type: "POST",
            url: "<?php echo base_url()."public_info/tree_data"; ?>",
            data:{classification:0},
            nodeDropComplete: function (event, data) {
            }
    });
});

</script>
