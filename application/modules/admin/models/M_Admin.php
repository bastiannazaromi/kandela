<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{
    public function countAdmin()
    {
        return $this->db->get('admin')->num_rows();
    }
    public function countSiswa()
    {
        return $this->db->get('siswa')->num_rows();
    }
    public function countBuku()
    {
        return $this->db->get('buku')->num_rows();
    }
    public function getPeminjaman()
    {
        $this->db->select('peminjaman.*, siswa.nisn, siswa.nama, siswa.kelas, buku.judul, buku.penerbit');
        $this->db->join('siswa', 'siswa.id = peminjaman.id_siswa', 'inner');
        $this->db->join('buku', 'buku.id = peminjaman.id_buku', 'inner');

        $this->db->order_by('peminjaman.tanggal_pinjam', 'desc');
        return $this->db->get('peminjaman')->result();
    }
    public function likeSiswa($like)
    {
        $this->db->select('id, nisn, nama, kelas');

        $this->db->group_start();
        $this->db->like('nama', $like, 'both');
        $this->db->or_like('nisn', $like, 'both');
        $this->db->group_end();

        $this->db->order_by('nisn', 'ASC');
        $this->db->limit(15);

        return $this->db->get('siswa')->result();
    }
    public function likeJudul($like)
    {
        $this->db->select('id, judul, stok');

        $this->db->group_start();
        $this->db->like('judul', $like, 'both');
        $this->db->group_end();

        $this->db->order_by('judul', 'ASC');
        $this->db->limit(15);

        return $this->db->get('buku')->result();
    }
    public function getPengembalian()
    {
        $this->db->select('peminjaman.*, siswa.nisn, siswa.nama, siswa.kelas, buku.judul, buku.penerbit');
        $this->db->join('siswa', 'siswa.id = peminjaman.id_siswa', 'inner');
        $this->db->join('buku', 'buku.id = peminjaman.id_buku', 'inner');

        $this->db->where([
            'peminjaman.status'              => 2,
            'peminjaman.tanggal_kembali !=' => null
        ]);

        $this->db->order_by('peminjaman.tanggal_pinjam', 'desc');
        return $this->db->get('peminjaman')->result();
    }
}

/* End of file M_Admin.php */