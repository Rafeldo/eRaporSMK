<div class="row">
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-primary">	
		<form role="form" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data">
		<div class="box-body">
			<div class="row">
				<div class="col-xs-8">
						 <div class="form-group col-xs-12">
						    <label for="username">Nama</label>
						    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>">
						    <?php echo form_error('username'); ?>
						  </div>
						  <div class="form-group col-xs-12">
						    <label for="phone">Handphone</label>
						    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user->phone; ?>">
						    <?php echo form_error('phone'); ?>
						  </div>
						   <div class="form-group col-xs-12">
						    <label for="email">Email</label>
						    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>">
							<?php echo form_error('email'); ?>
						  </div>
						  <div class="form-group col-xs-12">
						    <label for="password">Password (Biarkan kosong jika tidak ingin merubah)</label>
						    <input type="password" class="form-control" id="password" name="password" value="">
						    <?php echo form_error('password'); ?>
						  </div>

						  <div class="form-group col-xs-12">
						    <label for="password_confirm">Konfirmasi Password</label>
						    <input type="password" class="form-control" equalTo='#password' id="password_confirm" name="password_confirm" value="">
						    <?php echo form_error('password_confirm'); ?>
						  </div>
				</div>
				<div class="col-lg-4 ">
						<div class="hline"></div>
						<div class="col-lg-12">
						<p><img src="<?php echo  ($user->photo != '') ? base_url().PROFILEPHOTOSTHUMBS.$user->photo : base_url().'assets/img/300.gif';  ?>" class="img-responsive thumbnail center-block" alt="Responsive image"/></p>
						<label>Ganti foto</label>
						<input type="file" name="profilephoto" />
						</div>
					</div>
			</div>
		
		</div>	
		<div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div> 
		</form>
	</div>
</div>
</div>

