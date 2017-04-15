<?php
$readonly = '';
$disabled = '';
$loggeduser = $this->ion_auth->user()->row();
if($loggeduser->data_guru_id || $loggeduser->data_siswa_id){
	$readonly = 'readonly="true"';
	$disabled = 'disabled';
}
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
        <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
        <div class="box box-primary">
            <!-- form start -->

            <form role="form" method="POST" action="<?php echo site_url('admin/profil/update_sekolah'); ?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
					<div class="form-group col-xs-12"><h4><b>Data Sekolah</b></h4><hr></div>
                    <div class="col-xs-6">
					<div class="form-group col-xs-12">
                        <label>Nama Sekolah</label>
						<input type="hidden" name="sekolah_id" value="<?php echo $sekolah->id; ?>" />
                        <input type="text" class="form-control" name="nama_sekolah" value="<?php echo (isset($sekolah->nama)) ? $sekolah->nama: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>NPSN</label>
                        <input type="text" class="form-control" name="npsn_sekolah" value="<?php echo (isset($sekolah->npsn)) ? $sekolah->npsn: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat_sekolah" value="<?php echo (isset($sekolah->alamat)) ? $sekolah->alamat: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Desa/Kelurahan</label>
                        <input type="text" class="form-control" name="desa_kelurahan_sekolah" value="<?php echo (isset($sekolah->desa_kelurahan)) ? $sekolah->desa_kelurahan: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan_sekolah" value="<?php echo (isset($sekolah->kecamatan)) ? $sekolah->kecamatan: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Kabupaten</label>
                        <input type="text" class="form-control" name="kabupaten_sekolah" value="<?php echo (isset($sekolah->kabupaten)) ? $sekolah->kabupaten: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Provinsi</label>
                        <input type="text" class="form-control" name="provinsi_sekolah" value="<?php echo (isset($sekolah->provinsi)) ? $sekolah->provinsi: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
					<div class="form-group col-xs-12">
                        <label>Kodepos</label>
                        <input type="text" class="form-control" name="kodepos_sekolah" value="<?php echo (isset($sekolah->kode_pos)) ? $sekolah->kode_pos: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
					<div class="form-group col-xs-12">
                        <label>Telepon</label>
                        <input type="text" class="form-control" name="telp_sekolah" value="<?php echo (isset($sekolah->no_telp)) ? $sekolah->no_telp: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
					<div class="form-group col-xs-12">
                        <label>Fax</label>
                        <input type="text" class="form-control" name="fax_sekolah" value="<?php echo (isset($sekolah->no_fax)) ? $sekolah->no_fax: ''; ?>" <?php echo $readonly; ?>/>
                    </div>
					<div class="form-group col-xs-12">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email_sekolah" value="<?php echo (isset($sekolah->email)) ? $sekolah->email: ''; ?>" required <?php echo $readonly; ?>/>
                    </div>
					<div class="form-group col-xs-12">
                        <label>Website</label>
                        <input type="text" class="form-control" name="website_sekolah" value="<?php echo (isset($sekolah->website)) ? $sekolah->website: ''; ?>" <?php echo $readonly; ?>/>
                    </div>
					</div>
					<div class="col-xs-6">
						<input type="hidden" class="form-control" name="lintang_sekolah" value="<?php echo (isset($sekolah->lintang)) ? $sekolah->lintang: '1'; ?>" required <?php echo $readonly; ?>/>
                        <input type="hidden" class="form-control" name="bujur_sekolah" value="<?php echo (isset($sekolah->bujur)) ? $sekolah->bujur: '1'; ?>" required <?php echo $readonly; ?>/>
					 <div class="form-group col-xs-12">
                        <label>Kompetensi Keahlian</label>
                        <select class="select2 form-control" name="kompetensi_keahlian[]" multiple="multiple" required <?php echo $disabled; ?>>
						<?php 
						$keahlian = Keahlian::all();
						if($keahlian){
							foreach($keahlian as $ahli){
								$ahli_id[] = $ahli->kurikulum_id;
							}
						}
						if(isset($ahli_id)){
							$ahli_id = $ahli_id;
						} else {
							$ahli_id = array();
						}
						$kurikulum = Datakurikulum::all();
						foreach($kurikulum as $komp){
						?>
						<option value="<?php echo $komp->kurikulum_id ?>"<?php echo (isset($keahlian) && in_array($komp->kurikulum_id, $ahli_id)) ? ' selected="selected"' : ''; ?>><?php echo $komp->nama_kurikulum; ?></option>
						<?php } ?>
						</select>
                    </div>
						<div class="form-group col-xs-12">
                            <label>Nama Kepala Sekolah</label>
                            <input type="text" class="form-control" name="kepsek" value="<?php echo (isset($settings->kepsek)) ? $settings->kepsek : ''; ?>" required <?php echo $readonly; ?>/>
                        </div>
						<div class="form-group col-xs-12">
                            <label>NIP Kepala Sekolah</label>
                            <input type="text" class="form-control" name="nip_kepsek" value="<?php echo (isset($settings->nip_kepsek)) ? $settings->nip_kepsek : ''; ?>" <?php echo $readonly; ?>/>
                        </div>
						<div class="form-group col-xs-12">
						 <p><img src="<?php echo (isset($sekolah->logo_sekolah) && $sekolah->logo_sekolah != '') ? base_url().PROFILEPHOTOSTHUMBS.$sekolah->logo_sekolah: base_url().'assets/img/300.gif'; ?>" class="img-responsive thumbnail center-block" alt="Responsive image"/></p>
						<label>Ganti Logo Sekolah</label>
						<input type="file" name="profilephoto" />
						</div>
						</div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right" <?php echo $disabled; ?>>Simpan</button>
                </div>
            </form>
        </div><!-- /.box -->

    </div><!--/.col (left) -->

</div>