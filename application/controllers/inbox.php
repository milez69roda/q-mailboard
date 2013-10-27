<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inbox extends My_Controller {

	public function __construct(){
		parent::__construct(); 
		
		//print_r($this->my_inbox);
	}	
	
	public function index(){
	
		$this->load->view('inbox/header');
		$this->load->view('inbox/sidebar');
		$this->load->view('inbox/content_default');
		$this->load->view('inbox/footer');   
	}
	
	public function categorytpl(){ 
		echo $this->load->view('inbox/content_default_mail','', true);  
	}
	 
	public function init_js_var(){ 
		//$data['group']		= $this->groups->get_group();			
		$data['subgroup']	= $this->groups->get_subgroup();			 
		echo json_encode($data);		
	}
	 
	public function markread($off=true){
		
		$json = array('status'=>0, 'msg'=>'failed'); 
		
		if( $this->content->markread($this->input->post('x')) ){
			$json['status'] = 1;
			$json['msg'] = 'success';
		} 
		
		if( $off )
			echo json_encode($json);
	}
	
	public function get_mail_content(){
		$this->markread(false);		
		$data = '';	 
		
		$id = $this->input->post('x');
		$query = "SELECT
		dbo.mail_contents.*,
		dbo.center.centername
		FROM dbo.mail_contents
		LEFT OUTER JOIN dbo.center ON dbo.center.centerid = dbo.mail_contents.center_id
		WHERE dbo.mail_contents.id = $id ";	
		//echo $query;
		$data['row'] = $this->db->query($query)->row();
		echo $this->load->view('inbox/content_mail_view', $data, true);		
	}
	
	public function send(){		
		$json = array('status'=>false, 'msg'=>'');
		
		$type = $this->input->post('h_mail_option');
		
		$orig_group_id = $this->input->post('h_mail_g');
		$orig_subgroup_id = $this->input->post('h_mail_sg');
		
		$id = $this->input->post('h_mail_id');
		$center_id = $this->input->post('h_mail_centerid');
		$center_name = $this->input->post('h_mail_centername');
		
		$question = $this->input->post('txt_mail_body');
		$answer = $this->input->post('txt_mail_answer');
		 
		$to_group_id = @$this->input->post('selectGroup');
		$to_subgroup_id = @$this->input->post('selectSubGroup');		 
		 
		$sendtocenter = isset($_POST['sendtocenter'])?1:0;
		
		switch( $type ){
			case 'reply': // send answer to the center
				 
				$this->content->sendMail('','','');
				break;
			case 'forward':
				
				$set['mail_read'] 			= 0;
				$set['updated_date'] 		= date('Y-m-d H:i:s');
				$set['group_id'] 			= $to_group_id;
				$set['subgroup_id'] 		= $to_subgroup_id;
				$set['forward_from_gid'] 	= $orig_group_id;
				$set['forward_from_sgid'] 	= $orig_subgroup_id;
				$set['forward_by'] 			= $this->user_id;
				$set['forward_date'] 		= date('Y-m-d H:i:s'); 
				
				$this->db->where('id', $id); 
				
				if( $this->db->update('dbo.mail_contents', $set, false) ){ 
					$json['status'] = true;
					$json['msg'] 	= 'Successfully Forwarded';
					
					$logtxt = array('from_g'=>$orig_group_id,
						  'from_sg'=>$orig_subgroup_id,	
						  'to_g'=>$to_group_id,	
						  'to_sg'=>$to_subgroup_id,	
					);
					$this->content->log('forward', $id, $this->user_id, json_encode($logtxt));
				}
				break;
			case 'post':
				//update mail_contents
				$set['updated_date']	= date('Y-m-d H:i:s'); 
				$set['mail_status']		= $this->config->item('inbox_mail_status_post'); 							
				$set['mail_answer_by']	= $this->user_id;		
				$set['mail_answer_date']=  date('Y-m-d H:i:s');	 
				$this->db->where('id', $id);
				$this->db->update('dbo.mail_contents', $set);
				 
				//insert to the faq table
				$faq['ref_id'] 			= $id;
				$faq['group_id'] 		= $orig_group_id; 
				$faq['question'] 		= addslashes($question);
				$faq['answer'] 			= addslashes($answer); 
				$faq['posted_by'] 		= $this->user_fullname; 
				$faq['posted_by_id'] 	= $this->user_id;
				$faq['updated_date']	= date('Y-m-d H:i:s'); 
				 
				if( $this->db->insert('dbo.faq',$faq) ) {
					
					//log
					$logtxt = array('faq_id'=>$this->db->insert_id());
					$this->content->log('post', $id, $this->user_id, json_encode($logtxt));	 
					
					$json['status'] = true;
					$json['msg'] 	= 'Successfully Posted to FAQ';	 
				} 
				
				
				if( $sendtocenter ){
					$this->content->sendMail('','','');
					$json['msg'] .= '<br />An email was sent also to the center';
				}
 				
				break;
			
		}
		
		echo json_encode($json);
	}
	
	public function category_ajax_list(){
		
		$aColumns = array('id', 'mail_from_firstname','centername', 'mail_body', 'updated_date' );
		
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
		
		/* DB table to use */
		$sTable = "dbo.mail_contents";
		$sJoin = "LEFT OUTER JOIN dbo.center ON center.centerid = mail_contents.center_id";
		/* 
		 * Paging
		 */
		$sLimit = "";
		/* if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "BETWEEN ".( $_GET['iDisplayStart'] )." AND ".( $_GET['iDisplayLength'] );
		} */
		
		if( $_GET['iDisplayStart'] == 0 ){		
			$sLimit = "BETWEEN ".( $_GET['iDisplayStart'] )." AND ".( $_GET['iDisplayStart']+$_GET['iDisplayLength'] );
		}else{
			$sLimit = "BETWEEN ".( $_GET['iDisplayStart']+1 )." AND ".( $_GET['iDisplayStart']+$_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		 
		if ( isset( $_GET['iSortCol_0'] ) ) {
			
			$sOrder = "ORDER BY  ";  
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
			 
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { 
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ". $_GET['sSortDir_'.$i] .", "; 
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = " ORDER BY  created_date ASC";
			}
			
			$sOrder = " ( ".$sOrder." ) ";
		} 
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		
		$sWhere = "WHERE ";
		
		$sWhere .= " mail_status = 0 AND group_id = {$_GET['gidx']} AND subgroup_id = {$_GET['gidy']} "	;
		
		if ( $_GET['sSearch'] != "" ){
			
			$sWhere .= " AND (";	
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				
				//if( $aColumns[$i] != '' )
					$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
			
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')'; 
		} 
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}else { 
					$sWhere .= " AND";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
			}
		} 
		 
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		 //CONVERT(VARCHAR(19),created_date) as created_date,
		$sQuery =  "WITH CTE AS (
						SELECT 
							id,
							avaya, 
							mail_body, 
							mail_subject,
							mail_from_firstname,
							mail_from_lastname,
							mail_read,
							group_id,
							CONVERT(VARCHAR(19),updated_date) as updated_date,
							centername,
							ROW_NUMBER() OVER $sOrder AS  row_number
						FROM $sTable
						$sJoin
						$sWhere
					)
					SELECT * FROM CTE WHERE row_number $sLimit ";
	 
		//echo $sQuery;
		$rResult = $this->db->query($sQuery); 
		
		//echo $this->db->last_query();
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
		SELECT COUNT(".$sIndexColumn.") as numrow
		FROM   $sTable
		$sJoin
		$sWhere
		";
		 
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		 
		/*
		 * Output
		 */
		$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		//"iTotalDisplayRecords" => $iFilteredTotal,
		"iTotalDisplayRecords" => $iTotal,
		"aaData" => array()
		);
		
		//while ( $aRow = mysql_fetch_array( $rResult ) ){
		
		$rResult = $rResult->result();
		 
		foreach( $rResult as $row ){
			
			  
			$rows = array();
			
			$rows['DT_RowId'] = 'm_r_id_'.$row->id;  
			$rows['DT_RowClass'] = ($row->mail_read)?'':'mail_unread';  
			
			$rows[] = '<input type="checkbox" name="m_r_check" id="m_r_check_'.$row->id.'" class="m_r_check_c" value="'.$row->id.'" />';
			$rows[] = '<a href="javascript:void(0)" onclick="app.openMail('.$row->group_id.','.$row->id.')">'.$row->mail_from_firstname.' '.$row->mail_from_lastname.' #'.$row->avaya.'</a>';
			$rows[] = $row->centername;
			$rows[] =   character_limiter($row->mail_body, 20);
			$rows[] = $row->updated_date;
	   
			
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );			
		
	}
	
	public function rebuild_sidebar(){
		
		$data['gid'] = $this->input->post('gid');
		echo $this->load->view('inbox/sidebar', $data, true);
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */