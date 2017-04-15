<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Progress extends Frontend_Controller {
     
    public function __construct(){
		parent::__construct();
	}                              
	public function index(){
		$this->load->view('progress');
	}
}

/* End of file progress.php */
/* Location: ./application/controllers/progress.php */