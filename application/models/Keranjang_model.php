<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang_model extends CI_Model
{

    private $_table = "keranjang";

    public function get_all()
    {
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        // untuk check apakah berhasil atau tidak input data
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    public function getKeranjangByIdAndPelanggan($id_keranjang, $pelanggan_id)
    {
        $this->db->where('id_keranjang', $id_keranjang);
        $this->db->where('pelanggan_id', $pelanggan_id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_keranjang', $id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    public function get_by_pelanggan($pelanggan_id)
    {
        $this->db->where('pelanggan_id', $pelanggan_id);
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function ubah($data, $id)
    {
        $this->db->where('id_keranjang', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function hapus($id)
    {
        $this->db->delete($this->_table, array('id_keranjang' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}