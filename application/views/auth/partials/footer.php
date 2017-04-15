<!-- jQuery 2.2.3 -->
<script src="<?php echo site_url('assets/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo site_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?php echo site_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>