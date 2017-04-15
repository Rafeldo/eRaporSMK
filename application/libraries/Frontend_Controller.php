<?php 
class Frontend_Controller extends MY_Controller {
	protected $styles  		= 'frontend/partials/css';
	protected $header 		= 'frontend/partials/header';
	protected $footer 		= 'frontend/partials/footer';

	function __construct() {
		parent::__construct();
		$this->template->set_partial('styles', $this->styles)
        ->set_partial('header', $this->header)
        ->set_partial('footer', $this->footer);
	}
}