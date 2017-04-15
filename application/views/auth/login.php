<div class="login-logo">
	<img src="<?php echo base_url(); ?>assets/img/logo.png" alt="logo" class="text-center" width="100" />
	<!--a href="<?php echo site_url(); ?>"><b>e-Rapor SMK</b></a-->
</div>
<div class="login-box-body">
	<p class="login-box-msg"><a href="<?php echo site_url(); ?>"><b>e-Rapor SMK</b></a></p>
    <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
    <?php echo ($error) ? error_msg($error) : ''; ?>
    <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
    <form action="<?php echo site_url('admin/auth/'); ?>" method="post">
        <div class="form-group has-feedback">
			<input type="text" name="email" class="form-control" placeholder="Email/NUPTK/NISN"/>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="password" class="form-control" placeholder="Password"/>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-8">
				<div class="checkbox icheck">
					<label><input type="checkbox"> Remember Me</label>
				</div>
			</div>
			<!-- /.col -->
			<div class="col-xs-4">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
			</div>
			<!-- /.col -->
		</div>
        <?php
		/*<div class="footer" style="display:none;">                                                               
            <button type="submit" class="btn bg-olive col-md-5">Masuk</button>  
			<a href="<?php echo site_url('auth/forgot_password'); ?>" class="btn btn-danger col-md-5 pull-right">Lupa password</a>  
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		</div>
		*/
		?>
    </form>
</div>