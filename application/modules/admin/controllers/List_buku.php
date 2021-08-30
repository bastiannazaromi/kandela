<?php

defined('BASEPATH') or exit('No direct script access allowed');

class List_buku extends CI_Controller
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
				"judul"          		=> htmlspecialchars($this->input->post('judul')),
				"pengarang"             => htmlspecialchars($this->input->post('pengarang')),
				"penerbit"             	=> htmlspecialchars($this->input->post('penerbit')),
				"tahun"              	=> htmlspecialchars($this->input->post('tahun')),
				"jumlah"              	=> htmlspecialchars($this->input->post('jumlah')),
				"stok"              	=> htmlspecialchars($this->input->post('jumlah')),
				"keadaan"              	=> htmlspecialchars($this->input->post('keadaan'))
			];

			$insert = $this->universal->insert($data, 'buku');

			if ($insert) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil ditambahkan');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal ditambahkan');
			}
			redirect('admin/list_buku');
		} elseif ($this->u3 == 'edit') {
			$id = dekrip($this->input->post('id'));

			$data = [
				"judul"          		=> htmlspecialchars($this->input->post('judul')),
				"pengarang"             => htmlspecialchars($this->input->post('pengarang')),
				"penerbit"             	=> htmlspecialchars($this->input->post('penerbit')),
				"tahun"              	=> htmlspecialchars($this->input->post('tahun')),
				"jumlah"              	=> htmlspecialchars($this->input->post('jumlah')),
				"keadaan"              	=> htmlspecialchars($this->input->post('keadaan'))
			];

			$update = $this->universal->update($data, ['id' => $id], 'buku');

			if ($update) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil diupdate');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal diupdate');
			}
			redirect('admin/list_buku');
		} elseif ($this->u3 == 'multiple_delete') {
			$id = $this->input->post('id');

			if (!$id) {
				$this->session->set_flashdata('notif-error', 'Silahkan pilih data yang akan dihapus');
				redirect('admin/list_buku', 'resfresh');
			} else {
				foreach ($id as $id_new) {
					$data[] =
						dekrip($id_new);
				}
			}

			$this->db->where_in('id', $data);
			$this->db->delete('buku');

			$this->session->set_flashdata('notif-sukses', 'Data berhasil dihapus');
			redirect('admin/list_buku', 'resfresh');
		} else if ($this->u3 == 'getOne') {
			$id = dekrip($this->u4);

			$data = $this->universal->getOne(['id' => $id], 'buku');

			echo json_encode($data);
		} else if ($this->u3 == 'import') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			$config['upload_path']      = realpath('upload/excel');
			$config['allowed_types']    = 'xlsx|xls|csv';
			$config['max_size']         = '10000';
			$config['encrypt_name']     = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_excel')) {
				//upload gagal
				$this->session->set_flashdata('notif-error', str_replace("\r\n", "", strip_tags($this->upload->display_errors())));
				//redirect halaman

				redirect('admin/list_buku');
			} else {
				if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
					$upload_data = $this->upload->data();

					$arr_file = explode('.', $_FILES['file_excel']['name']);
					$extension = end($arr_file);
					if ('csv' == $extension) {
						$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					} else {
						$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					}
					$spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
					$sheetData = $spreadsheet->getActiveSheet()->toArray();
					echo "<pre>";
					$numrow = 1;
					$data = [];
					foreach ($sheetData as $hasil) {
						if ($numrow > 1) {
							if ($hasil[0] && $hasil[1]) {
								$cek = $this->universal->getOneSelect('judul', [
									'judul'       => $hasil[1],
									'penerbit'    => $hasil[3],
									'pengarang'   => $hasil[2],
									'tahun'       => $hasil[4]
								], 'buku');

								if (!$cek) {
									array_push($data, [
										"judul"          		=> $hasil[1],
										"pengarang"             => $hasil[2],
										"penerbit"             	=> $hasil[3],
										"tahun"              	=> $hasil[4],
										"jumlah"              	=> $hasil[5],
										"stok"              	=> $hasil[5],
										"keadaan"              	=> $hasil[6],
									]);
								}
							}
						}
						$numrow++;
					}
					//delete file from server
					unlink(FCPATH . 'upload/excel/' . $upload_data['file_name']);

					// echo json_encode($data);
					// die;
					if (count($data) != 0) {
						//$insert = $this->db->insert_batch('mahasiswa', $data);
						$insert = $this->universal->insert_batch($data, 'buku');
						if ($insert) {
							$this->session->set_flashdata('notif-sukses', 'Data berhasil diimport');
						} else {
							$this->session->set_flashdata('notif-sukses', 'Data gagal diimport');
						}
					} else {
						$this->session->set_flashdata('notif-sukses', 'Gagal import ! Data kosong / sudah ada dalam database');
					}
					//redirect halaman
					redirect('admin/list_buku');
				}
			}
		} else {
			$data = [
				'title'     => 'List Buku',
				'page'      => 'buku',
				'siswa'     => $this->universal->getOrderBy('', 'buku', 'penerbit, judul', 'asc', '')
			];

			$this->load->view('index', $data);
		}
	}
}

/* End of file List_buku.php */