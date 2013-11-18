<?php
class TShirt_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_all($where = array(), $limit = null, $offset = null)
	{
		$this->load->database();
		$this->db->order_by('dateCreated desc');
		$query = $this->db->get_where('tshirt', $where, $limit, $offset);
		return $query->result();
	}
	function get($id) {
		$this->load->database();
		$query = $this->db->get_where('tshirt', array('id' => $id));
		return $query->result()[0];
	}

	function insert($object)
	{
		$this->load->database();
		$this->db->insert('tshirt', $object); 
		return $this->db->insert_id();
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
		unlink('/asset/uploads/T-shirts/'.$this->get($id)->imgPath);
		$this->db->delete('tshirt', array('id' => $id));
	}
}
?>