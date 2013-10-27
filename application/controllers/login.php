<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}	
	
	public function index(){
		$this->load->view('login') ;  
	}
	
	public function check(){
	
		$json = array('status'=>0, 'msg'=>'Username or Password is Incorrect');
		
		$username = strtolower($this->input->post('txtUsername'));
		$password = strtolower($this->input->post('txtpassword'));
		
		$query = $this->db->get_where('dbo.mail_users', array('username'=>$username ));
		  
		if($query->num_rows() > 0){
		
			$row = $query->row();
			//echo  strtolower($row->userpass).'  '.$password;
			if( strtolower(trim($row->userpass)) == $password ){
				$set = array(
						'm_USERID'=>$row->id,
						'm_USERNAME'=>$username, 
						'm_FULLNAME'=>$row->user_fullname,
						''=>$row->email_address,
						'm_INBOX'=>explode(',', $row->inbox_access),
						'm_ISLOGIN'=>1
					);
					
				$this->session->set_userdata($set);
				
				$json['status'] = 1;
				$json['msg'] = 'Successfully Login';
				$json['redirect'] =  base_url()."inbox";
			}
		}

		echo json_encode($json);		
	}
	
	public function logout(){
		
		$this->session->sess_destroy();
		
		redirect(base_url());
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */