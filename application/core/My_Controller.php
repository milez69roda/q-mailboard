<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller {
	
	public $my_inbox = null;
	public $inboxes = null;
	public $categories = null;
	public $categories_count = null;
	public $user_id = null;
	public $user_fullname = null;
	public $user_email = null;
	
	public function __construct(){
		parent::__construct(); 
		 
		if( !$this->session->userdata('m_ISLOGIN') ){
			redirect(base_url()."login");
		}	

		$this->my_inbox = $this->session->userdata('m_INBOX');
		$this->user_id = $this->session->userdata('m_USERID');
		$this->user_fullname = $this->session->userdata('m_FULLNAME');
		$this->user_email = $this->session->userdata('m_EMAILADDRESS');
		
		$this->load->model('Groups_Model', 'groups');
		$this->load->model('MailsContent_Model', 'content');
		
		//load all the inbox
		$inbox = $this->groups->get_group(); 
		foreach($inbox as $row){
			$this->inboxes[$row['id']] = $row['group_name']; 
		}
		
		$this->categories = $this->groups->get_subgroup();
		$this->categories_count = $this->content->get_number_subgroup();
	}	
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */