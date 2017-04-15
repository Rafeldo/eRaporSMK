<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Portofolio extends Frontend_Controller {
    public function __construct(){
		parent::__construct();
	}                              
	public function index(){
		$post 			= array();
		parse_str($_REQUEST['form_data'], $post);
		$do_upload 		= $_REQUEST['costum_name'];
		$nilai_ke 		= str_replace('import_','',$do_upload);
		$ajaran_id		= $post['ajaran_id'];
		$rombel_id		= $post['rombel_id'];
		$id_mapel		= $post['id_mapel'];
		$penilaian_id 	= $post['nilai_'.$nilai_ke];
		$siswa_id		= $post['siswa_id'];
		$this->load->helper(array('form','url'));
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']    = 0;
		$this->load->library('upload', $config);
		$id_portofolio = '';
		if (!$this->upload->do_upload($do_upload)){
			$status['type'] = 'error';
			$status['text'] = $this->upload->display_errors();
			$status['title'] = 'Upload Gagal!';
		} else {
			$media = $this->upload->data();
			$portofolio = Dataportofolio::find_by_ajaran_id_and_rombel_id_and_id_mapel_and_penilaian_id_and_siswa_id($ajaran_id, $rombel_id, $id_mapel, $penilaian_id, $siswa_id);
			if($portofolio){
				$id_portofolio = $portofolio->id;
				$filename = './uploads/'.$portofolio->nama_portofolio;
				if (file_exists($filename)) {
					unlink($filename);
				}
				$data_update = array('nama_portofolio' => $media['file_name']);	
				$portofolio->update_attributes($data_update);
			} else {
				$insert_portofolio = array(
											'ajaran_id' => $ajaran_id,
											'rombel_id' => $rombel_id,
											'id_mapel' => $id_mapel,
											'siswa_id' => $siswa_id,
											'penilaian_id' => $penilaian_id,
											'nama_portofolio'	=> $media['file_name']
										);
				$new_portofolio = Dataportofolio::create($insert_portofolio);
			}
			if(isset($new_portofolio)){
				$id_portofolio = $new_portofolio->id;
			}
			
			$status['type'] = 'success';
			$status['text'] = 'Berhasil mengunggah file '.$media['file_name'];
			$status['title'] = 'Unggah Berhasil';
			$status['record'] = '<a href="'.site_url('uploads/'.$media['file_name']).'" target="_blank">'.$media['file_name'].'</a> <a href="'.site_url('admin/asesmen/delete_file/'.$new_portofolio->id.'/'.$media['file_name']).'" class="confirm tooltip-left" title="Hapus file '.$media['file_name'].'"><i class="fa fa-fw fa-trash-o"></i></a>';			
		}
		echo json_encode($status);
	}
}
/* End of file portofolio.php */
/* Location: ./application/controllers/import/portofolio.php */