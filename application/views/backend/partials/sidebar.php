<?php
$user = $this->ion_auth->user()->row();
$cari_rombel = '';
if($user->data_guru_id != 0){
	$cari_rombel = Datarombel::find_by_guru_id($user->data_guru_id);
}
$waka = array('waka');
if($this->ion_auth->in_group('admin')){
	$akses = 'admin';
	$this->load->view('backend/partials/sidebar_admin');
} elseif($this->ion_auth->in_group('tu')){
	$akses = 'tu';
	$this->load->view('backend/partials/sidebar_tu');
} elseif($this->ion_auth->in_group($waka)){
	$akses = 'waka';
	$this->load->view('backend/partials/sidebar_waka');
} elseif($this->ion_auth->in_group('siswa')){
	$akses = 'siswa';
	$this->load->view('backend/partials/sidebar_siswa');
} elseif(!$cari_rombel && $this->ion_auth->in_group('guru')){
	$akses = 'guru';
	$this->load->view('backend/partials/sidebar_guru');
} elseif($cari_rombel && $this->ion_auth->in_group('guru')){
	$akses = 'wali';
	$this->load->view('backend/partials/sidebar_wali');
} elseif($this->ion_auth->in_group('user')){
	$akses = 'user';
	$this->load->view('backend/partials/sidebar_user');
}elseif($this->ion_auth->in_group('kasir')){
	$akses = 'kasir';
	$this->load->view('backend/partials/sidebar_kasir');
}
echo $akses;
?>