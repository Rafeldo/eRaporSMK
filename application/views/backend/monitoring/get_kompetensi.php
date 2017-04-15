<div class="col-sm-12">
<?php
$rombel = Datarombel::find($data['rombel_id']);
//$datasiswa = Datasiswa::find_all_by_data_rombel_id($data['rombel_id']);
$datasiswa = filter_agama_siswa(get_nama_mapel($data['ajaran_id'],$data['rombel_id'],$data['id_mapel']),$data['rombel_id']);
$kkm_value = get_kkm($data['ajaran_id'],$data['rombel_id'],$data['id_mapel']);
$post = explode("#", $data['kd']);
$id_kd = $post[0];
$id_rp = $post[1];
$rencana_id = $post[2];
$kd = Kd::find($id_kd);
$renana_penilaian = Rencanapenilaian::find('all', array('conditions' => array('rencana_id = ? AND kd_id = ?', $rencana_id, $id_kd)));
?>
	<table class="table table-bordered table-striped">
		<tr>
			<th width="20%">Rombel</th>
			<th class="text-center" width="5%">:</th>
			<th width="75%"><?php echo $rombel->nama; ?></th>
		</tr>
		<tr>
			<th>Mata Pelajaran</th>
			<th class="text-center">:</th>
			<th><?php echo get_nama_mapel($data['ajaran_id'], $data['rombel_id'], $data['id_mapel']); ?></th>
		</tr>
		<tr>
			<th>Kompetensi Dasar</th>
			<th class="text-center">:</th>
			<th><?php echo $kd->kompetensi_dasar; ?></th>
		</tr>
	</table>
	<div id="bar_analisis" style="height: 400px;"></div>
</div>
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
		if(isset($datasiswa)){
			$i=0;
		foreach($datasiswa as $siswa){
			$nilai_value = 0;
			foreach($renana_penilaian as $rp){
				$nilai = Nilai::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_data_siswa_id_and_rencana_penilaian_id($data['ajaran_id'], $data['rombel_id'], $data['id_mapel'], $siswa->id, $rp->id);
				$nilai_value += isset($nilai->rerata_jadi) ? $nilai->rerata_jadi : 0;
				//test($nilai);
			}
			echo '['.$i.', "'. number_format($nilai_value,0) .'"],';
			$i++;
		}
		}
		?>
    ];
	var kkm1 = [
        [0, <?php echo isset($kkm_value) ? $kkm_value : 0; ?>],
        [<?php echo $i - 1; ?>, <?php echo isset($kkm_value) ? $kkm_value : 0; ?>]
    ];
	var bar_analisis = [
		{
			label: "Nilai Siswa",
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
	$.plot("#bar_analisis", bar_analisis, {
		xaxis: {
			mode: "categories",
			//axisLabel: 'Nilai Siswa',
			ticks: [
                	<?php
					if(isset($datasiswa)){
						$i=0;
						foreach($datasiswa as $siswa){
							echo '['.$i.', "'. $siswa->nama.'"],';
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
				right: 0
			}
        },
		valueLabels: {
            show: false
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
$("#bar_analisis").on("plothover", function (event, pos, item) {
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
            showTooltip(item.pageX,
            item.pageY,
            color,
                "<strong>" + title_label + "</strong> : <strong>Rata-rata " + y + "</strong>");
        }
    } else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});
</script>