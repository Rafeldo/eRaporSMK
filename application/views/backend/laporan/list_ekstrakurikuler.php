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
                <th width="5%">Kelas</th>
                <th width="10%">Nama Siswa</th>
                <th width="5%">Nama Eskul</th>
                <th width="5%">Predikat</th>
                <th width="25%">Deskripsi</th>
                <th style="width: 5%" class="text-center">Action</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>