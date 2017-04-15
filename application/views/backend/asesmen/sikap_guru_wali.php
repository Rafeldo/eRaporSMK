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
                <th style="width: 20%">Nama Siswa</th>
				<th style="width: 20%">Rombel/Tingkat</th>
                <th style="width: 15%" class="text-center">Butir Sikap</th>
                <th style="width: 5%" class="text-center">Opsi Sikap</th>
                <th style="width: 40%" class="text-center">Uraian Sikap</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
		</table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>