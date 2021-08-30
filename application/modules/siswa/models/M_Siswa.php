<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Siswa extends CI_Model
{
	public function countPinjam($where)
	{
		$this->db->where($where);
		return $this->db->get('peminjaman')->num_rows();
	}
	public function getPeminjaman($where)
	{
		$this->db->select('peminjaman.*, siswa.nisn, siswa.nama, siswa.kelas, buku.judul, buku.penerbit');
		$this->db->join('siswa', 'siswa.id = peminjaman.id_siswa', 'inner');
		$this->db->join('buku', 'buku.id = peminjaman.id_buku', 'inner');

		$this->db->where($where);

		$this->db->order_by('peminjaman.tanggal_pinjam', 'desc');
		return $this->db->get('peminjaman')->result();
	}
	public function getPengembalian($where)
	{
		$this->db->select('peminjaman.*, siswa.nisn, siswa.nama, siswa.kelas, buku.judul, buku.penerbit');
		$this->db->join('siswa', 'siswa.id = peminjaman.id_siswa', 'inner');
		$this->db->join('buku', 'buku.id = peminjaman.id_buku', 'inner');

		$this->db->where($where);

		$this->db->order_by('peminjaman.tanggal_pinjam', 'desc');
		return $this->db->get('peminjaman')->result();
	}
}

/* End of file M_Siswa.php */
