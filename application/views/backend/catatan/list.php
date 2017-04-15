<div class="row">
<!-- left column -->
<div class="col-md-12">
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<div class="box box-info">
    <div class="box-body">
	<button class="btn btn-success tambah_kode" style="margin-bottom:10px;">Tambah Data</button>
    <div style="margin-bottom:10px; display:none;" id="form_kode">
     <?php 
			$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
			echo form_open($form_action,$attributes);  ?>
		<input type="hidden" name="ajaran_id" value="<?php echo $ajaran_id; ?>" />
	<div class="form-group col-sm-6">
        <div class="form-group">
			<label for="pilih_rombel_catat" class="col-sm-4 control-label">Rombongan Belajar</label>
			<div class="col-sm-8">
				<select class="form-control select2" name="rombel_id" id="pilih_rombel_catat" style="width:100%">
					<option value="">== Pilih Rombongan Belajar ==</option>
					<?php foreach($rombels as $rombel){ ?>
					<option value="<?php echo $rombel->id; ?>"><?php echo $rombel->nama; ?></option>
					<?php } ?>						
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="data_siswa_id" class="col-sm-4 control-label">Data Siswa</label>
			<div class="col-sm-8">
				<select class="form-control select2" id="data_siswa_id" name="siswa_id" style="width:100%">
					<option value="">== Pilih Siswa ==</option>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group col-sm-6">
		<div class="form-group">
			<label for="uraian" class="col-sm-2 control-label">Isi Catatan</label>
			<div class="col-sm-10">
				<textarea class="form-control editor required" rows="10" name="uraian" id="uraian"></textarea>
		</div>
	</div>
		<div class="form-group col-sm-12">
			<button type="submit" class="btn btn-primary  pull-right">Simpan</button>
			<a href="javascript:void(0);" class="btn btn-danger  pull-right cancel_kode" style="margin-right:10px;">Batal</a>
		</div>
	</div>
</div>
	<?php echo form_close();  ?>
        <table id="datatable" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th style="width:2%" class="text-center"><label><input type="checkbox" id="checkall" title="Select all"/></label></th>
                <th style="width: 20%">Nama Siswa</th>
                <th style="width: 68%">Isi Catatan</th>
                <th style="width: 10%" class="text-center">Aksi</th>
            </tr>
            </thead>
			<tbody>
			</tbody>
			<tfoot>
			<tr>
				<th colspan="6">
				<a class="delete_all btn btn-danger btn-sm btn_delete"><i class="fa fa-trash-o"></i> Hapus Data Terpilih</a>
				</th>
			</tr>
			</tfoot>
		</table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>
<script type="text/javascript">
$('#pilih_rombel_catat').change(function(){
	var rombel_id = $(this).val();
	$('#data_siswa_id').prop('selectedIndex',0);
	if(rombel_id == ''){
		return false;
	}
	$.ajax({
		url: '<?php echo site_url('admin/ajax/get_prakerin');?>',
		type: 'post',
		data: {rombel_id:rombel_id},
		success: function(response){
			var data = $.parseJSON(response);
			$('#data_siswa_id').html('<option value="">== Pilih Siswa ==</option>');
			if($.isEmptyObject(data.siswa)){
			} else {
				$.each(data.siswa, function (i, item) {
					$('#data_siswa_id').append($('<option>', { 
						value: item.value,
						text : item.text
					}));
				});
			}
		}
	});
});
</script>