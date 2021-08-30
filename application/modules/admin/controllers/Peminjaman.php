<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
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
			$buku = $this->universal->getOneSelect('stok', ['id' => dekrip($this->input->post('id_buku'))], 'buku');

			$jumlah = $this->input->post('jumlah');
			if ($buku) {
				if ($jumlah <= $buku->stok) {
					$stok = $buku->stok - $jumlah;
					$data = [
						"id_siswa"          	=> dekrip($this->input->post('id_siswa')),
						"id_buku"         	    => dekrip($this->input->post('id_buku')),
						"jumlah"             	=> $jumlah,
						"tanggal_pinjam"       	=> date('Y-m-d H:i:s'),
						"status"				=> 1
					];
					$insert = $this->universal->insert($data, 'peminjaman');
					if ($insert) {
						$updateBuku = [
							'stok'	=> $stok
						];
						$this->universal->update($updateBuku, ['id' => dekrip($this->input->post('id_buku'))], 'buku');
						$this->session->set_flashdata('notif-sukses', 'Data berhasil ditambahkan');
					} else {
						$this->session->set_flashdata('notif-error', 'Data gagal ditambahkan');
					}
				} else {
					$this->session->set_flashdata('notif-error', 'Jumlah yang dipinjam tidak boleh melebihi stok');
				}
			} else {
				$this->session->set_flashdata('notif-error', 'Judul buku tidak ditemukan');
			}

			redirect('admin/peminjaman');
		} else if ($this->u3 == 'edit') {
			$id_pinjam = dekrip($this->u4);

			$data_pinjam = $this->universal->getOne(['id' => $id_pinjam], 'peminjaman');

			$buku = $this->universal->getOne(['id' => $data_pinjam->id_buku], 'buku');

			$data = [
				'tanggal_kembali'	=> date('Y-m-d H:i:s'),
				'status'			=> 2
			];

			$dataBuku = [
				'stok'	=> $data_pinjam->jumlah + $buku->stok
			];

			$update = $this->universal->update($data, ['id' => $id_pinjam], 'peminjaman');
			if ($update) {
				$this->universal->update($dataBuku, ['id' => $data_pinjam->id_buku], 'buku');
				$this->session->set_flashdata('notif-sukses', 'Buku sudah dikembalikan');
			}

			redirect('admin/peminjaman');
		} elseif ($this->u3 == 'multiple_delete') {
			$id = $this->input->post('id');

			if (!$id) {
				$this->session->set_flashdata('notif-error', 'Silahkan pilih data yang akan dihapus');
				redirect('admin/peminjaman', 'resfresh');
			} else {
				foreach ($id as $id_new) {
					$data[] =
						dekrip($id_new);
				}
			}

			$this->db->where_in('id', $data);
			$this->db->delete('peminjaman');

			$this->session->set_flashdata('notif-sukses', 'Data berhasil dihapus');
			redirect('admin/peminjaman', 'resfresh');
		} elseif ($this->u3 == 'getSiswa') {
			$siswa = $this->admin->likeSiswa($this->input->get('q'));
			$data = [];
			foreach ($siswa as $hasil) {
				array_push($data, [
					"value"         => enkrip($hasil->id),
					"text"          => $hasil->nisn . ' - ' . $hasil->nama . ' ( Kelas : ' . $hasil->kelas . ' )'
				]);
			}

			$this->output->set_header('Content-Type: application/json');
			echo json_encode($data);
		} elseif ($this->u3 == 'getJudul') {
			$judul = $this->admin->likeJudul($this->input->get('q'));
			$data = [];
			foreach ($judul as $hasil) {
				array_push($data, [
					"value"         => enkrip($hasil->id),
					"text"          => $hasil->judul . ' - Stok : ' . $hasil->stok
				]);
			}

			$this->output->set_header('Content-Type: application/json');
			echo json_encode($data);
		} else {
			$data = [
				'title'     => 'Peminjaman',
				'page'      => 'peminjaman',
				'pinjam'	=> $this->admin->getPeminjaman()
			];

			$this->load->view('index', $data);
		}
	}
}

/* End of file Peminjaman.php */