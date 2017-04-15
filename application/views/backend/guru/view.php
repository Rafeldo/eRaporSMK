<?php
//$guru = $user->user[0];
?>
<div class="row">
        <div class="col-xs-6">
            <label>Nama</label>
            <div class="well well-sm" style="margin-top: 10px;">
               <?php echo (isset($user)) ? $user->nama: ''; ?>
            </div>
             <label>NUPTK</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->nuptk : ''; ?>
                </div>
            <label>Email</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->email : ''; ?>
                </div>
            <label>Jenis Kelamin</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->jenis_kelamin : ''; ?>
                </div>
            <label>No. HP</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->no_hp : ''; ?>
                </div>
            <label>Status</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? status_label($user->active) : ''; ?>
                </div>
			<?php //if($this->ion_auth->in_group('admin')){ ?>
            <label>Password</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->password : ''; ?>
                </div>
			<?php //} ?>
        </div>
		<div class="col-xs-6">
            <label>Tempat Lahir</label>
            <div class="well well-sm" style="margin-top: 10px;">
               <?php echo (isset($user)) ? $user->tempat_lahir: ''; ?>
            </div>
             <label>Tanggal Lahir</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php 
				   $tanggal_lahir	= date_create($user->tanggal_lahir);
				   echo (isset($user)) ? date_format($tanggal_lahir,'d-m-Y') : ''; ?>
                </div>
            <label>Status Kepegawaian</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->status_kepegawaian : ''; ?>
                </div>
            <label>Jenis PTK</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->jenis_ptk: ''; ?>
                </div>
            <label>Agama</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? get_agama($user->agama) : ''; ?>
                </div>
            <label>Alamat</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->alamat : ''; ?>
                </div>
			<?php //if($this->ion_auth->in_group('admin')){ ?>
            <label>RT/RW</label>
                <div class="well well-sm no-shadow" style="margin-top: 10px;">
                   <?php echo (isset($user)) ? $user->rt.'/'.$user->rw : ''; ?>
                </div>
			<?php //} ?>
        </div>
</div>