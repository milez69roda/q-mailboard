<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	
	function get_group(){ 
		$this->db->select('id, group_name');		
		$this->db->where('group_active', 1);
		$this->db->order_by('group_name', 'asc');
		$result = $this->db->get('dbo.mail_group')->result_array();
		return $result;   
	}
	
	function get_subgroup(){
		  
		$this->db->select('id, group_id, subgroup_name');
		$this->db->where('subgroup_active', 1);
		$this->db->order_by('subgroup_name', 'asc');
		$result = $this->db->get('dbo.mail_sub_group')->result();
		$ar = array();
		foreach($result as $row){
			$ar[$row->group_id][$row->id] = $row->subgroup_name;
		}
		return $ar;   
	} 
	 
	  	
}

