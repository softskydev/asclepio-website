<?php

class My_query extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_query($query)
	{
		return $this->db->query($query);
	}

	public function insert_batch($tbl, $data)
	{
		$this->db->insert_batch($tbl, $data);
	}


	public function get_data($select = NULL, $from = NULL, $where = NULL, $join = NULL, $order = NULL, $or_where = NULL)
	{

		if ($select) {
			$this->db->select($select);
		}
		if ($from) {
			$this->db->from($from);
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($or_where) {
			for ($i = 0; $i < count($or_where); $i++) {
				$this->db->or_where($or_where[$i]['column'], $or_where[$i]['value']);
			}
		}

		if ($join) {
			$this->db->join($join['table'], $join['where'], $join['type']);
		}
		if ($order) {
			$this->db->order_by($order);
		}

		return $this->db->get();
	}

	function get_data_complex($select = NULL, $table = NULL, $limit = NULL, $like = NULL, $order = NULL, $join = NULL, $where = NULL, $group_by = NULL, $orderby = null, $or_where = null)
	{
		$this->db->select($select);
		$this->db->from($table);
		if ($join) {
			for ($i = 0; $i < sizeof($join['data']); $i++) {
				$this->db->join($join['data'][$i]['table'], $join['data'][$i]['join'], $join['data'][$i]['type']);
			}
		}
		if ($where) {
			for ($i = 0; $i < sizeof($where['data']); $i++) {
				$this->db->where($where['data'][$i]['column'], $where['data'][$i]['param']);
			}
		}

		if ($or_where) {
			for ($i = 0; $i < sizeof($or_where['data']); $i++) {
				$this->db->where($or_where['data'][$i]['column'], $or_where['data'][$i]['param']);
			}
		}


		// if ($where2) {
		//     $this->db->where($where2);
		// }
		if ($like) {
			for ($i = 0; $i < sizeof($like['data']); $i++) {
				$this->db->like('CONCAT_WS(" ", ' . $like['data'][$i]['column'] . ')', $like['data'][$i]['param']);
			}
		}
		if ($limit) {
			$this->db->limit($limit['finish'], $limit['start']);
		}
		if ($order) {
			for ($i = 0; $i < sizeof($order['data']); $i++) {
				$this->db->order_by($order['data'][$i]['column'], $order['data'][$i]['type']);
			}
		}
		if ($group_by) {
			$this->db->group_by($group_by);
		}

		if ($orderby) {
			$this->db->order_by($orderby);
		}

		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}



	function get_data_simple($table, $where = null)
	{
		if ($where) {
			$this->db->where($where);
		}
		$result 	=	$this->db->get($table);
		return $result;
	}

	function save_data($nama_table, $data)
	{
		$this->db->insert($nama_table, $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function update_data($nama_table, $where,  $data_update = '')
	{

		$this->db->where($where);
		$this->db->update($nama_table, $data_update);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function delete_data($nama_table, $where)
	{
		$this->db->delete($nama_table, $where);
		return true;
	}


	function insert_for_id($table, $where, $data)
	{
		if ($where) {
			$this->db->set($data);
			$this->db->where($where);
			$this->db->update($table);
		} else {
			$this->db->insert($table, $data);
		}
		$error = $this->db->error();
		$result = new stdclass();
		if ($this->db->affected_rows() > 0 or $error['code'] == 0) {
			$result->status = true;
			$result->output = $this->db->insert_id();
		} else {
			$result->status = false;
			// if($error['code'] <> 0)
			$result->output = $error['code'] . ': ' . $error['message'];
		}

		return $result;
	}
}
