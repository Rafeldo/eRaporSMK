<div class="row">
    <!-- left column -->
    <div class="col-xs-6">
        <?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
        <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
        <div class="box box-primary">
        <div class="box-body">
            <?php 
            $data_siswa = Datasiswa::find('all');
            ?>
            <div class="box-body">
                <div class="row">
                    
                        <div class="form-group col-xs-12">
                        <label for="siswa_id" class="control-label">Nama Siswa</label>
                            <select name="siswa_id" class="select2 form-control" id="siswa" required>
                                <option value="">== Pilih Nama Siswa ==</option>
                                <?php foreach($data_siswa as $siswa){ ?>
                                <option value="<?php echo $siswa->id; ?>"><?php echo $siswa->nama; ?></option>
                                <?php } ?>
                            </select>
                        
                    </div>
                        <div class="form-group col-xs-12">
                            <label for="bulan">Bayar Berapa Bulan?</label>
                            <input type="text" class="form-control" id="bulan" required/>
                        </div>   
                 
                </div>
            </div>
            <div class="box-footer clearfix">
                <button type="submit" class="btn btn-primary  pull-left">Simpan</button>
            </div>
            <?php echo form_close();?>
            </div>
        </div><!--/tab_1 active-->
    </div>
</div>
</div>
</div>