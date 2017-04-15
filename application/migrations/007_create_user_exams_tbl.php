<?php 

class Migration_Create_user_exams_tbl extends CI_Migration {

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
				'exam_id' => array(
						'type' => 'INT',
				),
				'start' => array(
						'type' => 'DATETIME',
				),
				'end' => array(
						'type' => 'DATETIME',
				),
				'status' => array(
						'type' => 'ENUM("completed", "inprogress")',
				),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_exams');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_exams');
	}
}