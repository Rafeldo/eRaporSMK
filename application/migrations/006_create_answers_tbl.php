<?php 

class Migration_Create_answers_tbl extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
				'id' => array(
						'type' => 'INT',
						'constraint' => 11,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
				'question_id' => array(
						'type' => 'INT',
				),
				'answer' => array(
						'type' => 'TEXT',
				),
				'correct' => array(
						'type' => 'ENUM("0", "1")',
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('answers');
	}

	public function down()
	{
		$this->dbforge->drop_table('answers');
	}
}