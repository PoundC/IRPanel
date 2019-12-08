
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.0/jquery-migrate.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="/admin_l_t_e/js/bootstrap-notify.min.js"></script>
<script src="/dist/js/adminlte.js"></script>


<?php if($notLoggedIn == false) { ?>
<script>
    $.ajax({
        url: "/admin-l-t-e/notifications/growl",
        type: 'GET',
        cache: false,
        success: function (result) {
            result.forEach(function(data, index) {
                $.notify({
                    icon: data.type,
                    message: data.message,
                    url: data.link
                },{
                    delay: 0,
                    type: data.color.toLowerCase()
                });
            });
        }
    });
    var id = setInterval(function() {
        $.ajax({
            url: "/admin-l-t-e/notifications/growl",
            type: 'GET',
            cache: false,
            success: function (result) {
                result.forEach(function(data, index) {
                    $.notify({
                        icon: data.type,
                        message: data.message,
                        url: data.link
                    },{
                        delay: 0,
                        type: data.color.toLowerCase()
                    });
                });
            }
        });
    }, 15000);
</script>
<?php } ?>
