<?php 

class Migration_Create_user_questions_tbl extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
				'id' => array(
						'type' => 'INT',
						'constraint' => 11,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
				),
				'user_id' => array(
						'type' => 'INT',
				),
				'question_id' => array(
						'type' => 'INT',
				),
				'filled' => array(
						'type' => 'ENUM("yes", "no")',
				),
				'answer' => array(
						'type' => 'INT',
				),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_questions');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_questions');
	}
}