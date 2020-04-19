<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_pegawai');
		$this->load->model('M_posisi');
		$this->load->model('M_kota');
		$this->load->model('M_Siswa');
	}

	public function index() {
		$data['jml_pegawai'] 	= $this->M_pegawai->total_rows();
		$data['jml_siswa'] 	= $this->M_Siswa->total_siswa();
		$data['jml_posisi'] 	= $this->M_posisi->total_rows();
		$data['jml_kota'] 		= $this->M_kota->total_rows();
		$data['userdata'] 		= $this->userdata;
		$data['jml_ditunggu']= $this->M_Siswa->total_siswa_ditunggu();

		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
		
		$posisi 				= $this->M_posisi->select_all();
		$index = 0;
		foreach ($posisi as $value) {
		    $color = '#' .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)];

			$pegawai_by_posisi = $this->M_pegawai->select_by_posisi($value->id);

			$data_posisi[$index]['value'] = $pegawai_by_posisi->jml;
			$data_posisi[$index]['color'] = $color;
			$data_posisi[$index]['highlight'] = $color;
			$data_posisi[$index]['label'] = $value->nama;
			
			$index++;
		}

		$kota 				= $this->M_kota->select_all();
		$index = 0;
		foreach ($kota as $value) {
		    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

			$pegawai_by_kota = $this->M_pegawai->select_by_kota($value->id);
			// var_dump($pegawai_by_kota);
			// die;

			$data_kota[$index]['value'] = $pegawai_by_kota->jml;
			$data_kota[$index]['color'] = $color;
			$data_kota[$index]['highlight'] = $color;
			$data_kota[$index]['label'] = $value->nama;
			
			$index++;
		}

		$status 				= $this->M_Siswa->select_all();
		$index = 0;
		$stat="";
		foreach ($status as $value) {
			if ($value->status==1) {
				$stat= "lulus";
			}
			else if ($value->status == 0) {
				$stat = "gagal";
			} else if ($value->status == 3){
				$stat = "Belum di pilih";
			}
			$color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
			// var_dump($value->status);die;

			$pegawai_by_kota = $this->M_Siswa->select_by_status($value->status);
			// var_dump($pegawai_by_kota);die;

			$data_status[$index]['value'] = $pegawai_by_kota->jml;
			$data_status[$index]['color'] = $color;
			$data_status[$index]['highlight'] = $color;
			$data_status[$index]['label'] = $stat;

			$index++;
		}


		$data['data_posisi'] = json_encode($data_posisi);
		$data['data_kota'] = json_encode($data_kota);
		$data['data_status'] = json_encode($data_status);
		// $data['data_tunggu'] = json_encode($data_tunggu);

		$data['page'] 			= "home";
		$data['judul'] 			= "Beranda";
		$data['deskripsi'] 		= "Manage Data CRUD";
		$this->template->views('home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */