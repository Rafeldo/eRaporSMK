<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data_model extends CI_Model{	
	function __construct(){
		parent::__construct(); 
	}
	function get_data_sekolah($user_id){
        //$sql = 'SELECT * FROM data_sekolahs WHERE user_id="'.$email.'"';
		$this->db->where('user_id', $user_id);
		$this->db->or_where('email', $user_id); 
		$query = $this->db->get('data_sekolahs');
		/*if($query->num_rows() == 0){
			$this->db->where('ptk_id', $user_id);
			$this->db->or_where('email', $user_id); 
			$this->db->or_where('nuptk', $user_id); 
			$query = $this->db->get('data_gurus');
		}*/
		return $query;
	}
	function get_data_guru($email){
        $sql = 'SELECT * FROM data_gurus WHERE uname="'.$email.'"';
		return $this->db->query($sql)->row();
	}
	function save_sekolah($user_id,$idSekolah,$nama_sekolah,$npsn,$bentuk,$alamat,$desa,$kecamatan,$kabupaten,$propinsi,$kodepos,$email,$password_dapo,$status){
		$sql = 'INSERT INTO data_sekolahs(`user_id`, `idSekolah`, `nama_sekolah`, `npsn`, `bentuk`, `alamat`, `desa`, `kecamatan`, `kabupaten`, `propinsi`, `kodepos`, `email`, `password_dapo`, `status`) VALUES
            ("'.$user_id.'", "'.$idSekolah.'", "'.$nama_sekolah.'", "'.$npsn.'", "'.$bentuk.'", "'.$alamat.'", "'.$desa.'", "'.$kecamatan.'", "'.$kabupaten.'", "'.$propinsi.'", "'.$kodepos.'", "'.$email.'", "'.$password_dapo.'", "'.$status.'")';
        $this->db->query($sql);
	}
	function update_sekolah($user_id,$idSekolah,$nama_sekolah,$npsn,$bentuk,$alamat,$desa,$kecamatan,$kabupaten,$propinsi,$kodepos,$email,$password_dapo,$status){
        $sql = 'UPDATE data_sekolahs SET `idSekolah`="'.$idSekolah.'", `nama_sekolah`="'.$nama_sekolah.'", `npsn`="'.$npsn.'", `bentuk`="'.$bentuk.'", `alamat`="'.$alamat.'", `desa`="'.$desa.'", `kecamatan`="'.$kecamatan.'", `kabupaten`="'.$kabupaten.'", `propinsi`="'.$propinsi.'", `kodepos`="'.$kodepos.'", `email`="'.$email.'", `password_dapo`="'.$password_dapo.'", `status`="'.$status.'" WHERE user_id="'.$user_id.'"';
        $this->db->query($sql);
    }
	function get_login_info($username){
		$this->db->where('uname',$username);
		$this->db->limit(1);
		$this->db->from('data_gurus');
		$this->db->join('user', 'user.IDGuru = data_gurus.GuruID');
		$query = $this->db->get();
		return $query->row();
	}
	function get_all_guru(){
		$query = $this->db->get('data_gurus');
		return $query->result();
	}
}