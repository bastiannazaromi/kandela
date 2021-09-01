<?php

defined('BASEPATH') or exit('No direct script access allowed');

class List_siswa extends CI_Controller
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
				"nisn"          	=> htmlspecialchars($this->input->post('nisn')),
				"password"          => password_hash($this->input->post('nisn'), PASSWORD_BCRYPT),
				"nama"              => htmlspecialchars($this->input->post('nama')),
				"kelas"             => htmlspecialchars($this->input->post('kelas')),
				"jk"              	=> htmlspecialchars($this->input->post('jk'))
			];

			$insert = $this->universal->insert($data, 'siswa');

			if ($insert) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil ditambahkan');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal ditambahkan');
			}
			redirect('admin/list_siswa');
		} elseif ($this->u3 == 'edit') {
			$id = dekrip($this->input->post('id'));

			$data = [
				"nisn"          	=> htmlspecialchars($this->input->post('nisn')),
				"nama"              => htmlspecialchars($this->input->post('nama')),
				"kelas"             => htmlspecialchars($this->input->post('kelas')),
				"jk"              	=> htmlspecialchars($this->input->post('jk')),
				"status"	      	=> htmlspecialchars($this->input->post('status'))
			];

			$update = $this->universal->update($data, ['id' => $id], 'siswa');

			if ($update) {
				$this->session->set_flashdata('notif-sukses', 'Data berhasil diupdate');
			} else {
				$this->session->set_flashdata('notif-error', 'Data gagal diupdate');
			}
			redirect('admin/list_siswa');
		} elseif ($this->u3 == 'multiple_delete') {
			$id = $this->input->post('id');

			if (!$id) {
				$this->session->set_flashdata('notif-error', 'Silahkan pilih data yang akan dihapus');
				redirect('admin/list_siswa', 'resfresh');
			} else {
				foreach ($id as $id_new) {
					$data[] =
						dekrip($id_new);

					$cek = $this->universal->getOneSelect('foto', ['id' => dekrip($id_new)], 'siswa');

					if ($cek->foto != "default.jpg") {
						unlink(FCPATH . 'upload/profile/' . $cek->foto);
					}
				}
			}

			$this->db->where_in('id', $data);
			$this->db->delete('siswa');

			$this->session->set_flashdata('notif-sukses', 'Data berhasil dihapus');
			redirect('admin/list_siswa', 'resfresh');
		} else if ($this->u3 == 'getOne') {
			$id = dekrip($this->u4);

			$data = $this->universal->getOne(['id' => $id], 'siswa');

			echo json_encode($data);
		} else if ($this->u3 == 'resetPassword') {
			$id		= dekrip($this->u4);
			$nisn	= dekrip($this->u5);

			$data = [
				'password'	=> password_hash($nisn, PASSWORD_BCRYPT),
			];

			$update = $this->universal->update($data, ['id' => $id], 'siswa');

			if ($update) {
				$this->session->set_flashdata('notif-sukses', 'Password berhasil direset');
			} else {
				$this->session->set_flashdata('notif-error', 'Password gagal direset');
			}
			redirect('admin/list_siswa');
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

				redirect('admin/list_siswa');
			} else {
				if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
					$upload_data = $this->upload->data();

					echo 123;
					die;

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
								$cek = $this->universal->getOneSelect('nama', [
									'nama'       => $hasil[1],
									'nisn'       => $hasil[3]
								], 'siswa');

								echo json_encode($cek);
								die;

								if (!$cek) {
									array_push($data, [
										"nisn"          	=> str_replace('\'', '', $hasil[3]),
										"password"          => password_hash(str_replace('\'', '', $hasil[3]), PASSWORD_BCRYPT),
										"nama"              => $hasil[1],
										"kelas"             => $hasil[2],
										"jk"              	=> $hasil[4]
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
						$insert = $this->universal->insert_batch($data, 'siswa');
						if ($insert) {
							$this->session->set_flashdata('notif-sukses', 'Data berhasil diimport');
						} else {
							$this->session->set_flashdata('notif-sukses', 'Data gagal diimport');
						}
					} else {
						$this->session->set_flashdata('notif-sukses', 'Gagal import ! Data kosong / sudah ada dalam database');
					}
					//redirect halaman
					redirect('admin/list_siswa');
				}
			}
		} else {
			$data = [
				'title'     => 'List Siswa',
				'page'      => 'siswa',
				'siswa'     => $this->universal->getOrderBy('', 'siswa', 'kelas, nama', 'asc', '')
			];

			$this->load->view('index', $data);
		}
	}
}

/* End of file List_siswa.php */