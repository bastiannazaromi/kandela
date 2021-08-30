<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian extends CI_Controller
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
		$data = [
			'title'     => 'Pengembalian',
			'page'      => 'pengembalian',
			'kembali'	=> $this->admin->getPengembalian()
		];

		$this->load->view('index', $data);
	}
}

/* End of file Pengembalian.php */