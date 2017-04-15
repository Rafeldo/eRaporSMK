<?php 

class Migration_Create_exam_tbl extends CI_Migration {

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
				'category_id' => array(
						'type' => 'INT',
				),
				'available_from' => array(
						'type' => 'date',
				),
				'available_to' => array(
						'type' => 'date',
				),
				'duration' => array(
						'type' => 'BIGINT',
				),
				'questions' => array(
						'type' => 'INT',
				),
				'pass_mark' => array(
						'type' => 'INT',
				),
				'type' => array(
					'type' => 'ENUM ("paid", "free")',
					'default' =>  'free'
				),
				'active' => array(
					'type' => 'ENUM ("0", "1")',
					'default' =>  '1'
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('exams');
	}

	public function down()
	{
		$this->dbforge->drop_table('exams');
	}
}