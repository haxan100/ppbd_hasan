<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_pegawai');
        $this->load->model('M_posisi');
        $this->load->model('M_kota');
        $this->load->model('M_Siswa');
        // $this->load->model('AuthModel');
        // $this->load->model('BidModel');
        // $this->load->model('ProdukModel');
        // $this->load->model('UserModel');
        // $this->load->library('image_lib');
        // $this->load->library('pdf');
    }
    public function bizDecrypt($enc)
    {
        $dec64 = base64_decode($enc);
        $substr1 = substr($dec64, 12, strlen($dec64) - 12);
        $substr2 = substr($substr1, 0, strlen($substr1) - 6);
        $dec = base64_decode(base64_decode($substr2));
        return $dec;
    }

    public function getAllSiswa()
    {
        // if (!$this->isLoggedInAdmin()) {
        //     echo '403 Forbidden!';
        //     exit();
        // }
        $dt = $this->M_Siswa->dt_siswa($_POST);
        $datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
        $datatable['recordsTotal']    = $dt['totalData'];
        $datatable['recordsFiltered'] = $dt['totalData'];
        $datatable['data']            = array();
            $status='';
        $start  = isset($_POST['start']) ? $_POST['start'] : 0;
        $no = $start + 1;
        foreach ($dt['data']->result() as $row) {
            // var_dump($row);die;

            if($row->status==1){
                $status= 'Di Terima';
            } else  if ($row->status == 0) {
                $status = 'Di Tolak';
            } else  {
                $status = 'Di Tunggu / Belum Ada Aksi';
            }

            $fields = array($no++);
            $fields[] = $row->nama_siswa;
            $fields[] = $row->nisn;
            $fields[] = $row->nohp;
            $fields[] = $status;
            // $fields[] = $row->status;
            // $fields[] = $row->id_admin;
            $fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
                    data-id_siswa="' . $row->id_siswa . '"
                    data-nisn="' . $row->nisn . '"
                    data-nama_siswa="' . $row->nama_siswa . '"
                    data-sekolah_asal="' . $row->sekolah_asal . '"
                    data-jenis_sekolah_awal="' . $row->jenis_sekolah_awal . '"
                    data-alamat="' . $row->alamat . '"	data-role-nohp="' . $row->nohp . '"
                    data-nama_ibu="' . $row->nama_ibu . '"
                    data-nama_ayah="' . $row->nama_ayah . '"
                    data-status="' . $row->status . '"  
                    data-tanggal_lahir="' . $row->tanggal_lahir . '"
                    data-tempat_lahir="' . $row->tempat_lahir . '"
                    data-nohp="' . $row->nohp . '"
                    data-id_kelas="' . $row->id_kelas . '">
                    <i class="far fa-edit"></i> Ubah</button>

        <button class="btn btn-danger my-1 btnHapus text-white" 
          
                    data-id_siswa="' . $row->id_siswa . '" 
                    data-nama_siswa="' . $row->nama_siswa . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

            $datatable['data'][] = $fields;
        }
        echo json_encode($datatable);
        exit();
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataPegawai'] = $this->M_pegawai->select_all();
        $data['dataPosisi'] = $this->M_posisi->select_all();
        $data['dataKota'] = $this->M_kota->select_all();
        $data['listKelas'] = $this->M_Siswa->getAllKelas();
        $data['page'] = "siswa";
        $data['judul'] = "Data Siswa";
        $data['deskripsi'] = "Manage Data Siswa";
        $data['ci'] = $this;
        $data['modal_tambah_pegawai'] = show_my_modal('modals/modal_tambah_pegawai', 'tambah-pegawai', $data);

        $this->template->views('siswa/home', $data);
    }
    public function kelas()
    {
        $data['userdata'] = $this->userdata;
        $data['dataPegawai'] = $this->M_pegawai->select_all();
        $data['dataPosisi'] = $this->M_posisi->select_all();
        $data['dataKota'] = $this->M_kota->select_all();

        $data['page'] = "kelas";
        $data['judul'] = "Data Siswa";
        $data['deskripsi'] = "Manage Data Siswa";
        $data['ci'] = $this;
        $data['modal_tambah_pegawai'] = show_my_modal('modals/modal_tambah_pegawai', 'tambah-pegawai', $data);

        $this->template->views('kelas/kelas', $data);
    }

    public function tambah_siswa()
    {

        $nama = $this->input->post('nama', TRUE);
        $nisn = $this->input->post('nisn', TRUE);
        $jenis_sekolah = $this->input->post('jenis_sekolah', TRUE);

        $sekolah_asal = $this->input->post('sekolah_asal', TRUE);
        $alamat = $this->input->post('alamat', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $nama_ibu = $this->input->post('nama_ibu', TRUE);
        $nama_ayah = $this->input->post('nama_ayah', TRUE);
        $status = $this->input->post('status', TRUE);

        $tempat_lahir = $this->input->post('tempat_lahir', TRUE);
        $tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
        $kelas = $this->input->post('kelas', TRUE);
        $register_at = date('YmdHis');
     
        // var_dump($nama);die;

        $message = 'Gagal menambahkan Siswa Baru!<br>Silahkan lengkapi data yang diperlukan.';
        $errorInputs = array();
        $status = true;

        $in = array(
            'nisn' => $nisn,
            'nama_siswa' => $nama,
            // 'password' =>   $this->bizEncrypt($password),
            'jenis_sekolah_awal' => $jenis_sekolah,
            'sekolah_asal' => $sekolah_asal,
            'alamat' => $alamat,
            'nohp' => $no_hp,
            'nama_ibu' => $nama_ibu,
            'nama_ayah' => $nama_ayah,
            'status' => $status,
            'tanggal_lahir' => $tanggal_lahir,
            'tempat_lahir' => $tempat_lahir,
            'id_kelas' => $kelas,
            'register_at' => $register_at,
            // 'status' => $status,
        );
        // var_dump($in);die();   

        $cek = $this->M_Siswa->cari_nisn($nisn);

        if ($cek >= 1) {
            $status = false;
            $errorInputs[] = array('#nama', 'NISN Sudah Ada!');
        }
              // var_dump($in);die();
        if ($status) {
            if ($this->M_Siswa->tambah_siswa($in)) {
                // $id_admin = $this->AdminModel->get_last_id()->last_id;


                $message = 'Berhasil  ';
                }  else {
            $message = 'Username Sudah Ada! ';
        }

        echo json_encode(array(
            'status' => $status,
            'message' => $message,
            'errorInputs' => $errorInputs
        ));
    }

    }

    public function edit_siswa()
    {
        $id_siswa = $this->input->post('id_siswa', TRUE);
        $nama_siswa = $this->input->post('nama_siswa', TRUE);
        $nisn = $this->input->post('nisn', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $status = $this->input->post('status', TRUE);
        $sekolah_asal = $this->input->post('sekolah_asal', TRUE);

        $jenis_sekolah = $this->input->post('jenis_sekolah', TRUE);
        $alamat = $this->input->post('alamat', TRUE);
        $nama_ibu = $this->input->post('nama_ibu', TRUE);
        $nama_ayah = $this->input->post('nama_ayah', TRUE);

        $tempat_lahir = $this->input->post('tempat_lahir', TRUE);
        $tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
        $kelas = $this->input->post('kelas', TRUE);
        $now = date('YmdHis');
        //  var_dump($now);die;

        // var_dump($pil_banks);die();
        $message = 'Gagal menambahkan Produk Baru!<br>Silahkan lengkapi data yang diperlukan.';
        $errorInputs = array();
        $statusnya = true;

        $inUser = array(
            'status' => $status,
            'nama_siswa' => $nama_siswa,
            'nisn' => $nisn,
            'nohp' => $no_hp,
            'jenis_sekolah_awal' => $jenis_sekolah,
            'sekolah_asal' => $sekolah_asal,
            'alamat' => $alamat,
            'nama_ibu' => $nama_ibu,
            'nama_ayah' => $nama_ayah,
            'status' => $status,

            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'id_kelas' => $kelas,
            'update_at' => $now,
        );
       
        // var_dump($cek);die;

        if ($statusnya) {
            if ($this->M_Siswa->update_profile_siswa($inUser, $id_siswa))




            $message = 'Berhasil Mengubah User Siswa ';
        } else {
            $message = 'Gagal ';
        }
        echo json_encode(array(
            'status' => $statusnya,
            'message' => $message,
            'errorInputs' => $errorInputs
        ));
        // var_dump($status);
        // die();

    }

        public function hapus_siswa()
    {
        $id = $_POST['id_siswa'];
        // var_dump($id);die;
        $result = $this->M_Siswa->delete_siswa($id);

        if ($result) {
            echo show_succ_msg('Data Pegawai Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Pegawai Gagal dihapus', '20px');
        }
    }
    public function getAllKelas()
    {
        // if (!$this->isLoggedInAdmin()) {
        //     echo '403 Forbidden!';
        //     exit();
        // }
        $dt = $this->M_Siswa->dt_class($_POST);
        $datatable['draw']            = isset($_POST['draw']) ? $_POST['draw'] : 1;
        $datatable['recordsTotal']    = $dt['totalData'];
        $datatable['recordsFiltered'] = $dt['totalData'];
        $datatable['data']            = array();
        $status = '';
        $start  = isset($_POST['start']) ? $_POST['start'] : 0;
        $no = $start + 1;
        foreach ($dt['data']->result() as $row) {
            // var_dump($row);die;



            $fields = array($no++);
            $fields[] = $row->nama_class;
            // $fields[] = $row->status;
            // $fields[] = $row->id_admin;
            $fields[] = '
        <button class="btn btn-warning my-1 btnEditAdmin  text-white" 
                    data-id_class="' . $row->id_class . '"
                    data-nama_kelas="' . $row->nama_class . '">
                    <i class="far fa-edit"></i> Ubah</button>

        <button class="btn btn-danger my-1 btnHapus text-white" 
          
                    data-id_class="' . $row->id_class . '" 
                    data-nama_class="' . $row->nama_class . '"
        ><i class="fas fa-trash"></i> Hapus</button>
        ';

            $datatable['data'][] = $fields;
        }
        echo json_encode($datatable);
        exit();
    }

    public function tambah_kelas()
    {

        $nama_kelas = $this->input->post('nama', TRUE);

        // var_dump($nama_kelas);die;

        $message = 'Gagal menambahkan Kelas Baru!<br>Silahkan lengkapi data yang diperlukan.';
        $errorInputs = array();
        $status = true;

        $in = array(
            'nama_class' => $nama_kelas,
            // 'status' => $status,
        );
        // var_dump($in);die();   

        $cek = $this->M_Siswa->cari_kelas($nama_kelas);
        // var_dump($cek);die();   

        if ($cek >= 1) {
            $status = false;
            $errorInputs[] = array('#nama_kelas', 'Kelas Sudah Ada!');
            // alert('data sudah ada');
        }
        // var_dump($in);die();
        if ($status) {
            if ($this->M_Siswa->tambah_kelas($in)) {
                // $id_admin = $this->AdminModel->get_last_id()->last_id;

                $message = 'Berhasil Menambahkan Kelas ';
            } else {
                $message = 'Username Sudah Ada! ';
            }

            echo json_encode(array(
                'status' => $status,
                'message' => $message,
                'errorInputs' => $errorInputs
            ));
        }
    }

    public function edit_kelas()
    {
        $id_kelas = $this->input->post('id_kelas', TRUE);
        $nama_kelas = $this->input->post('nama_kelas', TRUE);
        $now = date('YmdHis');
        //  var_dump($now);die;

        // var_dump($pil_banks);die();
        $message = 'Gagal menambahkan Kelas Baru!<br>Silahkan lengkapi data yang diperlukan.';
        $errorInputs = array();
        $statusnya = true;

        $inUser = array(
            'id_class' => $id_kelas,
            'nama_class' => $nama_kelas,
        );

        // var_dump($cek);die;

        if ($statusnya) {
            if ($this->M_Siswa->update_kelas($inUser, $id_kelas))




                $message = 'Berhasil Mengubah User Siswa ';
        } else {
            $message = 'Gagal ';
        }
        echo json_encode(array(
            'status' => $statusnya,
            'message' => $message,
            'errorInputs' => $errorInputs
        ));
        // var_dump($status);
        // die();

    }


    public function hapus_kelas()
    {
        $id = $_POST['id_class'];
        $result = $this->M_Siswa->delete_kelas($id);
        // var_dump($result);die;  

        if ($result) {
            echo show_succ_msg('Data Kelas Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Kelas Gagal dihapus', '20px');
        }
    }












//lama baru














    public function tampil()
    {
        $data['dataPegawai'] = $this->M_pegawai->select_all();
        // var_dump($data);die;
        $this->load->view('pegawai/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'trim|required');

        $data = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_pegawai->insert($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Pegawai Berhasil ditambahkan', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Pegawai Gagal ditambahkan', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function update()
    {
        $id = trim($_POST['id']);

        $data['dataPegawai'] = $this->M_pegawai->select_by_id($id);
        $data['dataPosisi'] = $this->M_posisi->select_all();
        $data['dataKota'] = $this->M_kota->select_all();
        $data['userdata'] = $this->userdata;

        echo show_my_modal('modals/modal_update_pegawai', 'update-pegawai', $data);
    }

    public function prosesUpdate()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'trim|required');

        $data = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_pegawai->update($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Pegawai Berhasil diupdate', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Pegawai Gagal diupdate', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function delete()
    {
        $id = $_POST['id'];
        $result = $this->M_pegawai->delete($id);

        if ($result > 0) {
            echo show_succ_msg('Data Pegawai Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Pegawai Gagal dihapus', '20px');
        }
    }

    public function export()
    {
        error_reporting(E_ALL);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->M_pegawai->select_all_pegawai();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "ID");
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Nama");
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "Nomor Telepon");
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "ID Kota");
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "ID Kelamin");
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "ID Posisi");
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "Status");
        $rowCount++;

        foreach ($data as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->nama);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowCount, $value->telp, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->id_kota);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->id_kelamin);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->id_posisi);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->status);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('./assets/excel/Data Pegawai.xlsx');

        $this->load->helper('download');
        force_download('./assets/excel/Data Pegawai.xlsx', NULL);
    }

    public function import()
    {
        $this->form_validation->set_rules('excel', 'File', 'trim|required');

        if ($_FILES['excel']['name'] == '') {
            $this->session->set_flashdata('msg', 'File harus diisi');
        } else {
            $config['upload_path'] = './assets/excel/';
            $config['allowed_types'] = 'xls|xlsx';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();

                error_reporting(E_ALL);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

                $inputFileName = './assets/excel/' . $data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $index = 0;
                foreach ($sheetData as $key => $value) {
                    if ($key != 1) {
                        $id = md5(DATE('ymdhms') . rand());
                        $check = $this->M_pegawai->check_nama($value['B']);

                        if ($check != 1) {
                            $resultData[$index]['id'] = $id;
                            $resultData[$index]['nama'] = ucwords($value['B']);
                            $resultData[$index]['telp'] = $value['C'];
                            $resultData[$index]['id_kota'] = $value['D'];
                            $resultData[$index]['id_kelamin'] = $value['E'];
                            $resultData[$index]['id_posisi'] = $value['F'];
                            $resultData[$index]['status'] = $value['G'];
                        }
                    }
                    $index++;
                }

                unlink('./assets/excel/' . $data['file_name']);

                if (count($resultData) != 0) {
                    $result = $this->M_pegawai->insert_batch($resultData);
                    if ($result > 0) {
                        $this->session->set_flashdata('msg', show_succ_msg('Data Pegawai Berhasil diimport ke database'));
                        redirect('Pegawai');
                    }
                } else {
                    $this->session->set_flashdata('msg', show_msg('Data Pegawai Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
                    redirect('Pegawai');
                }
            }
        }
    }
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */
