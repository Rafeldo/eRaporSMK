<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriptions extends Backend_Controller {
	protected $activemenu = 'subscriptions';
	public function __construct()
	{
		parent::__construct();
		$this->template->set('activemenu', $this->activemenu);
	}

	public function index(){
		$data['subscriptions'] = Subscription::find('all', array('order'=>'id DESC'));
		$this->template->title('Administrator Panel : manage subscriptions')
        ->set_layout($this->admin_tpl)
        ->set('page_title', 'Subscriptions')
        ->build($this->admin_folder.'/subscriptions/list', $data);
	}

	public function create(){
		if($_POST){
			$subscription = Subscription::create($_POST);
			if($subscription->is_invalid()){
				$this->session->set_flashdata('error', 'There where errors saving the subscription');
				redirect('admin/subscriptions/create');
			} 
			$this->session->set_flashdata('success', 'Subscription added successfuly');
			redirect('admin/subscriptions');
		}
		else{
			$data['exams'] = Exam::find('all',array('conditions' => array("type = ?",'paid')));;
			$data['group'] = Group::find_by_name('members');
			$this->template->title('Administrator Panel : create subscription')
	        ->set_layout($this->admin_tpl) 
	        ->set('page_title', 'Create Subscription')
	        ->set('form_action', 'admin/subscriptions/create')
	        ->build($this->admin_folder.'/subscriptions/_subscriptions', $data);
    	}
	}
	public function edit($id){
		$subscription = Subscription::find($id);
		if($_POST){
			$id = $this->input->post('subscription_id');
			unset($_POST['subscription_id']);	
			$subscription->update_attributes($_POST);
			if($subscription->is_invalid()){
				$this->session->set_flashdata('error', 'There where errors saving the subscription');
				redirect('admin/subscriptions/edit/'.$id);
			} 
			$this->session->set_flashdata('success', 'Subscription updated successfuly');
			redirect('admin/subscriptions');
		}
		else{
			$data['exams'] = Exam::find('all',array('conditions' => array("type = ?",'paid')));;
			$data['group'] = Group::find_by_name('members');
			$this->template->title('Administrator Panel : edit subscription')
	        ->set_layout($this->admin_tpl)
	        ->set('page_title', 'Edit Subscription')
	        ->set('form_action', 'admin/subscriptions/edit/'.$id)
	        ->set('subscription', $subscription)
	        ->build($this->admin_folder.'/subscriptions/_subscriptions', $data);
    	}
	}
	public function view($id){
		$subscription = Subscription::find($id);
		$this->template->title('Administrator Panel : view subscription')
        ->set_layout($this->modal_tpl)
        ->set('page_title', 'View Subscription')
        ->set('subscription', $subscription)
        ->build($this->admin_folder.'/subscriptions/view');
	}
	public function delete($id){
		$subscription = Subscription::find($id);
		$subscription->delete();
	}
}