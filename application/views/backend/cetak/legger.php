<?php
$rombel = Datarombel::find($rombel_id);
if(isset($query) && $query == 'wali'){
?>
<div class="row">
<div class="col-md-12">
<div class="box box-info">
    <div class="box-body">
<?php } ?>
<div style="clear:both;"></div>
<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
			<tr>
				<td class="text-center">
					<p>Download Legger Pengetahuan Kelas <?php echo $rombel->nama; ?></p>
					<p><a href="<?php echo site_url('admin/cetak/legger/'.$ajaran_id.'/'.$rombel_id.'/1'); ?>" target="_blank" class="btn btn-social-icon btn-dropbox tooltip-left" title="Download Legger Pengetahuan Kelas <?php echo $rombel->nama; ?>">
						<i class="fa fa-cloud-download"></i></a></p>
				</td>
				<td class="text-center">
					<p>Download Legger Keterampilan Kelas <?php echo $rombel->nama; ?></p>
					<p><a href="<?php echo site_url('admin/cetak/legger/'.$ajaran_id.'/'.$rombel_id.'/2'); ?>" target="_blank" class="btn btn-social-icon btn-google tooltip-left" title="Download Legger Keterampilan Kelas <?php echo $rombel->nama; ?>">
						<i class="fa fa-cloud-download"></i>
					</a></p>
				</td>
				<!--td class="text-center">
					<p>Download Legger Sikap Kelas <?php echo $rombel->nama; ?></p>
					<p><a href="<?php echo 'javascript:void(0)';//echo site_url('admin/cetak/legger/'.$ajaran_id.'/'.$rombel_id.'/3'); ?>" class="btn btn-social-icon btn-facebook tooltip-left" title="Download Legger Sikap Kelas <?php echo $rombel->nama; ?>">
					<i class="fa fa-cloud-download"></i></a></p>
				</td-->
			</tr>
		</tbody>
	</table>
</div>
<?php if(isset($query) && $query == 'wali'){ ?>
</div>
</div>
</div>
</div>
<?php } ?>
<script>
$('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 2}
  })
</script>