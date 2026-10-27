<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir2422500021_controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('Ongkir2422500021_model', 'ongkir_model');
    }

    public function index() {
        $data['list_ongkir'] = $this->ongkir_model->get_all();
        $this->load->view('administrator/templates/header');
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/ongkir2422500021/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    public function tambah_ongkir()
    {
        $data['title'] = 'Tambah Ongkir';
        $this->form_validation->set_rules('nama_ekspedisi021', 'Nama Ekspedisi', 'required|max_length[11]');
        $this->form_validation->set_rules('jnis_layanan021', 'Jenis Layanan', 'required|max_length[30]');
        $this->form_validation->set_rules('tarif_per_kg021', 'Tarif per Kg', 'required|max_length[10]');
        $this->form_validation->set_rules('status021', 'Status', 'required|max_length[15]');

        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_ongkir();
        } else {
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/ongkir2422500021/tambah_ongkir');
            $this->load->view('administrator/templates/footer');
        }
    }

    private function __simpan_ongkir()
    {
        $data = [
            'nama_ekspedisi021' => trim($this->input->post('nama_ekspedisi021', TRUE)),
            'jnis_layanan021' => trim($this->input->post('jnis_layanan021', TRUE)),
            'tarif_per_kg021' => trim($this->input->post('tarif_per_kg021', TRUE)),
            'status021' => trim($this->input->post('status021', TRUE)),
        ];
        $simpan = $this->ongkir_model->tambah($data);
        $this->session->set_flashdata('message', $simpan ? 'Berhasil menambahkan ongkir!!' : 'Gagal menambahkan ongkir!!');
        redirect('admin/ongkir2422500021');
    }

    public function hapus_ongkir($id)
    {
        $ongkir = $this->ongkir_model->get_by_id($id);
        if ($ongkir) {
            $hapus = $this->ongkir_model->hapus($id);
            $pesan = $hapus ? 'Berhasil menghapus ongkir!!' : 'Gagal menghapus ongkir!!';
        } else {
            $pesan = 'Ongkir tidak ditemukan!!';
        }
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/ongkir2422500021');
    }

    public function ubah_ongkir($id)
    {
        $ongkir = $this->ongkir_model->get_by_id($id);
        if ($ongkir) {
            $this->form_validation->set_rules('nama_ekspedisi021', 'Nama Ekspedisi', 'required|max_length[11]');
            $this->form_validation->set_rules('jnis_layanan021', 'Jenis Layanan', 'required|max_length[30]');
            $this->form_validation->set_rules('tarif_per_kg021', 'Tarif per Kg', 'required|max_length[10]');
            $this->form_validation->set_rules('status021', 'Status', 'required|max_length[15]');

            if ($this->form_validation->run() !== FALSE) {
                $this->__ubah_ongkir($id);
            } else {
                $data['title'] = 'Ubah Ongkir';
                $data['ongkir'] = $ongkir;
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/ongkir2422500021/ubah_ongkir', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->session->set_flashdata('message', 'Ongkir tidak ditemukan!!');
            redirect('admin/ongkir2422500021');
        }
    }

    private function __ubah_ongkir($id)
    {
        $data = [
            'nama_ekspedisi021' => trim($this->input->post('nama_ekspedisi021', TRUE)),
            'jnis_layanan021' => trim($this->input->post('jnis_layanan021', TRUE)),
            'tarif_per_kg021' => trim($this->input->post('tarif_per_kg021', TRUE)),
            'status021' => trim($this->input->post('status021', TRUE)),
        ];
        $ubah = $this->ongkir_model->ubah($data, $id);
        $this->session->set_flashdata('message', $ubah ? 'Berhasil mengubah ongkir!!' : 'Gagal mengubah ongkir!!');
        redirect('admin/ongkir2422500021');
    }
}
