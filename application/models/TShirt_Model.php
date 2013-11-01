<?php
class TShirt_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_all()
	{
		$this->load->database();
		$this->db->order_by('dateCreated asc');
		$query = $this->db->get('tshirt');
		return $query->result();
	}

	function insert($object)
	{
		$this->load->database();
		$this->db->insert('tshirt', $object); 

	}

	function edit($id, $object)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->update('tshirt', $object);
	}

	function delete($id)
	{
		$this->load->database();
		$this->db->delete('tshirt', array('id' => $id));
	}
}
?>