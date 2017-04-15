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
        <table id="datatable" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
				<?php if($this->ion_auth->in_group($admin_group)){ ?>
				<th style="width:2%" class="text-center"><label><input type="checkbox" id="checkall_atas" title="Select all"/></label></th>
				<?php } ?>
                <th width="40%">Nama</th>
                <th style="width: 3%" class="text-center">L/P</th>
                <th>Tempat, Tanggal Lahir</th>
                <th style="width: 10%" class="text-center">Status</th>
                <th style="width: 10%" class="text-center">Tindakan</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
			<?php if($this->ion_auth->in_group($admin_group)){ ?>
			<tfoot>
			<tr>
				<th style="width:2%" class="text-center"><label><input type="checkbox" id="checkall_bawah" title="Select all"/></label></th>
				<th colspan="5">
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