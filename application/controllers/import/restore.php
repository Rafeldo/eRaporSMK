<?php
class Restore extends Backend_Controller {
	function __construct()  {
         parent::__construct();
    }
	public function index(){
		$fileName = $_FILES['import']['name'];
		$status = array();
		$file_path = './assets/files/';
		if(move_uploaded_file($_FILES['import']['tmp_name'], $file_path.$fileName)){
			$file = $this->load->file($file_path.$fileName, true);
			$file_array = explode(';', $file);
			foreach($file_array as $query) {
				$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
				$this->db->query($query);
				$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
			}
			$status['type'] = 'success';
			$status['text'] = 'Restore '.$fileName.' sukses.';
			$status['title'] = 'Restore Data Sukses!';
		} else {
			$status['type'] = 'error';
			$status['text'] = 'Restore '.$fileName.' gagal.';
			$status['title'] = 'Restore Data Gagal!';
		}
		echo json_encode($status);
	}
}