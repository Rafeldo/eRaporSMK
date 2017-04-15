<?php
$get_rerata_pengetahuan = 0;
$get_rerata_keterampilan = 0;
$siswa = Datasiswa::find_by_id($siswa_id);
$kkm_value = get_kkm($ajaran_id, $rombel_id,$id_mapel);
$all_rencana_pengetahuan = Rencana::find_all_by_ajaran_id_and_rombel_id_and_id_mapel_and_kompetensi_id($ajaran_id, $rombel_id, $id_mapel, 1);
foreach($all_rencana_pengetahuan as $ren){
	$id_rencana_pengetahuan[] = $ren->id;
}
$all_rencana_keterampilan = Rencana::find_all_by_ajaran_id_and_rombel_id_and_id_mapel_and_kompetensi_id($ajaran_id, $rombel_id, $id_mapel, 2);
foreach($all_rencana_keterampilan as $ren){
	$id_rencana_keterampilan[] = $ren->id;
}
if(isset($id_rencana_pengetahuan)){
	$axisLabel_pengetahuan = 'Kompetensi Dasar Pengetahuan';
	$label_pengetahuan = "Nilai Pengetahuan per KD";
	$get_all_bobot_pengetahuan = Rencanapenilaian::find('all', array('group' => 'nama_penilaian','order'=>'id ASC', 'conditions' => array("rencana_id IN(?)",$id_rencana_pengetahuan)));
	foreach($get_all_bobot_pengetahuan as $getbobotp){
		$get_nilai_pengetahuan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 1, $siswa->data_rombel_id, $id_mapel, $siswa_id, $getbobotp->id);
		$get_rerata_pengetahuan += isset($get_nilai_pengetahuan->rerata_jadi) ? $get_nilai_pengetahuan->rerata_jadi : 0;
	}
	$all_pengetahuan = Rencanapenilaian::find('all', array('conditions' => array('rencana_id IN (?)', $id_rencana_pengetahuan)));
	if($all_pengetahuan){
		foreach($all_pengetahuan as $ap){
			$get_nilai_pengetahuan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 1, $siswa->data_rombel_id, $id_mapel, $siswa_id, $ap->id);
			$kd = Kd::find_by_id($ap->kd_id);
			$get_kd_pengetahuan[] = 
			array(
				'id' => isset($kd->id_kompetensi_alias) && ($kd->id_kompetensi_alias) ? $kd->id_kompetensi_alias : $kd->id_kompetensi,
				'nilai' => isset($get_nilai_pengetahuan->nilai) ? $get_nilai_pengetahuan->nilai : 0,
				'nama' => $ap->nama_penilaian,
			);
		}
	} else {
		$get_kd_pengetahuan = array();
	}
}
if(isset($id_rencana_keterampilan)){
	$axisLabel_keterampilan = 'Kompetensi Dasar Keterampilan';
	$label_keterampilan = "Nilai Keterampilan per KD";
	$get_all_bobot_keterampilan = Rencanapenilaian::find('all', array('group' => 'nama_penilaian','order'=>'id ASC', 'conditions' => array("rencana_id IN(?)",$id_rencana_keterampilan)));
	foreach($get_all_bobot_keterampilan as $getbobotk){
		$get_nilai_keterampilan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 2, $siswa->data_rombel_id, $id_mapel, $siswa_id, $getbobotk->id);
		$get_rerata_keterampilan += isset($get_nilai_keterampilan->rerata_jadi) ? $get_nilai_keterampilan->rerata_jadi : 0;
	}
	$all_keterampilan = Rencanapenilaian::find('all', array('conditions' => array('rencana_id IN (?)', $id_rencana_keterampilan)));
	if($all_keterampilan){
		foreach($all_keterampilan as $ak){
			$get_nilai_keterampilan = Nilai::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($ajaran_id, 2, $siswa->data_rombel_id, $id_mapel, $siswa_id, $ak->id);
			$kd = Kd::find_by_id($ak->kd_id);
			$get_kd_keterampilan[] = 
			array(
				'id' => isset($kd->id_kompetensi_alias) && ($kd->id_kompetensi_alias) ? $kd->id_kompetensi_alias : $kd->id_kompetensi,
				'nilai' => isset($get_nilai_keterampilan->nilai) ? $get_nilai_keterampilan->nilai : 0,
				'nama' => $ak->nama_penilaian,
			);
		}
	} else {
		$get_kd_keterampilan = array();
	}
} 
?>
<p><strong>Sebaran Hasil Penilaian</strong></p>
<div class="col-sm-6">
	<table class="table table-bordered table-striped">
		<tr>
			<th width="40%">KKM</th>
			<th class="text-center" width="5%">:</th>
			<th width="55%"><?php echo $kkm_value; ?></th>
		</tr>
		<tr>
			<th>Nilai rata-rata</th>
			<th class="text-center">:</th>
			<th><?php echo number_format($get_rerata_pengetahuan,0); ?></th>
		</tr>
	</table>
	<div id="bar_pengetahuan" style="height: 400px;"></div>
</div>
<div class="col-sm-6">
		<table class="table table-bordered table-striped">
		<tr>
			<th width="40%">KKM</th>
			<th class="text-center" width="5%">:</th>
			<th width="55%"><?php echo $kkm_value; ?></th>
		</tr>
		<tr>
			<th>Nilai rata-rata</th>
			<th class="text-center">:</th>
			<th><?php echo number_format($get_rerata_keterampilan,0); ?></th>
		</tr>
	</table>
	<div id="bar_keterampilan" style="height: 400px;"></div>
</div>
<?php echo link_tag('assets/css/tooltip-viewport.css', 'stylesheet', 'text/css'); ?>
<!-- FLOT CHARTS -->
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.categories.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.tickrotor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/plugins/flot/jquery.flot.axislabels.js"></script>
<script src="<?php echo base_url()?>assets/js/tooltip-viewport.js"></script>
<script>
$(function () {
	/*
	* BAR CHART
	* --------
	*/
	var a1 = [
		<?php
		if(isset($get_kd_pengetahuan)){
		$i=0;
		foreach($get_kd_pengetahuan as $getkdp){
			echo '['.$i.', "'. $getkdp['nilai'].'"],';
		$i++;
		}
		}
		?>
    ];
	var a2 = [
		<?php
		if(isset($get_kd_keterampilan)){
		$i=0;
		foreach($get_kd_keterampilan as $getkdk){
			echo '['.$i.', "'. $getkdk['nilai'].'"],';
		$i++;
		}
		}
		?>
    ];
	var kkm1 = [
        [0, <?php echo $kkm_value; ?>],
        [<?php echo count($get_kd_pengetahuan) - 1; ?>, <?php echo $kkm_value; ?>]
    ];
	var kkm2 = [
        [0, <?php echo $kkm_value; ?>],
        [<?php echo count($get_kd_keterampilan) - 1; ?>, <?php echo $kkm_value; ?>]
    ];
	var bar_data_pengetahuan = [
		{
			label: "<?php echo $label_pengetahuan; ?>",
			data: a1,
			bars: {
					show: true,
					barWidth: 0.5,
					align: "center"
					},
			color: "#3c8dbc",
		},
		{
            label: "KKM",
            data: kkm1,
            lines: {
                show: true,
                fill: false
            },
            points: {
                show: false
            },
            color: '#AA4643',
    }];
	var bar_data_keterampilan = [
		{
			label: "<?php echo $label_keterampilan; ?>",
			data: a2,
			bars: {
					show: true,
					barWidth: 0.5,
					align: "center"
					},
			color: "#3c8dbc",
		},
		{
            label: "KKM",
            data: kkm2,
            lines: {
                show: true,
                fill: false
            },
            points: {
                show: false
            },
            color: '#AA4643',
    }];
	$.plot("#bar_pengetahuan", bar_data_pengetahuan, {
		xaxis: {
			mode: "categories",
			axisLabel: '<?php echo $axisLabel_pengetahuan; ?>',
			ticks: [
                	<?php
					if(isset($get_kd_pengetahuan)){
						$i=0;
						foreach($get_kd_pengetahuan as $getkdp){
							echo '['.$i.', "'. $getkdp['id'].'"],';
						$i++;
						}
					}
				?>
            ],
			ticks_custom: [
                	<?php
					if(isset($get_kd_pengetahuan)){
						$i=0;
						foreach($get_kd_pengetahuan as $getkdp){
							echo '['.$i.', "Penilaian '. $getkdp['nama'].'"],';
						$i++;
						}
					}
				?>
            ],
			rotateTicks:135,
		},
		yaxis: {
			ticks:10,
			max:100,
			min:0,
		},
		grid: {
            hoverable: true,
            clickable: true,
			borderWidth: 1,
			borderColor: "#f3f3f3",
			tickColor: "#f3f3f3",
			margin: {
				top: 0,
				left: 20,
				bottom: 0,
				right: 0
			}
        },
		valueLabels: {
            show: true
        }
	});
	$.plot("#bar_keterampilan", bar_data_keterampilan, {
		xaxis: {
			mode: "categories",
			axisLabel: '<?php echo $axisLabel_keterampilan; ?>',
			ticks: [
                	<?php
					if(isset($get_kd_keterampilan)){
						$i=0;
						foreach($get_kd_keterampilan as $getkdk){
							echo '['.$i.', "'. $getkdk['id'].'"],';
						$i++;
						}
					}
				?>
            ],
			ticks_custom: [
                	<?php
					if(isset($get_kd_keterampilan)){
						$i=0;
						foreach($get_kd_keterampilan as $getkdk){
							echo '['.$i.', "Penilaian '. $getkdk['nama'].'"],';
						$i++;
						}
					}
				?>
            ],
			rotateTicks:135,
		},
		yaxis: {
			ticks:10,
			max:100,
			min:0
		},
		grid: {
            hoverable: true,
            clickable: true,
			borderWidth: 1,
			borderColor: "#f3f3f3",
			tickColor: "#f3f3f3",
			margin: {
				top: 0,
				left: 20,
				bottom: 0,
				right: 30
			}
			//mouseActiveRadius: 30  //specifies how far the mouse can activate an item
        },
		valueLabels: {
            show: true
        }
	});
                /* END BAR CHART */
});
var previousPoint = null,
    previousLabel = null;

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 20,
        border: '2px solid ' + color,
        padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}
$("#bar_pengetahuan").on("plothover", function (event, pos, item) {
    if (item) {
        if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
            previousPoint = item.dataIndex;
            previousLabel = item.series.label;
            $("#tooltip").remove();

            var x = item.datapoint[0];
            var y = item.datapoint[1];
            var color = item.series.color;
			var title_label = item.series.xaxis.rotatedTicks[x].label;
			if(item.series.label == 'KKM'){
				title_label = 'KKM';
			}
			var nama_ujian = item.series.xaxis.options.ticks_custom[x];
            showTooltip(item.pageX,
            item.pageY,
            color,
                "<strong>" + nama_ujian[1] + "</strong> <br /> <strong>" + title_label + "</strong> : <strong>" + y + "</strong>");
        }
    } else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});
$("#bar_keterampilan").on("plothover", function (event, pos, item) {
    if (item) {
        if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
            previousPoint = item.dataIndex;
            previousLabel = item.series.label;
            $("#tooltip").remove();

            var x = item.datapoint[0];
            var y = item.datapoint[1];
            var color = item.series.color;
			var title_label = item.series.xaxis.rotatedTicks[x].label;
			if(item.series.label == 'KKM'){
				title_label = 'KKM';
			}
			var nama_ujian = item.series.xaxis.options.ticks_custom[x];
            showTooltip(item.pageX,
            item.pageY,
            color,
                "<strong>" + nama_ujian[1] + "</strong> <br /> <strong>" + title_label + "</strong> : <strong>" + y + "</strong>");
        }
    } else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});
</script>