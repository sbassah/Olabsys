<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Item_kits extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('item_kits');
		$this->load->library('ckeditor');
		 $this->load->library('ckfinder');
 $this->ckeditor->basePath = base_url().'asset/ckeditor3/';
 $this->ckeditor->config['language'] = 'en';
 $this->ckeditor->config['width'] = '800px';
 $this->ckeditor->config['height'] = '950px'; 
 //Add Ckfinder to Ckeditor
 $this->ckfinder->SetupCKEditor($this->ckeditor,'../asset/ckfinder3/');
	}

	function index()
	{
		$config['base_url'] = site_url('/item_kits/index');
		$config['total_rows'] = $this->Giftcard->count_all();
			$config['per_page'] = '30';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_temp_manage_table1( $this->Giftcard->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this ); 
		$this->load->view('item_kits/manage',$data);
	}
	
	public function new_temp() {
	
	$this->load->view('item_kits/template');

	}
	
		public function edit_temp($temp_id) {

		$data['temp'] = $this->Giftcard->get_lab($temp_id);
		
	   $this->load->view('item_kits/template', $data);

	}
	
	
	// Fetch user data and convert data into json
public function temp_created() {

if (isset($_POST['temp_button']) and isset($_POST['post_id']))
{ 
	$data = array(
'name' => $this->input->post('test_name'),
'content' => $this->input->post('info'),
'deleted' => 1,
);

// Converting $data in json
$json_data['content'] = json_encode($data);

$temp_id = $this->input->post('temp_id');

if($temp_id == "")
{
	
// Send json encoded data to model
$return = $this->Item_kit->insert_json_in_db($data);
if ($return == true) {
//echo "<script>
	//alert('Test Template Created') </script>"; 
	} 
}

else{
// Send json encoded data to model
$return = $this->Item_kit->update_json_in_db($data, $temp_id );
if ($return == true) {
//echo "<script>
	//alert('Test Template Updated') </script>"; 
	} 
}



// Load view to show message

   $this->index();
}
	
}
	
function del_temp($view_url, $temp_id){

$return = $this->Item_kit->updated_temp_status($temp_id );
if ($return == true) {
echo "<script>
	alert('Template Deleted') </script>"; 
	} 

   $this->index();
}

	
	
	
	
	
	/*
	Returns supplier table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
			$data_rows=get_temp_manage_table_data_rows1($this->Giftcard->search($search),$this);
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
	
	
	/*

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_item_kits_manage_table_data_rows($this->Item_kit->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for

	function suggest()
	{
		$suggestions = $this->Item_kit->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
*/
	function get_row()
	{
		$item_kit_id = $this->input->post('row_id');
		$data_row=get_item_kit_data_row($this->Item_kit->get_info($item_kit_id),$this);
		echo $data_row;
	}

	function view($item_kit_id=-1)
	{
		$data['item_kit_info']=$this->Item_kit->get_info($item_kit_id);
		$this->load->view("item_kits/form",$data);
	}
	
	function save($item_kit_id=-1)
	{
		$item_kit_data = array(
		'name'=>$this->input->post('name'),
		'description'=>$this->input->post('description')
		);
		
		if($this->Item_kit->save($item_kit_data,$item_kit_id))
		{
			//New item kit
			if($item_kit_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('item_kits_successful_adding').' '.
				$item_kit_data['name'],'item_kit_id'=>$item_kit_data['item_kit_id']));
				$item_kit_id = $item_kit_data['item_kit_id'];
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('item_kits_successful_updating').' '.
				$item_kit_data['name'],'item_kit_id'=>$item_kit_id));
			}
			
			if ($this->input->post('item_kit_item'))
			{
				$item_kit_items = array();
				foreach($this->input->post('item_kit_item') as $item_id => $quantity)
				{
					$item_kit_items[] = array(
						'item_id' => $item_id,
						'quantity' => $quantity
						);
				}
			
				$this->Item_kit_items->save($item_kit_items, $item_kit_id);
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('item_kits_error_adding_updating').' '.
			$item_kit_data['name'],'item_kit_id'=>-1));
		}

	}
	
	function delete()
	{
		$item_kits_to_delete=$this->input->post('ids');

		if($this->Item_kit->delete_list($item_kits_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('item_kits_successful_deleted').' '.
			count($item_kits_to_delete).' '.$this->lang->line('item_kits_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('item_kits_cannot_be_deleted')));
		}
	}
	
	function generate_barcodes($item_kit_ids)
	{
		$result = array();

		$item_kit_ids = explode(':', $item_kit_ids);
		foreach ($item_kit_ids as $item_kid_id)
		{
			$item_kit_info = $this->Item_kit->get_info($item_kid_id);

			$result[] = array('name' =>$item_kit_info->name, 'id'=> 'KIT '.$item_kid_id);
		}

		$data['items'] = $result;
		$this->load->view("barcode_sheet", $data);
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