<style>
#sortable1, #sortable2 {list-style-type: none;margin: 0;padding: 5px 0 0 0;border: 1px solid #eee;
overflow: scroll;
height: 450px;}
#sortable1 li, #sortable2 li {border: 1px solid #eee;margin: 0 5px 5px 5px;padding: 5px;}
#sortable1 li:hover, #sortable2 li:hover{cursor:move;}
.ui-state-highlight{background:#CCCCCC;height: 2.5em;}
.ui-sortable-helper {
    display: table;
}
</style>
<input type="hidden" id="rombel_id" value="<?php echo $id_rombel; ?>" />
<script>
$(function(){
	var rombel_id = $('#rombel_id').val();
	$( "#sortable1, #sortable2" ).sortable({
		placeholder: "ui-state-highlight",
		connectWith: ".connectedSortable"
	}).disableSelection();
	$( "#sortable2" ).on( "sortreceive", function( event, ui ) {
		var siswa_id = ui.item.find('input').val();
		console.log('receive');
		$.ajax({
			url: '<?php echo site_url('admin/rombel/simpan_anggota');?>',
			type: 'post',
			data: {rombel_id:rombel_id,siswa_id:siswa_id},
			success: function(response){
				var view = $.parseJSON(response);
				noty({
					text        : view.text,
					type        : view.type,
					timeout		: 1500,
					dismissQueue: true,
					layout      : 'top',
					animation: {
						open: {height: 'toggle'},
						close: {height: 'toggle'}, 
						easing: 'swing', 
						speed: 500 
					}
				});
			}
		});
	} );
	$( "#sortable2" ).on( "sortremove", function( event, ui ) {
		var siswa_id = ui.item.find('input').val();
		console.log('remove');
		$.ajax({
			url: '<?php echo site_url('admin/rombel/hapus_anggota');?>',
			type: 'post',
			data: {rombel_id:rombel_id,siswa_id:siswa_id},
			success: function(response){
				var view = $.parseJSON(response);
				noty({
					text        : view.text,
					type        : view.type,
					timeout		: 1500,
					dismissQueue: true,
					layout      : 'top',
					animation: {
						open: {height: 'toggle'},
						close: {height: 'toggle'}, 
						easing: 'swing', 
						speed: 500 
					}
				});
			}
		});
	} );
});
</script>
<div class="row">
	<div class="row">
		<div class="col-xs-12">
			<ul id="sortable1" class="connectedSortable col-xs-6">
			<?php foreach($free as $f){ ?>
				<li class="ui-state-default">
				<input type="hidden" name="siswa" value="<?php echo $f->id; ?>" />
				<?php echo $f->nama; ?>
				</li>
			<?php } ?>
			</ul>
			<form id="anggota">
			<ul id="sortable2" class="connectedSortable col-xs-6">
				<?php foreach($anggota as $a){
				$siswa = Datasiswa::find_by_id($a->siswa_id);
				?>
				<li class="ui-state-highlight">
					<input type="hidden" name="siswa" value="<?php echo isset($siswa->id) ? $siswa->id : ''; ?>" />
					<?php echo isset($siswa->nama) ? $siswa->nama : ''; ?>
				</li>
				<?php } ?>
			</ul>
			</form>
		</div>
     </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.noty.packaged.js"></script>
<script type="text/javascript">
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
$('.simpan_anggota').click(function(){
	var data = $("form#anggota").serializeObject();
	var result = $.parseJSON(JSON.stringify(data));
	console.log(result);
	$.each(result.siswa, function (i, item) {
		console.log(item);
		$.ajax({
			url: '<?php echo site_url('admin/rombel/simpan_anggota');?>',
			type: 'post',
			data: {rombel_id:result.rombel_id,siswa_id:item},
			success: function(response){
				var view = $.parseJSON(response);
				noty({
					text        : view.text,
					type        : view.type,
					timeout		: 1500,
					dismissQueue: true,
					layout      : 'top',
					animation: {
						open: {height: 'toggle'},
						close: {height: 'toggle'}, 
						easing: 'swing', 
						speed: 500 
					}
				});
			}
		});
	});
	$('#modal_content').modal('hide');
});
</script>	