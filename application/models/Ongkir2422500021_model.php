<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ongkir2422500021_model extends CI_Model
{
    private $_table = 'ongkir2422500021';

    public function get_all()
    {
        return $this->db->get($this->_table)->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->affected_rows() === 1;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ['id_ongkir021' => $id])->row_array();
    }

    public function hapus($id)
    {
        $this->db->delete($this->_table, ['id_ongkir021' => $id]);
        return $this->db->affected_rows() === 1;
    }

    public function ubah($data, $id)
    {
        $this->db->where('id_ongkir021', $id);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows() === 1;
    }
}
