<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
        <table class="table table-bordered table-striped table-hover" id="datatable">
            <thead>
            <tr>
                <th style="width: 2%"></th>
                <th style="width: 10%">Nama</th>
                <th style="width: 15%">Email</th>
                <th style="width: 10%">No. Handphone</th>
                <th style="width: 15%">Jenis Pengguna</th>
                <th style="width: 5%">Status</th>
                <th style="width: 5%" class="text-center">Tindakan</th>
            </tr>
            </thead>
            <tbody>
			</tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>