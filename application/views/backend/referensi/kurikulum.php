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
			<div class="col-md-6">
				<select id="filter_jurusan" class="form-control">
					<option value="">==Filter Berdasar Kompetensi Keahlian==</option>
					<?php foreach($data_kompetensi as $kompetensi){ ?>
					<option value="<?php echo $kompetensi->kurikulum_id; ?>"><?php echo get_kurikulum($kompetensi->kurikulum_id); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
        <table id="datatable" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th style="width: 25%">Kompetensi Keahlian</th>
				<th style="width: 25%">Mata Pelajaran</th>
				<th style="width: 5%">Kelas 10</th>
				<th style="width: 5%">Kelas 11</th>
                <th style="width: 5%">Kelas 12</th>
                <th style="width: 5%">Kelas 13</th>
                <th style="width: 8%" class="text-center">Tindakan</th>
            </tr>
            </thead>
			<tbody>
			</tbody>      
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>