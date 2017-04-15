<div class="form-box" id="login-box">
    <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
    <?php echo ($error) ? error_msg($error) : ''; ?>
    <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
    <div class="header">Forgot Password</div>
    <form action="<?php echo site_url('auth/reset_password/'.$code); ?>" method="post">

        <div class="body bg-gray">
            <div class="form-group">
                <input type="password" name="new" class="form-control" placeholder="password"/>
            </div>        
            <div class="form-group">
                <input type="password" name="new_confirm" class="form-control" placeholder="password confirm"/>
            </div>        
        </div>
        <?php echo form_input($user_id);?>
		<?php echo form_hidden($csrf); ?>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Reset Password</button>                  
        </div>
    </form>
</div>