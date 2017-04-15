<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
        <table class="table table-bordered table-striped table-hover datatable">
            <thead>
            <tr>
                <th style="width: 2%"></th>
                <th style="width: 10%">Nama</th>
                <th style="width: 15%">Email</th>
                <th style="width: 10%">No. Handphone</th>
                <th style="width: 15%">User Type</th>
                <th style="width: 5%">Status</th>
                <th style="width: 20%" class="text-center">Action</th>
            </tr>
            </thead>
            <?php 
            	if(!empty($users)) { 
                    $count = 1;
                    $loggeduser = $this->ion_auth->user()->row();
            	foreach ($users as $user) {
                    if($loggeduser->id != $user->id){
                ?>
                	<tr>
                    <td><?php echo $count; ?>.</td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $user->phone; ?></td>
                    <td><?php $groups = $this->ion_auth->get_users_groups($user->id)->result_array(); 
                         echo implode(', ', array_map(function ($entry) {
						 	return $entry['description'];
						}, $groups));
                    ?>
                    </td>
                    <td><?php echo status_label($user->active); ?></td>
                    <td class="text-center">
                        <?php echo view_btn('admin/users/view/'.$user->id,'Detil'); ?>
                        <?php echo edit_btn('admin/users/edit/'.$user->id); ?>
                        <?php echo ($user->active == 1)  ? deactivate_btn('admin/users/deactivate/'.$user->id,'Non Aktifkan') : activate_btn('admin/users/activate/'.$user->id,'Aktifkan'); ?>
                        <?php echo delete_btn('admin/users/delete/'.$user->id,'Hapus'); ?>
                    </td>
                	</tr>
            <?php		$count++;	# code...
            		}}
            	} ?>
            
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>