<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-pencil"></i> Backup Data</a></li>
					<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-upload"></i> Restore Data</a></li>
                    <!--li><a href="#tab_3" data-toggle="tab"><i class="fa fa-download"></i> Download XML</a></li-->
				</ul>
			<div class="tab-content">
				<div class="tab-pane active text-center" id="tab_1">
				<a class="btn btn-success btn-lg btn-block" href="<?php echo site_url('main/backup'); ?>">Backup</a>
				</div>
				<div style="clear:both"></div>
				<div class="tab-pane" id="tab_2">
						<p class="text-center"><span class="btn btn-danger btn-file btn-lg btn-block">								
									Browse  <input type="file" id="fileupload" name="import" />
								</span></p>
								<div id="result"></div>
								<div id="gagal" class="alert alert-danger" style="margin-top:20px; display:none;"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Import Data Error!</b> Silahkan pilih Mata Pelajaran terlebih dahulu.</div>
						<div id="progress" class="progress" style="margin-top:10px; display:none;">
							<div class="progress-bar progress-bar-success"></div>
						</div>
				</div>
                <div style="clear:both;"></div>
			</div>
		</div>	
	</div>
</div>