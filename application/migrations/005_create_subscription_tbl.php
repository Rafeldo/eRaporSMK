<?php 

class Migration_Create_subscription_tbl extends CI_Migration {

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
				'amount' => array(
						'type' => 'DOUBLE',
				),
				'created_at' => array(
						'type' => 'DATETIME',
				),
				'updated_at' => array(
						'type' => 'DATETIME',
				)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('subscriptions');
	}

	public function down()
	{
		$this->dbforge->drop_table('subscriptions');
	}
}