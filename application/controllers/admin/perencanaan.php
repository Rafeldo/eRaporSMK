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
		$pilih_rombel = '<a href="'.site_url('admin/perencanaan/add_pengetahuan').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
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
			if(isset($rombel_id)){
				$id_rombel = $rombel_id;
			} else {
				$id_rombel = array();
			}
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $id_rombel)));
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
		$pilih_rombel = '<a href="'.site_url('admin/perencanaan/add_keterampilan').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
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
			if(isset($rombel_id)){
				$id_rombel = $rombel_id;
			} else {
				$id_rombel = array();
			}
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $id_rombel)));
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
			//test($_POST);
			//die();
			$kompetensi_id		= $_POST['kompetensi_id'];
			$ajaran_id			= $_POST['ajaran_id'];
			$rombel_id			= $_POST['rombel_id'];
			$id_mapel			= $_POST['id_mapel'];
			$nama_penilaian		= $_POST['nama_penilaian'];
			$bentuk_penilaian	= $_POST['bentuk_penilaian'];
			$bobot_penilaian	= isset($_POST['bobot_penilaian']) ? $_POST['bobot_penilaian'] : '';
			$keterangan_penilaian	= $_POST['keterangan_penilaian'];
			$bobot_penilaian_result = 1;
			if($kompetensi_id == 1){
				$redirect = 'pengetahuan';
			} else {
				$redirect = 'keterampilan';
			}
			for ($i = 1; $i <= count($nama_penilaian); $i++) {
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
				if($bobot_penilaian){
					if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
						$bobot_penilaian_result = $bobot_penilaian[$k];
					}
				} else {
					$bobot_penilaian_result = '0';
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
						$new_rencana_penilaian->keterangan_penilaian	= $keterangan_penilaian[$k];
						$new_rencana_penilaian->kd_id			= $id_kd;
						$new_rencana_penilaian->kd				= $id_kompetensi;
						$new_rencana_penilaian->save();
					}
				}
			}
			$this->session->set_flashdata('success', 'Berhasil menambah rencana penilaian '.$redirect);
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
			for ($i = 1; $i <= count($nama_penilaian); $i++) {
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
			$this->session->set_flashdata('success', 'Berhasil mengupdate rencana penilaian '.$redirect);
			redirect('admin/perencanaan/'.$redirect);
		}
	}
    public function list_pengetahuan($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 25;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$join_rombel = '';
		$join_mapel = '';
		$id_rombel = '';
		$id_mapel = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$get_id_rombel[$datamapel->rombel_id] = $datamapel->rombel_id;
				$get_id_mapel[$datamapel->id_mapel] = $datamapel->id_mapel;
			}
			if(isset($get_id_rombel)){
				$id_rombel = array_unique($get_id_rombel);
				$id_rombel = implode(",", $id_rombel);
			} else {
				$id_rombel = 0;
			}
			if(isset($get_id_mapel)){
				$id_mapel = array_unique($get_id_mapel);
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			} else {
				$id_mapel = 0;
			}
		$join_rombel = "AND a.id IN ($id_rombel)";
		$join_mapel = "AND b.id_mapel IN ($id_mapel)";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		}elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat AND a.id = $rombel $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel AND b.id_mapel IN ($id_mapel))";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		}
		$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 1 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'select'=>$sel, 'group'=> 'id'));
		$filter = Rencana::find('all', array('conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 1 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'group'=> 'id'));
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
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			foreach($rencana_penilaian_group as $rpg){
				$rpg_id[] = $rpg->id;
			}
			if(isset($rpg_id)){
				$rpg_id_result = implode(',',$rpg_id);
			} else {
				$rpg_id_result = 0;
			}
			$nilai = Nilai::find('all', array('conditions' => "rencana_penilaian_id IN ($rpg_id_result)", 'limit'=>1));
			if(!in_array('waka',$nama_group)){ //murni guru
				if($nilai){
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				} else {
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
					$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				}
			} else { // guru plus waka
				$admin_akses = '<li><a href="'.site_url('admin/perencanaan/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i> Detil</a></li>';
				if(get_nama_guru($loggeduser->data_guru_id) == get_nama_guru($temp->guru_id)){
					if($nilai){
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					} else {
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/edit/1'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					}
				}
			}
			$jumlah_rencana_penilaian = count($temp->rencanapenilaian);
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $ajaran->tahun;
			$record[] = get_nama_rombel($temp->rombel_id);
			$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
            $record[] = get_nama_guru($temp->guru_id);
            $record[] = '<div class="text-center">'.count($rencana_penilaian_group).'</div>';
            $record[] = '<div class="text-center">'.$jumlah_rencana_penilaian.'</div>';
			//$record[] = '<div class="text-center">'.$admin_akses.'</div>';
            //$record[] = '<a class="tooltip-left" title="'.$get_kd->kompetensi_dasar.'">'.$temp->kd.'</a>';
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
								 <!--li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li-->
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$get_all_rombel = Datarombel::find('all', array('conditions' => "id IN ($id_rombel) AND kurikulum_id = $jurusan AND tingkat = $tingkat"));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan,$tingkat);
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
	public function view($id){
		$rencana = Rencana::find($id, array('include'=>array('rencanapenilaian')));
		$this->template->title('Administrator Panel : Detil Perencanaan Penilaian')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'Detil Perencanaan Penilaian')
        ->set('rencana', $rencana)
		->set('modal_footer', '')		
        ->build($this->admin_folder.'/perencanaan/view');
	}	
	public function list_keterampilan($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
		$search = "";
		$start = 0;
		$rows = 25;
		$ajaran = get_ta();
		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->custom_fuction->get_start();
		$rows = $this->custom_fuction->get_rows();
		$join_rombel = '';
		$join_mapel = '';
		$id_rombel = '';
		$id_mapel = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id",'order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$get_id_rombel[$datamapel->rombel_id] = $datamapel->rombel_id;
				$get_id_mapel[$datamapel->id_mapel] = $datamapel->id_mapel;
			}
			if(isset($get_id_rombel)){
				$id_rombel = array_unique($get_id_rombel);
				$id_rombel = implode(",", $id_rombel);
			} else {
				$id_rombel = 0;
			}
			if(isset($get_id_mapel)){
				$id_mapel = array_unique($get_id_mapel);
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			} else {
				$id_mapel = 0;
			}
		$join_rombel = "AND a.id IN ($id_rombel)";
		$join_mapel = "AND b.id_mapel IN ($id_mapel)";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		}elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat AND a.id = $rombel $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel AND b.id_mapel IN ($id_mapel))";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		} else {
			$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id $join_rombel)";
			$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
			$sel = 'rencanas.*, b.guru_id AS guru_id';
		}
		$query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 2 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'select'=>$sel, 'group'=> 'id'));
		$filter = Rencana::find('all', array('conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 2 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'group'=> 'id'));
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
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
			$rencana_penilaian = Rencanapenilaian::find_by_rencana_id($temp->id);
			$rencana_penilaian_id = isset($rencana_penilaian->id) ? $rencana_penilaian->id : '';
			$nilai = Nilai::find_by_rencana_penilaian_id($rencana_penilaian_id);
			if(!in_array('waka',$nama_group)){ //murni guru
				if($nilai){
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				} else {
					$admin_akses = '<li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
					$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
				}
			} else { // guru plus waka
				$admin_akses = '<li><a href="'.site_url('admin/perencanaan/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i> Detil</a></li>';
				if(get_nama_guru($loggeduser->data_guru_id) == get_nama_guru($temp->guru_id)){
					if($nilai){
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					} else {
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/edit/1'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
						$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
					}
				}
			}
			$jumlah_rencana_penilaian = count($temp->rencanapenilaian);
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $ajaran->tahun;
			$record[] = get_nama_rombel($temp->rombel_id);
			$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
            $record[] = get_nama_guru($temp->guru_id);
            $record[] = '<div class="text-center">'.count($rencana_penilaian_group).'</div>';
            $record[] = '<div class="text-center">'.$jumlah_rencana_penilaian.'</div>';
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
								 <!--li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li-->
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
				$get_all_rombel = Datarombel::find('all', array('conditions' => "id IN ($id_rombel) AND kurikulum_id = $jurusan AND tingkat = $tingkat"));
			} else {
				$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan,$tingkat);
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
	public function delete($id){
		$super_admin = array('admin','tu','guru');
		if($this->ion_auth->in_group($super_admin)){
			$rencana = Rencana::find($id);
			$rencana->delete();
			$status['type'] = 'success';
			$status['text'] = 'Data berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
	public function delete_rp($id){
		$rp = Rencanapenilaian::find($id);
		$all_rencana = Rencanapenilaian::find_all_by_rencana_id_and_kompetensi_id_and_nama_penilaian($rp->rencana_id,$rp->kompetensi_id, $rp->nama_penilaian);
		$super_admin = array('admin','tu','guru');
		if($this->ion_auth->in_group($super_admin)){
			foreach($all_rencana as $rencana){
				$rencana->delete();
			}
			$status['type'] = 'success';
			$status['text'] = 'Data berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
	public function multidelete(){
		$ids = $_POST['id'];
		$super_admin = array('admin','tu','guru');
		if($this->ion_auth->in_group($super_admin)){
			//$ids = $_POST['id'];
			Rencana::table()->delete(array('id' => $ids));
			$status['type'] = 'success';
			$status['text'] = 'Data berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
}