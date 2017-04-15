<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title">Data Deskripsi Per Mata Pelajaran Tahun Pelajaran <?php echo $ajaran; ?></h3>
			</div>
		    <div class="box-body">
				<table class="table table-bordered">
					<tr>
						<th>No.</th>
						<th>Mata Pelajaran</th>
						<th>Deskripsi Pengetahuan</th>
						<th>Deskripsi Keterampilan</th>
					</tr>
					<?php
					$i=1;
					foreach($deskripsi as $desc){
						if($desc->deskripsi_mulok){
							$get_nama_mapel = Mulok::find_by_id($desc->mapel_id);
							$nama_mapel = $get_nama_mapel->nama_mulok;
						} else {
							$get_nama_mapel = Datamapel::find_by_id_mapel($desc->mapel_id);
							$nama_mapel = $get_nama_mapel->nama_mapel;
						}
						?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $nama_mapel; ?></td>
						<?php if($desc->deskripsi_mulok){ ?>
						<td colspan="2"><?php echo $desc->deskripsi_mulok; ?></td>
						<?php } else { ?>
						<td><?php echo $desc->deskripsi_pengetahuan; ?></td>
						<td><?php echo $desc->deskripsi_keterampilan; ?></td>
						<?php } ?>
					</tr>
						<?php
						$i++;
					}
					?>
				</table>
			</div>
			<div class="box-footer">
			</div>
		</div>
	</div>
</div>