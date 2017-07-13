<?php
require_once("report.php");
class Inventory_summary extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_test_type'), $this->lang->line('reports_Payment_ID'), $this->lang->line('reports_Employee_Name'), $this->lang->line('reports_Customer_Name'), $this->lang->line('reports_Pritning_Time'));
	}
	
	public function getData(array $inputs)
	{
		$this->db->select('test_type, receipt_id, customer_name, employee_name, printing_time');
		$this->db->from('result_printing');
			
		$this->db->order_by('test_type');
		
		return $this->db->get()->result_array();

	}
	
	public function getSummaryData(array $inputs)
	{
		return array();
	}
}
?>