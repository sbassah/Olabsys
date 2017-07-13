<?php
class Giftcard extends CI_Model
{
	/*
	Determines if a given giftcard_id is an giftcard
	*/
	
       function get_lab($id)
	{
	
		$this->db->from('template');
		$this->db->where('id', $id);
				
	     $query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	
	
	
	function exists( $giftcard_id )
	{
		$this->db->from('giftcards');
		$this->db->where('giftcard_id',$giftcard_id);
		$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	/*
	Returns all the giftcards
	*/
	function get_all($limit=10000, $offset=0)
	{
		$this->db->from('template');
		$this->db->where('deleted',1);
		$this->db->order_by("name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	
	
	function pending_receipt($limit=10000, $offset=0)
	{
	$this->db->from('sales');
		$this->db->join('people','sales.customer_id=people.person_id');	
		$this->db->where('print_left >',0);
		$this->db->order_by("sales.sale_id", "asc");		
			return $this->db->get();
				
	
	}

	
	
	
	function count_all()
	{
		$this->db->from('template');
		$this->db->where('deleted',1);
		return $this->db->count_all_results();
	}

	function print_count_all()
	{
		$this->db->from('sales');
		$this->db->where('print_left >',0);
		return $this->db->count_all_results();
	}
	
	
	/*
	Gets information about a particular giftcard
	*/
	function get_info($giftcard_id)
	{
		$this->db->from('giftcards');
		$this->db->where('giftcard_id',$giftcard_id);
		$this->db->where('deleted',0);
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $giftcard_id is NOT an giftcard
			$giftcard_obj=new stdClass();

			//Get all the fields from giftcards table
			$fields = $this->db->list_fields('giftcards');

			foreach ($fields as $field)
			{
				$giftcard_obj->$field='';
			}

			return $giftcard_obj;
		}
	}
/**Receipt_Drop Down*/
	function get_dropdown_list()

{
$this->db->from('sales');
$this->db->where('printed',0);
$this->db->order_by('sale_id');
$result = $this->db->get();
  $return = array();

if($result->num_rows() > 0) {
foreach($result->result_array() as $row) {
$return[$row['sale_id']] = 'POS '.$row['sale_id'];
}
}
     return $return;

}



function get_customer_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('sales');
		$this->db->join('people','sales.customer_id=people.person_id');	
		$this->db->where("(receipt_id LIKE '%".$this->db->escape_like_str($search)."%')");
		$this->db->order_by("sales.sale_id", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$recconcat= $row->receipt_id .'~'.$row->first_name.'  '.$row->last_name;
			$suggestions[]= $recconcat .'|'.$row->first_name.'  '.$row->last_name.'  '.$row->receipt_id;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_secret($sale_id)
	{
		
		$this->db->from('sales');
		$this->db->join('people','sales.customer_id=people.person_id');	
		$this->db->where('sale_id', $sale_id);
			
		$query = $this->db->get();
		
			if($query->num_rows()==1)
		{
		$recconcat= $query->row()->receipt_id .'~'.$query->row()->first_name.'  '.$query->row()->last_name;
		return $recconcat;
			//return $query->row()->giftcard_id;
		}

		return false;
		
		

	}
	
	
	

	function is_valid_receipt_name($receipt_id, $firstname, $lastname)
	{
		$query = array();
	
		$this->db->from('sales');
		$this->db->join('people','sales.customer_id=people.person_id');	
		$this->db->where("(receipt_id LIKE '".$this->db->escape_like_str($receipt_id)."' ) and 
		(first_name LIKE '".$this->db->escape_like_str($firstname)."' ) and 
		(last_name LIKE '".$this->db->escape_like_str($lastname)."' )");
		$this->db->order_by("sales.sale_id", "asc");		
		
		//$by_name = $this->db->get();
		
		$query = $this->db->get();

		return ($query->num_rows()==1);

	}

	
	
	/*
	Get an giftcard id given an giftcard number
	*/
	function get_giftcard_id($giftcard_number)
	{
		$this->db->from('giftcards');
		$this->db->where('giftcard_number',$giftcard_number);
		$this->db->where('deleted',0);

		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->giftcard_id;
		}

		return false;
	}

	/*
	Gets information about multiple giftcards
	*/
	function get_multiple_info($giftcard_ids)
	{
		$this->db->from('giftcards');
		$this->db->where_in('giftcard_id',$giftcard_ids);
		$this->db->where('deleted',0);
		$this->db->order_by("giftcard_number", "asc");
		return $this->db->get();
	}

	/*
	Inserts or updates a giftcard
	*/
	// Insert json data into database
public function insert_json_in_db($json_data) 
{
 $this->db->set($json_data);
 
 $success = $this->db->insert('result_printing',$json_data);
return   $success;
	//$this->db->insert('result_printing');
		/**
		if ($this->db->affected_rows() > 0) {
		return true;
		} else {
			return false;
		}
		**/
			}
	
	
	function save(&$giftcard_data,$giftcard_id=false)
	{
		if (!$giftcard_id or !$this->exists($giftcard_id))
		{
			if($this->db->insert('result_printing',$giftcard_data))
			{
				
				return true;
			}
			return false;
		}

		$this->db->where('giftcard_id', $giftcard_id);
		return $this->db->update('giftcards',$giftcard_data);
	}

	/*
	Updates multiple giftcards at once
	*/
	function update_multiple($giftcard_data,$giftcard_ids)
	{
		$this->db->where_in('giftcard_id',$giftcard_ids);
		return $this->db->update('giftcards',$giftcard_data);
	}
	
	
 function update_sales($receipt_id) {
  $this->db->where('receipt_id',$receipt_id);
  $this->db->set('print_left', 'print_left-1', FALSE);
  $this->db->update('sales');
  
  return true;
}
	
	

	/*
	Deletes one giftcard
	*/
	function delete($giftcard_id)
	{
		$this->db->where('giftcard_id', $giftcard_id);
		return $this->db->update('giftcards', array('deleted' => 1));
	}

	/*
	Deletes a list of giftcards
	*/
	function delete_list($giftcard_ids)
	{
		$this->db->where_in('giftcard_id',$giftcard_ids);
		return $this->db->update('giftcards', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find giftcards
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('template');
		$this->db->where('deleted',1);
		$this->db->like('name', $search);
		
		$this->db->order_by("name", "asc");
		$by_number = $this->db->get();
		foreach($by_number->result() as $row)
		{
			$suggestions[]=$row->name;
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

	/*
	Preform a search on giftcards
	*/
	function search($search)
	{
		$this->db->from('template');
		$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'");
		$this->db->order_by("name", "asc");
		return $this->db->get();	
	}
	
	function searchpending($search)
	{
				
		$this->db->from('sales');
		$this->db->join('people','sales.customer_id=people.person_id');	
		$this->db->where("(receipt_id LIKE '%".$this->db->escape_like_str($search)."%') 
		and (print_left >0)");
		$this->db->order_by("sales.sale_id", "asc");		
		return $this->db->get();	
	}
		

	
		
		
	
	public function get_giftcard_value( $giftcard_number )
	{
		if ( !$this->exists( $this->get_giftcard_id($giftcard_number)))
			return 0;
		
		$this->db->from('giftcards');
		$this->db->where('giftcard_number',$giftcard_number);
		return $this->db->get()->row()->value;
	}
	
	function update_giftcard_value( $giftcard_number, $value )
	{
		$this->db->where('giftcard_number', $giftcard_number);
		$this->db->update('giftcards', array('value' => $value));
	}
}
?>
