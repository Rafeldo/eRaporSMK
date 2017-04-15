<div class="row">
<!-- left column -->
<div class="col-md-12">

<div class="box box-primary">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<?php echo (isset($message) && $message != '') ? error_msg($message) : '';?>

<?php echo form_open(uri_string());?>

<div class="box-body">
    <div class="row">
      <div class="col-xs-7"> 
      <div class="form-group col-xs-12">
           <label>Nama</label>
            <?php echo form_input($username);?>
      </div>
      <div class="form-group col-xs-12">
            <label>Email</label>
            <?php echo form_input($email);?>
      </div>
      <div class="form-group col-xs-12">
            <label>User Type</label><br />
            <?php 
			foreach($currentGroups as $g){
				$cg[] = $g['id'];
			}
			?>
			<?php foreach ($groups as $k=>$group):?>
			<div class="checkbox">
			<label><input type="checkbox" class="icheck" name="user_type[]" value="<?php echo $group['id'];?>"<?php echo (in_array($group['id'],$cg)) ? ' checked="checked"' : ''; ?> /><?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?></label>
			</div>
			<?php endforeach?>
      </div>

      <div class="form-group col-xs-12">
            <label>Password (Leave blank if not changing password)</label>
            <?php echo form_input($password);?>
      </div>

      <div class="form-group col-xs-12">
            <label>Password Confirmation</label>
            <?php echo form_input($password_confirm);?>
      </div>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>
              </div>
          </div>
        </div>

        <div class="box-footer clearfix">
            <div class="form-group col-xs-7">
          <button type="submit" class="btn btn-primary  pull-right">Submit</button>
      </div>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>
