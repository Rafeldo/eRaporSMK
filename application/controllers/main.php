<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends Frontend_Controller {
     
    public function __construct(){
		parent::__construct();
	}                              
	public function index(){
		$this->load->view('progress');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */