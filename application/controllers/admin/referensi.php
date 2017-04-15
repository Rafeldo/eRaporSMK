<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Referensi extends Backend_Controller {
	protected $activemenu = 'referensi';
	public function __construct() {
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('custom_fuction');
		$admin_group = array(1,2,3,5,6);
		hak_akses($admin_group);
	}
	public function index(){
		echo 'Blank';
	}
	public function mata_pelajaran(){
		$pilih_rombel = '<a href="'.site_url('admin/referensi/tambah_mapel').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel : Referensi Kurikulum')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Referensi Mata Pelajaran')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/referensi/kurikulum');
	}
	public function metode(){
		$loggeduser = $this->ion_auth->user()->row();
		$pilih_rombel = '<a href="'.site_url('admin/referensi/add_metode').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel : Referensi Metode Penilaian')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Referensi Metode Penilaian')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/referensi/metode');
	}
	public function add_metode(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Teknik Penilaian')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_metode');
	}
	public function sikap(){
		$loggeduser = $this->ion_auth->user()->row();
		$pilih_rombel = '<a href="'.site_url('admin/referensi/add_sikap').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel : Referensi Sikap')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Referensi Sikap')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/referensi/sikap');
	}
	public function add_sikap(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Sikap')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_sikap');
	}
	public function tambah_mapel(){
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Kurikulum')
		->set('form_action', 'admin/referensi/simpan')
		->set('user', $this->ion_auth->user()->row())
		->build($this->admin_folder.'/referensi/_kurikulum');
	}
	public function edit_kurikulum($id){
		$kurikulum = Kurikulum::find($id);
		$data_rombel = Datarombel::find($kurikulum->rombel_id);
		$tingkat = $data_rombel->tingkat;
		$kurikulum_id = $data_rombel->kurikulum_id;
		$kelas_X	= 0;
		$kelas_XI	= 0;
		$kelas_XII	= 0;
		$kelas_XIII	= 0;
		$k1 = 0;
		$k2 = 0;
		$k3 = 0;
		if($tingkat == 10){
			$kelas_X	= 1;
			$k1			= 1;
		} elseif($tingkat == 11){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$k1			= 1;
			$k2			= 1;
		} elseif($tingkat == 12){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$kelas_XII	= 1;
			$k3			= 1;
			$k1			= 1;
			$k2			= 1;
		} elseif($tingkat == 13){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$kelas_XII	= 1;
			$kelas_XIII	= 1;
		}
		//$all_mapel = Matpelkomp::find_all_by_kelas_X_and_kelas_XI_and_kelas_XII_and_kelas_XIII($kelas_X,$kelas_XI,$kelas_XII,$kelas_XIII);
		$matpel_komp = Matpelkomp::find('all', array('conditions' => array('kelas_X = ? AND kelas_XI = ? AND kelas_XII = ? AND kelas_XIII = ? AND kurikulum_id = ?', $kelas_X,$kelas_XI,$kelas_XII,$kelas_XIII, $kurikulum_id)));
		$matpel_umum = Datamapel::find('all', array('conditions' => array('k1 = ? AND k2 = ? AND k3 = ? AND kur = ?', $k1, $k2, $k3, 2013)));
		if(is_array($matpel_komp) && is_array($matpel_umum)){
			$all_mapel = array_merge($matpel_komp,$matpel_umum);
		} elseif(is_array($matpel_komp) && !is_array($matpel_umum)){
			$all_mapel = $matpel_komp;
		} elseif(is_array($matpel_komp) && !is_array($matpel_umum)){
			$all_mapel = $matpel_umum;
		}
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$all_rombel = Datarombel::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('data', $kurikulum)
		->set('data_rombel', $data_rombel)
		->set('all_mapel', $all_mapel)
		->set('all_rombel', $all_rombel)
		->set('page_title', 'Edit Referensi Kurikulum')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_kurikulum',$data);
	}
	public function simpan(){
		$query = $_POST['query'];
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$action = isset($_POST['action']) ? $_POST['action'] : '';
		$ajaran_id = isset($_POST['ajaran_id']) ? $_POST['ajaran_id'] : '';
		$kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
		$rombel_id = isset($_POST['rombel_id']) ? $_POST['rombel_id'] : '';
		$mapel_id =  isset($_POST['mapel_id']) ? $_POST['mapel_id'] : '';
		$guru_id = isset($_POST['guru_id']) ? $_POST['guru_id'] : '';
		$nama_kur = isset($_POST['nama_kur']) ? $_POST['nama_kur'] : '';
		$nama_mulok = isset($_POST['nama_mulok']) ? $_POST['nama_mulok'] : '';
		$kkm = isset($_POST['kkm']) ? $_POST['kkm'] : '';
		$nama_ekskul = isset($_POST['nama_ekskul']) ? $_POST['nama_ekskul'] : '';
		$nama_ketua = isset($_POST['nama_ketua']) ? $_POST['nama_ketua'] : '';
		$nomor_kontak = isset($_POST['nomor_kontak']) ? $_POST['nomor_kontak'] : '';
		$alamat_ekskul = isset($_POST['alamat_ekskul']) ? $_POST['alamat_ekskul'] : '';
		$kompetensi_id = isset($_POST['kompetensi_id']) ? $_POST['kompetensi_id'] : '';
		$nama_metode = isset($_POST['nama_metode']) ? $_POST['nama_metode'] : '';
		$kd_id = isset($_POST['kd_id']) ? $_POST['kd_id'] : '';
		$kd_uraian = isset($_POST['kd_uraian']) ? $_POST['kd_uraian'] : '';
		$butir_sikap = isset($_POST['butir_sikap']) ? $_POST['butir_sikap'] : '';
		if($query == 'metode'){
			if($action == 'edit'){
				$data = Metode::find($id);
				if($data){
					$data->update_attributes(
							array(
							'nama_metode' => $nama_metode 
						)
					);
					$this->session->set_flashdata('success', 'Berhasil mengupdate metode penilaian');
				}
			} else {
				$find = Metode::find_by_ajaran_id_and_kompetensi_id_and_nama_metode($ajaran_id, $kompetensi_id, $nama_metode);
				if($find){
					$this->session->set_flashdata('error', 'Terdeteksi data metode penilaian dengan data existing');
				} else {
					$new_data				= new Metode();
					$new_data->ajaran_id	= $ajaran_id;
					$new_data->kompetensi_id	= $kompetensi_id;
					$new_data->nama_metode		= $nama_metode;
					$new_data->save();
					$this->session->set_flashdata('success', 'Berhasil menambah data metode penilaian');
				}
			}
			redirect('admin/referensi/metode');
		} elseif($query == 'sikap'){
			if($action == 'edit'){
				$data = Datasikap::find($id);
				if($data){
					$data->update_attributes(
							array(
							'butir_sikap' => $butir_sikap 
						)
					);
					$this->session->set_flashdata('success', 'Berhasil mengupdate butir sikap');
				}
			} else {
				$find = Datasikap::find_by_ajaran_id_and_butir_sikap($ajaran_id, $butir_sikap);
				if($find){
					$this->session->set_flashdata('error', 'Terdeteksi data sikap dengan data existing');
				} else {
					$new_data				= new Datasikap();
					$new_data->ajaran_id	= $ajaran_id;
					$new_data->butir_sikap	= $butir_sikap;
					$new_data->save();
					$this->session->set_flashdata('success', 'Berhasil menambah data butir sikap penilaian');
				}
			}
			redirect('admin/referensi/sikap');
		} elseif($query == 'nama_kur_kurikulum'){
			if($action == 'edit'){
				$data = Kurikulum::find($id);
				if($data){
					$data->update_attributes(
							array(
							'id_mapel' => $mapel_id,
							'guru_id' => $guru_id,
							'nama_kur' => $nama_kur 
						)
					);
					$this->session->set_flashdata('success', 'Berhasil mengupdate kurikulum');
				}
			} else {
				$find = Kurikulum::find_by_ajaran_id_and_rombel_id_and_id_mapel($ajaran_id,$rombel_id,$mapel_id);
				if($find){
					$this->session->set_flashdata('error', 'Terdeteksi data kurikulum dengan data existing');
				} else {
					$new_data				= new Kurikulum();
					$new_data->ajaran_id	= $ajaran_id;
					$new_data->rombel_id	= $rombel_id;
					$new_data->id_mapel		= $mapel_id;
					$new_data->guru_id		= $guru_id;
					$new_data->nama_kur		= $nama_kur;
					$new_data->save();
					$this->session->set_flashdata('success', 'Berhasil menambah kurikulum');
				}
			}
			redirect('admin/referensi/kurikulum');
		} elseif($query == 'ekskul'){
			if($action == 'edit'){
				$data = Ekskul::find($id);
				if($data){
					$data->update_attributes(
							array(
							'ajaran_id' => $ajaran_id,
							'guru_id' => $guru_id,
							'nama_ekskul' => $nama_ekskul,
							'nama_ketua' => $nama_ketua, 
							'nomor_kontak' => $nomor_kontak, 
							'alamat_ekskul' => $alamat_ekskul, 
						)
					);
					$this->session->set_flashdata('success', 'Berhasil mengupdate Ekstrakurikuler');
				}
			} else {
				$find = Ekskul::find_by_ajaran_id_and_guru_id_and_nama_ekskul($ajaran_id,$guru_id,$nama_ekskul);
				if($find){
					$this->session->set_flashdata('error', 'Terdeteksi Ekstrakurikuler dengan data existing');
				} else {
					$new_data				= new Ekskul();
					$new_data->ajaran_id	= $ajaran_id;
					$new_data->guru_id		= $guru_id;
					$new_data->nama_ekskul	= $nama_ekskul;
					$new_data->nama_ketua	= $nama_ketua;
					$new_data->nomor_kontak	= $nomor_kontak;
					$new_data->alamat_ekskul= $alamat_ekskul;
					$new_data->save();
					$this->session->set_flashdata('success', 'Berhasil menambah Ekstrakurikuler');
				}
			}
			redirect('admin/referensi/ekskul');
		} elseif($query == 'add_kd'){
			if($kompetensi_id == 1){
				$aspek = 'P';
			} else {
				$aspek = 'K';
			}
			$find = Kd::find_by_id_kompetensi_and_id_mapel_and_kelas($kd_id,$mapel_id,$kelas);
			if($find){
				$this->session->set_flashdata('error', 'Terdeteksi data Kompetensi Dasar dengan data existing');
			} else {
				$new_data							= new Kd();
				$new_data->id_kompetensi			= $kd_id;
				$new_data->aspek					= $aspek;
				$new_data->id_mapel					= $mapel_id;
				$new_data->kelas					= $kelas;
				$new_data->id_kompetensi_nas		= 0;
				$new_data->kompetensi_dasar			= $kd_uraian;
				$new_data->kompetensi_dasar_alias	= '';
				$new_data->save();
				$this->session->set_flashdata('success', 'Berhasil menambah Kompetensi Dasar');
			}
			redirect('admin/referensi/kd');
		} elseif($query == 'matpel_komp'){
			$user_id = $_POST['user_id'];
			$nama_mapel = $_POST['nama_mapel'];
			$post = explode("#", $_POST['kur']);
			$kurikulum_id = $post[0];
			$kur = $post[1];
			$kelas_x = isset($_POST['kelas_x']) ? $_POST['kelas_x'] : '';
			$kelas_xi = isset($_POST['kelas_xi']) ? $_POST['kelas_xi'] : '';
			$kelas_xii = isset($_POST['kelas_xii']) ? $_POST['kelas_xii'] : '';
			$kelas_xiii = isset($_POST['kelas_xiii']) ? $_POST['kelas_xiii'] : '';
			$data_mapels = Datamapel::find_by_nama_mapel_and_kur($nama_mapel,$kur);
			if($data_mapels){
				$attributes_update_datamapel = array(
					'id_mapel'		=> $data_mapels->id_mapel,
					'id_mapel_nas'	=> 0,
					'nama_mapel'	=> $nama_mapel,
					'k1'			=> $kelas_x,
					'k2'			=> $kelas_xi,
					'k3'			=> $kelas_xii,
					'kur'			=> $kur
				);
				if($data_mapels->update_attributes($attributes_update_datamapel)){
					$find_matpel = Matpelkomp::find_by_kurikulum_id_and_id_mapel($kurikulum_id, $data_mapels->id_mapel);
					$attributes_update_matpel = array(
							'kurikulum_id'	=> $kurikulum_id,
							'id_mapel'		=> $data_mapels->id_mapel,
							'kelas_X'		=> $kelas_x,
							'kelas_XI'		=> $kelas_xi,
							'kelas_XII'		=> $kelas_xii,
							'kelas_XIII'	=> $kelas_xiii,
							'user_id'		=> $user_id
						);
					if($find_matpel){
						$find_matpel->update_attributes($attributes_update_matpel);
					} else {
						$attributes_matpel = array(
							'kurikulum_id'	=> $kurikulum_id,
							'id_mapel'		=> $data_mapels->id_mapel,
							'kelas_X'		=> $kelas_x,
							'kelas_XI'		=> $kelas_xi,
							'kelas_XII'		=> $kelas_xii,
							'kelas_XIII'	=> $kelas_xiii,
							'user_id'		=> $user_id
						);
						$new_matpel = Matpelkomp::create($attributes_matpel);
					}
					$this->session->set_flashdata('success', 'Berhasil memperbaharui referensi mata pelajaran');
				} else {
					$find_matpel = Matpelkomp::find_by_kurikulum_id_and_id_mapel($kurikulum_id, $data_mapels->id_mapel);
					if($find_matpel){
						$this->session->set_flashdata('error', 'Mata pelajaran terdeteksi sudah ada di database');
					} else {
						$attributes_matpel = array(
							'kurikulum_id'	=> $kurikulum_id,
							'id_mapel'		=> $data_mapels->id_mapel,
							'kelas_X'		=> $kelas_x,
							'kelas_XI'		=> $kelas_xi,
							'kelas_XII'		=> $kelas_xii,
							'kelas_XIII'	=> $kelas_xiii,
							'user_id'		=> $user_id
						);
						$new_matpel = Matpelkomp::create($attributes_matpel);
						$this->session->set_flashdata('success', 'Berhasil menambah referensi mata pelajaran');
					}
				}
			} else {
				$attributes_datamapel = array(
					'id_mapel'	=> 0,
					'id_mapel_nas'	=> 0,
					'nama_mapel'	=> $nama_mapel,
					'k1'			=> $kelas_x,
					'k2'			=> $kelas_xi,
					'k3'			=> $kelas_xii,
					'kur'			=> $kur
				);
				$new_mapel = Datamapel::create($attributes_datamapel);
				if($new_mapel){
					$find = Datamapel::find($new_mapel->id);
					if($find){
						$find->update_attributes(
						array(
							'id_mapel'	=> $new_mapel->id,
							)
						);
					}
					$attributes_matpel = array(
						'kurikulum_id'	=> $kurikulum_id,
						'id_mapel'		=> $new_mapel->id,
						'kelas_X'		=> $kelas_x,
						'kelas_XI'		=> $kelas_xi,
						'kelas_XII'		=> $kelas_xii,
						'kelas_XIII'	=> $kelas_xiii,
						'user_id'		=> $user_id
					);
					$new_matpel = Matpelkomp::create($attributes_matpel);
					$this->session->set_flashdata('success', 'Berhasil menambah referensi mata pelajaran');
				} else {
					$this->session->set_flashdata('error', 'Gagal menyimpan mata pelajaran, silahkan coba beberapa saat lagi');
				}
			}
			//test($_POST);
			redirect('admin/referensi/mata_pelajaran');
		} else {
			test($_POST);
		}
	}
	public function list_mata_pelajaran($jurusan = NULL, $tingkat = NULL){
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
		$sel = 'matpel_komps.*, c.kurikulum_id AS nama_kurikulum, b.nama_mapel AS nama_mapel';
		if($jurusan && $tingkat == NULL){
			//$join = "INNER JOIN datakurikulums a ON(matpel_komps.kurikulum_id = a.kurikulum_id AND a.kurikulum_id = $jurusan)";
			$join = "LEFT JOIN data_mapels b ON(matpel_komps.id_mapel = b.id_mapel)";
			$join .= "INNER JOIN keahlians c ON(matpel_komps.kurikulum_id= c.kurikulum_id AND c.kurikulum_id = $jurusan)";
		} elseif($jurusan && $tingkat){
			//$join = "INNER JOIN datakurikulums a ON(matpel_komps.kurikulum_id= a.kurikulum_id AND a.kurikulum_id = $jurusan AND matpel_komp.$tingkat = 1)";
			$join = "LEFT JOIN data_mapels b ON(matpel_komps.id_mapel = b.id_mapel)";
			$join .= "INNER JOIN keahlians c ON(matpel_komps.kurikulum_id= c.kurikulum_id)";
		} else {
			//$join = "INNER JOIN datakurikulums a ON(matpel_komps.kurikulum_id= a.kurikulum_id)";
			$join = "LEFT JOIN data_mapels b ON(matpel_komps.id_mapel = b.id_mapel)";
			$join .= "INNER JOIN keahlians c ON(matpel_komps.kurikulum_id= c.kurikulum_id)";
		}
		$query = Matpelkomp::find('all', array('conditions' => "matpel_komps.kurikulum_id IS NOT NULL AND (c.kurikulum_id LIKE '%$search%' OR b.nama_mapel LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC', 'joins'=> $join, 'select' => $sel));
		$filter = Matpelkomp::find('all', array('conditions' => "matpel_komps.kurikulum_id IS NOT NULL AND (c.kurikulum_id LIKE '%$search%' OR b.nama_mapel LIKE '%$search%')",'order'=>'id ASC', 'joins'=> $join));
		$iFilteredTotal = count($query);
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$record = array();
            $admin_akses = '';
			if($temp->user_id == $loggeduser->id){
				$admin_akses = '<li><a href="'.site_url('admin/referensi/delete/mapel/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>';
			}
			$record[] = get_kurikulum($temp->nama_kurikulum);
			$record[] = $temp->nama_mapel;
            $record[] = status_label($temp->kelas_x);
            $record[] = status_label($temp->kelas_xi);
            $record[] = status_label($temp->kelas_xii);
            $record[] = status_label($temp->kelas_xiii);
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="'.site_url('admin/referensi/edit_mapel/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		echo json_encode($output);
	}
	public function edit_mapel($id){
		$data = Matpelkomp::find($id);
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Kurikulum')
		->set('form_action', 'admin/referensi/simpan')
		->set('data', $data)
		->set('user', $this->ion_auth->user()->row())
		->build($this->admin_folder.'/referensi/_kurikulum');
	}
	public function list_metode(){
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
		$query = Metode::find('all', array('conditions' => "ajaran_id IS NOT NULL AND (ajaran_id LIKE '%$search%' OR nama_metode LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Metode::find('all', array('conditions' => "ajaran_id IS NOT NULL AND (ajaran_id LIKE '%$search%' OR nama_metode LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$tahun_ajaran = '-';
			$nama_rombel = '-';
			$nama_mapel = '-';
			$nama_guru = '-';
			if($temp->ajaran_id){
				$ajaran = Ajaran::find($temp->ajaran_id);
				$tahun_ajaran = $ajaran->tahun;
			}
			$kompetensi_id = ($temp->kompetensi_id == 1) ? 'Pengetahuan' : 'Keterampilan';
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $tahun_ajaran;
            $record[] = $kompetensi_id;
            $record[] = $temp->nama_metode;
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
								 <li><a href="'.site_url('admin/referensi/edit_metode/'.$temp->id).'" class="toggle-modal"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/referensi/delete/metode/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		echo json_encode($output);
	}
	public function list_sikap(){
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
		$query = Datasikap::find('all', array('conditions' => "id IS NOT NULL AND (butir_sikap LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC'));
		$filter = Datasikap::find('all', array('conditions' => "id IS NOT NULL AND (butir_sikap LIKE '%$search%')",'order'=>'id ASC'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$tahun_ajaran = '-';
			if($temp->ajaran_id){
				$ajaran = Ajaran::find($temp->ajaran_id);
				$tahun_ajaran = $ajaran->tahun;
			}
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $tahun_ajaran;
			$record[] = $temp->butir_sikap;
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
								 <li><a href="'.site_url('admin/referensi/edit_sikap/'.$temp->id).'" class="toggle-modal"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/referensi/delete/sikap/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		echo json_encode($output);
	}
	public function edit_metode($id){
		$data['data'] = Metode::find($id);
		$this->template->title('Administrator Panel')
		->set_layout($this->modal_tpl)
		->set('page_title', 'Edit Metode')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_metode',$data);
	}
	public function edit_sikap($id){
		$data['data'] = Datasikap::find($id);
		$this->template->title('Administrator Panel')
		->set_layout($this->modal_tpl)
		->set('page_title', 'Edit Sikap')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_sikap',$data);
	}
	public function kkm(){
		$pilih_rombel = '<a href="'.site_url('admin/referensi/add_kkm').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Referensi KB (KKM)')
		->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/referensi/kkm');
	}
	public function add_kkm(){
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data KB (KKM)')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_kkm',$data);
	}
	public function list_kkm($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$ajaran = get_ta();
		$ajaran_id = isset($ajaran->id) ? $ajaran->id : 0;
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
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
		$guru = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$guru = "AND b.id = $loggeduser->data_guru_id";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan)";
		} elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan AND c.tingkat = $tingkat)";
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan AND c.tingkat = $tingkat  AND c.id = $rombel)";
		} else {
			$join = "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id)";
		}
		$query = Kurikulum::find('all', array("conditions" => "ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'rombel_id ASC, id DESC', 'joins'=> $join, 'group' => 'id'));
		$filter = Kurikulum::find('all', array("conditions" => "ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')", 'order'=>'rombel_id ASC, id DESC', 'joins'=> $join));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find($temp->ajaran_id);
			$tahun_ajaran = isset($ajaran->tahun) ? $ajaran->tahun : '-';
			$admin_akses = '<li><a href="'.site_url('admin/referensi/delete/kkm/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>';
			if($loggeduser->data_guru_id){
				$admin_akses = '';
			}
			if($temp->kkm){
				$predikat = 'A: 100-'.(predikat($temp->kkm,'b') + 1);
				$predikat .= '&nbsp;&nbsp;&nbsp;&nbsp;B: '.predikat($temp->kkm,'b').'-'.(predikat($temp->kkm,'c') + 1);
				$predikat .= '&nbsp;&nbsp;&nbsp;&nbsp;C: '.predikat($temp->kkm,'c').'-'.$temp->kkm;
				$predikat .= '&nbsp;&nbsp;&nbsp;&nbsp;D: '.predikat($temp->kkm,'d').'-0';
			} else {
				$predikat = 0;
			}
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $tahun_ajaran;
			$record[] = get_nama_rombel($temp->rombel_id);
			$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
            $record[] = get_nama_guru($temp->guru_id);
			$record[] = $predikat;
            $record[] = '<div class="text-center">'.$temp->kkm.'</div>';
			/*$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
								 <li><a href="'.site_url('admin/referensi/edit_kkm/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								 '.$admin_akses.'
                            </ul>
                        </div></div>';
			*/
			$record[] = '<div class="text-center"><a class="btn btn-info btn-sm toggle-swal" href="'.site_url('admin/referensi/edit_kkm/'.$temp->id).'">Edit KKM</a></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan, $tingkat);
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
	public function list_mulok($jurusan = NULL, $tingkat = NULL, $rombel = NULL){
		$ajaran = get_ta();
		$ajaran_id = isset($ajaran->id) ? $ajaran->id : 0;
		$loggeduser = $this->ion_auth->user()->row();
		$nama_guru_login = Dataguru::find_by_id($loggeduser->data_guru_id);
		$nama_guru_login = isset($nama_guru_login->nama) ? $nama_guru_login->nama : '';
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
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
		$guru = '';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$guru = "AND b.id = $loggeduser->data_guru_id";
		}
		if($jurusan && $tingkat == NULL && $rombel == NULL){
			$join = "INNER JOIN kurikulum_aliases a ON(kurikulums.id_mapel = a.id AND a.nama_kur = 'k13_mulok' OR kurikulums.id_mapel = a.id AND a.nama_kur = 'k_mulok' OR kurikulums.id_mapel = '850010100')";
			$join .= "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan)";
			$query = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'rombel_id ASC, id DESC', 'joins'=> $join, 'group' => 'id'));
			$filter = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')", 'order'=>'rombel_id ASC, id DESC', 'joins'=> $join));
		} elseif($jurusan && $tingkat && $rombel == NULL){
			$join = "INNER JOIN kurikulum_aliases a ON(kurikulums.id_mapel = a.id AND a.nama_kur = 'k13_mulok' OR kurikulums.id_mapel = a.id AND a.nama_kur = 'k_mulok' OR kurikulums.id_mapel = '850010100')";
			$join .= "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan AND c.tingkat = $tingkat)";
			$query = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'rombel_id ASC, id DESC', 'joins'=> $join, 'group' => 'id'));
			$filter = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')", 'order'=>'rombel_id ASC, id DESC', 'joins'=> $join));
		} elseif($jurusan && $tingkat && $rombel){
			$join = "INNER JOIN kurikulum_aliases a ON(kurikulums.id_mapel = a.id AND a.nama_kur = 'k13_mulok' OR kurikulums.id_mapel = a.id AND a.nama_kur = 'k_mulok' OR kurikulums.id_mapel = '850010100')";
			$join .= "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id AND c.kurikulum_id= $jurusan AND c.tingkat = $tingkat  AND c.id = $rombel)";
			$query = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND keahlian_id = $jurusan AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'rombel_id ASC, id DESC', 'joins'=> $join, 'group' => 'id'));
			$filter = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND keahlian_id = $jurusan AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')", 'order'=>'rombel_id ASC, id DESC', 'joins'=> $join));
		} else {
			$join = "INNER JOIN kurikulum_aliases a ON(kurikulums.id_mapel = a.id AND a.nama_kur = 'k13_mulok' OR kurikulums.id_mapel = a.id AND a.nama_kur = 'k_mulok' OR kurikulums.id_mapel = '850010100')";
			$join .= "INNER JOIN data_gurus b ON(kurikulums.guru_id = b.id $guru)";
			$join .= "INNER JOIN data_rombels c ON(kurikulums.rombel_id = c.id)";
			$query = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'rombel_id ASC, id DESC', 'joins'=> $join, 'group' => 'id'));
			$filter = Kurikulum::find('all', array("conditions" => "a.ajaran_id = $ajaran_id AND (nama_mapel_alias LIKE '%$search%' OR b.nama LIKE '%$search%' OR c.nama LIKE '%$search%')", 'order'=>'rombel_id ASC, id DESC', 'joins'=> $join));
		}
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		$admin_group = array(1,2);
	    foreach ($query as $temp) {
			$ajaran = Ajaran::find_by_id($temp->ajaran_id);
			$tahun_ajaran = isset($ajaran->tahun) ? $ajaran->tahun : '-';
			$rombel = Datarombel::find_by_id($temp->rombel_id);
			$nama_rombel = isset($rombel->nama) ? $rombel->nama : '-';
			$guru = Dataguru::find_by_id($temp->guru_id);
			$nama_guru = isset($guru->nama) ? $guru->nama : '-';;
			$record = array();
            $tombol_aktif = '';
			if($this->ion_auth->in_group($admin_group)){
				$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			} else {
				//$record[] = '<div class="text-center">'. $i+1 .'</div>';
				$record[] = '<div class="text-center">'. ($i+1) .'</div>';
			}
			$record[] = $tahun_ajaran;
			$record[] = get_nama_rombel($temp->rombel_id);
			$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
            $record[] = get_nama_guru($temp->guru_id);
            $record[] = '<div class="text-center">'.get_kkm($temp->id).'</div>';
			$record[] = '<div class="text-center"><a class="btn btn-info btn-sm toggle-swal" href="'.site_url('admin/referensi/edit_kkm/'.$temp->id).'">Edit KKM</a></div>';
			$output['aaData'][] = $record;
		$i++;
		}
		if($jurusan && $tingkat){
			$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan, $tingkat);
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
	public function list_ekskul(){
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
		$query = Ekskul::find('all', array('conditions' => "ajaran_id IS NOT NULL AND ajaran_id != 0 AND (ajaran_id LIKE '%$search%' OR guru_id LIKE '%$search%' OR nama_ekskul LIKE '%$search%' OR nama_ketua LIKE '%$search%' OR nomor_kontak LIKE '%$search%' OR alamat_ekskul LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id DESC, guru_id asc'));
			$filter = Ekskul::find('all', array('conditions' => "ajaran_id IS NOT NULL AND ajaran_id != 0 AND (ajaran_id LIKE '%$search%' OR guru_id LIKE '%$search%' OR nama_ekskul LIKE '%$search%' OR nama_ketua LIKE '%$search%' OR nomor_kontak LIKE '%$search%' OR alamat_ekskul LIKE '%$search%')",'order'=>'id DESC, guru_id asc'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$tahun_ajaran = '-';
			$nama_rombel = '-';
			$nama_mapel = '-';
			$nama_guru = '-';
			if($temp->ajaran_id){
				$ajaran = Ajaran::find($temp->ajaran_id);
				$tahun_ajaran = $ajaran->tahun;
			}
			if($temp->guru_id){
				$guru = Dataguru::find_by_id($temp->guru_id);
				if($guru){
					$nama_guru = $guru->nama;
				}
			}
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = $tahun_ajaran;
			$record[] = $temp->nama_ekskul;
            $record[] = $nama_guru;
			$record[] = $temp->nama_ketua;
			$record[] = $temp->nomor_kontak;
			$record[] = $temp->alamat_ekskul;
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
								 <li><a href="'.site_url('admin/referensi/edit_ekskul/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/referensi/delete/ekskul/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		echo json_encode($output);
	}
	public function edit_kkm($id){
		$kurikulum = Kurikulum::find($id);
		if($_POST){
			$kkm = array('kkm'=> $_POST['kkm']);
			$kurikulum->update_attributes($kkm);
		} else {
			$kkm = array('kkm'=> $kurikulum->kkm);
		}
		echo json_encode($kkm);
	}
	public function edit_kkm_asli($id){
		$kkm = Kkm::find($id);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$data['data_rombel'] = Datarombel::find_by_id($kkm->rombel_id);
		$all_rombel = Datarombel::all();
		$get_mapel = Kurikulum::find_all_by_ajaran_id_and_rombel_id($kkm->ajaran_id,$kkm->rombel_id);
		$this->template->title('Administrator Panel : Edit KB (KKM)')
		->set_layout($this->blank_tpl)
		->set('page_title', 'Edit KB (KKM)')
		->set('data', $kkm)
		->set('all_rombel', $all_rombel)
		->set('all_mapel', $get_mapel)
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_kkm',$data);
	}
	public function add_mulok(){
		$super_admin = array(1,2,5);
		if($this->ion_auth->in_group($super_admin)){
			$data['ajarans'] = Ajaran::all();
			$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
			$data['data_guru'] = Dataguru::all();
			$this->template->title('Administrator Panel')
			->set_layout($this->admin_tpl)
			->set('page_title', 'Tambah Data Muatan Lokal')
			->set('form_action', 'admin/referensi/simpan')
			->build($this->admin_folder.'/referensi/_mulok',$data);
		} else {
			$this->session->set_flashdata('error', 'Akses menambah data muatan lokal hanya untuk Administrator dan atau Waka Kurikulum');
			redirect('admin/referensi/mulok');
		}
	}
	public function add_ekskul(){
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Ekstrakurikuler')
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_ekstrakurikuler',$data);
	}
	public function edit_ekskul($id){
		$ekskul = Ekskul::find($id);
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$all_rombel = Datarombel::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Edit Ekstrakurikuler')
		->set('data', $ekskul)
		->set('all_rombel', $all_rombel)
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_ekstrakurikuler',$data);
	}
	/*public function delete_kurikulum($id){
		echo 'delete_kurikulum';
	}
	public function delete_kkm($id){
		echo 'delete_kkm';
	}
	public function delete_mulok($id){
		echo 'delete_mulok';
	}
	public function delete_ekskul($id){
		echo 'delete_ekskul';
	}*/
	public function get_mapel($segment_name,$rombel_id){
		$data_rombel = Datarombel::find($rombel_id);
		$tingkat = $data_rombel->tingkat;
		$kurikulum_id = $data_rombel->kurikulum_id;
		$kelas_X	= 0;
		$kelas_XI	= 0;
		$kelas_XII	= 0;
		$kelas_XIII	= 0;
		$k1 = 0;
		$k2 = 0;
		$k3 = 0;
		if($tingkat == 10){
			$kelas_X	= 1;
			$kelas_XI	= 0;
			$kelas_XII	= 0;
			$kelas_XIII	= 0;
			$k1			= 1;
		} elseif($tingkat == 11){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$k2			= 1;
		} elseif($tingkat == 12){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$kelas_XII	= 1;
			$kelas_XIII	= 0;
			$k3			= 1;
		} elseif($tingkat == 13){
			$kelas_X	= 1;
			$kelas_XI	= 1;
			$kelas_XII	= 1;
			$kelas_XIII	= 1;
		}
		//$all_mapel = Matpelkomp::find_all_by_kelas_X_and_kelas_XI_and_kelas_XII_and_kelas_XIII($kelas_X,$kelas_XI,$kelas_XII,$kelas_XIII);
		$matpel_komp = Matpelkomp::find('all', array('conditions' => array('kelas_X = ? AND kelas_XI = ? AND kelas_XII = ? AND kelas_XIII = ? AND kurikulum_id = ?', $kelas_X,$kelas_XI,$kelas_XII,$kelas_XIII, $kurikulum_id)));
		$matpel_umum = Datamapel::find('all', array('conditions' => array('kur = ?', '2013')));
		if(is_array($matpel_komp) && is_array($matpel_umum)){
			$all_mapel = array_merge($matpel_komp,$matpel_umum);
		} elseif(is_array($matpel_komp) && !is_array($matpel_umum)){
			$all_mapel = $matpel_komp;
		} elseif(is_array($matpel_komp) && !is_array($matpel_umum)){
			$all_mapel = $matpel_umum;
		}
		//print_r($all_mapel);
		//die();
		foreach($all_mapel as $mapel){
			$data_mapel = Datamapel::find_by_id_mapel($mapel->id_mapel);
			$record['value'] 	= $mapel->id_mapel; //array("value" => $mapel->id_mapel, "property" => $data_mapel->nama_mapel.' ('.$data_mapel->id_mapel.')');
			$record['property']	= $data_mapel->nama_mapel.' ('.$data_mapel->id_mapel.')';
			$records[] = $record;
		}
		if(isset($record)){
			$output = $records;
		} else {
			$output = array("value" => '0', "property" => 'Belum ada mata pelajaran di rombel terpilih');
		}
		echo json_encode($output);
	}
	public function get_kurikulum(){
		if($_POST){
			$id_mapel = $_POST['id_mapel'];
			$data_mapel = Datamapel::find_by_id_mapel($id_mapel);
			echo $data_mapel->kur;
		}
	}
	public function excel_kkm(){
		$kurikulum = Kurikulum::all();
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Direktorak Pembinaan SMK")
				->setLastModifiedBy("ERAPOR")
				->setTitle("Template KB (KKM)")
				->setSubject("Template KB (KKM)")
				->setDescription("Template KB (KKM)")
				->setKeywords("office 2007 openxml php")
				->setCategory("Template");
		$objPHPExcel->setActiveSheetIndex(0);
		// Rename sheet
		$myCustomWidth = 10;
		$objPHPExcel->getActiveSheet()->setTitle("Template KB (KKM)");
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No.');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'kur_id');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ajaran_id');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'rombel_id');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'mapel_id');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Tahun Pelajaran');
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Kelas');
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Mata Pelajaran');
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Nama Guru');
		$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'KKM');
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$rowIterator = 2;
		$col = 1;			
		foreach($kurikulum as $kur){
			$kkm = Kkm::find_by_ajaran_id_and_rombel_id_and_mapel_id($kur->ajaran_id,$kur->rombel_id,$kur->mapel_id);
			if($kkm){
				$isi_kkm = $kkm->kkm;
			} else {
				$isi_kkm = '';
			}
			$ajaran = Ajaran::find($kur->ajaran_id);
			$rombel = Datarombel::find($kur->rombel_id);
			$mapel = Mapel::find($kur->mapel_id);
			$guru = Dataguru::find($kur->guru_id);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowIterator, $col);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowIterator, $kur->id);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowIterator, $kur->ajaran_id);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowIterator, $kur->rombel_id);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowIterator, $kur->mapel_id);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowIterator, $ajaran->tahun);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowIterator, $rombel->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$rowIterator, $mapel->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowIterator, $guru->nama);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$rowIterator, $isi_kkm);
		$col++;
		$rowIterator++;
		}
		$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => '00000000'),
							),
						),
					);
		$objPHPExcel->getActiveSheet()->getStyle('A1:J'.($rowIterator - 1))->applyFromArray($styleArray);
		$filename="Template KKM.xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');
	}	
	public function mulok(){
		$pilih_rombel = '<a href="'.site_url('admin/referensi/add_mulok').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Referensi Muatan Lokal')
		->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/referensi/mulok');
	}
	public function ekskul(){
		$pilih_rombel = '<div class="col-md-3">&nbsp;</div><div class="col-md-3">&nbsp;</div><a href="'.site_url('admin/referensi/add_ekskul').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('pilih_rombel', $pilih_rombel)
		->set('page_title', 'Referensi Ektrakurikuler')
		->build($this->admin_folder.'/referensi/ekstrakurikuler');
	}
	public function kd(){
		$pilih_rombel = '<a href="'.site_url('admin/referensi/add_kd').'" class="btn btn-success" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah Data</a>';
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Referensi Kompetensi Dasar')
		->set('pilih_rombel', $pilih_rombel)
		->build($this->admin_folder.'/referensi/kompetensi_dasar');
	}
	public function add_kd($kompetensi_id = NULL, $rombel_id = NULL, $mapel_id = NULL, $tingkat = NULL){
		$ajaran = get_ta();
		$ajaran_id = isset($ajaran->id) ? $ajaran->id : '';
		$loggeduser = $this->ion_auth->user()->row();
		if($loggeduser->data_guru_id){
			$get_all_mapel = Kurikulum::find('all', array('conditions' => array("guru_id = ?",$loggeduser->data_guru_id),'group' => 'id_mapel'));
		} else {
			$get_all_mapel = Kurikulum::find('all', array('conditions' => array("ajaran_id = ?",$ajaran_id)));
		}
		if($kompetensi_id)
		$data['kompetensi_id'] = $kompetensi_id;
		if($rombel_id)
		$data['rombel_id'] = $rombel_id;
		if($mapel_id)
		$data['mapel_id'] = $mapel_id;
		if($tingkat)
		$data['tingkat'] = $tingkat;
		$data['ajarans'] = Ajaran::all();
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Tambah Data Kompetensi Dasar')
		->set('form_action', 'admin/referensi/simpan')
		->set('all_mapel', $get_all_mapel)
		->build($this->admin_folder.'/referensi/_kd',$data);
	}
	public function list_kd($jurusan = NULL, $tingkat = NULL, $mapel = NULL, $kompetensi = NULL){
		$ajaran = get_ta();
		$ajaran_id = isset($ajaran->id) ? $ajaran->id : 0;
		$loggeduser = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($loggeduser->id)->result();
		foreach($user_groups as $user_group){
			$nama_group[] = $user_group->name; 
		}
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
		$comma_separated = '0';
		if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", /*'group' => 'id_mapel', */'order'=>'rombel_id ASC'));
			foreach($data_mapel as $datamapel){
				$id_mapel[] = $datamapel->id_mapel;
				$rombel_id[] = $datamapel->rombel_id;
			}
			$data_rombel = Datarombel::find_all_by_id($rombel_id);
			if($data_rombel){
				foreach($data_rombel as $rombel){
					$tingkat_rombel[] = $rombel->tingkat;
				}
			}
			if(isset($id_mapel)){
				$id_mapel = array_unique($id_mapel);
				$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
			} else {
				$id_mapel = '0';
			}
			if(isset($tingkat_rombel)){
				$tingkat_rombel = "'" . implode("','", $tingkat_rombel) . "'";//implode(",", $id_mapel);
			} else {
				$tingkat_rombel = '';
			}
		//echo $loggeduser->data_guru_id;
		$siswa_guru_joint = "AND a.id_mapel IN ($id_mapel) AND kds.kelas IN ($tingkat_rombel)";
		}
		if($jurusan && $tingkat == NULL && $mapel == NULL && $kompetensi == NULL){
			$join = "INNER JOIN kurikulums a ON(kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan)";
			$join .= 'LEFT JOIN data_mapels b ON(kds.id_mapel = b.id_mapel)';
			$sel = 'kds.*, a.rombel_id AS rombel_id, a.ajaran_id AS ajaran_id';
		} elseif($jurusan && $tingkat && $mapel == NULL && $kompetensi == NULL){
			$join = "INNER JOIN kurikulums a ON(kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan AND kds.kelas = $tingkat)";
			$join .= 'LEFT JOIN data_mapels b ON(kds.id_mapel = b.id_mapel)';
			$sel = 'kds.*, a.rombel_id AS rombel_id, a.ajaran_id AS ajaran_id';
		} elseif($jurusan && $tingkat && $mapel && $kompetensi == NULL){
			$join = "INNER JOIN kurikulums a ON(kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan AND kds.kelas = $tingkat AND a.id_mapel = '$mapel')";
			$join .= 'LEFT JOIN data_mapels b ON(kds.id_mapel = b.id_mapel)';
			$sel = 'kds.*, a.rombel_id AS rombel_id, a.ajaran_id AS ajaran_id';
		} elseif($jurusan && $tingkat && $mapel && $kompetensi){
			$join = "INNER JOIN kurikulums a ON(kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan AND kds.kelas = $tingkat AND a.id_mapel = '$mapel' AND kds.id_kompetensi = '$kompetensi' OR kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan AND kds.kelas = $tingkat AND a.id_mapel = '$mapel' AND kds.aspek = '$kompetensi'  OR kds.id_mapel= a.id_mapel AND a.keahlian_id = $jurusan AND kds.kelas = $tingkat AND a.id_mapel = '$mapel' AND kds.aspek = 'PK')";
			$join .= 'LEFT JOIN data_mapels b ON(kds.id_mapel = b.id_mapel)';
			$sel = 'kds.*, a.rombel_id AS rombel_id, a.ajaran_id AS ajaran_id';
		} else {
			$join = "INNER JOIN kurikulums a ON(kds.id_mapel= a.id_mapel)";
			$join .= 'LEFT JOIN data_mapels b ON(kds.id_mapel = b.id_mapel)';
			$sel = 'kds.*, a.rombel_id AS rombel_id, a.ajaran_id AS ajaran_id';
		}
		$query = Kd::find('all', array('conditions' => "id_kompetensi IS NOT NULL $siswa_guru_joint AND (id_kompetensi LIKE '%$search%' OR b.nama_mapel LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'id ASC, kds.id_mapel DESC', 'joins'=> $join,'group' => 'id', 'select'=>$sel));
		$filter = Kd::find('all', array('conditions' => "id_kompetensi IS NOT NULL $siswa_guru_joint AND (id_kompetensi LIKE '%$search%' OR b.nama_mapel LIKE '%$search%')",'order'=>'id ASC, id_mapel DESC', 'joins'=> $join,'group' => 'id'));
		$iFilteredTotal = count($query);
		
		$iTotal=count($filter);
	    
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );
		//print_r($get_all_rombel);
		$i=$start;
		//print_r($query);
	    foreach ($query as $temp) {
			$kompetensi_dasar_alias = ($temp->kompetensi_dasar_alias) ? $temp->kompetensi_dasar_alias : $temp->kompetensi_dasar;
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
			$record[] = $temp->id_kompetensi;
			$record[] = $temp->kelas;
            $record[] = $temp->kompetensi_dasar;
            $record[] = $kompetensi_dasar_alias;
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
								 <li><a href="'.site_url('admin/referensi/edit_kd/'.$temp->id).'" class="toggle-modal tooltip-left" title="Tambah/Ubah Ringkasan Kompetensi"><i class="fa fa-pencil"></i>Edit</a></li>
								 <li><a href="'.site_url('admin/referensi/delete/kd/'.$temp->id).'" class="confirm tooltip-left" title="Hapus Ringkasan Kompetensi"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		if($jurusan && $tingkat){
			$nama_mapel = '';
			$komp = array(
							1=> array(
									'id' 	=> 'P',
									'name' 	=> 'Pengetahuan'
								),
							2=> array(
									'id'	=> 'K',
									'name'	=> 'Keterampilan'
								)
						);
			for ($i = 1; $i <= 2; $i++) {
				$result['value']	= $komp[$i]['id'];
				$result['text']		= $komp[$i]['name'];
				$output['kompetensi'][] = $result;
			}
			$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan, $tingkat);
			foreach($get_all_rombel as $allrombel){
				$get_rombel_id[$allrombel->id] = $allrombel->id;
			}
			if(isset($get_rombel_id)){
				if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
					$get_all_mapel = Kurikulum::find('all', array('conditions' => array("rombel_id IN (?) AND guru_id = ?", $get_rombel_id, $loggeduser->data_guru_id),'group' => 'id_mapel'));
				} else {
					$get_all_mapel = Kurikulum::find('all', array('conditions' => array("rombel_id IN (?)",$get_rombel_id),'group' => 'id_mapel'));
				}
				if($get_all_mapel){
					foreach($get_all_mapel as $allmapel){
						$all_mapel= array();
						$all_mapel['value'] = $allmapel->id_mapel;
						$all_mapel['text'] = get_nama_mapel($ajaran_id, $get_rombel_id, $allmapel->id_mapel);
						$output['rombel'][] = $all_mapel;
					}
				} else {
					$result['value'] = '';
					$result['text'] = 'Belum ada mata pelajaran di kelas terpilih';
					$output['rombel'][] = $result;
				}
			} else {
				$result['value'] = '';
				$result['text'] = 'Belum ada mata pelajaran di kelas terpilih';
				$output['rombel'][] = $result;
			}
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	public function edit_kd($id){
		$kd = Kd::find_by_id($id);
		if($_POST){
			$kd->update_attributes(
				array(
					'kompetensi_dasar_alias' => $_POST['kompetensi_dasar_alias'],
				)
			);
		} else {
			$this->template->title('Administrator Panel : Tambah/Ubah Alias Kompetensi Dasar')
			->set_layout($this->modal_tpl)
			->set('page_title', 'Tambah/Ubah Alias Kompetensi Dasar')
			->set('kd', $kd)
			->set('modal_footer', '<a class="btn btn-primary" id="button_form" href="javascript:void(0);">Update</a>')
			->build($this->admin_folder.'/referensi/alias');
		}
	}
	public function edit_mulok($id){
		$mulok = Mulok::find($id);
		$data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$data['data_guru'] = Dataguru::all();
		$data['data_rombel'] = Datarombel::find_by_id($mulok->rombel_id);
		$all_rombel = Datarombel::all();
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('page_title', 'Edit Muatan Lokal')
		->set('data', $mulok)
		->set('all_rombel', $all_rombel)
		->set('form_action', 'admin/referensi/simpan')
		->build($this->admin_folder.'/referensi/_mulok',$data);
	}
	public function delete_kd($id){
		$kd = Kd::find_by_id($id);
		$kd->update_attributes(
				array(
					'kompetensi_dasar_alias' => '',
				)
			);
	}
	public function multidelete($q){
		$ids = $_POST['id'];
		$super_admin = array(1,2);
		if($q == 'metode'){
			$data = $q::find($ids);
			if(is_array($data)){
				foreach($data as $d){
					$d->delete();
				}
			} else {
				$data->delete();
			}
			$status['type'] = 'success';
			$status['text'] = 'Data '.$q.' berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} elseif($query == 'kd'){
			$data = Kd::find_by_id($id);
			$data->update_attributes(
				array(
					'kompetensi_dasar_alias' => '',
				)
			);
		} elseif($this->ion_auth->in_group($super_admin)){
			if(is_array($data)){
				foreach($data as $d){
					$d->delete();
				}
			} else {
				$data->delete();
			}
			$status['type'] = 'success';
			$status['text'] = 'Data '.$q.' berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data '.$q.' tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
	public function delete($query,$id){
		$super_admin = array(1,2,3);
		if($this->ion_auth->in_group($super_admin)){
			if($query == 'metode'){
				$data = Metode::find($id);
				$data->delete();
			}elseif($query == 'kurikulum'){
				$data = Kurikulum::find($id);
				$data->delete();
			} elseif($query == 'kkm'){
				$data = Kkm::find($id);
				$data->delete();
			} elseif($query == 'kd'){
				$data = Kd::find_by_id($id);
				$data->update_attributes(
					array(
						'kompetensi_dasar_alias' => '',
					)
				);
			} elseif($query == 'mulok'){
				$data = Mulok::find($id);
				$data->delete();
			} elseif($query == 'sikap'){
				$data = Datasikap::find($id);
				$data->delete();
			} elseif($query == 'ekskul'){
				$data = Ekskul::find($id);
				$data->delete();
			} elseif($query == 'mapel'){
				$find_matpel = Matpelkomp::find_by_id($id);
				if($find_matpel){
					$data = Datamapel::find_by_id($find_matpel->id_mapel);
					if($data){
						$data->delete();
					}
					$find_matpel->delete();
				}
			}
			$status['type'] = 'success';
			$status['text'] = 'Data '.$query.' berhasil dihapus';
			$status['title'] = 'Data Terhapus!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Data '.$query.' tidak terhapus';
			$status['title'] = 'Akses Ditolak!';
		}
		echo json_encode($status);
	}
}