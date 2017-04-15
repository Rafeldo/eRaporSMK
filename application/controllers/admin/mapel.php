<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mapel extends Backend_Controller {
	protected $activemenu = 'mapel';
	public function __construct()
	{
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
		$this->load->library('form_validation');
		$this->load->library('custom_fuction');
		if($this->ion_auth->in_group('guru')){
			redirect('guru/dashboard');
		} elseif($this->ion_auth->in_group('siswa')){
			redirect('siswa/dashboard');
		}
	}

	public function index(){
		$loggeduser = $this->ion_auth->user()->row();
		$data['categories'] = Category::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		//$data['rombels'] = Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$data['rombels'] = Datarombel::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id", 'order' => "nama ASC"));
		$data_rombel = Datarombel::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id", 'order' => "nama ASC"));
		$pilih_rombel = '<div class="col-md-3"><select id="pilih_rombel" class="form-control">';
		$pilih_rombel .= '<option value="">==Filter Berdasar Rombel==</option>';
		foreach($data_rombel as $rombel){
			$pilih_rombel .= '<option value="'.$rombel->id.'">'.$rombel->nama.'</option>';
		}
		$pilih_rombel .= '</select>';
		$pilih_rombel .= '</div>';
		$this->template->title('Administrator Panel : Mata Pelajaran')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Mata Pelajaran')
		->set('pilih_rombel', $pilih_rombel)
        ->build($this->admin_folder.'/mapel/list', $data);
	}

	public function tambah(){
		$this->form_validation->set_rules('data_sekolah_id', 'Sekolah ID', 'required|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama Mata Pelajaran', 'required|xss_clean');
		$this->form_validation->set_rules('data_rombel_id', 'Rombel', 'required|xss_clean');
		$this->form_validation->set_rules('guru_id', 'Guru Mata Pelajaran', 'required|xss_clean');
		if ($this->form_validation->run() == true){
			$data = array(
				'data_sekolah_id'	=> $this->input->post('data_sekolah_id'),
				'nama'			=> $this->input->post('nama'),
				'data_rombel_id'    	=> $this->input->post('data_rombel_id'),
				'guru_id'    	=> $this->input->post('guru_id'),
				'petugas'  		=> $this->input->post('petugas'),
			);
			$category = Category::create($data);
			if($category){
				$this->session->set_flashdata('success', 'Mata Pelajaran Berhasil ditambah');
				redirect("admin/mapel/tambah", 'refresh');
			} else {
				$message = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				$this->session->set_flashdata('message', $message);
				redirect("admin/mapel/tambah", 'refresh');
			}
			$this->session->set_flashdata('success', 'Mata Pelajaran berhasil disimpan');
			redirect('admin/mapel');
		}
		else{
			$message = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->session->set_flashdata('message', $message);
			$loggeduser = $this->ion_auth->user()->row();
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
			$data['gurus'] = Dataguru::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id", 'order' => "nama asc"));
			$this->template->title('Administrator Panel : tambah Mata Pelajaran')
	        ->set_layout($this->admin_tpl)
	        ->set('page_title', 'Mata Pelajaran')
	        ->set('form_action', 'admin/mapel/tambah')
	        ->build($this->admin_folder.'/mapel/_mapel',$data);
			//->build($this->admin_folder.'/demo');
    	}
	}

	public function edit($id){
		$loggeduser = $this->ion_auth->user()->row();
		$category = Category::find($id);
		$data['rombels'] = Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$data['gurus'] = Dataguru::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id", 'order' => "nama asc"));
		if($_POST){
			$id = $this->input->post('category_id');
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['category_id']);		
			$category->update_attributes($_POST);
			if($category->is_invalid()){
				$this->session->set_flashdata('error', 'Ada kesalahan saat menyimpan Mata Pelajaran');
				redirect('admin/mapel/edit');
			} 
			$this->session->set_flashdata('success', 'Update Mata Pelajaran Berhasil');
			redirect('admin/mapel');
		}
		else{
			$this->template->title('Administrator Panel : Edit Mata Pelajaran')
	        ->set_layout($this->admin_tpl)
	        ->set('page_title', 'Edit Mata Pelajaran')
	        ->set('form_action', 'admin/mapel/edit/'.$id)
	        ->set('category', $category)
	        ->build($this->admin_folder.'/mapel/_mapel',$data);
			//->build($this->admin_folder.'/demo');
    	}
	}

	public function view($id){
		$category = Category::find($id);
		$this->template->title('Administrator Panel : Lihat Mata Pelajaran')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Detil Mata Pelajaran')
	        ->set('category', $category)
	        ->build($this->admin_folder.'/mapel/view');
	}

	public function delete($id){
		$category = Category::find($id);
		$category->delete();
	}
	public function multidelete(){
		$ids = $_POST['id'];
		foreach($ids as $id){
			$category = Category::find($id);
			$category->delete();
			echo 'delete_mapel';
		}
	}
	public function guru($id){
		$loggeduser = $this->ion_auth->user()->row();
		//$user 	= Dataguru::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$user = Dataguru::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id", 'order' => "nama asc"));
		$this->template->title('Administrator Panel : Detil Guru')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Nama Guru')
	        ->set('id_rombel', $id)
	        ->set('gurus', $user)
			->set('modal_footer', '<a href="javascript:void(0)" class="btn btn-success btn-sm pilih_guru"><i class="fa fa-plus-circle"></i> Pilih</a>')			
	        ->build($this->admin_folder.'/mapel/select');
	}
	public function rombel($id){
		$loggeduser = $this->ion_auth->user()->row();
		$rombels 	= Datarombel::find('all', array('conditions' => array('data_sekolah_id = ?',$loggeduser->data_sekolah_id)));
		$this->template->title('Administrator Panel : Detil Rombongan Belajar')
	        ->set_layout($this->modal_tpl)
	        ->set('page_title', 'Nama Rombongan Belajar')
	        ->set('id_mapel', $id)
	        ->set('rombels', $rombels)
			->set('modal_footer', '<a href="javascript:void(0)" class="btn btn-success btn-sm pilih_guru"><i class="fa fa-plus-circle"></i> Pilih</a>')			
	        ->build($this->admin_folder.'/mapel/rombel');
	}
	public function gurumapel($id){
		if(isset($_POST['id'])){
			$guru_id = $_POST['id'];
			$this->db->where('id', $id);
			$updatedata = array('guru_id'=>$guru_id);
			$this->db->update('categories', $updatedata); 
			$query = $this->db->get('categories');
			if($query->num_rows()>0){
				$mapel = $query->result();
				$updateexams = array('guru_id'=>$guru_id);
				$this->db->where('category_id', $mapel[0]->id);
				$this->db->update('exams', $updateexams); 
				$status['sukses'] 	= 1;
				$status['text']		= 'Update data berhasil';
			} else {
				$status['sukses']	= 1;
				$status['text']		= 'Update data sukses';
			}
		} else {
			$status['sukses'] = 0;
			$status['text'] = 'Update data gagal!';
		}
		echo json_encode($status);
	}
	public function setrombel($id){
		if(isset($_POST['id'])){
			$rombel_id = $_POST['id'];
			$updatedata = array('data_rombel_id'=>$rombel_id);
			$this->db->where('id', $id);
			$this->db->update('categories', $updatedata); 
			echo 'sukses';
		} else {
			echo 'gagal';
		}
	}
	public function listview($id = NULL){
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

		// run query to get user listing
		if($id){
			$query = Category::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id AND data_rombel_id = '$id' AND (nama LIKE '%$search%' OR data_rombel_id LIKE '%$search%' OR guru_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Category::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id AND data_rombel_id = '$id' AND (nama LIKE '%$search%' OR data_rombel_id LIKE '%$search%' OR guru_id LIKE '%$search%')"));
		} else {
			$query = Category::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id AND (nama LIKE '%$search%' OR data_rombel_id LIKE '%$search%' OR guru_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start));
			$filter = Category::find('all', array('conditions' => "data_sekolah_id = $loggeduser->data_sekolah_id AND (nama LIKE '%$search%' OR data_rombel_id LIKE '%$search%' OR guru_id LIKE '%$search%')"));
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
			if($temp->guru_id == 0){
				$wali = 0;
			} else {
				$wali = Dataguru::find($temp->guru_id);
			}
			if($temp->data_rombel_id == 0){
				$rombel = 0;
			} else {
				$rombel = Datarombel::find($temp->data_rombel_id);
			}
			$namarombel = ($rombel != '0') ? $rombel->nama: '<a href="'.site_url('admin/mapel/rombel/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-search-plus"></i> Pilih Rombongan Belajar</a>';
			$gurumapel = ($wali != '0') ? $wali->nama: '<a href="'.site_url('admin/mapel/guru/'.$temp->id).'" class="btn btn-primary btn-sm toggle-modal"><i class="fa fa-search-plus"></i> Pilih Guru Mata Pelajaran</a>';
			$record = array();
            $tombol_aktif = '';
			$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
			$record[] = '<div class="text-center">'.$namarombel.'</div>';
			$record[] = $temp->nama;
			$record[] = $gurumapel;
			//$record[] = $this->custom_fuction->view_btn('admin/guru/view/'.$guru->id,'Detil').' '.$this->custom_fuction->edit_btn('admin/guru/edit/'.$guru->id);
			$record[] = '<div class="text-center"><div class="btn-group">
							<button type="button" class="btn btn-default btn-sm">Aksi</button>
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu pull-right text-left" role="menu">
                                <li><a href="'.site_url('admin/mapel/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li>
								<li><a href="'.site_url('admin/mapel/edit/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li>
								<li><a href="'.site_url('admin/mapel/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i>Hapus</a></li>
                            </ul>
                        </div></div>';
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}	
}
