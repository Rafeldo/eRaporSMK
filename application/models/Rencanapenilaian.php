<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RencanaPenilaian extends ActiveRecord\Model{
	static $has_many = array(
							array('nilai'),
							array('nilaiakhir'),
						);
	public function before_destroy(){
        $nilai = Nilai::find('all',array(
            'conditions' => array(
            'rencana_penilaian_id' => $this->id)
        ));
		foreach($nilai as $n){
			$id[] = $n->id;
		}
        if($nilai){
	        Nilai::table()->delete(array('id' => $id));
		}
		$nilaiakhir = Nilaiakhir::find('all',array(
            'conditions' => array(
            'rencana_penilaian_id' => $this->id)
        ));
		foreach($nilaiakhir as $na){
			$ida[] = $na->id;
		}
        if($nilaiakhir){
	        Nilaiakhir::table()->delete(array('id' => $ida));
		}
    }
}