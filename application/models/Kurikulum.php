<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kurikulum extends ActiveRecord\Model{
	static $after_create = array('after_create_log'); # new records only
	static $after_update = array('after_update_log');
	public function after_create_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Tambah data pembelajaran','ID:'.$this->id,$loggeduser->username);
	}
	public function after_update_log(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Update data pembelajaran','ID:'.$this->id,$loggeduser->username);
	}
	public function before_destroy(){
		$CI = & get_instance();
		$CI->load->library('ion_auth');
		$loggeduser = $CI->ion_auth->user()->row();
		set_log('Hapus data pembelajaran','ID:'.$this->id,$loggeduser->username);
		$rencana = Rencana::find('all',array(
            				'conditions' => array(
					            'ajaran_id' => $this->ajaran_id,
								'rombel_id' => $this->rombel_id,
								'id_mapel' => $this->id_mapel
							)
					)
        );
        if($rencana){
			foreach($rencana as $e){
				$e->delete();
			}
		}
	}
}