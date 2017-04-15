<div class="row">
    <?php echo form_open("admin/guru/deactivate/".$user->id);?>
      <?php if(isset($user)){
        echo form_hidden('id', $user->id);
      }
      ?>
        <div class="col-xs-12">
			<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
            <div class="text-muted well well-sm" style="margin-top: 10px;">
               <?php echo (isset($user)) ? $user->username : ''; ?>
            </div>
            <div class="form-group col-xs-12" style="padding-left:25px">
                  <div class="radio">
                      <label>
                          <input type="radio" name="confirm" id="yes" value="yes" checked>
                           <small class="badge bg-green">YES</small>
                      </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="confirm" id="no" value="no">
                            <small class="badge bg-red">NO</small>
                        </label>
                    </div>
            </div>
            </div>
        <div class="box-footer clearfix">
        <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-primary  pull-right">Submit</button>
        </div>
        </div>
        <?php echo form_hidden($csrf); ?>
      <?php echo form_close();  ?>
</div>
