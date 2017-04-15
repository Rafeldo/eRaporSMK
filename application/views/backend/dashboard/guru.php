<?php
$user = $this->ion_auth->user()->row();
$ajaran = get_ta();
$cari_mapel = Kurikulum::find_all_by_ajaran_id_and_guru_id($ajaran->id, $user->data_guru_id);
//$cari_mulok = Mulok::find_all_by_ajaran_id_and_guru_id($ajaran->id, $user->data_guru_id);
$cari_rombel = Datarombel::find_by_guru_id($user->data_guru_id);
?>
<h4 class="page-header">Mata Pelajaran yang diampu di Tahun Pelajaran <?php echo $ajaran->tahun; ?> Semester <?php echo $ajaran->smt; ?></h4>
<div class="row">
	<div class="col-lg-12 col-xs-12">
	<?php if($cari_mapel){ ?>
		<table class="table table-bordered table-striped table-hover datatable">
			<thead>
				<tr>
					<th style="width: 10px">#</th>
					<th>Mata Pelajaran</th>
					<th>Rombel</th>
					<th>Wali Kelas</th>
					<th class="text-center">Jumlah Siswa</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=1;
				foreach($cari_mapel as $m){
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo get_nama_mapel($ajaran->id,$m->rombel_id,$m->id_mapel); ?></td>
					<td><?php echo get_nama_rombel($m->rombel_id); ?></td>
					<td><?php echo get_wali_kelas($m->rombel_id); ?></td>
					<td class="text-center"><?php echo get_jumlah_siswa($m->rombel_id); ?></td>
				</tr>
				<?php $i++;
				 }
				 ?>
			</tbody>
		</table>
	<?php } else { ?>
			<table class="table table-bordered table-striped table-hover">
				<tr><td class="text-center">Anda tidak memiliki jadwal mengajar!</td></tr>
			</table>
		<?php } if($cari_rombel){
		$this->load->view('backend/dashboard/walas');
		}
		?>
	</div>
</div>
<?php
/*?>

				
					
				<?php 
				}
				?>
			</tbody>
		</table>
		<?php } 
		
				
			</tbody>
		</table>
		
			
		<?php } ?>
		<?php ?>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-xs-12">
		<section id="mata-pelajaran">
			<h4>Anda adalah Wali Kelas Rombongan Belajar <span class="btn btn-success"><?php echo $cari_rombel->nama; ?></span></h4>
			<h5>Daftar Mata Pelajaran di Rombongan Belajar <span class="btn btn-success btn-xs"><?php echo (isset($cari_rombel)) ? $cari_rombel->nama: ''; ?></span></h5>
			<div class="row">
				<div class="col-lg-12 col-xs-12" style="margin-bottom:20px;">
					<table class="table table-bordered table-striped table-hover datatable">
						<thead>
							<tr>
								<th style="width: 10px" class="text-center">#</th>
								<th>Mata Pelajaran</th>
								<th>Guru Mata Pelajaran</th>
								<th class="text-center">Kelas</th>
								<th class="text-center">Jumlah Siswa</th>
							</tr>
						</thead>
						<tbody>
					<?php
					$all_mapel = Kurikulum::find_all_by_rombel_id($cari_rombel->id);
					if($all_mapel){
						$count = 1;
						foreach($all_mapel as $m){
							$rombel = Datarombel::find($m->rombel_id);
							$mapel = Datamapel::find($m->id_mapel);
							$guru = Dataguru::find($m->guru_id);
							$jumlah_siswa = Datasiswa::find_all_by_data_rombel_id($rombel->id);
						?>
							<tr>
								<td class="text-center"><?php echo $count; ?>.</td> 
								<td><?php echo $mapel->nama_mapel; ?></td>  
								<td><?php echo $guru->nama; ?></td>
								<td class="text-center"><?php echo $rombel->nama; ?></td>
								<td class="text-center"><?php echo count($jumlah_siswa); ?></td>
							</tr>
						<?php
							$count++;
						}
					}
					$all_mulok = Mulok::find_all_by_rombel_id($cari_rombel->id);
					if($all_mulok){
						$count = $count;
						foreach($all_mulok as $mulok){
							$rombel = Datarombel::find($mulok->rombel_id);
							$guru = Dataguru::find($mulok->guru_id);
							$jumlah_siswa = Datasiswa::find_all_by_data_rombel_id($rombel->id);
						?>
							<tr>
								<td class="text-center"><?php echo $count; ?>.</td> 
								<td><?php echo $mulok->nama_mulok; ?></td>  
								<td><?php echo $guru->nama; ?></td>
								<td class="text-center"><?php echo $rombel->nama; ?></td>
								<td class="text-center"><?php echo count($jumlah_siswa); ?></td>
							</tr>
						<?php
							$count++;
						}
					}
					?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<?php } */?>