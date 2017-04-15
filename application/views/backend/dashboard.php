<?php
$setting = Setting::first();
$cari_rombel = Datarombel::find_by_guru_id($user->data_guru_id);
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid" style="padding-bottom:25px;">
		    <div class="box-header with-border">
        		<h3 class="text-center box-title">Selamat Datang <?php echo $user->username; ?></h3>
	    	</div><!-- /.box-header -->
    		<div class="box-body">
			<?php 
			if($user->data_siswa_id){
				$this->load->view('backend/dashboard/siswa');
			} else { 
			$super_admin = array(1,2);
			if($this->ion_auth->in_group($super_admin)){?>
				<div class="col-lg-6 col-xs-12">
					<div class="col-lg-6 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-green disabled color-palette">
							<div class="inner">
								<h3><?php echo $guru; ?></h3>
								<p>Guru</p>
							</div>
							<div class="icon"><i class="ion ion-person-add"></i></div>
							<a href="<?php echo site_url('admin/guru'); ?>" class="small-box-footer">
								Selengkapnya <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-6 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-yellow disabled color-palette">
							<div class="inner">
								<h3><?php echo $siswa; ?></h3>
								<p>Siswa</p>
							</div>
							<div class="icon"><i class="ion ion-android-contacts"></i></div>
							<a href="<?php echo site_url('admin/siswa'); ?>" class="small-box-footer">
								Selengkapnya <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-6 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-red disabled color-palette">
							<div class="inner">
								<h3><?php echo $rencana_penilaian; ?></h3>
								<p>Rencana Penilaian (P&amp;K)</p>
							</div>
							<div class="icon"><i class="ion ion-android-checkbox-outline"></i></div>
							<a href="javascript:void(0)" class="small-box-footer">
								Selengkapnya <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-6 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-maroon disabled color-palette">
							<div class="inner">
								<h3><?php echo $nilai; ?></h3>
								<p>Penilaian Per KD (P&amp;K)</p>
							</div>
							<div class="icon"><i class="ion ion-arrow-graph-up-right"></i></div>
							<a href="javascript:void(0)" class="small-box-footer">
								Selengkapnya <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
				</div>
				<div class="col-lg-6 col-xs-12">
					<canvas id="pieChart" style="height:250px"></canvas>
					<h3 class="text-center">Statistik Jumlah Penilaian Per Mata Pelajaran</h3>
				</div>
				<?php } ?>
				<?php } ?>
				<?php if($user->data_guru_id){
					$this->load->view('backend/dashboard/guru');
				} 
				if ($this->ion_auth->in_group('bk')){
					$this->load->view('backend/dashboard/bk');
				} 
				if ($this->ion_auth->in_group('kasek')){
					$this->load->view('backend/dashboard/kasek');
				} ?>
			</div><!-- /.box-body -->
			<div style="clear:both;"></div>
		</div><!--/-->
	</div>
</div>
<?php
if($user->data_siswa_id || $user->data_guru_id){
} else {
?>
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var PieData = [];
	$.ajax({
		url: "<?php echo site_url('admin/ajax/get_chart');?>",
		method: "GET",
		success: function(response) {
			var result = $.parseJSON(response);
			$.each(result.result, function (i, item) {
				PieData.push({
					value: item.value,
					color: item.color,
					highlight: item.highlight,
					label: item.label
				});
			});
			var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
			var pieChart = new Chart(pieChartCanvas);
			var pieOptions = {
				//Boolean - Whether we should show a stroke on each segment
				segmentShowStroke: true,
				//String - The colour of each segment stroke
				segmentStrokeColor: "#fff",
				//Number - The width of each segment stroke
				segmentStrokeWidth: 2,
				//Number - The percentage of the chart that we cut out of the middle
				percentageInnerCutout: 50, // This is 0 for Pie charts
				//Number - Amount of animation steps
				animationSteps: 100,
				//String - Animation easing effect
				animationEasing: "easeOutBounce",
				//Boolean - Whether we animate the rotation of the Doughnut
				animateRotate: true,
				//Boolean - Whether we animate scaling the Doughnut from the centre
				animateScale: false,
				//Boolean - whether to make the chart responsive to window resizing
				responsive: true,
				// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
				maintainAspectRatio: true,
				//String - A legend template
				legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
			};
			//Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			pieChart.Doughnut(PieData, pieOptions);
		}
	});
});
</script>
<?php } ?>