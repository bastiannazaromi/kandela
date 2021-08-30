<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_admin'))) {
            $this->session->set_flashdata('notif-error', 'Anda Belum Login');
            redirect('login', 'refresh');
        }

        $this->u2        = $this->uri->segment(2);
        $this->u3        = $this->uri->segment(3);
        $this->u4        = $this->uri->segment(4);
        $this->u5        = $this->uri->segment(5);
        $this->u6        = $this->uri->segment(6);
        $this->u7        = $this->uri->segment(7);
        $this->u8        = $this->uri->segment(8);
        $this->u9        = $this->uri->segment(9);

        $this->load->model('M_Admin', 'admin');
        $this->load->model('Universal_model', 'universal');

        $this->db->where('id', $this->session->userdata('log_admin')['id']);
        $this->data = $this->db->get('admin')->row();
    }

    public function index()
    {
        if ($this->u2 == 'profile') {
            $data = [
                'title'     => 'Profile Admin',
                'page'      => 'profile'
            ];

            $this->load->view('index', $data);
        } elseif ($this->u2 == 'updateFoto') {
            $id = dekrip($this->input->post('id'));

            $config['upload_path']          = 'upload/profile';
            $config['allowed_types']        = 'png|jpg|jpeg';
            $config['max_size']             = 2048; // 2 mb
            $config['remove_spaces']        = TRUE;
            $config['file_name']            = date('d-m-Y') . '_' . $_FILES["foto_profil"]['name'];;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto_profil')) {

                $data = [
                    "username"  => str_replace(' ', '', $this->input->post('username')),
                    "nama"      => $this->input->post('nama')
                ];

                $update = $this->universal->update($data, ['id' => $id], 'admin');
                if ($update) {
                    $this->session->set_flashdata('notif-sukses', 'Profil berhasil diupdate');
                }

                redirect('admin/profile', 'refresh');
            } else {
                $upload_data = $this->upload->data();

                $admin = $this->universal->getOne(['id' => $id], 'admin');
                $data = [
                    "username"  => str_replace(' ', '', $this->input->post('username')),
                    "nama"      => $this->input->post('nama'),
                    "foto"      => $upload_data['file_name']
                ];

                if ($admin->foto != "default.jpg") {
                    unlink(FCPATH . 'upload/profile/' . $admin->foto);
                }

                $this->universal->update($data, ['id' => $id], 'admin');

                $this->session->set_flashdata('notif-sukses', 'Profil berhasil diupdate');

                redirect('admin/profile', 'refresh');
            }
        } elseif ($this->u2 == 'updatePass') {
            $this->form_validation->set_rules('pas_lama', 'Password Baru', 'required', [
                'required' => 'Password lama harap di isi !'
            ]);
            $this->form_validation->set_rules('pas_baru', 'Password Baru', 'required|trim|min_length[5]', [
                'required' => 'Password baru harap di isi !',
                'min_length' => 'Password kurang dari 5'
            ]);
            $this->form_validation->set_rules('pas_konfir', 'Password Konfirmasi', 'required|trim|min_length[5]|matches[pas_baru]', [
                'required' => 'Password konfirmasi harap di isi !',
                'matches' => 'Password konfirmasi salah !',
                'min_length' => 'Password kurang dari 5'
            ]);

            if ($this->form_validation->run() == false) {
                $data = [
                    'title' => 'Profil Admin',
                    'page'  => 'profile'
                ];

                $this->load->view('index', $data);
            } else {
                $id = dekrip($this->input->post('id'));
                $admin = $this->universal->getOne(['id' => $id], 'admin');

                $pas_lama = $this->input->post('pas_lama', TRUE);
                $pas_baru = $this->input->post('pas_baru', TRUE);

                if (password_verify($pas_lama, $admin->password)) {
                    $data = [
                        "password" =>  password_hash($pas_baru, PASSWORD_BCRYPT)
                    ];

                    $this->universal->update($data, ['id' => $id], 'admin');

                    $this->session->set_flashdata('notif-sukses', 'Password berhasil diupdate');

                    redirect('admin/profile', 'refresh');
                } else {
                    $this->session->set_flashdata('notif-error', 'Password lama salah');

                    redirect('admin/profile', 'refresh');
                }
            }
        } else {
            $data = [
                'title'         => 'Dashboard Admin',
                'page'          => 'dashboard',
                'd_admin'       => $this->admin->countAdmin(),
                'siswa'         => $this->admin->countSiswa(),
                'buku'          => $this->admin->countBuku()
            ];

            $this->load->view('index', $data);
        }
    }
}

/* End of file Admin.php */