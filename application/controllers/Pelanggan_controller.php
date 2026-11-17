<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model', 'pelanggan_model');
    }

    public function login()
    {
        if ($this->session->has_userdata('pelanggan_login')) {
            redirect(base_url());
            return;
        }

        $this->form_validation->set_rules('email', 'Alamat Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ecom/template/header');
            $this->load->view('ecom/pelanggan_login');
            $this->load->view('ecom/template/footer');
        } else {
            $this->__login();
        }
    }

    private function __login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $check = $this->pelanggan_model->check_login($email, $password);

        if ($check) {
            $session_data = array(
                'id' => $check['id_pelanggan'],
                'email' => $check['email'],
                'nama' => $check['nama_pelanggan'],
                'pelanggan_login' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect(base_url());
        } else {
            $this->session->set_flashdata('message', 'Email atau password salah!');
            redirect('login');
        }
    }

    public function register()
    {
        if ($this->session->has_userdata('pelanggan_login')) {
            redirect(base_url());
            return;
        }

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nopon', 'No Telpon', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kota', 'Kota Tinggal', 'required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ecom/template/header');
            $this->load->view('ecom/pelanggan_register');
            $this->load->view('ecom/template/footer');
        } else {
            $this->__register();
        }
    }

    private function __register()
    {
        $email = $this->input->post('email');
        if (!$this->pelanggan_model->get_by_email($email)) {
            $data = array(
                'email' => $email,
                'password' => md5($this->input->post('password')),
                'nama_pelanggan' => ucwords($this->input->post('nama')),
                'telp_pelanggan' => $this->input->post('nopon'),
                'alamat' => ucwords($this->input->post('alamat')),
                'kota' => ucwords($this->input->post('kota')),
                'kode_pos' => $this->input->post('kodepos'),
                'provinsi' => ucwords($this->input->post('provinsi'))
            );

            if ($this->pelanggan_model->tambah($data)) {
                $this->session->set_flashdata('message', 'Berhasil register, silakan login!');
            } else {
                $this->session->set_flashdata('message', 'Gagal melakukan registrasi!');
            }
        } else {
            $this->session->set_flashdata('message', 'Email yang anda masukan sudah terdaftar!');
        }
        redirect('register');
    }

    public function logout()
    {
        $session_data = array('id', 'email', 'nama', 'pelanggan_login');
        $this->session->unset_userdata($session_data);
        redirect(base_url());
    }

    public function profil()
    {
        if (!$this->session->has_userdata('pelanggan_login')) {
            redirect('login');
            return;
        }

        $data['pelanggan'] = $this->pelanggan_model->get_by_id($this->session->userdata('id'));
        $this->load->view('ecom/template/header');
        $this->load->view('ecom/pelanggan_profil', $data);
        $this->load->view('ecom/template/footer');
    }
}
