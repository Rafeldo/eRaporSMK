<?php 

class Migration_Create_questions_tbl extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
				'id' => array(
						'type' => 'INT',
						'constraint' => 11,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
				'exam_id' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
				),
				'question' => array(
						'type' => 'TEXT',
				),
				'image' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
				),
				'marks' => array(
						'type' => 'INT',
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('questions');
	}

	public function down()
	{
		$this->dbforge->drop_table('questions');
	}
}