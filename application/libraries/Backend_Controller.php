<?php 

class Backend_Controller extends MY_Controller {

	protected $admin_folder = 'backend';
	protected $styles  		= 'backend/partials/css';
	protected $header 		= 'backend/partials/header';
	protected $sidebar 		= 'backend/partials/sidebar';
	protected $footer 		= 'backend/partials/footer';
	protected $admin_tpl 	= 'admin_tpl';
	protected $modal_tpl 	= 'modal_tpl';
	protected $blank_tpl 		= 'blank_tpl';

	function __construct() {
		parent::__construct();
		$this->template->set_partial('styles', $this->styles)
        ->set_partial('header', $this->header)
        ->set_partial('sidebar', $this->sidebar)
        ->set_partial('footer', $this->footer);
		if (!$this->db->field_exists('ajaran_id', 'data_sikaps')){
			$fields = array(
				'ajaran_id' => array('type' => 'INT',
								'constraint' => 11,
								'default' => '0',
								'null' => FALSE)
				);
			$this->dbforge->add_column('data_sikaps', $fields);
		}
		if (!$this->db->field_exists('user_id', 'matpel_komps')){
			$fields = array(
				'user_id' => array('type' => 'INT',
								'constraint' => 11,
								'default' => '0',
								'null' => FALSE)
				);
			$this->dbforge->add_column('matpel_komps', $fields);
		}
		if (!$this->db->table_exists('remedials')){
			$fields = array(
						'id' 				=> array(
												'type' => 'INT',
												'constraint' => 11,
												'unsigned' => TRUE,
												'auto_increment' => TRUE
											),
						'ajaran_id'		=> array(
												'type' => 'INT',
												'constraint' => 11
											),
						'kompetensi_id'		=> array(
												'type' => 'INT',
												'constraint' => 11
											),
						'rombel_id'		=> array(
												'type' => 'INT',
												'constraint' => 11
											),
						'mapel_id'		=> array(
												'type' => 'VARCHAR',
												'constraint' => '255'
											),
						'data_siswa_id'		=> array(
												'type' => 'INT',
												'constraint' => 11
											),
						'nilai'		=> array(
												'type' => 'TEXT'
											),
						'rerata_akhir'	=> array(
												'type' => 'VARCHAR',
												'constraint' => '255'
											),
						'rerata_remedial'		=> array(
												'type' => 'VARCHAR',
												'constraint' => '255'
											),
						'created_at'	=> array(
												'type' => 'datetime'
											),
						'updated_at'	=> array(
												'type' => 'datetime'
											)
						);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('remedials');
		}
        //login check 
		$exception_urls = array(
			'admin/auth',
		);
		
		if (in_array(uri_string(), $exception_urls) == FALSE) {
			if(!$this->ion_auth->logged_in()){
				redirect('admin/auth/');
			}
		}
	}

}