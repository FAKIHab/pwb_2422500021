<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
        $this->load->helper('form');
    }

    public function index()
    {
        $data['list_produk'] = $this->produk_model->get_all();
        $this->load->view('administrator/templates/header');
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/produk/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    public function tambah_produk()
    {
        $this->_validasi_produk();
        if ($this->form_validation->run()) {
            $id = $this->produk_model->tambah($this->_data_produk());
            if ($id) {
                $this->_simpan_gambar($id);
                $this->session->set_flashdata('message', '<div class="alert alert-success">Produk berhasil ditambahkan.</div>');
                redirect('admin/produk');
                return;
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Produk gagal ditambahkan.</div>');
        }

        $data['title'] = 'Tambah Produk';
        $data['list_kategori'] = $this->produk_kategori_model->get_all();
        $this->_render_form('administrator/produk/tambah_produk', $data);
    }

    public function ubah_produk($id)
    {
        $produk = $this->produk_model->get_by_id($id);
        if (!$produk) {
            show_404();
            return;
        }

        $this->_validasi_produk();
        if ($this->form_validation->run()) {
            if ($this->produk_model->ubah($this->_data_produk(), $id)) {
                $this->_simpan_gambar($id);
                $this->session->set_flashdata('message', '<div class="alert alert-success">Produk berhasil diubah.</div>');
                redirect('admin/produk');
                return;
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Produk gagal diubah.</div>');
        }

        $data['title'] = 'Ubah Produk';
        $data['produk'] = $produk;
        $data['list_kategori'] = $this->produk_kategori_model->get_all();
        $data['list_gambar'] = $this->produk_gambar_model->get_by_produk_id($id);
        $this->_render_form('administrator/produk/ubah_produk', $data);
    }

    public function hapus_produk($id)
    {
        $produk = $this->produk_model->get_by_id($id);
        if ($produk) {
            foreach ($this->produk_gambar_model->get_by_produk_id($id) as $gambar) {
                $path = FCPATH . 'uploads/produk/' . $gambar['nama_gambar'];
                if (is_file($path)) {
                    unlink($path);
                }
                $this->produk_gambar_model->hapus($gambar['id_gambar']);
            }
            $this->produk_model->hapus($id);
        }
        redirect('admin/produk');
    }

    public function hapus_gambar($gambar_id, $produk_id)
    {
        $gambar = $this->produk_gambar_model->get_by_id($gambar_id);
        if ($gambar && (int) $gambar['produk_id'] === (int) $produk_id) {
            $path = FCPATH . 'uploads/produk/' . $gambar['nama_gambar'];
            if (is_file($path)) {
                unlink($path);
            }
            $this->produk_gambar_model->hapus($gambar_id);
        }
        redirect('admin/produk/ubah/' . (int) $produk_id);
    }

    private function _validasi_produk()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama produk', 'required|max_length[100]');
        $this->form_validation->set_rules('kategori_produk', 'Kategori produk', 'required|integer');
        $this->form_validation->set_rules('harga_produk', 'Harga', 'required|integer');
        $this->form_validation->set_rules('stok_produk', 'Stok produk', 'required|integer');
    }

    private function _data_produk()
    {
        return array(
            'nama' => trim($this->input->post('nama_produk', TRUE)),
            'categori_id' => (int) $this->input->post('kategori_produk'),
            'harga' => (int) $this->input->post('harga_produk'),
            'stok' => (int) $this->input->post('stok_produk'),
            'deskripsi' => trim($this->input->post('deskripsi_produk', TRUE)),
        );
    }

    private function _simpan_gambar($produk_id)
    {
        if (empty($_FILES['gambar_produk']['name'][0])) {
            return;
        }

        $directory = FCPATH . 'uploads/produk/';
        if (!is_dir($directory)) {
            mkdir($directory, 0755, TRUE);
        }
        $files = $_FILES['gambar_produk'];
        $total = count($files['name']);
        for ($i = 0; $i < $total; $i++) {
            if (empty($files['name'][$i])) {
                continue;
            }
            $_FILES['produk_upload'] = array(
                'name' => $files['name'][$i], 'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            );
            $this->load->library('upload');
            $this->upload->initialize(array(
                'upload_path' => $directory,
                'allowed_types' => 'jpg|jpeg|png|gif|webp',
                'max_size' => 5120,
                'file_name' => 'produk-' . (int) $produk_id . '-' . time() . '-' . $i,
                'file_ext_tolower' => TRUE,
                'remove_spaces' => TRUE,
            ));
            if ($this->upload->do_upload('produk_upload')) {
                $uploaded = $this->upload->data();
                $this->produk_gambar_model->tambah(array(
                    'nama_gambar' => $uploaded['file_name'], 'produk_id' => $produk_id,
                ));
            }
        }
        unset($_FILES['produk_upload']);
    }

    private function _render_form($view, $data)
    {
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view($view, $data);
        $this->load->view('administrator/templates/footer');
    }
}
