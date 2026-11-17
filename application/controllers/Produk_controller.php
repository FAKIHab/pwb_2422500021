<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
    }

    public function detail($id = 0)
    {
        if ($id == 0) {
            redirect('/');
            die;
        }

        $produk = $this->produk_model->get_by_id($id);
        if (!$produk) {
            redirect('/');
            die;
        }

        $data['produk'] = $produk;
        $data['list_gambar'] = $this->produk_gambar_model->get_by_produk_id($id);
        $data['kategori'] = $this->produk_kategori_model->get_by_id($produk['categori_id']);

        $this->load->view('ecom/template/header');
        $this->load->view('ecom/produk_detail', $data);
        $this->load->view('ecom/template/footer');
    }
}
