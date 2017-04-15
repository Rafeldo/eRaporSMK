<?php 

class Migration_Create_category_tbl extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
				'id' => array(
						'type' => 'INT',
						'constraint' => 11,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
				'name' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
				),
				'description' => array(
						'type' => 'TEXT',
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('categories');
	}

	public function down()
	{
		$this->dbforge->drop_table('categories');
	}
}