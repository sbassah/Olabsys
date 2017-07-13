	<?php
	require_once ("secure_area.php");
	require_once ("interfaces/idata_controller.php");
	class Giftcards extends Secure_area implements iData_controller
	{
var $CI;

  
	
	


	function __construct()
		{
			parent::__construct('giftcards');
			$this->load->library('ckeditor');
	 $this->load->library('ckfinder');
	 $this->ckeditor->basePath = base_url().'asset/ckeditor/';
	 $this->ckeditor->config['language'] = 'en';
	 $this->ckeditor->config['width'] = '800px';
	 $this->ckeditor->config['height'] = '950px'; 
	 //Add Ckfinder to Ckeditor
	 $this->ckfinder->SetupCKEditor($this->ckeditor,'../asset/ckfinder/');
	 $this->load->library('session');
		}
		

		function index()
		{
		$config['base_url'] = site_url('/giftcards/index');
		$config['total_rows'] = $this->Giftcard->print_count_all();
		$config['per_page'] = '30';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
			
			$data['controller_name']=strtolower(get_class());
			$data['secretword']= $this->session->userdata('secretword');
			$data['form_width']=$this->get_form_width(); 
			$data['manage_table']=get_pending_manage_table( $this->Giftcard->pending_receipt( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
			$this->load->view('giftcards/pending',$data);
		
		
		
	//	$this->load->view("giftcards/listing",array());	
		}
		
		
		
		

		function template_select($nav,$sale_id)
		{
		    $secretpass = $this->Giftcard->get_secret($sale_id);
			
			$this->session->unset_userdata('secretword');
			$this->session->unset_userdata('receiptstat');	
			$this->session->set_userdata('secretword', $secretpass);
			$this->session->set_userdata('receiptstat', "true");
			
			$config['base_url'] = site_url('/giftcards/template_select_paged');
			$config['total_rows'] = $this->Giftcard->count_all();
			$config['per_page'] = '30';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
			$data['comb_value'] = $secretpass;
			$data['controller_name']=strtolower(get_class());
			$data['secretword']= $this->session->userdata('secretword');
			$data['form_width']=$this->get_form_width(); 
			$data['manage_table']=get_temp_manage_table( $this->Giftcard->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
			$this->load->view('giftcards/manage',$data);

		}
		
		
		function template_select_paged()
		{
			$config['base_url'] = site_url('/giftcards/template_select_paged');
			$config['total_rows'] = $this->Giftcard->count_all();
			$config['per_page'] = '30';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
			$data['comb_value'] = $secretpass;
			$data['controller_name']=strtolower(get_class());
			$data['secretword']= $this->session->userdata('secretword');
			$data['form_width']=$this->get_form_width(); 
			$data['manage_table']=get_temp_manage_table( $this->Giftcard->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
			$this->load->view('giftcards/manage',$data);
		}
		
		
		
		
		
		function lab_result($result_id)
		{
		//$this->session->set_userdata('secretword', "Testing");
		$data['temp'] = $this->Giftcard->get_lab($result_id);
		$data['sales_id'] = $this->Giftcard->get_dropdown_list();
		
		$data['secretword']= $this->session->userdata('secretword');
		$data['receiptstat']= $this->session->userdata('receiptstat');	
		
		$this->load->view("giftcards/lab_report",$data);  
		
		
		}
		
		// Fetch user data and convert data into json
		public function data_submitted() {
		
		$input_variable = $this->input->post('receipt_details');
			$str_explode = explode("~", $input_variable);
			$receipt_id = $str_explode[0]; 
			$cust_name = $str_explode[1]; 
			
			if (isset($_POST['btnprintsave'])) {
		
			$data = array(
			'name' => $this->input->post('test_name'),
			'content' => $this->input->post('info'),
			);

			// Converting $data in json
			$json_data['content'] = json_encode($data);


	// Send json encoded data to model
	$return = $this->Item_kit->insert_json_in_db($data);
		
		} 
		
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
			$emp_info=$this->Employee->get_info($employee_id);

			// Store user submitted data in array
			
			
	$data = array(
	'test_type' => $this->input->post('type'),
	'receipt_id' => $receipt_id,
	'customer_name' => $cust_name,
	'employee_name'=>$emp_info->first_name.' '.$emp_info->last_name,
	'printing_time' => date('Y-m-d H:i:s'),
	'content' => $this->input->post('info'),
	);

	// Converting $data in json
	$json_data['content'] = json_encode($data);


	// Send json encoded data to model
	$return = $this->Giftcard->insert_json_in_db($data);
	if ($return == true) {
	$data['result_msg'] = 'Json data successfully inserted into database !';


	} else {
	$data['result_msg'] = 'Please configure your database correctly';

	}
			$this->session->unset_userdata('secretword');
			$this->session->unset_userdata('receiptstat');
	$sales_id= $this->input->post('receipt_no');
	$return = $this->Giftcard->update_sales($receipt_id);

     
	// Load view to show message
	$this->load->view("home");
}
		
		
		function customer_search()
		{
			$suggestions = $this->Giftcard->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
			echo implode("\n",$suggestions);
		}

		function receipt_select()
		{
	
			
			$input_variable = $this->input->post('receipt_no');
			$temp_content = $this->input->post('info');
			$temp_title = $this->input->post('type');
			$str_explode = explode("~", $input_variable);
			$receipt_id = $str_explode[0]; 
			$cust_name = $str_explode[1]; 
			$str_nameexplode = explode("  ", $cust_name);
			$firstname = $str_nameexplode[0]; 
			$lastname = $str_nameexplode[1]; 
			$isValidReceipt = $this->Giftcard->is_valid_receipt_name($receipt_id, $firstname, $lastname);
				if($isValidReceipt==1)
					{
				$this->session->unset_userdata('secretword');
				$this->session->unset_userdata('receiptstat');
						$data['customer_name'] = $cust_name;
						$data['receipt_id'] = $receipt_id;
						$data['comb_value'] = $input_variable;
						$data['temp_title'] = $temp_title;
						$data['temp_content'] = $temp_content;
					$this->session->set_userdata('secretword', $input_variable);
					$this->session->set_userdata('receiptstat', "true");
						//$this->CI->session->set_userdata
						$config['base_url'] = site_url('/giftcards/index');
			$config['total_rows'] = $this->Giftcard->count_all();
			$config['per_page'] = '30';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
			
			$data['controller_name']=strtolower(get_class());
			$data['form_width']=$this->get_form_width(); 
			$data['manage_table']=get_temp_manage_table( $this->Giftcard->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
					
				}
				else{
				
			}	
			$this->load->view('giftcards/manage',$data);
				
		}
		

		
		
		

		function search()
		{
			$search=$this->input->post('search');
			$data_rows=get_temp_manage_table_data_rows($this->Giftcard->search($search),$this);
			echo $data_rows;
		}

		function searchpending()
		{
			$search=$this->input->post('search');
			$data_rows=get_pending_manage_table_data_rows($this->Giftcard->searchpending($search),$this);
			echo $data_rows;
			
		}
		
		
		/*
		Gives search suggestions based on what is being searched for
		*/
		function suggest()
		{
			$suggestions = $this->Giftcard->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
			echo implode("\n",$suggestions);
		}

		function get_row()
		{
			$giftcard_id = $this->input->post('row_id');
			$data_row=get_giftcard_data_row($this->Giftcard->get_info($giftcard_id),$this);
			echo $data_row;
		}

		function view($giftcard_id=-1)
		{
			$data['giftcard_info']=$this->Giftcard->get_info($giftcard_id);

			$this->load->view("giftcards/form",$data);
		}
		
		function save($giftcard_id=-1)
		{  
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
			$emp_info=$this->Employee->get_info($employee_id);
			
			$giftcard_data = array(
			'test_type'=>'scan',
			'receipt_no'=>$this->input->post('receipt_no'),
			'cust_name'=>$this->input->post('cust_name'),
			'employee_name'=>$emp_info->first_name.' '.$emp_info->last_name,
			'print_time' => date('Y-m-d H:i:s')
			
			);
			
			
			if( $this->Giftcard->save($giftcard_data) )
			{
			
					echo json_encode(array('success'=>true,'message'=>$this->lang->line('giftcards_successful_adding')));

				echo "<script>
	alert('There are no fields to generate a report');
	window.location.href='localhost';
	</script>";
			}
			else//failure
			{
				echo json_encode(array('success'=>false,'message'=>$this->lang->line('giftcards_error_adding_updating')));
			}

		}

		function delete()
		{
			$giftcards_to_delete=$this->input->post('ids');

			if($this->Giftcard->delete_list($giftcards_to_delete))
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('giftcards_successful_deleted').' '.
				count($giftcards_to_delete).' '.$this->lang->line('giftcards_one_or_multiple')));
			}
			else
			{
				echo json_encode(array('success'=>false,'message'=>$this->lang->line('giftcards_cannot_be_deleted')));
			}
		}
			
		/*
		get the width for the add/edit form
		*/
		function get_form_width()
		{
			return 360;
		}
	}
	?>