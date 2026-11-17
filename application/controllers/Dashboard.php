<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function index() {
        $this->load->model('produk_model');
        $this->load->model('produk_gambar_model');

        $data['list_produk'] = $this->produk_model->get_all();
        $data['gambar_model'] = $this->produk_gambar_model;

        $this->load->view('ecom/template/header');
        $this->load->view('ecom/template/carausel');
        $this->load->view('ecom/home', $data);
        $this->load->view('ecom/template/footer');
    }
}
