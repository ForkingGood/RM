<?php
class Feedback_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_all($where = array(), $limit = null, $offset = null)
	{
		$this->load->database();
		$this->db->order_by('dateCreated desc');
		$query = $this->db->get_where('feedback', $where, $limit, $offset);
		return $query->result();
	}
	function get($id) {
		$this->load->database();
		$query = $this->db->get_where('feedback', array('id' => $id));
		return $query->result()[0];
	}

	function insert($object)
	{
		$this->load->database();
		$this->db->insert('feedback', $object); 
		return $this->db->insert_id();
	}

	function edit($id, $object)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->update('feedback', $object);
	}

	function delete($id)
	{
		$this->load->database();
		$this->db->delete('feedback', array('id' => $id));
	}
}
?>