<?php
require_once("report.php");
class Summary_payments extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
			return array('summary' => array( $this->lang->line('reports_Payment_ID'), $this->lang->line('reports_test_type'), $this->lang->line('reports_Employee_Name'), $this->lang->line('reports_Customer_Name'), $this->lang->line('reports_Pritning_Time')) , 
				'details' => array($this->lang->line('reports_name'))
			
			);
			
			

	}
	
	public function getData(array $inputs)
	{
		$this->db->select('id, receipt_id, test_type, customer_name, employee_name, printing_time');
		$this->db->from('result_printing');
		$this->db->where('printing_time BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->order_by('receipt_id');
		
		$data = array();
		$data['summary'] = $this->db->get()->result_array();
		$data['details'] = array();
		
		foreach($data['summary'] as $key=>$value)
		{
			$this->db->select('content');
			$this->db->from('result_printing');
			$this->db->where('id = '.$value['id']);
			
			$data['details'][$key] = $this->db->get()->result_array();
		}
		
		return $data;
	
	}
	
	public function getSummaryData(array $inputs)
	{
		$this->db->select('id, receipt_id ,test_type, customer_name, employee_name, printing_time', 'content');
		$this->db->from('result_printing');
		$this->db->where('printing_time BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->order_by('receipt_id');
		
		return $this->db->get()->row_array();
	}
}
?>