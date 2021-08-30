<?php

defined('BASEPATH') or exit('No direct script access allowed');

class List_admin extends CI_Controller
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
		if ($this->u3 == 'tambah') {
			$data = [
				"username"          => htmlspecialchars($this->input->post('username')),
				"password"          => password_hash('admin', PASSWORD_BCRYPT),
				"nama"              => htmlspecialchars($this->input->post('nama')),
				"foto"              => 'default.jpg'
			];

			$insert = $this->universal->insert($data, 'admin');

			if ($insert) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil ditambahkan');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal ditambahkan');
			}
			redirect('admin/list_admin');
		} elseif ($this->u3 == 'edit') {
			$id = dekrip($this->input->post('id'));

			$data = [
				"username"          => htmlspecialchars($this->input->post('username')),
				"nama"              => htmlspecialchars($this->input->post('nama')),
				"foto"              => 'default.jpg'
			];

			$update = $this->universal->update($data, ['id' => $id], 'admin');

			if ($update) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil diupdate');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal diupdate');
			}
			redirect('admin/list_admin');
		} elseif ($this->u3 == 'multiple_delete') {
			$id = $this->input->post('id');

			if (!$id) {
				$this->session->set_flashdata('notif-error', 'Silahkan pilih data yang akan dihapus');
				redirect('admin/list_admin', 'resfresh');
			} else {
				foreach ($id as $id_new) {
					$data[] =
						dekrip($id_new);

					$cek = $this->universal->getOneSelect('foto', ['id' => dekrip($id_new)], 'admin');

					if ($cek->foto != "default.jpg") {
						unlink(FCPATH . 'upload/profile/' . $cek->foto);
					}
				}
			}

			$this->db->where_in('id', $data);
			$this->db->delete('admin');

			$this->session->set_flashdata('notif-sukses', 'Data berhasil dihapus');
			redirect('admin/list_admin', 'resfresh');
		} else if ($this->u3 == 'resetPassword') {
			$id		= dekrip($this->u4);

			$data = [
				'password'	=> password_hash('admin', PASSWORD_BCRYPT),
			];

			$update = $this->universal->update($data, ['id' => $id], 'admin');

			if ($update) {
				$this->session->set_flashdata('notif-sukses', 'Password berhasil direset');
			} else {
				$this->session->set_flashdata('notif-error', 'Password gagal direset');
			}
			redirect('admin/list_admin');
		} else {
			$data = [
				'title'     => 'List Admin',
				'page'      => 'admin',
				'admin'     => $this->universal->getMulti('', 'admin')
			];

			$this->load->view('index', $data);
		}
	}
}

/* End of file List_admin.php */