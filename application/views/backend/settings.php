<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
        <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
        <div class="box box-primary">
            <!-- form start -->

            <form role="form" method="POST" action="<?php echo site_url('admin/settings/update'); ?>" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                    <div class="col-xs-6">
					<div class="form-group col-xs-12"><h4><b>Data Sekolah</b></h4><hr></div>					
                    <div class="form-group col-xs-12">
                        <label>Nama Aplikasi</label>
                        <input type="text" class="form-control" name="nama_aplikasi" value="<?php echo (isset($settings->site_title)) ? $settings->site_title: ''; ?>" required readonly="true" />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Nama Sekolah</label>
                        <input type="text" class="form-control" name="nama_sekolah" value="<?php echo (isset($sekolah->nama)) ? $sekolah->nama: ''; ?>" readonly="true" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>NPSN</label>
                        <input type="text" class="form-control" name="npsn_sekolah" value="<?php echo (isset($sekolah->npsn)) ? $sekolah->npsn: ''; ?>" readonly="true" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat_sekolah" value="<?php echo (isset($sekolah->alamat)) ? $sekolah->alamat: ''; ?>" required/>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Desa/Kelurahan</label>
                        <input type="text" class="form-control" name="desa_kelurahan_sekolah" value="<?php echo (isset($sekolah->desa_kelurahan)) ? $sekolah->desa_kelurahan: ''; ?>" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan_sekolah" value="<?php echo (isset($sekolah->kecamatan)) ? $sekolah->kecamatan: ''; ?>" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Kabupaten</label>
                        <input type="text" class="form-control" name="kabupaten_sekolah" value="<?php echo (isset($sekolah->kabupaten)) ? $sekolah->kabupaten: ''; ?>" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Provinsi</label>
                        <input type="text" class="form-control" name="provinsi_sekolah" value="<?php echo (isset($sekolah->provinsi)) ? $sekolah->provinsi: ''; ?>" required />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Kodepos</label>
                        <input type="text" class="form-control" name="kodepos_sekolah" value="<?php echo (isset($sekolah->kode_pos)) ? $sekolah->kode_pos: ''; ?>" required />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Lintang</label>
                        <input type="text" class="form-control" name="lintang_sekolah" value="<?php echo (isset($sekolah->lintang)) ? $sekolah->lintang: ''; ?>" required />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Bujur</label>
                        <input type="text" class="form-control" name="bujur_sekolah" value="<?php echo (isset($sekolah->bujur)) ? $sekolah->bujur: ''; ?>" required />
                    </div>
					
                    </div>
                    <div class="col-xs-6">
					<div class="form-group col-xs-12">
                        <label>Telepon</label>
                        <input type="text" class="form-control" name="telp_sekolah" value="<?php echo (isset($sekolah->no_telp)) ? $sekolah->no_telp: ''; ?>" required />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Fax</label>
                        <input type="text" class="form-control" name="fax_sekolah" value="<?php echo (isset($sekolah->no_fax)) ? $sekolah->no_fax: ''; ?>" />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email_sekolah" value="<?php echo (isset($sekolah->email)) ? $sekolah->email: ''; ?>" required />
                    </div>
					<div class="form-group col-xs-12">
                        <label>Website</label>
                        <input type="text" class="form-control" name="website_sekolah" value="<?php echo (isset($sekolah->website)) ? $sekolah->website: ''; ?>" />
                    </div>
                         <div class="form-group col-xs-12"><h4><b>Kelengkapan Sekolah</b></h4><hr></div>
						 <div class="form-group col-xs-12">
                        <label>Periode</label>
                        <select class="form-control" name="keywords" required>
						<?php $tahun = array(0,0,1,1,2,2);
						$i=0;
						foreach($tahun as $t){
						if($i%2){
							$periode = 'Genap';
						} else {
							$periode = 'Ganjil';
						}
						$t1 = (date('Y')+$t)-2;
						$t2 = (date('Y')+$t)-1;
						$t3 = 'Semester '.$periode;
						$value = $t1.'/'.$t2.' | '.$t3;
						?>
						<option value="<?php echo (date('Y')+$t)-2; ?>/<?php echo (date('Y')+$t)-1; ?> | Semester <?php echo $periode; ?>"<?php echo ($settings->keywords == $value) ? ' selected="selected"' : '';?>><?php echo (date('Y')+$t)-2; ?>/<?php echo (date('Y')+$t)-1; ?> Semester <?php echo $periode; ?></option>
						<?php $i++;} ?>
						</select>
                    </div>
						 
						
						
						<div class="form-group col-xs-12">
                            <label>Nama Kepala Sekolah</label>
                            <input type="text" class="form-control" name="facebook_url" value="<?php echo (isset($settings->facebook_url)) ? $settings->facebook_url : ''; ?>" required />
                        </div>
						<div class="form-group col-xs-12">
                            <label>NIP Kepala Sekolah</label>
                            <input type="text" class="form-control" name="twitter_url" value="<?php echo (isset($settings->twitter_url)) ? $settings->twitter_url : ''; ?>"/>
                        </div>
						</div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div><!-- /.box -->

    </div><!--/.col (left) -->

</div>