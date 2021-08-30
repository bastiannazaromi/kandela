<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('log_admin'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('admin');
            }
        } else if (!empty($this->session->userdata('log_siswa'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('siswa');
            }
        }

        $this->load->model('M_Login', 'login');
    }

    public function index()
    {
        $data['title'] = 'Halaman Login';
        $this->load->view('index', $data);
    }

    public function proses()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('notif-error', validation_errors());
            redirect('login');
        } else {
            $username = $this->input->post("username");
            $password = $this->input->post("password");

            $data = $this->login->cek($username, $password);

            if ($data == 'Admin') {
                $this->session->set_flashdata('notif-sukses', 'Berhasil login');
                redirect('admin');
            } else if ($data == 'Siswa') {
                $this->session->set_flashdata('notif-sukses', 'Berhasil login');
                redirect('siswa');
            } else {
                $this->session->set_flashdata('notif-error', $data);
                redirect('login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }
}

/* End of file Login.php */