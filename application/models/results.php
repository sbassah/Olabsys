<?php
class Results extends CI_Model
{
	/*
	Determines if a given giftcard_id is an giftcard
	*/
	   function get_lab()
	{
		$this->db->from('template');
		$this->db->where('name',"lab");
		return $this->db->get();
	}
	
	
	
	/*
	Returns all the giftcards
	*/
	function get_all($limit=10000, $offset=0)
	{
		$this->db->from('giftcards');
		$this->db->where('deleted',0);
		$this->db->order_by("giftcard_number", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
}
	
?>
