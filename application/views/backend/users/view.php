<div class="row">
        <div class="col-xs-12">
            <label>Nama</label>
            <div class="text-muted well well-sm" style="margin-top: 10px;">
               <?php echo (isset($user)) ? $user->username : ''; ?>
            </div>
            <label>Email</label>
                <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->email : ''; ?>
                </div>
            <label>Phone</label>
                <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->phone : ''; ?>
                </div>
            <label>Status</label>
                <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? status_label($user->active) : ''; ?>
                </div>
            <label>User Group</label>
              <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <ul>
                 <?php 
                  foreach ($groups as $group) {
                    echo '<li>'.$group->name.'</li>';
                  }
                 ?>
                 </ul>
              </div> 
        </div>
</div>