<?php
$admin_group = array(1,2);
?>
<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
        <?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
		<div class="row" style="margin-bottom:10px;">
		<?php 
		$data_rombel = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data_kompetensi = Keahlian::all();
		?>
			<div class="col-md-4">
				<select id="filter_jurusan" class="form-control">
					<option value="">==Filter Berdasar Kompetensi Keahlian==</option>
					<?php foreach($data_kompetensi as $kompetensi){ ?>
					<option value="<?php echo $kompetensi->kurikulum_id; ?>"><?php echo get_kurikulum($kompetensi->kurikulum_id); ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<select id="filter_tingkat" class="form-control" style="display:none;">
					<option value="">==Filter Berdasar Tingkat==</option>
					<?php foreach($data_rombel as $rombel){ ?>
					<option value="<?php echo $rombel->tingkat; ?>"><?php echo $rombel->tingkat; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<select id="filter_rombel" class="form-control" style="display:none;"></select>
			</div>
		</div>
        <table id="datatable" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
				<?php if($this->ion_auth->in_group($admin_group)){ ?>
                <th style="width:2%" class="text-center"><label><input type="checkbox" id="checkall_atas" title="Select all"/></label></th>
				<?php } else { ?>
				<th style="width:2%" class="text-center">No.</th>
				<?php } ?>
                <th style="width: 8%">Tahun Pelajaran</th>
				<th style="width: 10%">Kelas</th>
                <th style="width: 25%">Nama Muatan Lokal</th>
				<th style="width: 20%">Nama Guru</th>
                <th style="width: 5%" class="text-center">KKM</th>
                <th style="width: 8%" class="text-center">Tindakan</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
			<?php if($this->ion_auth->in_group($admin_group)){ ?>
			<tfoot>
			<tr>
				<th style="width:2%" class="text-center"><label><input type="checkbox" id="checkall_bawah" title="Select all"/></label></th>
				<th colspan="6">
				<a class="delete_all btn btn-danger btn-sm btn_delete"><i class="fa fa-trash-o"></i> Hapus Data Terpilih</a>
				</th>
			</tr>
			</tfoot>
			<?php } ?>      
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>