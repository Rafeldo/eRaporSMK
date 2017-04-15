<div class="row">
<!-- left column -->
<div class="col-md-12">
  <!-- general form elements -->
  <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
  <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
  <div class="box box-primary">

<?php echo (isset($message) && $message != '') ? error_msg($message) : '';?>

<?php echo form_open("auth/create_user");?>

<div class="box-body">
      <div class="row">
      <div class="col-xs-7">    
      <div class="form-group col-xs-12">
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </div>

      <div class="form-group col-xs-12">
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </div>
      </div>
      </div>
    </div>
<div class="box-footer clearfix">
      <div class="form-group col-xs-7"><button type="submit" class="btn btn-primary  pull-right">Submit</button></div>
</div>
<?php echo form_close();?>
            </div>
      </div>
</div>
