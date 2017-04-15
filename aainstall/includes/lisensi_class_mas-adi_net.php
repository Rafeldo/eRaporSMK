<?php
require 'Curl/Curl.php';
$curl = new Curl();
function daftar($data){
	$server = $_SERVER["SERVER_NAME"];
	$lisensi = $data['kode_lisensi'];
	$comp_name = $data['comp_name'];
	$hdd_id = $data['hdd_id'];
	$disk_id = $data['hdd_id'];
	$npsn = $data['npsn'];
	global $curl;
	$curl->post('http://admin.cybereducation.co.id/klien/verifyLicense.php', array(
			'server' => $server,
			'lisensi' => $lisensi,
			'comp_name' => $comp_name,
			'hdd_id' => $hdd_id,
			'disk_id' => $disk_id,
			'npsn' => $npsn
		));
	return $curl->response;
}