<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Integrasi extends Backend_Controller {
	function __construct(){
		parent:: __construct();
		$this->load->library('simple_html_dom');
	}
	
	public function index(){
        redirect('admin/dashboard');
	}
    
    public function login(){
		$email 		= $this->input->post('email',TRUE);
		$password 	= $this->input->post('password',TRUE);
		if(!$email && !$password){
		$email 		= $this->input->post('email_guru',TRUE);
		$password 	= $this->input->post('password_guru',TRUE);
		}
		$semester 	= $this->input->post('semester',TRUE);
        //$result = $this->custom_fuction->LoginIntegrasi();
		//$username="akun.smai@gmail.com"; 
		//$password="himalaya"; 
		$url="http://dapo.dikmen.kemdikbud.go.id/portal/web/proseslogin"; 
		$cookie=base_url()."assets/cookie.txt";
		$url2 = "http://dapo.dikmen.kemdikbud.go.id/portal/web/";
		$postdata = "email=".$email."&password=".$password; 
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
		curl_setopt ($ch, CURLOPT_REFERER, $url); 
		
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		curl_setopt ($ch, CURLOPT_POST, 1); 
		$result = curl_exec ($ch);
		$pesan = json_decode($result);
		$pesan = $pesan->pesan;
		if($pesan != 'Anda Berhasil Masuk. Mohon tunggu sebelum halaman dimuat ulang'){
			echo $result;
			return false;
		}
		//
		//print_r(json_decode($result));
		echo str_replace('}',',',$result);
		$url = 'http://dapo.dikmen.kemdikbud.go.id/portal/web/'; 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		$data = curl_exec($ch);
		$html = str_get_html($data);
		//echo $html;
		foreach($html->find('a.btn') as $a => $e) {
			if($a==0){
			    echo '"link":"http://dapo.dikmen.kemdikbud.go.id/portal/web/'.$e->href.'",';
				$url = explode("/",$e->href);
				$url = $url[2];
			    echo '"IDdaftarPtkJson":"'.$url.'",';
			    echo '"IDdaftarPdJson":"'.$url.'",';
		    	echo '"IDdaftarRombelJson":"'.$url.'",';
				echo '"daftarPtkJson":"http://dapo.dikmen.kemdikbud.go.id/portal/web/report/daftarPtkJson/'.$url.'/'.$semester.'",';
				echo '"daftarPdJson":"http://dapo.dikmen.kemdikbud.go.id/portal/web/report/daftarPdJson/'.$url.'/'.$semester.'",';
				echo '"email":"'.$email.'",';
				echo '"password":"'.$password.'",';
				echo '"semester":"'.$semester.'",';
				echo '"daftarRombelJson":"http://dapo.dikmen.kemdikbud.go.id/portal/web/report/daftarRombelJson/'.$url.'/'.$semester.'"}';
			}
		}
    }
    public function singkron(){
		$email 		= $this->input->post('email_dapodikmen',TRUE);
		$password 	= $this->input->post('password_dapodikmen',TRUE);
		$semester 	= $this->input->post('semester',TRUE);
		$url="http://dapo.dikmen.kemdikbud.go.id/portal/web/proseslogin"; 
		$cookie=base_url()."assets/cookie.txt";
		$url2 = "http://dapo.dikmen.kemdikbud.go.id/portal/web/";
		$postdata = "email=".$email."&password=".$password; 
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
		curl_setopt ($ch, CURLOPT_REFERER, $url); 
		
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		curl_setopt ($ch, CURLOPT_POST, 1); 
		$result = curl_exec ($ch);
		$pesan = json_decode($result);
		$pesan = $pesan->pesan;
		if($pesan != 'Anda Berhasil Masuk. Mohon tunggu sebelum halaman dimuat ulang'){
			echo $result;
			return false;
		}
		//
		//print_r(json_decode($result));
		echo str_replace('}',',',$result);
		$url = 'http://dapo.dikmen.kemdikbud.go.id/portal/web/'; 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		$data = curl_exec($ch);
		$html = str_get_html($data);
		//echo $html;
		foreach($html->find('a.btn') as $a => $e) {
			if($a==0){
			    echo '"link":"http://dapo.dikmen.kemdikbud.go.id/portal/web/'.$e->href.'",';
				$url = explode("/",$e->href);
				$SekolahID = $url[2];
				echo '"email":"'.$email.'",';
				echo '"password":"'.$password.'",';
				echo '"SekolahID":"'.$SekolahID.'"}';
			}
		}
    }
    public function sekolah(){
		$username	= $this->input->get('email', TRUE);
		$password	= $this->input->get('password', TRUE);
		$SekolahID	= $this->input->get('SekolahID',TRUE);
		$url="http://dapo.dikmen.kemdikbud.go.id/portal/web/proseslogin"; 
		$cookie=base_url()."assets/cookie.txt";
		$url2 = "http://dapo.dikmen.kemdikbud.go.id/portal/web/";
		
		$postdata = "email=".$username."&password=".$password; 
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
		curl_setopt ($ch, CURLOPT_REFERER, $url); 
		
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		curl_setopt ($ch, CURLOPT_POST, 1); 
		$result = curl_exec ($ch);
		$url = 'http://dapo.dikmen.kemdikbud.go.id/portal/web/breadcrumb/datasekolah/'.$SekolahID;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		$data = curl_exec($ch);
		$html = str_get_html($data);
		echo $html;
    }
	public function ptk(){
		$username			= $this->input->get('email', TRUE);
		$password			= $this->input->get('password', TRUE);
		$semester 			= $this->input->get('semester',TRUE);
		$IDdaftarPtkJson	= $this->input->get('idSekolah',TRUE);
		$url="http://dapo.dikmen.kemdikbud.go.id/portal/web/proseslogin"; 
		$cookie=base_url()."assets/cookie.txt";
		$url2 = "http://dapo.dikmen.kemdikbud.go.id/portal/web/";
		
		$postdata = "email=".$username."&password=".$password; 
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
		curl_setopt ($ch, CURLOPT_REFERER, $url); 
		
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		curl_setopt ($ch, CURLOPT_POST, 1); 
		$result = curl_exec ($ch);
		$url = 'http://dapo.dikmen.kemdikbud.go.id/portal/web/report/daftarPtkJson/'.$IDdaftarPtkJson.'/'.$semester.'';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		$data = curl_exec($ch);
		$html = str_get_html($data);
		echo $html;
	}
	public function pd(){
		$username			= $this->input->get('email', TRUE);
		$password			= $this->input->get('password', TRUE);
		$semester 			= $this->input->get('semester',TRUE);
		$IDdaftarPdJson		= $this->input->get('idSekolah',TRUE);
		$url="http://dapo.dikmen.kemdikbud.go.id/portal/web/proseslogin"; 
		$cookie=base_url()."assets/cookie.txt";
		$url2 = "http://dapo.dikmen.kemdikbud.go.id/portal/web/";
		
		$postdata = "email=".$username."&password=".$password; 
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
		curl_setopt ($ch, CURLOPT_REFERER, $url); 
		
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
		curl_setopt ($ch, CURLOPT_POST, 1); 
		$result = curl_exec ($ch);
		$url = 'http://dapo.dikmen.kemdikbud.go.id/portal/web/report/daftarPdJson/'.$IDdaftarPdJson.'/'.$semester.'';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		$data = curl_exec($ch);
		$html = str_get_html($data);
		echo $html;
	}
	public function post_sekolah(){
		//print_r($_POST);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('idSekolah', 'Jalan','strip_tags');
		$this->form_validation->set_rules('bentuk_pendidikan_id_str', '','strip_tags');
		$this->form_validation->set_rules('nama_sekolah', '','strip_tags');
		$this->form_validation->set_rules('npsn', '','strip_tags');
		$this->form_validation->set_rules('bentuk', '','strip_tags');
		$this->form_validation->set_rules('alamat', '','strip_tags');
		$this->form_validation->set_rules('desa', '','strip_tags');
		$this->form_validation->set_rules('kecamatan', '','strip_tags');
		$this->form_validation->set_rules('kabupaten', '','strip_tags');
		$this->form_validation->set_rules('propinsi', '','strip_tags');
		$this->form_validation->set_rules('kodepos', '','strip_tags');
		$this->form_validation->set_rules('email', '','strip_tags');
		$this->form_validation->set_rules('password_dapo', '','strip_tags');
		$this->form_validation->set_rules('status', '','strip_tags');
		$this->form_validation->set_rules('user_is', '','strip_tags');
		if($this->form_validation->run() == TRUE){
            $this->load->model('data_model');
			$idSekolah = $this->input->post('idSekolah', TRUE);
			$nama_sekolah = $this->input->post('nama_sekolah', TRUE);
			$npsn = $this->input->post('npsn', TRUE);
			$bentuk = $this->input->post('bentuk', TRUE);
			$alamat = $this->input->post('alamat', TRUE);
			$desa = $this->input->post('desa', TRUE);
			$kecamatan = $this->input->post('kecamatan', TRUE);
			$kabupaten = $this->input->post('kabupaten', TRUE);
			$propinsi = $this->input->post('propinsi', TRUE);
			$kodepos = $this->input->post('kodepos', TRUE);
			$email = $this->input->post('email', TRUE);			
			$password_dapo = $this->input->post('password_dapo', TRUE);			
			$status = $this->input->post('status', TRUE);	
			$user_id = $this->input->post('user_id', TRUE);
			$cari_email = $this->data_model->get_data_sekolah($user_id);
			if($cari_email->num_rows()>0){
				$this->data_model->update_sekolah($user_id,$idSekolah,$nama_sekolah,$npsn,$bentuk,$alamat,$desa,$kecamatan,$kabupaten,$propinsi,$kodepos,$email,$password_dapo,$status);
			} else {
				$this->data_model->save_sekolah($user_id,$idSekolah,$nama_sekolah,$npsn,$bentuk,$alamat,$desa,$kecamatan,$kabupaten,$propinsi,$kodepos,$email,$password_dapo,$status);
			}
			$result['status'] = 1;
			$result['error'] = '';
		} else {
			$result['status'] = 0;
            $result['error'] = validation_errors();
		}
		echo json_encode($result);
	}
	function updateGuruID(){
		//print_r($_POST);
		//return false;
		$GuruID = $this->input->post('data_anda', TRUE);
		$username = $this->input->post('uname', TRUE);
		$idSekolah = $this->input->post('idSekolah_anda', TRUE);
		$nama = $this->input->post('nama_anda', TRUE);
		$nuptk = $this->input->post('nuptk', TRUE);
		$kelamin = $this->input->post('kelamin', TRUE);
		$status_kepegawaian = $this->input->post('status_kepegawaian', TRUE);
		$petugas = $this->input->post('uname', TRUE);
		$this->load->model('users_model');
		$query = $this->users_model->updateGuruID($GuruID,$username,$idSekolah,$nama,$nuptk,$kelamin,$status_kepegawaian,$petugas);		
		echo $query;
	}
}