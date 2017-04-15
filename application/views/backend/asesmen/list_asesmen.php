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
				<th style="vertical-align:middle" width="10%">Tahun Ajaran</th>
                <th style="vertical-align:middle" width="8%">Kelas</th>
                <th style="vertical-align:middle" width="30%">Mata Pelajaran</th>
                <th style="vertical-align:middle" width="10%">Nama Guru</th>
				<th class="text-center" width="5%">Jumlah <br />Penilaian</th>
				<th class="text-center" width="5%">Jumlah <br />KD</th>
                <th  style="vertical-align:middle;width: 5%" class="text-center">Tindakan</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>