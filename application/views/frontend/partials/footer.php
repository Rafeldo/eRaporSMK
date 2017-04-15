<?php
$uri = $this->uri->segment_array();
?>
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--select2-->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script-->
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Jquery validate -->
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.reload.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/js/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/js/juploads/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url()?>assets/js/juploads/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url()?>assets/js/juploads/jquery.fileupload.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/morris/morris.min.js"></script>
<div id="spinner" style="position:fixed; top: 50%; left: 50%; margin-left: -50px; margin-top: -50px;z-index: 999999;display: none;">
	<img src="<?php echo base_url()?>assets/img/ajax-loader.gif" />
</div>
<div id="modal_content" class="modal fade"></div>
<script type="text/javascript">
var url_saat_ini = '';
<?php
$list = '';
$uri2 = '';
$upload = '';
if(isset($uri[3])){
	$list = $uri[3];
}
if(isset($uri[2]) && !isset($uri[3])){
	$list = $uri[2];
	if($uri[2] == 'backup'){
		$upload = 'restore';
	} 
}
if(isset($uri[2])){
	$uri2 = $uri[2];
	$upload = $uri[2];
	//$upload = 'matpel';
}
echo 'url_saat_ini = "'.site_url('admin/'.$uri2.'/list_'.$list).'";';
$multidelete = isset($uri[2]) ? $uri[2] : '';
$query = isset($uri[3]) ? $uri[3] : '';
?>
function turn_on_icheck(){
	$('.satuan').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('#checkall_atas').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('#checkall_bawah').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('#checkall_atas').on('ifChecked', function(event){
		$('.satuan').iCheck('check');
		$('#checkall_bawah').iCheck('check');
	});
	$('#checkall_bawah').on('ifChecked', function(event){
		$('.satuan').iCheck('check');
		$('#checkall_atas').iCheck('check');
	});
	$('#checkall_atas').on('ifUnchecked', function(event){
		$('.satuan').iCheck('uncheck');
		$('#checkall_bawah').iCheck('uncheck');
	});
	$('#checkall_bawah').on('ifUnchecked', function(event){
		$('.satuan').iCheck('uncheck');
		$('#checkall_atas').iCheck('uncheck');
	});
	$('.satuan').on('ifUnchecked', function(event){
		$('#checkall_atas').iCheck('indeterminate');
		$('#checkall_bawah').iCheck('indeterminate');
	});
	$('a.toggle-modal').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		if (url.indexOf('#') == 0) {
			$('#modal_content').modal('open');
	        $('.editor').wysihtml5();
		} else {
			$.get(url, function(data) {
				$('#modal_content').modal();
				$('#modal_content').html(data);
			}).success(function(data) {
				if(data == 'activate' || data== 'deactivate'){
					$('#modal_content').modal('hide');
					var url      = window.location.href;     // Returns full URL
					window.location.replace(url);
				}
				$('input:text:visible:first').focus();
			});
		}
	});
	$('a.toggle-swal').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		$.get(url).done(function(response) {
			var data = $.parseJSON(response);
			swal({
				title: 'Masukkan KKM',
				input: 'text',
				inputValue : data.kkm,
				showCancelButton: true,
				confirmButtonText: 'Simpan',
				showLoaderOnConfirm: true,
				preConfirm: function (kkm) {
					return new Promise(function (resolve, reject) {
						resolve();
					})
				},
				allowOutsideClick: false
			}).then(function (kkm) {
					$.ajax({
						url: url,
						type: 'post',
						data: {kkm:kkm},
						success: function(response){
							swal({title:"Sukses", text:"KKM berhasil ditambahkan", type:"success"}).then(function() {
								$('#datatable').dataTable().fnReloadAjax();
							}).done();
						}
					});
			}).done();
		});
	});
	$('a.confirm').bind('click',function(e) {
		var ini = $(this).parents('tr');
		e.preventDefault();
		var url = $(this).attr('href');
		swal({
			title: "Anda Yakin?",
			text: "Tindakan ini tidak bisa dikembalikan!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Hapus!",
			showLoaderOnConfirm: true,
			preConfirm: function() {
				return new Promise(function(resolve) {
					$.get(url)
					.done(function(response) {
						var data = $.parseJSON(response);
					//swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						swal({title:data.title, html:data.text, type:data.type}).then(function() {
							$('#datatable').dataTable().fnReloadAjax();
						});
						/*swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
							$('#datatable').dataTable().fnReloadAjax();
						});*/
					})
				})
			}
		});
	});
	$('a.confirm_input').bind('click',function(e) {
		var ini = $(this).parents('tr');
		e.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			url: url,
			type: 'post',
			data: '',
			success: function(response){
				var data = $.parseJSON(response);
				console.log(data);
				swal({
					title: 'Pilih Kurikulum',
					input: 'select',
					inputClass: 'select2',
					inputOptions: data,
					inputPlaceholder: '== Pilih Kurikulum ==',
					showCancelButton: true,
					inputValidator: function(value) {
						return new Promise(function(resolve, reject) {
							console.log(value);
							if (value === '' || value == 0) {
								reject('Kurikulum Tidak Boleh Kosong');
							} else {
								resolve();
							}
						})
					}
				}).then(function(result) {
					$.ajax({
						url: url,
						type: 'post',
						data: {nama:result},
						success: function(response){
							swal({title:"Sukses", text:"Kurikulum berhasil ditambahkan", type:"success"}).then(function() {
								$('#datatable').dataTable().fnReloadAjax();
							});
						}
					});
				}).done();
			}
		});
	});
	$('a.turunan').bind('click',function(e) {
		var ini = $(this).parents('tr');
		e.preventDefault();
		var url = $(this).attr('href');
		swal({
			title: "Anda Yakin?",
			text: "Tindakan ini tidak bisa dikembalikan!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Hapus!",
			}).then(function(data) {
					$.get(url)
					.then(function(data) {
						$('#modal_content').modal();
						$('#modal_content').html(data);
					})
		});
	});
	$('.tooltip-left').tooltip({
		placement: 'left',
		viewport: {selector: 'body', padding: 2}
	})
};
window.setTimeout(function() { $(".alert-dismissable").hide('slow'); }, 15000);
$(function() {
	$(".datatable").dataTable({ 
		"bLengthChange": false, 
		"bSort": false,
		"oLanguage": {
			"oPaginate": {
				"sNext": "Selanjutnya",
				"sPrevious": "Sebelumnya",
			},
			"sInfo": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
			"sSearch": "Cari:",
			"sEmptyTable": "Tidak ada data untuk ditampilkan",
			"sInfoEmpty": "Menampilkan 0 sampai 0 dari total 0 data",
			"sLengthMenu": "_MENU_ entri",
		}
	});
	$('div.dataTables_filter input').focus();
	$('.datepicker').datepicker({
		autoclose: true,
		format: "dd-mm-yyyy"
	});
	var checkJSON = function(m) {
		if (typeof m == 'object') { 
			try{ m = JSON.stringify(m); 
			} catch(err) { 
				return false; 
			}
		}
		if (typeof m == 'string') {
			try{ m = JSON.parse(m); 
			} catch (err) {
				return false;
			}
		}
		if (typeof m != 'object') { 
			return false;
		}
		return true;
	};
	$('.tooltip-right').tooltip({
		placement: 'right',
		viewport: {selector: 'body', padding: 2}
	})
	$('.tooltip-left').tooltip({
		placement: 'left',
		viewport: {selector: 'body', padding: 2}
	})
	$('.tooltip-bottom').tooltip({
		placement: 'bottom',
		viewport: {selector: 'body', padding: 2}
	})
	$('.tooltip-viewport-right').tooltip({
		placement: 'right',
		viewport: {selector: '.container-viewport', padding: 2}
	})
	$('.tooltip-viewport-bottom').tooltip({
		placement: 'bottom',
		viewport: {selector: '.container-viewport', padding: 2}
	})
	$('.icheck').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
	$('.select2').select2();
	$(".editor").wysihtml5();
	var t = $('#datatable').on('draw.dt', function () {
		turn_on_icheck();
	});
	$('#datatable').on( 'processing.dt', function ( e, settings, processing ) {
		$('#spinner').show();
	});
	$('#datatable').dataTable({
		"sPaginationType"	: "bootstrap",
		"bProcessing"		: false,
		"bServerSide"		: true, 
		"iDisplayLength"	:10,
		"aoColumns"			: null,
		"bSort"				: false,
		"sAjaxSource"		: url_saat_ini,
		"oLanguage": {
			"oPaginate": {
				"sNext": "Selanjutnya",
				"sPrevious": "Sebelumnya",
			},
			"sInfo": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
			"sSearch": "Cari:",
			"sEmptyTable": "Tidak ada data untuk ditampilkan",
			"sInfoEmpty": "Menampilkan 0 sampai 0 dari total 0 data",
			"sLengthMenu": "_MENU_ entri",
		}
	});
	$('#filter_jurusan').change(function(e){
		e.preventDefault();
		var kompetensi = $(this).val();
		$('#filter_tingkat').show();
		$("#filter_tingkat").prop("selectedIndex", 0);
		$('#filter_rombel').hide();
		$('#filter_kompetensi').hide();
		$('#datatable').dataTable().fnDestroy();
		<?php if(isset($uri[3])){ 
		$list = $uri[3];
		if($uri[3] == 'pengetahuan') {
			$list = 'pengetahuan';
		} elseif($uri[3] == 'keterampilan') {
			$list = 'keterampilan';
		}
		?>
		var url_filter_kompetensi_first = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+kompetensi;
		<?php } else { ?>
		var url_filter_kompetensi_first = window.location.href+"/list_<?php echo $uri2; ?>/"+kompetensi;
		<?php } ?>
		$('#datatable').dataTable({
			"sPaginationType"	: "bootstrap",
			"bProcessing"		: false,
			"bServerSide"		: true, 
			"iDisplayLength"	:10,
			"aoColumns"			: null,
			"bSort"				: false,
			"sAjaxSource"		: url_filter_kompetensi_first,
       	});
	});
	$('#filter_tingkat').change(function(e){
		e.preventDefault();
		var jurusan = $('#filter_jurusan').val();
		var tingkat = $(this).val();
		var cari_filter_rombel = $('body').find('#filter_rombel');
		if(cari_filter_rombel.length>0){
			$('#filter_rombel').show();
			$('#filter_rombel').html('<option value="">== Filter By Rombel ==</option>');
		}
		var cari_filter_mapel = $('body').find('#filter_mapel');
		if(cari_filter_mapel.length>0){
			$('#filter_mapel').show();
			$('#filter_mapel').html('<option value="">== Filter By Mapel ==</option>');
		}
		$('#datatable').dataTable().fnDestroy();
		<?php if(isset($uri[3])){
		$list = $uri[3];
		if($uri[3] == 'pengetahuan') {
			$list = 'pengetahuan';
		} elseif($uri[3] == 'keterampilan') {
			$list = 'keterampilan';
		}
		?>
		var url_filter_tingkat = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+jurusan+"/"+tingkat;
		<?php } else { ?>
		var url_filter_tingkat = window.location.href+"/list_<?php echo $uri2; ?>/"+jurusan+"/"+tingkat;
		<?php } ?>
		if(cari_filter_rombel.length>0){
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_tingkat,
				"fnServerData": function ( sSource, aoData, fnCallback ) {
					$.ajax( {
						"dataType": 'json',
						"url": sSource,
						"data": aoData,
						"success": function(data, textStatus, jqXHR) {
							if(tingkat != '') {
								$.each(data.rombel, function (i, item) {
									$('#filter_rombel').append($('<option>', { 
										value: item.value,
										text : item.text
									}));
								});
							}
							fnCallback(data, textStatus, jqXHR);
						}
					});
				}
			});
		} else if(cari_filter_mapel.length>0){
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_tingkat,
				"fnServerData": function ( sSource, aoData, fnCallback ) {
					$.ajax( {
						"dataType": 'json',
						"url": sSource,
						"data": aoData,
						"success": function(data, textStatus, jqXHR) {
							if(tingkat != '') {
								$.each(data.rombel, function (i, item) {
									$('#filter_mapel').append($('<option>', { 
										value: item.value,
										text : item.text
									}));
								});
							}
							fnCallback(data, textStatus, jqXHR);
						}
					});
				}
			});
		} else {
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_tingkat
			});
		}
	});
	$('#filter_rombel').change(function(e){
		e.preventDefault();
		var rombel = $(this).val();
		var tingkat = $('#filter_tingkat').val();
		var jurusan = $('#filter_jurusan').val();
		var cari_filter_kompetensi = $('body').find('#filter_kompetensi');
		if(cari_filter_kompetensi.length>0){
			$('#filter_kompetensi').show();
			$('#filter_kompetensi').html('<option value="">== Filter By Kompetensi ==</option>');
		}
		<?php if(isset($uri[3])){ 
		$list = $uri[3];
		if($uri[3] == 'pengetahuan') {
			$list = 'pengetahuan';
		} elseif($uri[3] == 'keterampilan') {
			$list = 'keterampilan';
		}
		?>
		var url_filter_rombel = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+jurusan+'/'+tingkat+'/'+rombel;
		<?php } else { ?>
		var url_filter_rombel = window.location.href+"/list_<?php echo $uri2; ?>/"+jurusan+'/'+tingkat+'/'+rombel;
		<?php } ?>
		$('#datatable').dataTable().fnDestroy();
		if(cari_filter_kompetensi.length>0){
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_rombel,
				"fnServerData": function ( sSource, aoData, fnCallback ) {
					$.ajax( {
						"dataType": 'json',
						"url": sSource,
						"data": aoData,
						"success": function(data, textStatus, jqXHR) {
							if(rombel != '') {
								$.each(data.kompetensi, function (i, item) {
									$('#filter_kompetensi').append($('<option>', { 
										value: item.value,
										text : item.text
									}));
								});
							}
							fnCallback(data, textStatus, jqXHR);
						}
					});
				}
			});
		} else {
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_rombel
			});
		}
	});
	$('#filter_mapel').change(function(e){
		e.preventDefault();
		var mapel = $(this).val();
		var tingkat = $('#filter_tingkat').val();
		var jurusan = $('#filter_jurusan').val();
		var cari_filter_kompetensi = $('body').find('#filter_kompetensi');
		if(cari_filter_kompetensi.length>0){
			$('#filter_kompetensi').show();
			$('#filter_kompetensi').html('<option value="">== Filter By Kompetensi ==</option>');
		}
		<?php if(isset($uri[3])){ 
		$list = $uri[3];
		if($uri[3] == 'pengetahuan') {
			$list = 'pengetahuan';
		} elseif($uri[3] == 'keterampilan') {
			$list = 'keterampilan';
		}
		?>
		var url_filter_mapel = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+jurusan+'/'+tingkat+'/'+mapel;
		<?php } else { ?>
		var url_filter_mapel = window.location.href+"/list_<?php echo $uri2; ?>/"+jurusan+'/'+tingkat+'/'+mapel;
		<?php } ?>
		$('#datatable').dataTable().fnDestroy();
		if(cari_filter_kompetensi.length>0){
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_mapel,
				"fnServerData": function ( sSource, aoData, fnCallback ) {
					$.ajax( {
						"dataType": 'json',
						"url": sSource,
						"data": aoData,
						"success": function(data, textStatus, jqXHR) {
							if(mapel != '') {
								$.each(data.kompetensi, function (i, item) {
									$('#filter_kompetensi').append($('<option>', { 
										value: item.value,
										text : item.text
									}));
								});
							}
							fnCallback(data, textStatus, jqXHR);
						}
					});
				}
			});
		} else {
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_filter_mapel
			});
		}
	});
	$('#filter_kompetensi').change(function(e){
		e.preventDefault();
		var kompetensi = $(this).val();
		var tingkat = $('#filter_tingkat').val();
		var rombel = $('#filter_rombel').val();
		var jurusan = $('#filter_jurusan').val();
		var cari_filter_mapel = $('body').find('#filter_mapel');
		if(cari_filter_mapel.length>0){
			rombel = $('#filter_mapel').val();
		}
		$('#datatable').dataTable().fnDestroy();
		<?php if(isset($uri[3])){ 
		$list = $uri[3];
		if($uri[3] == 'pengetahuan') {
			$list = 'pengetahuan';
		} elseif($uri[3] == 'keterampilan') {
			$list = 'keterampilan';
		}
		?>
		var url_filter_kompetensi = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+jurusan+'/'+tingkat+'/'+rombel+'/'+kompetensi;
		<?php } else { ?>
		var url_filter_kompetensi = window.location.href+"/list_<?php echo $uri2; ?>/"+jurusan+'/'+tingkat+'/'+rombel+'/'+kompetensi;
		<?php } ?>
		$('#datatable').dataTable({
			"sPaginationType"	: "bootstrap",
			"bProcessing"		: false,
			"bServerSide"		: true, 
			"iDisplayLength"	:10,
			"aoColumns"			: null,
			"bSort"				: false,
			"sAjaxSource"		: url_filter_kompetensi,
       	});
	});
	$('.delete_all').click(function(){
			var names = [];
			var ids = $('.satuan:checked');
			$(ids).each(function(e,a){
				var he = $(a).val();
				names.push($(a).val());
			});
			if($.isEmptyObject(names)){
				swal({title:"Error",text:"Silahkan checklist terlebih dahulu data yang ingin dihapus.",type:"error"});
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/'.$multidelete.'/multidelete/'.$query);?>',
				type: 'post',
				data: {id:names},
				success: function(response){
					var data = $.parseJSON(response);
					//swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
					swal({title:data.title, html:data.text, type:data.type}).then(function() {
						$('#checkall_atas').iCheck('uncheck');
						$('#checkall_bawah').iCheck('uncheck');
						$('#datatable').dataTable().fnReloadAjax();
					});
				}
			});
		});
	$(document).bind("ajaxSend", function() {
		$("#spinner").show();
		$("#show").hide();
	}).bind("ajaxStop", function() {
		$("#spinner").hide();
		$("#show").show();
	}).bind("ajaxError", function() {
		$("#spinner").hide();
		$("#show").show();
	});
	$('#jurusan').change(function(){
		$("#kelas").val('');
		$("#rombel").val('');
		$("#mapel").val('');
		$("#kelas").trigger('change.select2');
		$("#rombel").trigger('change.select2');
		$("#mapel").trigger('change.select2');
	});
	$('#kelas').change(function(){
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		$.ajax({
			url: '<?php echo site_url('admin/ajax/get_rombel');?>',
			type: 'post',
			data: $("form").serialize(),
			success: function(response){
				$('.simpan').hide();
				$('#result').html('');
				$('table.table').addClass("jarak1");
				var data = $.parseJSON(response);
				$('#rombel').html('<option value="">== Pilih Rombongan Belajar ==</option>');
				if($.isEmptyObject(data.result)){
				} else {
					$.each(data.result, function (i, item) {
						$('#rombel').append($('<option>', { 
							value: item.value,
							text : item.text
						}));
					});
				}
			}
		});
	});
	$('#rombel').change(function(){
		var get = '';
		var nama_kur = '';
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		var query = $('#query').val();
		if(query == 'rapor'){
			get = 'rapor';
		} else if(query == 'legger'){
			get = 'legger';
		} else if(query == 'deskripsi_antar_mapel'){
			get = 'deskripsi_antar_mapel';
		} else if(query == 'absensi'){
			get = 'absensi';
		} else if(query == 'nama_kur_kurikulum'){
			get = 'kurikulum';
		} else {
			get = 'mapel';
		}
		$.ajax({
			url: '<?php echo site_url('admin/ajax/get_');?>'+get,
			type: 'post',
			data: $("form").serialize(),
			success: function(response){
				result = checkJSON(response);
				if(result == true){
					var data = $.parseJSON(response);
					$('#mapel').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#mapel_mulok').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#siswa').html('<option value="">== Pilih Nama Siswa ==</option>');
					$('#ekskul').html('<option value="">== Pilih Nama Ekstrakurikuler ==</option>');
					if($.isEmptyObject(data.mapel)){
					} else {
						$.each(data.mapel, function (i, item) {
							$('#mapel').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
					if($.isEmptyObject(data.siswa)){
					} else {
						$.each(data.siswa, function (i, item) {
							$('#siswa').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
					if($.isEmptyObject(data.mulok)){
					} else {
						$.each(data.mulok, function (i, item) {
							$('#mapel_mulok').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
					if($.isEmptyObject(data.ekskul)){
					} else {
						$.each(data.ekskul, function (i, item) {
							$('#ekskul').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
				} else {
					$('.simpan').show();
					$('#result').html(response);
					$('#result_alt').html(response);
				}
			}
		});
	});
	$('#mapel_mulok').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_nilai');?>',
				type: 'post',
				data: $("form").serialize(),
				success: function(response){
					$('.simpan').show();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak1");
					$('.add').show();
				}
			});
		});
	$('#mapel').change(function(){
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		var query = $('#query').val();
		var url_get = '<?php echo site_url('admin/ajax/get_');?>';
		if(query == 'analisis_penilaian'){
			query = 'rencana_id';
		}
		if(query == 'analisis_kompetensi'){
			query = 'all_kd';
		}
		if(query == 'sikap'){
			query = 'undefined';
		}
		if(query == 'mulok'){
			query = 'nilai';
			url_get = '<?php echo site_url('admin/asesmen/get_');?>'
		}
		$.ajax({
			url: url_get+query,
			type: 'post',
			data: $("form").serialize(),
			success: function(response){
				$('#kompetensi').html('<option value="">== Pilih Kompetensi Penilaian ==</option>');
				$('#penilaian').html('<option value="">== Pilih Penilaian ==</option>');
				$('#kd').html('<option value="">== Pilih KD ==</option>');
				result = checkJSON(response);
				if(result == true){
					var data = $.parseJSON(response);
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#siswa').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
							$('#kompetensi').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
							$('#penilaian').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
							$('#kd').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
						});
					}
				} else {		
					$('.simpan').show();
					$('.cancel').hide();
					$('#form').fadeOut();
					var test =$('#result');
					if(test.is('input')){
						$('#result').val(response);
					} else {
						$('#result').html(response);
					}
					$('table.table').addClass("jarak1");
					$('.add').show();
				}
			}
		});
	});
	$('#kompetensi').change(function(){
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		var query = $('#query').val();
		if(query == 'analisis_penilaian'){
			query = 'rencana_penilaian';
		}
		$.ajax({
			url: '<?php echo site_url('admin/ajax/get_');?>'+query,
			type: 'post',
			data: $("form").serialize(),
			success: function(response){
				$('#penilaian').html('<option value="">== Pilih Penilaian ==</option>');
				result = checkJSON(response);
				if(result == true){
					var data = $.parseJSON(response);
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#siswa').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
							$('#penilaian').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
						});
					}
				} else {		
					$('.simpan').show();
					$('.cancel').hide();
					$('#form').fadeOut();
					var test =$('#result');
					if(test.is('input')){
						$('#result').val(response);
					} else {
						$('#result').html(response);
					}
					$('table.table').addClass("jarak1");
					$('.add').show();
				}
			}
		});
	});
	$('#penilaian').change(function(){
		var query = $('#query_2').val();
		if(typeof query == 'undefined'){
			var query = $('#query').val();
		}
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		$('#result').html('');
		$('.simpan').hide();
		$('.cancel').hide();
		$('#rerata').hide();
		$.ajax({
			url: '<?php echo site_url('admin/asesmen');?>/get_'+query,
			type: 'post',
			data: $('form').serialize(),
			success: function(response){
				result = checkJSON(response);
				if(result == true){
					$('#kd').html('<option value="">== Pilih KD ==</option>');
					var data = $.parseJSON(response);
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#kd').append($('<option>', { 
								value: item.value,
								text : item.text,
								}));
						});
					}
				} else {
					$('.simpan').hide();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak1");
					$('.add').show();
					$('#rerata').show();
				}
			}
		});
	});
	$('#siswa').change(function(){
		var query = $('#query').val();
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		$('#result').html('');
		$('.simpan').hide();
		$('.cancel').hide();
		$('#rerata').hide();
		$.ajax({
			url: '<?php echo site_url('admin/asesmen');?>/get_'+query,
			type: 'post',
			data: $('form').serialize(),
			success: function(response){
				$('.simpan').show();
				$('.cancel').hide();
				$('#form').fadeOut();
				$('#result').html(response);
				$('table.table').addClass("jarak1");
				$('.add').show();
				$('#rerata').show();
			}
		});
	});
	$('#kd').change(function(){
		var query = $('#query').val();
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		$('#result').html('');
		$('.simpan').hide();
		$('.cancel').hide();
		$('#rerata').hide();
		$.ajax({
			url: '<?php echo site_url('admin/monitoring');?>/get_'+query,
			type: 'post',
			data: $('form').serialize(),
			success: function(response){
				$('.simpan').show();
				$('.cancel').hide();
				$('#form').fadeOut();
				$('#result').html(response);
				$('table.table').addClass("jarak1");
				$('.add').show();
				$('#rerata').show();
			}
		});
	});
	$('#ekskul').change(function(){
		var query = $('#query').val();
		var ini = $(this).val();
		if(ini == ''){
			return false;
		}
		$.ajax({
			url: '<?php echo site_url('admin/asesmen');?>/get_'+query,
			type: 'post',
			data: $('form').serialize(),
			success: function(response){
				$('.simpan').show();
				$('.cancel').hide();
				$('#form').fadeOut();
				$('#result').html(response);
				$('table.table').addClass("jarak1");
				$('.add').show();
				$('#rerata').show();
			}
		});
	});
	$('#rerata').click(function(){
		var form_data = $('form').serialize();
		$.ajax({
			url: '<?php echo site_url('admin/asesmen/get_rerata');?>',
			type: 'post',
			data: form_data,
			success: function(response){
				var data = $.parseJSON(response);
				//$('.simpan').show();
				$('#rumus').html(data.rumus);
				if($.isEmptyObject(data.rerata)){
				} else {
					$.each(data.rerata, function (i, item) {
						$('#rerata_'+i).val(item.value);
						$('#rerata_jadi_'+i).val(item.rerata_jadi);
						$('#rerata_text_'+i).html(item.rerata_text);
					});
				}
				$('form').submit();
			}
		});
	});
	<?php //$upload = 'dasar'; ?>
	var url = '<?php echo site_url('import').'/'.$upload;?>';
	console.log(url);
	$('#fileupload').fileupload({
        url: url,
		dataType: 'json',
	}).on('fileuploadprogress', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css('width',progress + '%');
	}).on('fileuploadsubmit', function (e, data) {
		$('#gagal').hide();
		var mapel = $('#category_id_upload').val();
    	data.formData = {data: mapel};
		if(data.formData.mapel == ''){
			$('#gagal').show();
			return false;
		}else{
			$('#progress').show();
		}
	}).on('fileuploaddone', function (e, data) {
		window.setTimeout(function() { 
			$('#progress').hide();
			$('#progress .progress-bar').css('width','0%');
		}, 1000);
		swal({title:data.result.title,type:data.result.type,html:data.result.text}).done();
	}).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>