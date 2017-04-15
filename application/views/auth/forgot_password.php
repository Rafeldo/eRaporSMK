<div class="form-box" id="login-box">
    <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
    <?php echo (isset($error) && !empty($error)) ? error_msg($error) : ''; ?>
    <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
    <div class="header">Forgot Password</div>
    <form action="<?php echo site_url('auth/forgot_password'); ?>" method="post">

        <div class="body bg-gray">
        	<h5>Please enter your Email so we can send you an email to reset your password.</h5>
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="email"/>
            </div>        
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Send Email</button>        
        </div>
    </form>
</div>