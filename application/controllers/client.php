<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		
	}
	 
	public function index(){
		$this->load->view('template');
	}
	 
	public function emailform(){ 
		$this->load->model('groups_model', 'group'); 
		$data['version'] = '1.1';  
		$data['group']		= $this->group->get_group();			
		$data['subgroup']	= $this->group->get_subgroup();				
		$data['html'] = $this->load->view('email_tpl', '', true); 
		echo json_encode($data);
	}
	
	public function emailsend(){
		$json = array('status'=>0,'msg'=>'Sending Failed');
		
		$this->load->model('MailsContent_Model', 'mailcontent'); 
		
		$this->load->library('form_validation');	
		
		$this->form_validation->set_rules('inputFirstname', 'Firstname', 'required');
		$this->form_validation->set_rules('inputLastname', 'Lastname', 'required');
		$this->form_validation->set_rules('inputAyava', 'Avaya', 'required|integer|callback_check_avaya_exist');
		$this->form_validation->set_rules('selectGroup', 'To: Department', 'required');		
		$this->form_validation->set_rules('selectSubGroup', 'To: Category', 'required');		
		//$this->form_validation->set_rules('inputSubjectOther', 'Subject', 'trim|callback_subject_other_check(["'.$this->input->post('selectSubGroup').'"])');		
		$this->form_validation->set_rules('textMessage', 'Message', 'required');		
		
		if ($this->form_validation->run() == FALSE){
			$json['msg'] = validation_errors(); 
		}else{
			$set['updated_date'] 		= date('Y-m-d H:i:s');
			$set['mail_from_firstname'] = $this->input->post('inputFirstname');
			$set['mail_from_lastname'] 	= $this->input->post('inputLastname');
			$set['avaya'] 				= $this->input->post('inputAyava');
			$set['mail_subject'] 		= ($this->input->post('inputSubjectOther'))?$this->input->post('inputSubjectOther'):'';
			$set['mail_body'] 			= addslashes($this->input->post('textMessage')); 
			$set['group_id'] 			= addslashes($this->input->post('selectGroup'));
			$set['subgroup_id'] 		= $this->input->post('selectSubGroup');
			$set['ipaddress'] 			= $_SERVER['REMOTE_ADDR'];
			$set['center_id'] 			= $this->mailcontent->get_centerid_by_avaya($this->input->post('inputAyava'));
			
			if( $this->db->insert('dbo.mail_contents', $set) ){
				$json['status'] = 1;
				$json['msg'] = "Send Successfully"; 	
			}else{
				
				$json['msg'] = "Sending/Saving Error"; 	
			}
			 
		}
		 
		echo json_encode($json); 
	} 
	
	function check_avaya_exist($str){
		$this->load->model('MailsContent_Model', 'mailcontent'); 
		
		
		if ( $this->mailcontent->get_centerid_by_avaya($str) > 0) { 
			return TRUE;
		}else{
			$this->form_validation->set_message('check_avaya_exist', 'The avaya is not valid');
			return FALSE;
		}		
	}
	
	public function test(){
	
		$this->load->view('test');
		 
	}
	
	public function phpinfo(){
		echo phpinfo();
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/client.php */