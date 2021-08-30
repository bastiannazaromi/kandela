<?php

function enkrip($string)
{
	$bumbu = md5(str_replace("=", "", base64_encode("kandala.com")));
	$katakata = false;
	$metodeenkrip = "AES-256-CBC";
	$kunci = hash('sha256', $bumbu);
	$kodeiv = substr(hash('sha256', $bumbu), 0, 16);

	$katakata = str_replace("=", "", openssl_encrypt($string, $metodeenkrip, $kunci, 0, $kodeiv));
	$katakata = str_replace("=", "", base64_encode($katakata));

	return $katakata;
}

function dekrip($string)
{
	$bumbu = md5(str_replace("=", "", base64_encode("kandala.com")));
	$katakata = false;
	$metodeenkrip = "AES-256-CBC";
	$kunci = hash('sha256', $bumbu);
	$kodeiv = substr(hash('sha256', $bumbu), 0, 16);

	$katakata = openssl_decrypt(base64_decode($string), $metodeenkrip, $kunci, 0, $kodeiv);
	return $katakata;
}

function bulan()
{
	$bulan = Date('m');
	switch ($bulan) {
		case 1:
			$bulan = "Januari";
			break;
		case 2:
			$bulan = "Februari";
			break;
		case 3:
			$bulan = "Maret";
			break;
		case 4:
			$bulan = "April";
			break;
		case 5:
			$bulan = "Mei";
			break;
		case 6:
			$bulan = "Juni";
			break;
		case 7:
			$bulan = "Juli";
			break;
		case 8:
			$bulan = "Agustus";
			break;
		case 9:
			$bulan = "September";
			break;
		case 10:
			$bulan = "Oktober";
			break;
		case 11:
			$bulan = "November";
			break;
		case 12:
			$bulan = "Desember";
			break;

		default:
			$bulan = Date('F');
			break;
	}
	return $bulan;
}


function tanggal_indo()
{
	$tanggal = Date('d') . " " . bulan() . " " . Date('Y');
	return $tanggal;
}

function kategori_soal($id_kat)
{
	$CI = &get_instance();

	$CI->db->select('nama');
	$CI->db->where('id', $id_kat);

	$data = $CI->db->get('kategori_soal')->row();
	return $data->nama;
}
