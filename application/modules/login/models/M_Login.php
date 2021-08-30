<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Login extends CI_Model
{

	function cek($u, $p)
	{
		$this->db->where('username', $u);
		$query = $this->db->get('admin');
		$data = $query->result();

		if (count($data) === 1) {
			if (password_verify($p, $data[0]->password)) {
				$login		=	array(
					'is_logged_in'	=> true,
					'username'	    => $u,
					'id'			=> $data[0]->id,
					'nama'			=> $data[0]->nama,
					'role'			=> 'admin'
				);
				if ($login) {
					$this->session->set_userdata('log_admin', $login);
					$this->session->set_userdata($login);
					return 'Admin';
				}
			} else {
				return 'Password Salah';
			}
		} else {
			$this->db->where('nisn', $u);
			$query = $this->db->get('siswa');
			$data = $query->result();

			if (count($data) === 1) {
				if (password_verify($p, $data[0]->password)) {
					$login		=	array(
						'is_logged_in'	=> true,
						'username'	    => $u,
						'id'			=> $data[0]->id,
						'nama'			=> $data[0]->nama,
						'role'			=> 'siswa'
					);
					if ($login) {
						$this->session->set_userdata('log_siswa', $login);
						$this->session->set_userdata($login);
						return 'Siswa';
					}
				} else {
					return 'Password Salah';
				}
			} else {
				return 'Username tidak terdaftar';
			}
		}
	}
}

/* End of file M_Login.php */