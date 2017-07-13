<?php
require_once ("secure_area.php");
class Config extends Secure_area 
{
	function __construct()
	{
		parent::__construct('config');
	}
	
	function index()
	{
		$this->load->view("config");
	}
		
	function save()
	{
		$batch_save_data=array(
		'company'=>$this->input->post('company'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email'),
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),		
		'default_tax_1_name'=>$this->input->post('default_tax_1_name'),		
		'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),	
		'default_tax_2_name'=>$this->input->post('default_tax_2_name'),		
		'currency_symbol'=>$this->input->post('currency_symbol'),
		'receipt_code'=>$this->input->post('receipt_code'),
		'language'=>$this->input->post('language'),
		'timezone'=>$this->input->post('timezone'),
		'print_after_sale'=>$this->input->post('print_after_sale')	
		);
		
		if($_SERVER['HTTP_HOST'] !='ospos.pappastech.com' && $this->Appconfig->batch_save($batch_save_data))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('config_saved_successfully')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('config_saved_unsuccessfully')));
	
		}
	}
	
	 function backup_db()
    {
    	$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
    	if($this->Employee->has_permission('config',$employee_id))
    	{
    		$this->load->dbutil();
    		$prefs = array(
				'format'      => 'zip',
				'filename'    => 'ospos.sql'
    		);
    		 
    		$backup =& $this->dbutil->backup($prefs);
    		 
			$file_name = 'ospos-' . date("Y-m-d-H-i-s") .'.zip';
    		$save = 'uploads/'.$file_name;
    		$this->load->helper('download');
    		while (ob_get_level()) {
    			ob_end_clean();
    		}
    		force_download($file_name, $backup);
    	}
    	else 
    	{
    		redirect('no_access/config');
    	}
    }
	
}
?>