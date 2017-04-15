<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Perencanaan extends Backend_Controller {
	protected $activemenu = 'perencanaan';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
	}
	public function pengetahuan(){
		$data_rombel = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$pilih_rombel = '<div class="col-md-3"><select id="filter_tingkat" class="form-control">';
		$pilih_rombel .= '<option value="">==Filter Berdasar Tingkat==</option>'; 
		foreach($data_rombel as $rombel){
			$pilih_rombel .= '<option value="'.$rombel->tingkat.'">'.$rombel->tingkat.'</option>';
		}
		$pilih_rombel .= '</select>';
		$pilih_rombel .= '</div><div class="col-md-3"><select id="filter_rombel" class="form-control" style="display:none;"></select></div><a href="'.site_url('admin/perencanaan/add_pengetahuan').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Perencanaan Penilaian Pengetahuan')
		->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/perencanaan/list_rencana');
	}
	public function add_pengetahuan(){
		$data['ajarans'] = Ajaran::all();
		$loggeduser = $this->ion_auth->user()->row();
		if($loggeduser->data_guru_id){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$rombel_id[] = $datamapel->rombel_id;
			}
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $rombel_id)));
		} else {
			$data['rombels'] = Datarombel::all();
		}
		$data['kelas'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/perencanaan/simpan_perencanaan')
		->set('page_title', 'Perencanaan Penilaian Pengetahuan')
		->set('query', 'kd')
		->set('kompetensi_id', 1)
		->build($this->admin_folder.'/perencanaan/add_perencanaan',$data);
	}
	public function keterampilan(){
		$data_rombel = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$pilih_rombel = '<div class="col-md-3"><select id="filter_tingkat" class="form-control">';
		$pilih_rombel .= '<option value="">==Filter Berdasar Tingkat==</option>'; 
		foreach($data_rombel as $rombel){
			$pilih_rombel .= '<option value="'.$rombel->tingkat.'">'.$rombel->tingkat.'</option>';
		}
		$pilih_rombel .= '</select>';
		$pilih_rombel .= '</div><div class="col-md-3"><select id="filter_rombel" class="form-control" style="display:none;"></select></div><a href="'.site_url('admin/perencanaan/add_keterampilan').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Perencanaan Penilaian Keterampilan')
		->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/perencanaan/list_rencana');
	}
	public function add_keterampilan(){
		$data['ajarans'] = Ajaran::all();
		$loggeduser = $this->ion_auth->user()->row();
		if($loggeduser->data_guru_id){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$rombel_id[] = $datamapel->rombel_id;
			}
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $rombel_id)));
		} else {
			$data['rombels'] = Datarombel::all();
		}
		$data['kelas'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/perencanaan/simpan_perencanaan')
		->set('page_title', 'Perencanaan Penilaian Keterampilan')
		->set('query', 'kd')
		->set('kompetensi_id', 2)
		->build($this->admin_folder.'/perencanaan/add_perencanaan',$data);
	}
	public function simpan_perencanaan(){
		if($_POST){
			$kompetensi_id		= $_POST['kompetensi_id'];
			$ajaran_id			= $_POST['ajaran_id'];
			$rombel_id			= $_POST['rombel_id'];
			$id_mapel			= $_POST['id_mapel'];
			$nama_penilaian		= $_POST['nama_penilaian'];
			$bentuk_penilaian	= $_POST['bentuk_penilaian'];
			$bobot_penilaian	= $_POST['bobot_penilaian'];
			$bobot_penilaian_result = 1;
			if($kompetensi_id == 1){
				$redirect = 'pengetahuan';
			} else {
				$redirect = 'keterampilan';
			}
			for ($i = 1; $i <= 5; $i++) {
				$kd[]		= isset($_POST['kd_'.$i]) ? $_POST['kd_'.$i] : '';
				$kd_id[]	= isset($_POST['kd_id_'.$i]) ? $_POST['kd_id_'.$i] : '';
			}
			$rencana = new Rencana();
			$rencana->ajaran_id			= $ajaran_id;
			$rencana->id_mapel			= $id_mapel;
			$rencana->rombel_id			= $rombel_id;
			$rencana->kompetensi_id		= $kompetensi_id;
			$rencana->save();
			foreach($kd as $k=>$v){
				if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
					$bobot_penilaian_result = $bobot_penilaian[$k];
				}
				if(is_array($v)){
					foreach($v as $ks=>$vs){
						$get_post_kd = explode("|", $vs);
						$id_kompetensi = $get_post_kd[0];
						$id_kd = $get_post_kd[1];
						$new_rencana_penilaian					= new Rencanapenilaian();
						$new_rencana_penilaian->rencana_id		= $rencana->id;
						$new_rencana_penilaian->kompetensi_id	= $kompetensi_id;
						$new_rencana_penilaian->nama_penilaian	= $nama_penilaian[$k];
						$new_rencana_penilaian->bentuk_penilaian= $bentuk_penilaian[$k];
						$new_rencana_penilaian->bobot_penilaian	= $bobot_penilaian_result;
						$new_rencana_penilaian->kd_id			= $id_kd;
						$new_rencana_penilaian->kd				= $id_kompetensi;
						$new_rencana_penilaian->save();
						//print_r($kd);
					}
				}
			}
			//exit;
			redirect('admin/perencanaan/'.$redirect);
		}
	}
	public function update_perencanaan(){
		if($_POST){
			$rencana_id			= $_POST['rencana_id'];
			$kompetensi_id		= $_POST['kompetensi_id'];
			$ajaran_id			= $_POST['ajaran_id'];
			$rombel_id			= $_POST['rombel_id'];
			$id_mapel			= $_POST['id_mapel'];
			$nama_penilaian		= $_POST['nama_penilaian'];
			$bentuk_penilaian	= $_POST['bentuk_penilaian'];
			$bobot_penilaian	= $_POST['bobot_penilaian'];
			$bobot_penilaian_result = 1;
			if($kompetensi_id == 1){
				$redirect = 'pengetahuan';
			} else {
				$redirect = 'keterampilan';
			}
			for ($i = 1; $i <= 5; $i++) {
				$kd[]		= isset($_POST['kd_'.$i]) ? $_POST['kd_'.$i] : '';
				$kd_id[]	= isset($_POST['kd_id_'.$i]) ? $_POST['kd_id_'.$i] : '';
			}
			$rencana			= Rencana::find($rencana_id);
			if($rencana){
				foreach($kd as $k=>$v){
					if(is_array($v)){
						foreach($v as $ks=>$vs){
							$get_post_kd = explode("|", $vs);
							$id_kompetensi = $get_post_kd[0];
							$id_kd = $get_post_kd[1];
							$rencana_penilaian = Rencanapenilaian::find_all_by_rencana_id_and_nama_penilaian_and_kompetensi_id_and_kd_id($rencana->id,$nama_penilaian[$k],$kompetensi_id,$id_kd);
							if($rencana_penilaian){
								if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
									$bobot_penilaian_result = $bobot_penilaian[$k];
								}
								foreach($rencana_penilaian as $rp){
									$id_rp[] = $rp->id;
									$rp->update_attributes(
										array(
												'nama_penilaian' => $nama_penilaian[$k], 
												'bentuk_penilaian' => $bentuk_penilaian[$k], 
												'bobot_penilaian' => $bobot_penilaian_result, 
												'kd_id' => $id_kd, 
												'kd' => $id_kompetensi
												)
										);
								}
							} else {
								$new_rencana_penilaian					= new Rencanapenilaian();
								$new_rencana_penilaian->rencana_id		= $rencana->id;
								$new_rencana_penilaian->kompetensi_id	= $kompetensi_id;
								$new_rencana_penilaian->nama_penilaian	= $nama_penilaian[$k];
								$new_rencana_penilaian->bentuk_penilaian= $bentuk_penilaian[$k];
								$new_rencana_penilaian->bobot_penilaian	= $bobot_penilaian[$k];
								$new_rencana_penilaian->kd_id			= $id_kd;
								$new_rencana_penilaian->kd				= $id_kompetensi;
								$new_rencana_penilaian->save();
								$new_rp[] = $new_rencana_penilaian->id;
							}
						}
					}
				}
				if(isset($id_rp)){
					if(isset($new_rp)){
						$id_rp = array_merge($id_rp,$new_rp);
					}
					$del_rp = Rencanapenilaian::find('all', array('conditions' => array('rencana_id = ? AND id not in(?)',$rencana->id,$id_rp)));
					foreach($del_rp as $drp){
						$drp->delete();
					}
				}
			} else {
				//echo $ajaran_id.'=>'.$rombel_id.'=>'.$id_mapel.'=>no_4<br />';
				$rencana = new Rencana();
				$rencana->ajaran_id			= $ajaran_id;
				$rencana->id_mapel			= $id_mapel;
				$rencana->rombel_id			= $rombel_id;
				$rencana->kompetensi_id		= $kompetensi_id;
				$rencana->save();
				foreach($kd as $k=>$v){
					if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
						$bobot_penilaian_result = $bobot_penilaian[$k];
					}
					if(is_array($v)){
						foreach($v as $ks=>$vs){
							$get_post_kd = explode("|", $vs);
							$id_kompetensi = $get_post_kd[0];
							$id_kd = $get_post_kd[1];
							$new_rencana_penilaian					= new Rencanapenilaian();
							$new_rencana_penilaian->rencana_id		= $rencana->id;
							$new_rencana_penilaian->kompetensi_id	= $kompetensi_id;
							$new_rencana_penilaian->nama_penilaian	= $nama_penilaian[$k];
							$new_rencana_penilaian->bentuk_penilaian= $bentuk_penilaian[$k];
							$new_rencana_penilaian->bobot_penilaian	= $bobot_penilaian_result;
							$new_rencana_penilaian->kd_id			= $id_kd;
							$new_rencana_penilaian->kd				= $id_kompetensi;
							$new_rencana_penilaian->save();
							//print_r($kd);
						}
					}
				}

			}
			//exit;
			redirect('admin/perencanaan/'.$redirect);
		}
	}
    public function list_pengetahuan($tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$search = "";
		$start = 0;
		$rows = 25;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$siswa_guru_joint = '';
		$siswa_guru = '';
		$comma_separated = '';
		$id_mapel = '';
		if($loggeduser->data_guru_id){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$id_rombel[] = $datamapel->rombel_id;
				$id_mapel[] = $datamapel->id_mapel;
			}
			if(isset($id_rombel)){
				$id_rombel = implode(",", $id_rombel);
			}
			if($id_mapel){
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			}
		$siswa_guru_joint = "AND a.id IN ($id_rombel) AND rombel_id IN ($id_rombel) AND id_mapel IN ($id_mapel)";
		}
		if($tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.tingkat = $tingkat $siswa_guru_joint)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 1 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 1 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		} elseif($tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.tingkat = $tingkat AND a.id = $rombel $siswa_guru_joint)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 1 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 1 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 1 $siswa_guru_joint AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 1 $siswa_guru_joint AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		}
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    // get result after running query and put it in array
		$i=$start;
		//$barang = $query->result();
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$mapel = Datamapel::find($temp->id_mapel);
			$get_kurikulum = Kurikulum::find_by_rombel_id_and_id_mapel($temp->rombel_id,$temp->id_mapel);
			if (is_object($get_kurikulum)) {
				$get_nama_guru = Dataguru::find($get_kurikulum->guru_id);
				if($get_nama_guru){
				$nama_guru = $get_nama_guru->nama;
				}
			} else {
				$nama_guru = '-';
			} 
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			$rencana_penilaian_all = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id"));
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $mapel->nama_mapel;
            $record[] = $nama_guru;
            $record[] = count($rencana_penilaian_group);
            $record[] = count($rencana_penilaian_all);
            /*$record[] = '<a class="tooltip-left" title="'.$get_kd->kompetensi_dasar.'">'.$temp->kd.'</a>';*/
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
								 <li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($tingkat){
			if($loggeduser->data_guru_id){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$rombel_id[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND tingkat = ?', $rombel_id, $tingkat)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_tingkat($tingkat);
			}
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function edit($kompetensi_id,$id){
		$data['kompetensi_id'] = $kompetensi_id;
		$data['rencana'] = Rencana::find($id);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/perencanaan/')
		->set('page_title', 'Edit Perencanaan Penilaian')
		->build($this->admin_folder.'/perencanaan/edit',$data);
	}
	public function list_keterampilan($tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$search = "";
		$start = 0;
		$rows = 25;
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}
		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$siswa_guru_joint = '';
		$siswa_guru = '';
		$comma_separated = '';
		$id_mapel = '';
		if($loggeduser->data_guru_id){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$id_rombel[] = $datamapel->rombel_id;
				$id_mapel[] = $datamapel->id_mapel;
			}
			if(isset($id_rombel)){
				$id_rombel = implode(",", $id_rombel);
			}
			if($id_mapel){
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			}
		$siswa_guru_joint = "AND a.id IN ($id_rombel) AND rombel_id IN ($id_rombel) AND id_mapel IN ($id_mapel)";
		}
		if($tingkat && !$rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.tingkat = $tingkat $siswa_guru_joint)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 2 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 2 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		} elseif($tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.tingkat = $tingkat AND a.id = $rombel $siswa_guru_joint)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 2 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 2 AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id)";
			$query = Rencana::find('all', array('conditions' => "kompetensi_id = 2 $siswa_guru_joint AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
			$filter = Rencana::find('all', array('conditions' => "kompetensi_id = 2 $siswa_guru_joint AND (ajaran_id LIKE '%$search%' OR id_mapel LIKE '%$search%' OR rombel_id LIKE '%$search%')",'order'=>'id DESC, rombel_id DESC', 'joins'=> $join));
		}
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		$i=$start;
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rombel = Datarombel::find($temp->rombel_id);
			$mapel = Datamapel::find($temp->id_mapel);
			$get_kurikulum = Kurikulum::find_by_rombel_id_and_id_mapel($temp->rombel_id,$temp->id_mapel);
			if (is_object($get_kurikulum)) {
				$get_nama_guru = Dataguru::find($get_kurikulum->guru_id);
				if($get_nama_guru){
				$nama_guru = $get_nama_guru->nama;
				}
			} else {
				$nama_guru = '-';
			}
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			$rencana_penilaian_all = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id"));
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $ajaran->tahun;
			$record[] = $rombel->nama;
			$record[] = $mapel->nama_mapel;
            $record[] = $nama_guru;
            $record[] = count($rencana_penilaian_group);
            $record[] = count($rencana_penilaian_all);
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
								 <li><a href="'.site_url('admin/perencanaan/edit/2/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($tingkat){
			if($loggeduser->data_guru_id){
				$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
				foreach($data_mapel as $datamapel){
					$rombel_id[] = $datamapel->rombel_id;
				}
				$get_all_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND tingkat = ?', $rombel_id, $tingkat)));
			} else {
				$get_all_rombel = Datarombel::find_all_by_tingkat($tingkat);
			}
			foreach($get_all_rombel as $allrombel){
				$all_rombel= array();
				$all_rombel['value'] = $allrombel->id;
				$all_rombel['text'] = $allrombel->nama;
				$output['rombel'][] = $all_rombel;
			}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function delete($id){
		$rencana = Rencana::find($id);
		$rencana->delete();
	}
}