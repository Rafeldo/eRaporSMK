<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
        <table id="datatable" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="10%">Tahun Ajaran</th>
                <th width="5%">Kelas</th>
                <th width="10%">Nama Siswa</th>
                <th	>Isi Catatan</th>
				<!--th>Metode</th>
				<th>Bobot</th>
				<th>KD</th-->
                <th style="width: 10%" class="text-center">Action</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>