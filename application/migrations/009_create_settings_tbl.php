<?php 

class Migration_Create_settings_tbl extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
				'id' => array(
						'type' => 'INT',
						'constraint' => 11,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
				'site_title' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'description' => array(
						'type' => 'TEXT',
				),
				'keywords' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'address' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'city' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'email' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'phone' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'logo' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'paypal' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'date_format' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'currency' => array(
						'type' => 'VARCHAR',
						'constraint'=> '100'
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)

		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('settings');
	}

	public function down()
	{
		$this->dbforge->drop_table('settings');
	}
}