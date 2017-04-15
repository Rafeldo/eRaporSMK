<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.js"></script>
<!-- Sparkline -->
<!--script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script-->
<!-- jvectormap -->
<!--script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script-->
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--select2-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php
/*
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- Jquery validate -->
*/
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.reload.js" type="text/javascript"></script>
<!-- InputMask -->
<!--script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script-->
<script src="<?php echo base_url()?>assets/js/sweetalert2/sweetalert2.min.js"></script>
<!--script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script-->
<script src="<?php echo base_url()?>assets/js/juploads/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url()?>assets/js/juploads/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url()?>assets/js/juploads/jquery.fileupload.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/morris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/morris/morris.min.js"></script>
<?php
$uri = $this->uri->segment_array();
$upload = '';
$cetak = '';
$multidelete = isset($uri[2]) ? $uri[2] : '';
if(isset($uri[3])){
	if($uri[3] == 'kurikulum'){
	$upload = 'sikap';//'mata_pelajaran';
	}
	if($uri[3] == 'kkm'){
	$upload = 'kriteria';
	}
	if($uri[3] == 'manage'){
	$upload = 'soal';
	}
	if($uri[3] == 'backup'){
	$upload = 'restore';
	}
	$upload = $uri[2];
	$cetak = $uri[3];
} else {
	$upload = 'sekolah';
}
?>
<div id="spinner" style="position:fixed; top: 50%; left: 50%; margin-left: -50px; margin-top: -50px;z-index: 999999;display: none;">
	<img src="<?php echo base_url()?>assets/img/ajax-loader.gif" />
</div>
		<div id="modal_content" class="modal fade"></div>
<script type="text/javascript">
function turn_on_icheck(){
	$('.satuan').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
	$('#checkall').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
	$('#checkall1').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
	$('#checkall').on('ifChecked', function(event){
		$('.satuan').iCheck('check');
		$('#checkall1').iCheck('check');
	});
	$('.satuan_login').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
	$('#checkall_login').on('ifChecked', function(event){
		$('.reset_login_all').show();
		$('.satuan_login').iCheck('check');
		$('#checkall1_login').iCheck('check');
	});
	$('#checkall_login').on('ifUnchecked', function(event){
		$('.reset_login_all').hide();
		$('.satuan_login').iCheck('uncheck');
		$('#checkall1_login').iCheck('uncheck');
	});
	$('.satuan_login').on('ifUnchecked', function(event){
		$('#checkall_login').iCheck('indeterminate');
		$('#checkall1_login').iCheck('indeterminate');
	});
	$('#checkall1_login').on('ifChecked', function(event){
		$('.reset_login_all').show();
		$('.satuan_login').iCheck('check');
		$('#checkall_login').iCheck('check');
	});
	$('#checkall1_login').on('ifUnchecked', function(event){
		$('.reset_login_all').hide();
		$('.satuan_login').iCheck('uncheck');
		$('#checkall_login').iCheck('uncheck');
	});
	$('.satuan_ujian').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
	$('#checkall_ujian').on('ifChecked', function(event){
		$('.satuan_ujian').iCheck('check');
		$('#checkall1_ujian').iCheck('check');
	});
	$('#checkall_ujian').on('ifUnchecked', function(event){
		$('.satuan_ujian').iCheck('uncheck');
		$('#checkall1_ujian').iCheck('uncheck');
	});
	$('.satuan_ujian').on('ifUnchecked', function(event){
		$('#checkall_ujian').iCheck('indeterminate');
	});
	$('#checkall1_ujian').on('ifChecked', function(event){
		$('.satuan_ujian').iCheck('check');
		$('#checkall_ujian').iCheck('check');
	});
	$('#checkall1_ujian').on('ifUnchecked', function(event){
		$('.satuan_ujian').iCheck('uncheck');
		$('#checkall_ujian').iCheck('uncheck');
	});
	$('.satuan_ujian').on('ifUnchecked', function(event){
		$('#checkall1_ujian').iCheck('indeterminate');
	});
	$('#checkall').on('ifUnchecked', function(event){
		$('.satuan').iCheck('uncheck');
		$('#checkall1').iCheck('uncheck');
	});
	$('.satuan').on('ifUnchecked', function(event){
		$('#checkall').iCheck('indeterminate');
	});
	$('#checkall1').on('ifChecked', function(event){
		$('.satuan').iCheck('check');
		$('#checkall').iCheck('check');
	});
	$('#checkall1').on('ifUnchecked', function(event){
		$('.satuan').iCheck('uncheck');
		$('#checkall').iCheck('uncheck');
	});
	$('.satuan').on('ifUnchecked', function(event){
		$('#checkall1').iCheck('indeterminate');
	});
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
	$('a.reset_login').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			url: url,
			type: 'post',
			data: {},
			success: function(response){
				swal({title:"Sukses!",text:"Status Login Siswa berhasil direset.",type:"success"}).then(function() {
					$("#datatable1").dataTable().fnDraw();
					//window.location.replace('<?php echo site_url('admin/settings/resets')?>');
				});
			}
		});
	});
	$('.reset_login_all').click(function(){
		var names = [];
		var ids = $('.satuan_login:checked');
		$(ids).each(function(e,a){
			var he = $(a).val();
			names.push($(a).val());
		});
		if($.isEmptyObject(names)){
			swal({title:"Error",text:"Silahkan checklist terlebih dahulu siswa yang ingin di reset.",type:"error"});
			return false;
		}
		$.ajax({
			url: '<?php echo site_url('admin/tools/reset')?>',
			type: 'post',
			data: {id:names},
			success: function(response){
				swal({title:"Sukses!",text:"Status Login Siswa berhasil direset.",type:"success"}).then(function() {
					$("#datatable1").dataTable().fnDraw();
					$('#checkall_login').iCheck('uncheck');
					$('#checkall1_login').iCheck('uncheck');
					//window.location.replace('<?php echo site_url('admin/settings/resets')?>');
				});
			}
		});
	});
	$('a.reset_ujian').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			url: url,
			type: 'post',
			data: {},
			success: function(response){
				swal({title:"Sukses!",text:"Ujian Siswa berhasil direset.",type:"success"}).then(function() {
					$("#datatable").dataTable().fnDraw();
					$('#checkall_ujian').iCheck('uncheck');
					$('#checkall1_ujian').iCheck('uncheck');
					//window.location.replace('<?php echo site_url('admin/settings/resets')?>');
				});
			}
		});
	});
	$('.reset_ujian_all').click(function(){
		var names = [];
		var ids = $('.satuan_ujian:checked');
		$(ids).each(function(e,a){
			var he = $(a).val();
			names.push($(a).val());
		});
		if($.isEmptyObject(names)){
			swal({title:"Error",text:"Silahkan checklist terlebih dahulu siswa yang ingin di reset.",type:"error"});
			return false;
		}
		$.ajax({
			url: '<?php echo site_url('admin/tools/reset_ujian')?>',
			type: 'post',
			data: {id:names},
			success: function(response){
				swal({title:"Sukses!",text:"Ujian Siswa berhasil direset.",type:"success"}).then(function() {
					$("#datatable").dataTable().fnDraw();
					//window.location.replace('<?php echo site_url('admin/settings/resets')?>');
				});
			}
		});
	});
	$('a.toggle-modal').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		if (url.indexOf('#') == 0) {
			$('#modal_content').modal('open');
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
				//$('.header').hide();
				//$('#logo').hide();
				$('input:text:visible:first').focus();
			});
		}
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
			//closeOnConfirm: false
			showLoaderOnConfirm: true,
			/*},
			function(){
				$.ajax({
				url: url,
				type: 'post',
				data: {},
				success: function(response){
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						$('#datatable').dataTable().fnReloadAjax();
					});
				}
			});*/
			preConfirm: function() {
				return new Promise(function(resolve) {
					$.get(url)
					//$.post( "test.php", { name: "John", time: "2pm"})
					.done(function(data) {
						//swal.insertQueueStep(data.ip)
						//resolve()
						swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
							$('#datatable').dataTable().fnReloadAjax();
						});
					})
				})
			}
		});
		//return false;
	});
	$('a.reset').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		swal({
			title: "Anda Yakin?",
			text: "Tindakan ini akan mengeluarkan siswa yang sedang login!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Reset Login!",
			closeOnConfirm: false
			},
			function(){
				$.ajax({
				url: url,
				type: 'post',
				data: {},
				success: function(response){
					swal({title:"Sukses!",text:"Login siswa berhasil di reset!.",type:"success"}).then(function() {
						$('#datatable').dataTable().fnReloadAjax();
					});
				}
			});
		});
		//return false;
	});
	$('a.duplicate').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		swal({
			title: "Anda Yakin?",
			text: "Materi ujian ini akan di duplikasi!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Ya!",
			closeOnConfirm: false
			},
			function(){
				$.ajax({
				url: url,
				type: 'post',
				data: {},
				success: function(response){
					//console.log(response);
					var data = $.parseJSON(response);
					swal({title:"Sukses!",text:data.text,type:data.type},function(){
							$('#datatable').dataTable().fnReloadAjax();
					});
				}
			});
		});
		//return false;
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
				swal({
					title: 'Pilih Kurikulum',
					input: 'select',
					inputClass: 'select2',
					inputOptions: data,
					inputPlaceholder: '== Pilih Kurikulum ==',
					showCancelButton: true,
					inputValidator: function(value) {
						return new Promise(function(resolve, reject) {
							if (value === '') {
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
}
    $(function() {
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
		$('#rerata').click(function(){
			var form_data = $('form').serialize();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_rerata');?>',
				type: 'post',
				data: form_data,
				success: function(response){
					//$('#rerata_0').val(response);
					var data = $.parseJSON(response);
					console.log(data.rerata);
					console.log(data.rumus);
					$('#rumus').html(data.rumus);
					if($.isEmptyObject(data.rerata)){
					} else {
						$.each(data.rerata, function (i, item) {
							$('#rerata_'+i).val(item.value);
							$('#rerata_jadi_'+i).val(item.rerata_jadi);
							$('#rerata_text_'+i).html(item.rerata_text);
						});
					}
				}
			});
		});
		$('.icheck').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
		$('.select2').select2();
		$('.tambah_kode').click(function(){
			$('#form_kode').show(1000);
		});
		$('.cancel_kode').click(function(){
			$('#form_kode').hide(1000);
		});
		$('#butir_soal').click(function(){
			window.setTimeout(function() {
				$('#datatable').dataTable().fnReloadAjax();
			}, 1000);
		});
		
    	window.setTimeout(function() { $(".alert-dismissable").hide('slow'); }, 15000);
        //bootstrap WYSIHTML5 - text editor
        $(".editor").wysihtml5();
		var t = $('#datatable').on('draw.dt', function () {
			turn_on_icheck();
		});
		$('#datatable').on( 'processing.dt', function ( e, settings, processing ) {
			$('#spinner').show();
		});
		$('#datatable1').on('draw.dt', function () {
			turn_on_icheck();
		});
		$('#datatable1').on( 'processing.dt', function ( e, settings, processing ) {
			$('#spinner').show();
		});
		
		<?php
		if(isset($uri[4])){
			echo 'var url_saat_ini = "'.site_url('admin/questions/listview').'/'.$uri[4].'";';
		} elseif(isset($uri[3])){
			if($uri[3] == 'kurikulum'){
				$saat_ini = 'list_kurikulum';
			} elseif($uri[3] == 'kompetensi') {
				$saat_ini = 'list_kompetensi';
			} elseif($uri[3] == 'pengetahuan') {
				$saat_ini = 'list_rencana_pengetahuan';
			} elseif($uri[3] == 'keterampilan') {
				$saat_ini = 'list_rencana_keterampilan';
			} elseif($uri[3] == 'deskripsi_mapel') {
				$saat_ini = 'list_deskripsi_mapel';
			} elseif($uri[3] == 'kkm') {
				$saat_ini = 'list_kkm';
			} elseif($uri[3] == 'mulok') {
				$saat_ini = 'list_mulok';
			} elseif($uri[3] == 'ekskul') {
				$saat_ini = 'list_ekskul';
			} elseif($uri[3] == 'catatan') {
				$saat_ini = 'list_catatan';
			} else {
				$saat_ini = 'reset_ujian';
			}
			echo 'var url_saat_ini = "'.site_url('admin/'.$uri[2].'/'.$saat_ini).'";';
		} else {
			echo 'var url_saat_ini = window.location.href+"/listview";';
		}
		?>
		$('#filter_tingkat').change(function(){
			var tingkat = $(this).val();
			$('#filter_rombel').show();
			$('#filter_rombel').html('<option value="">== Filter By Rombel ==</option>');
			$('#datatable').dataTable().fnDestroy();
			<?php if(isset($uri[3])){
			$list = $uri[3];
			if($uri[3] == 'pengetahuan') {
				$list = 'rencana_pengetahuan';
			} elseif($uri[3] == 'keterampilan') {
				$list = 'rencana_keterampilan';
			}
			?>
			var url_saat_ini = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+tingkat;
			<?php } else { ?>
			var url_saat_ini = window.location.href+"/listview/"+tingkat;
			<?php } ?>
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
				"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.ajax( {
					"dataType": 'json',
					"url": sSource,
					"data": aoData,
					"success": function(data, textStatus, jqXHR) {
						// find avatar attached to your "data"
						console.log(data.rombel);
						$.each(data.rombel, function (i, item) {
							$('#filter_rombel').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
						fnCallback(data, textStatus, jqXHR);
					}
				});
			}
        	});
		});
		$('#filter_rombel').change(function(){
			var rombel = $(this).val();
			var tingkat = $('#filter_tingkat').val();
			$('#datatable').dataTable().fnDestroy();
			<?php if(isset($uri[3])){ 
			$list = $uri[3];
			if($uri[3] == 'pengetahuan') {
				$list = 'rencana_pengetahuan';
			} elseif($uri[3] == 'keterampilan') {
				$list = 'rencana_keterampilan';
			}
			?>
			var url_saat_ini = "<?php echo site_url('admin/'.$uri[2].'/list_'.$list).'/';?>"+tingkat+'/'+rombel;
			<?php } else { ?>
			var url_saat_ini = window.location.href+"/listview/"+tingkat+'/'+rombel;
			<?php } ?>
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
        	});
		});
		$('#mapel').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/referensi/get_kurikulum');?>',
				type: 'post',
				data: {id_mapel:id_mapel},
				success: function(response){
					console.log(response);
					$('#nama_kur').val(response);
				}
			});
		});
		$('#mapel_analisis').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			var query = $('#queri').val();
			$('#result').html('');
			$.ajax({
				url: '<?php echo site_url('admin/ajax');?>/get_'+query,
				type: 'post',
				data: {id_mapel:id_mapel},
				success: function(response){
					$('#result').html(response);
				}
			});
		});
		//select input legger start
		$('#rombel_id_siswa').change(function(){
			var rombel_id = $(this).val();
			if(rombel_id == ''){
				return false;
			}
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			$('#form').hide();
			var ajaran_id = $('#ajaran_id').val();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_siswa');?>',
				type: 'post',
				data: {ajaran_id:ajaran_id,rombel_id:rombel_id},
				success: function(response){
					$('.simpan').hide();
					$('#result').html('');
					$('table.table').addClass("jarak");
					var data = $.parseJSON(response);
					$('#siswa_id').html('<option value="">== Pilih Nama Siswa ==</option>');
					$('#siswa_id_portofolio').html('<option value="">== Pilih Nama Siswa ==</option>');
					$('#id_mapel_portofolio').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_mulok').html('<option value="">== Pilih Pelajaran Muatan Lokal ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#siswa_id_portofolio').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
						$.each(data.result, function (i, item) {
							$('#siswa_id').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
						$.each(data.mapel, function (i, item) {
							$('#id_mapel_portofolio').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
						$.each(data.mulok, function (i, item) {
							$('#id_mapel_mulok').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
				}
			});
		});
		$('#id_mapel_mulok').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			var ajaran_id = $('#ajaran_id').val();
			var rombel_id = $('#rombel_id_siswa').val();
			var query = 'mulok';
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_nilai');?>',
				type: 'post',
				data: {query:query,ajaran_id:ajaran_id,id_mapel:id_mapel,rombel_id:rombel_id},
				success: function(response){
					$('.simpan').show();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak");
					$('.add').show();
				}
			});
		});
		$('#siswa_id_portofolio').change(function(){
			var siswa_id = $(this).val();
			if(siswa_id == ''){
				return false;
			}
			var ajaran_id = $('#ajaran_id').val();
			var rombel_id = $('#rombel_id_siswa').val();
			var id_mapel = $('#id_mapel_portofolio').val();
			var query = '';
			if(id_mapel){
				query = 'portofolio';
			} else {
				query = 'mulok';
				id_mapel = $('#id_mapel_mulok').val();
			}
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_nilai');?>',
				type: 'post',
				//data: {query:query,ajaran_id:ajaran_id,id_mapel:id_mapel,rombel_id:rombel_id,siswa_id:siswa_id},
				data: $('form').serialize(),
				success: function(response){
					$('.simpan').hide();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak");
					$('.add').show();
				}
			});
		});
		$('#siswa_id').change(function(){
			var query = $('#query').val();
			var siswa_id = $(this).val();
			if(siswa_id == ''){
				return false;
			}
			var rombel_id = $('#rombel').val();
			if(typeof rombel_id == 'undefined'){
				var rombel_id = $('#rombel_id_siswa').val();
			}
			console.log(rombel_id);
			var ajaran_id = $('#ajaran_id').val();
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen');?>/get_'+query,
				type: 'post',
				data: $('form').serialize(),
				success: function(response){
					$('.simpan').hide();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak");
					$('.add').show();
				}
			});
		});
		$('#rombel').change(function(){
			var rombel_id = $(this).val();
			if(rombel_id == ''){
				return false;
			}
			var ajaran_id = $('#ajaran_id').val();
			$('#result').html('');
			$('.simpan').hide();
			$('.cancel').hide();
			var query = $('#queri').val();
			var result = '';
			$.ajax({
				//url: '<?php echo site_url('admin/laporan');?>/get_'+query,
				url: '<?php echo site_url('admin/ajax');?>/get_'+query,
				type: 'post',
				data: {ajaran_id:ajaran_id,rombel_id:rombel_id},
				success: function(response){
					result = checkJSON(response);
					if(result == true){
						var data = $.parseJSON(response);
						console.log(data);
						$('#ekskul').html('<option value="">== Pilih Ekstrakurikuler ==</option>');
						$('#mapel').html('<option value="">== Pilih Mata Pelajaran ==</option>');
						$('#nama_kur').val(data.nama_kur);
						if($.isEmptyObject(data.mapel)){
						} else {
							$.each(data.mapel, function (i, item) {
								$('#mapel').append($('<option>', { 
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
						$('#siswa_id').html('<option value="">== Pilih Siswa ==</option>');
						if($.isEmptyObject(data.siswa)){
						} else {
							$.each(data.siswa, function (i, item) {
								$('#siswa_id').append($('<option>', { 
									value: item.value,
									text : item.text
								}));
							});
						}
					} else {
						$('.simpan').show();
						$('.cancel').hide();
						$('#form').fadeOut();
						$('#result').html(response);
						$('table.table').addClass("jarak");
						$('.add').show();
					}
				}
			});
		});
		//$('#nilai_ekskul').bind('change',(function(){
		$('#ekskul').change(function(){
			var ekskul_id = $(this).val();
			if(ekskul_id == ''){
				return false;
			}
			var ajaran_id = $('#ajaran_id').val();
			var rombel_id = $('#rombel').val();
			$.ajax({
				url: '<?php echo site_url('admin/laporan/get_ekskul');?>',
				type: 'post',
				data: {ajaran_id:ajaran_id,rombel_id:rombel_id,ekskul_id:ekskul_id},
				success: function(response){
					$('.simpan').show();
					$('.cancel').hide();
					$('#form').fadeOut();
					$('#result').html(response);
					$('table.table').addClass("jarak");
					$('.add').show();
				}
			});
		});
		$('#kelas').change(function(){
			var tingkat = $(this).val();
			if(tingkat == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/laporan/get_rombel');?>',
				type: 'post',
				data: {tingkat:tingkat},
				success: function(response){
					$('.simpan').hide();
					$('#result_kd').html('');
					$('table.table').addClass("jarak");
					var data = $.parseJSON(response);
					$('#rombel').html('<option value="">== Pilih Rombongan Belajar ==</option>');
					$('#rombel_id').html('<option value="">== Pilih Rombongan Belajar ==</option>');
					$('#rombel_id_mapel').html('<option value="">== Pilih Rombongan Belajar ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#rombel').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#rombel_id').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#rombel_id_mapel').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
				}
			});
		});
		$('#rombel_id_mapel').change(function(){
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/perencanaan/get_mapel');?>',
				type: 'post',
				data: $("form").serialize(),//{kompetensi_id:kompetensi_id,ajaran_id:ajaran_id,rombel_id:rombel_id,id_mapel:id_mapel},
				success: function(response){
					$('.simpan').hide();
					$('#result_kd').html('');
					var data = $.parseJSON(response);
					$('#id_mapel_perencanaan').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_perencanaan').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_penilaian').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_deskripsi').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#siswa_id_analisis').html('<option value="">== Pilih Nama Siswa ==</option>');
					$('#siswa_id_portofolio').html('<option value="">== Pilih Nama Siswa ==</option>');
					$('#id_mapel_portofolio').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#id_mapel_perencanaan').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#id_mapel_penilaian').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#id_mapel_deskripsi').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#id_mapel_portofolio').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
					if($.isEmptyObject(data.siswa)){
					} else {
						$.each(data.siswa, function (i, item) {
							$('#siswa_id_analisis').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#siswa_id_portofolio').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
				}
			});
		});
		$('#rombel_id_perencanaan').change(function(){
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/perencanaan/get_mapel');?>',
				type: 'post',
				data: {id_rombel:id_rombel},
				success: function(response){
					$('.simpan').hide();
					$('#result_kd').html('');
					var data = $.parseJSON(response);
					$('#id_mapel_perencanaan').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_perencanaan').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_penilaian').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#id_mapel_deskripsi').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					$('#siswa_id_analisis').html('<option value="">== Pilih Nama Siswa ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
							$('#id_mapel_perencanaan').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#id_mapel_penilaian').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
							$('#id_mapel_deskripsi').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
					if($.isEmptyObject(data.siswa)){
					} else {
						$.each(data.siswa, function (i, item) {
							$('#siswa_id_analisis').append($('<option>', { 
								value: item.value,
								text : item.text
							}));
						});
					}
				}
			});
		});
		$('#id_mapel_penilaian').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			$('#result').html('');
			$("#siswa_id_analisis").prop('selectedIndex', 0);
			var rombel_id = $('#rombel_id_perencanaan').val();
			var ajaran_id = $('#ajaran_id').val();
			var kompetensi_id = $('#kompetensi_id').val();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_rencana_penilaian');?>',
				type: 'post',
				data: $("form").serialize(),//data: {kompetensi_id:kompetensi_id,ajaran_id:ajaran_id,rombel_id:rombel_id,id_mapel:id_mapel},
				success: function(response){
					var data = $.parseJSON(response);
					$('#penilaian_penugasan').html('<option value="">== Pilih Penilaian ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
						$('#penilaian_penugasan').append($('<option>', { 
							value: item.value,
							text : item.text,
							}));
						});
					}
				}
			});
		});
		$('#siswa_id_analisis').change(function(){
			if($(this).val() == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/ajax/get_analisis_individu');?>',
				type: 'post',
				data: $("form").serialize(),
				success: function(response){
					$('#result').html(response);
				}
			});
		});
		$('#id_mapel_deskripsi').change(function(){
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			var rombel_id = $('#rombel_id_perencanaan').val();
			var ajaran_id = $('#ajaran_id').val();
			var kompetensi_id = $('#kompetensi_id').val();
			$.ajax({
				url: '<?php echo site_url('admin/asesmen/get_deskripsi_mapel');?>',
				type: 'post',
				//data: {kompetensi_id:kompetensi_id,ajaran_id:ajaran_id,rombel_id:rombel_id,id_mapel:id_mapel},
				data: $("form").serialize(),
				success: function(response){
					$('.simpan').show();
					$('#result').html(response);
					$('table.table').addClass("jarak");
				}
			});
		});
		$('#penilaian_penugasan').change(function(){
			var rencana_id = $(this).val();
			if(rencana_id == ''){
				return false;
			}
			var ajaran_id = $('#ajaran_id').val();
			$('#result').html('');
			$('#rerata').hide();
			var query = $('#queri').val();
			$.ajax({
				//url: '<?php echo site_url('admin/asesmen/get_kd_penilaian');?>',
				url: '<?php echo site_url('admin/ajax');?>/get_'+query,
				type: 'post',
				data: {ajaran_id:ajaran_id,rencana_id:rencana_id},
				success: function(response){
					//$('.simpan').show();
					$('#rerata').show();
					$('#result').html(response);
					//$('table.table').addClass("jarak");
				}
			});
		});
		$("#rerata").click(function(){
			$(this).hide();
			$(".simpan").show();
		});
		$('#id_mapel_perencanaan').change(function(){
			var kompetensi_id = $('#kompetensi_id').val();
			var ajaran_id = $('#ajaran_id').val();
			var id_rombel = $('#rombel_id_perencanaan').val();
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/perencanaan/get_kd');?>',
				type: 'post',
				data: {kompetensi_id:kompetensi_id,ajaran_id:ajaran_id,id_mapel:id_mapel,id_rombel:id_rombel},
				success: function(response){
					$('#result_kd').html(response);
					$('table.table').addClass("jarak");
					$('.simpan').show();
				}
			});
		});
		//select input legger start
		$('#pilih_rombel_cetak').change(function(){
			$('#pilih_smt_cetak').prop('selectedIndex',0);
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/cetak/pilih_smt');?>',
				type: 'post',
				data: {id_rombel:id_rombel},
				success: function(response){
					var data = $.parseJSON(response);
					$('#pilih_smt_cetak').html('<option value="">== Pilih Semester ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
						$('#pilih_smt_cetak').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
		});
		$('#pilih_smt_cetak').change(function(){
			var id_smt = $(this).val();
			if(id_smt == ''){
				return false;
			}
			var id_mapel = $('#pilih_mapel_cetak').val();
			var id_rombel = $('#pilih_rombel_cetak').val();
			var tanggal_raport = $('#tanggal_raport').val();
			var selected = $(this).find('option:selected');
			var aksi = selected.data('aksi');
			if(tanggal_raport == ''){
				swal({title:"Gagal Menampilkan Data!",text:"Tanggal Raport Harus Diisi.",type:"error"},function(){
						$('#pilih_rombel_cetak').prop('selectedIndex',0);
						$('#pilih_smt_cetak').prop('selectedIndex',0);
					});
				return false;
			}
			<?php if($cetak == ''){ ?>
			if(id_smt == ''){
				return false;
			}
			<?php }?>
			$.ajax({
				url: '<?php echo site_url('admin/cetak/generate_'.$cetak);?>',
				type: 'post',
				data: {id_smt:id_smt,id_mapel:id_mapel,id_rombel:id_rombel,tanggal_raport:tanggal_raport},
				success: function(response){
					$('#result_cetak').show();
					$('#result_centak').addClass("jarak");
					$('#response_cetak').html(response);
				}
			});
		});
		//select input legger end
		//select input absen start
		$('#pilih_rombel_absen').change(function(){
			var id_rombel = $(this).val();
			var id_smt = $('#id_smt').val();
			if(id_rombel == ''){
				return false;
			}
			$( "#table_absensi" ).load( "<?php echo site_url('admin/absensi/pilih_rombel_absen');?>",{"id_rombel":id_rombel,"id_smt":id_smt});
		});
		$('#pilih_rombel_ekskul').change(function(){
			var id_rombel = $(this).val();
			var id_smt = $('#id_smt').val();
			var ekskul_id = $('#ekskul_id').val();
			if(id_rombel == ''){
				return false;
			}
			$( "#table_absensi" ).load( "<?php echo site_url('admin/ekstrakurikuler/pilih_rombel');?>",{"id_rombel":id_rombel,"id_smt":id_smt,"ekskul_id":ekskul_id});
		});
		//select input absen end
		//select deskripsi start
		$('#pilih_rombel_desk').change(function(){
			$('#pilih_mapel_desk').prop('selectedIndex',0);
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/entry/pilih_rombel_nilai');?>',
				type: 'post',
				data: {id_rombel:id_rombel},
				success: function(response){
					var data = $.parseJSON(response);
					$('#pilih_mapel_desk').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					if($.isEmptyObject(data.mapel)){
					} else {
						$.each(data.mapel, function (i, item) {
						$('#pilih_mapel_desk').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
		});
		// select deskripsi end
		//select input nilai start
		$('#pilih_rombel_entry_nilai').change(function(){
			var id_pilih_rombel_entry_nilai = $(this).val();
			if(id_pilih_rombel_entry_nilai == ''){
				return false;
			}
			var selected = $(this).find('option:selected');
			var code_id = selected.data('code_id');
			console.log(code_id);
			$( "#table_entry_nilai" ).load( "<?php echo site_url('admin/entry/pilih_rombel');?>",{"id_rombel":id_pilih_rombel_entry_nilai,"code_id":code_id}, function() {
				console.log('show');
				$('#simpan_nilai').show();
			});
		});
		$('#pilih_rombel_nilai').change(function(){
			$('#pilih_mapel_nilai').prop('selectedIndex',0);
			$('#pilih_smt_nilai').prop('selectedIndex',0);
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$('#proses_penilaian').hide();
			$.ajax({
				url: '<?php echo site_url('admin/entry/pilih_rombel_nilai');?>',
				type: 'post',
				data: {id_rombel:id_rombel},
				success: function(response){
					var data = $.parseJSON(response);
					$('#pilih_mapel_nilai').html('<option value="">== Pilih Mata Pelajaran ==</option>');
					if($.isEmptyObject(data.mapel)){
						console.log(data.mapel);
						console.log('atas');
					} else {
						console.log(data.mapel);
						console.log('bawah');
						$.each(data.mapel, function (i, item) {
						$('#pilih_mapel_nilai').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
			$('#datatable').dataTable().fnDestroy();
			<?php if(isset($uri[3])){ ?>
			var url_saat_ini = "<?php echo site_url('admin/'.$uri[2].'/');?>/rekap_nilai/"+id_rombel;
			<?php } else { ?>
			var url_saat_ini = window.location.href+"/listview/"+id_rombel;
			<?php } ?>
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
        	});
		});
		$('#pilih_mapel_nilai').change(function(){
			$('#pilih_smt_nilai').prop('selectedIndex',0);
			var id_rombel = $('#pilih_rombel_nilai').val();
			var id_mapel = $(this).val();
			if(id_mapel == ''){
				return false;
			}
			$('#proses_penilaian').hide();
			$.ajax({
				url: '<?php echo site_url('admin/entry/pilih_mapel_nilai');?>',
				type: 'post',
				data: {id_mapel:id_mapel},
				success: function(response){
					var data = $.parseJSON(response);
					$('#pilih_smt_nilai').html('<option value="">== Pilih Semester ==</option>');
					if($.isEmptyObject(data.mapel)){
					} else {
						$.each(data.mapel, function (i, item) {
						$('#pilih_smt_nilai').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
			$('#datatable').dataTable().fnDestroy();
			<?php if(isset($uri[3])){ ?>
			var url_saat_ini = "<?php echo site_url('admin/'.$uri[2].'/');?>/rekap_nilai/"+id_rombel;
			<?php } else { ?>
			var url_saat_ini = window.location.href+"/listview/"+id_rombel+"/"+id_mapel;
			<?php } ?>
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
        	});
		});
		$('#pilih_smt_nilai').change(function(){
			var id_rombel = $('#pilih_rombel_nilai').val();
			var id_mapel = $('#pilih_mapel_nilai').val();
			var id_smt = $(this).val();
			if(id_smt == ''){
				return false;
			}
			$('#proses_penilaian').hide();
			var kompetensi_id = $('#pilih_kompetensi_nilai').val();
			$('#datatable').dataTable().fnDestroy();
			<?php if(isset($uri[3])){ ?>
			var url_saat_ini = "<?php echo site_url('admin/'.$uri[2].'/');?>/rekap_nilai/"+id_rombel;
			<?php } else { ?>
			var url_saat_ini = window.location.href+"/listview/"+id_rombel+"/"+id_mapel+"/"+id_smt;
			<?php } ?>
			$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
        	});
			$('#proses_penilaian').show();
			$('a#proses_penilaian').attr('href','<?php echo site_url('admin/entry/nilai'); ?>'+'/'+id_mapel+'/'+kompetensi_id);
		});
		$('#rombel_id').change(function(){
			var id_rombel = $(this).val();
			if(id_rombel == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/ajax/get_siswa');?>',
				type: 'post',
				data: $('form').serialize(),
				success: function(response){
					var data = $.parseJSON(response);
					$('#siswa_id').html('<option value="">== Pilih Nama Siswa ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
						$('#siswa_id').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
		});
		$('#kompetensi_id').change(function(){
			var kompetensi_id = $(this).val();
			if(kompetensi_id == ''){
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/entry/get_kompetensi');?>',
				type: 'post',
				data: {kompetensi_id:kompetensi_id},
				success: function(response){
					var data = $.parseJSON(response);
					$('#penilaian_id').html('<option value="">== Pilih Jenis Penilaian ==</option>');
					if($.isEmptyObject(data.result)){
					} else {
						$.each(data.result, function (i, item) {
						$('#penilaian_id').append($('<option>', { 
							value: item.value,
							text : item.text
							}));
						});
					}
				}
			});
		});
		//select input nilai end
		$('#datatable1').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: '<?php echo site_url('admin/settings/reset_login'); ?>',
        });
		$('#datatable').dataTable({
				"sPaginationType"	: "bootstrap",
				"bProcessing"		: false,
				"bServerSide"		: true, 
				"iDisplayLength"	:10,
				"aoColumns"			: null,
				"bSort"				: false,
				"sAjaxSource"		: url_saat_ini,
        });
		$(".datatable").dataTable({ "bLengthChange": false, "bSort": false });
        $('div.dataTables_filter input').focus();
		$('form').validate({
			ignore: [], 
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				element
				.closest('.form-group').removeClass('has-error').addClass('has-success');
			}
		});
		//Popover
		$('.btn_reset').click(function(){
			//$('#tombol_reset').show();
			swal({title:"Informasi",text:"Fitur reset database di versi demo di non aktifkan.",type:"success"});
		});
		//$('.btn_delete').popover({ html : true, singleton : false});
		$(document).on("click", '.btn-delete', function (e) {
			e.preventDefault(); 
			var btn = $(this);
			var url = $(this).attr('href');
			$.ajax({
				url: url,
				type: 'post',
				data: {},
				beforeSend: function(){
					$(this).addClass('disabled'); 
				},
				success: function(response){
					if(response == 'terus') {
						window.location.replace('<?php echo site_url('admin/dashboard?reset=true')?>');
					}
					if(response == 'guru') {
						window.location.replace('<?php echo site_url('admin/dashboard')?>');
					}
					if(response == 'delete_guru') {
						window.location.replace('<?php echo site_url('admin/guru')?>');
					}
					if(response == 'delete_siswa') {
						window.location.replace('<?php echo site_url('admin/siswa')?>');
					}
					if(response == 'delete_mapel'){
						window.location.replace('<?php echo site_url('admin/mapel')?>');
					}
					$('.btn_delete').popover('hide'); 
					btn.parents('tr').remove(); 
				}
			});
			return false;
		});
		//var tombol = $('#DataTables_Table_0_wrapper').find('.col-xs-6').first();
		//$(tombol).html('');
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
				url: '<?php echo site_url('admin/'.$multidelete.'/multidelete');?>',
				type: 'post',
				data: {id:names},
				success: function(response){
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						$('#checkall').iCheck('uncheck');
						$('#checkall1').iCheck('uncheck');
						$('#datatable').dataTable().fnReloadAjax();
					});
				}
			});
		});
		$('.aktif_nilai').click(function(){
			var names = [];
			var ids = $('.satuan:checked');
			$(ids).each(function(e,a){
				var he = $(a).val();
				names.push($(a).val());
			});
			if($.isEmptyObject(names)){
				swal({title:"Error",text:"Silahkan checklist terlebih dahulu data yang ingin diaktifkan.",type:"error"});
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/penilaian/aktifkan')?>',
				type: 'post',
				data: {id:names},
				success: function(response){
					$('#checkall').iCheck('uncheck');
					$('#checkall1').iCheck('uncheck');
					$('#datatable').dataTable().fnReloadAjax();
				}
			});
		});
		$('.nonaktif_nilai').click(function(){
			var names = [];
			var ids = $('.satuan:checked');
			$(ids).each(function(e,a){
				var he = $(a).val();
				names.push($(a).val());
			});
			if($.isEmptyObject(names)){
				swal({title:"Error",text:"Silahkan checklist terlebih dahulu data yang ingin dinonaktifkan.",type:"error"});
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('admin/penilaian/nonaktifkan')?>',
				type: 'post',
				data: {id:names},
				success: function(response){
					$('#checkall').iCheck('uncheck');
					$('#checkall1').iCheck('uncheck');
					$('#datatable').dataTable().fnReloadAjax();
				}
			});
		});
		$(document).on("click", '.btn-close', function (e) {
			$('.btn_delete').popover('hide'); 
		});
		$('body').on('click', function (e) {
			$('.btn_delete').each(function () {
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
					$(this).popover('hide');
				}
			});
		});
	// Load modal windows via ajax.
	$('a.toggle-modal').bind('click',function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		if (url.indexOf('#') == 0) {
			$('#modal_content').modal('open');
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
				//$('.header').hide();
				//$('#logo').hide();
				$('input:text:visible:first').focus();
			});
		}
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
			closeOnConfirm: false
			},
			function(){
				$.ajax({
				url: url,
				type: 'post',
				data: {},
				success: function(response){
					swal({title:"Data Terhapus!",text:"Data berhasil dihapus.",type:"success"}).then(function() {
						var url      = window.location.href;     // Returns full URL
						window.location.replace(url);
					});
				}
			});
		});
		//return false;
	});
	$.ajaxSetup ({
		// Disable caching of AJAX responses
		cache: false
	});
	$('#button_form').click(function(){
		alert('asd');
	});
	$('#id_guru').change(function(){
		var selected = $(this).find('option:selected');
		var id_guru = selected.data('guru_id'); 
		$('#guru_id').val(id_guru);
	});
	$('#category_id_upload').change(function(){
		if($(this).val() == ''){
			$('#download_template').hide();
			$('.btn-file').hide();
		} else {
			$('#download_template').show();
			$('.btn-file').show();
		}
		var urlku = $('#download_template').attr('href');
		$('#download_template').attr('href','../downloads/template_'+$(this).val()+'.xlsx');
		$('a#download_template span').text($(this).val());
	});
	var url = '<?php echo site_url('import').'/'.$upload;?>';
	console.log(url);
	console.log(url_saat_ini);
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
			//$('.noty').hide();
		}, 5000);
		swal({title:data.result.title,type:data.result.type,html:data.result.text});
	}).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
});
</script>