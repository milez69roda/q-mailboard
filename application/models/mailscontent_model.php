<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MailsContent_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	  
	/*
	*@desc GET center_id for an avaya
	&@param avaya_id
	*@return center_id
	*/
	function get_centerid_by_avaya($avaya_id){
		 
		$this->db->where(" $avaya_id BETWEEN avaya_start AND avaya_end ");
		$query = $this->db->get('avaya_range_extension');
		 
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->center_id;
		}else
			return 0;
		 
	}

	/*
	* return total unread
	&@param  
	*@return group_id, subgroup_id, total unread
	*/	
	function get_number_subgroup(){
	
		$sql = "SELECT 
				dbo.mail_contents.group_id, 
				dbo.mail_contents.subgroup_id, 
				SUM( CASE dbo.mail_contents.mail_read WHEN 0 THEN 1 ELSE 0 END ) AS total_unread,
				COUNT(id) AS total
			FROM dbo.mail_contents 
			WHERE dbo.mail_contents.mail_status = 0
			GROUP BY
				dbo.mail_contents.group_id, 
				dbo.mail_contents.subgroup_id";
				
		$query = $this->db->query($sql)->result();
		$return = array();
		foreach( $query as $row  ){
			$return[$row->group_id][$row->subgroup_id]['unread'] = $row->total_unread;
			$return[$row->group_id][$row->subgroup_id]['total'] = $row->total;
		}
		
		return $return;
	}
	
	
	function markread($id){
		$this->db->set('mail_read', 1);
		$this->db->where('id', $id, false);
		return $this->db->update('dbo.mail_contents');
	}
	
	function get_center_info(){
		
		
	}
	
	function log($operation, $id, $user_id, $logtxt){
		
		$set['mail_contents_id'] 	= $id;
		$set['operation_type'] 		= $operation;
		$set['user_id'] 			= $user_id;
		$set['logtxt']				= $logtxt;
		 
		$this->db->insert('dbo.mail_history', $set);
	}
	
	function sendMail($to, $headers, $from){
	
		/* $this->load->library('email');
		
		$this->email->from('your@example.com', 'Your Name');
		$this->email->to('someone@example.com');
		$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		
		$this->email->send();
		
		echo $this->email->print_debugger();	 */
		
		return true;
	}
	
}

