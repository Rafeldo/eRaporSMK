<?php 
class MY_Controller extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
		check_installer();
	}
}
