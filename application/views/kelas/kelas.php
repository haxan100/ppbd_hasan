<?php
defined('BASEPATH') or exit('No direct script access allowed');
$bu = base_url();
$obj['ci'] = $ci;
$obj['header'] = array(
    'title' => 'Master Admin',
    'page' => 'master_admin',
);
// $ci->load->view('_layout/_header', $obj);
?>


<style>
    .kotak {
        padding-left: 59px;
        padding-right: 60px
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Kelas</h5>

                    <!-- /$role = $this->AdminModel->getRoleAll($this->session->userdata('id_admin'))->row();			 -->
                    <!-- var_dump($role); -->
                    <!-- if($role->tambah_admin == 1){ -->
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalAdmin" class="btn m-t-20 btn-info waves-effect waves-light btnTambahAdmin">
                        <i class="ti-plus"></i> Tambah Kelas Baru
                    </a>
                    <!--  -->

                    <p id="alertNotif">
                        <?php
                        if ($this->session->flashdata('notifikasi')) {
                        ?>
                            <div class="alert <?= $this->session->flashdata('notifikasi')['alert']; ?> alert-dismissible show" role="alert">
                                <span>
                                    <?= $this->session->flashdata('notifikasi')['msg']; ?>
                                </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php
                        } // tutup if flashdata
                        ?>
                    </p>


                    <p id="alertNotif" class="mt-2"></p>
                    <div class="table-responsive">
                        <table id="adminList" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade none-border" id="modalAdmin">
    <div class="modal-dialog modal-xl">
        <div class="modal-content kotak">

            <div class="modal-header">
                <h4 class="modal-title modalProdukTitleTambah"><strong>Tambah</strong> Kelas Baru</h4>
                <h4 class="modal-title modalProdukTitleUbah  style=" display: none"><strong>Ubah</strong> Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-bodys">
                <p id="alertNotifModal" class="mt-2"></p>
                <input id="id_siswa" name="id_siswa" value="" type="hidden">
                <div class="row ">
                    <div class="col p-6">
                        <div class="row">
                            <div class="col form-group">
                                <label for="nama_kelas">Nama Kelas </label>
                                <input id="nama_siswa" name="nama_siswa" placeholder="Masukan Nama Lengkap" required type="text" class="form-control">

                                <small></small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btnTambahAdmin" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <button type="button" id="btnEditAdmin" class="btn btn-primary"><i class="fas fa-save"></i> Edit</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $(document).ready(function() {

        var datatable = $('#adminList').DataTable({
            'lengthMenu': [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All']
            ],
            'pageLength': 5,
            "processing": true,
            "serverSide": true,
            "columnDefs": [{
                    "targets": 0,
                    "className": "dt-body-center dt-head-center",
                    "width": "20px"
                },
                {
                    "targets": 1,
                    "className": "dt-head-center"
                },
                {
                    "targets": 2,
                    "className": "dt-head-center"
                },


            ],
            "order": [
                [1, "asc"]
            ],
            'ajax': {
                url: '<?= base_url('siswa/getAllKelas'); ?>',
                type: 'POST',
            },
        });



        $('.btnTambahAdmin').on('click', function() {
            $('.modalProdukTitleTambah').show();
            $('.modalProdukTitleUbah').hide();
            $('#btnEditAdmin').hide();

        });


        $('#btnTambahAdmin').on('click', function() {

            $('small.text-danger').html('');
            var nama = $('#nama_kelas').val();


            if (nama == '') {
                $('*[for="nama_kelas"] > small').html('Harap diisi!');
                alert('harap isi Nama!');
            
            } else {

                $.ajax({
                    url: '<?= $bu ?>siswa/tambah_kelas ',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        nama: nama,
                        nisn: nisn,
                        // password: password,
                        jenis_sekolah: jenis_sekolah,
                        sekolah_asal: sekolah_asal,
                        alamat: alamat,
                        no_hp: no_hp,
                        nama_ibu: nama_ibu,
                        nama_ayah: nama_ayah,
                        status: status,
                        tanggal_lahir: tanggal_lahir,
                        tempat_lahir: tempat_lahir,
                        kelas: kelas,

                    }
                }).done(function(e) {
                    console.log('berhasil');
                    // console.log(e);
                    $('#nama_siswa').val('');
                    $('#nisn').val('');
                    $('#jenis_sekolah').val('');
                    $('#sekolah_asal').val('');
                    $('#alamat').val('');
                    $('#no_hp').val('');
                    $('#nama_ibu').val('');
                    $('#nama_ayah').val('');
                    $('#status').val('');
                    $('#tempat_lahir').val('');
                    $('#kelas').val('');

                    $('#modalAdmin').modal('show');
                    datatable.ajax.reload();
                    //$('body').removeClass('modal-open');$('.modal-backdrop').remove();
                    var alert = '';
                    if (e.status) {
                        // notifikasi('#alertNotif', e.message, false);
                        $('#modalAdmin').modal('hide');
                        datatable.ajax.reload();

                        // resetForm();
                    } else {
                        notifikasi('#alertNotifModal', e.message, true);
                        // $.each(e.errorInputs, function(key, val) {
                        // 	console.log(val[0], val[1]);
                        // 	validasi(val[0], false, val[1]);
                        // 	$(val[0])
                        // 		.parent()
                        // 		.find('.input-group-text')
                        // 		.addClass('form-control is-invalid');
                        // });

                    }
                }).fail(function(e) {
                    console.log(e);
                    // resetForm($('#modalAdmin'));
                    $('#modalAdmin').modal('show');
                    // notifikasi('#alertNotif', 'Terjadi kesalahan!', true);
                });
            }
            return false;
        });

        $('body').on('click', '.btnEditAdmin', function() {

            var id_siswa = $(this).data('id_siswa');
            var nama = $(this).data('nama_siswa');
            var nisn = $(this).data('nisn');
            var jenis_sekolah_asal = $(this).data('jenis_sekolah_awal');
            var sekolah_asal = $(this).data('sekolah_asal');
            var alamat = $(this).data('alamat');
            var no_hp = $(this).data('nohp');
            var nama_ibu = $(this).data('nama_ibu');
            var nama_ayah = $(this).data('nama_ayah');
            var status = $(this).data('status');
            // console.log(sekolah_asal);
            var tanggal_lahir = $(this).data('tanggal_lahir');
            var tempat_lahir = $(this).data('tempat_lahir');
            var kelas = $(this).data('kelas');


            $('#btnEditAdmin').show();
            $('#btnTambahAdmin').hide();
            $('.modalProdukTitleTambah').hide();
            $('#modalProdukTitleUbah').show();
            $('#tambahUser').hide();
            $('#modalEditUserTitle').hide();
            $('#editUser').show();
            $('#modalAdmin').modal('show');

            // $('.btnEditAdmin').on('click', function() {

            $('#id_siswa').val(id_siswa);
            $('#nama_siswa').val(nama);
            $('#nisn').val(nisn);
            $('#jenis_sekolah').val(jenis_sekolah_asal);
            $('#sekolah_asal').val(sekolah_asal);

            $('#alamat').val(alamat);
            $('#no_hp').val(no_hp);
            $('#nama_ibu').val(nama_ibu);
            $('#nama_ayah').val(nama_ayah);
            $('#status').val(status);

            $('#tanggal_lahir').val(tanggal_lahir);
            $('#tempat_lahir').val(tempat_lahir);
            $('#kelas').val(kelas);




            // return false;
        });

        $('#btnEditAdmin').on('click', function() {
            console.log("ter");
            // return false;

            $('small.text-danger').html('');
            var id_siswa = $('#id_siswa').val();
            var nisn = $('#nisn').val();
            var nama_siswa = $('#nama_siswa').val();
            var jenis_sekolah = $('#jenis_sekolah').val();
            var sekolah_asal = $('#sekolah_asal').val();

            var jenis_sekolah = $('#jenis_sekolah option:selected').val();

            var sekolah_asal = $('#sekolah_asal').val();

            var alamat = $('#alamat').val();
            var no_hp = $('#no_hp').val();
            var nama_ibu = $('#nama_ibu').val();

            var nama_ayah = $('#nama_ayah').val();
            var status = $('#status').val();
            var tanggal_lahir = $('#tanggal_lahir').val();
            var tempat_lahir = $('#tempat_lahir').val();

            var kelas = $('#kelas option:selected').val();

            if (nama_siswa == '') {
                $('*[for="nama_siswa"] > small').html('Harap diisi!');
                alert('harap isi Nama!');
            } else if (nisn == '') {
                $('*[for="nisn"] > small').html('Harap diisi!');
                // alert('harap isi NISN!');
            } else if (jenis_sekolah == '') {
                $('*[for="jenis_sekolah"] > small').html('Harap diisi!');
                alert('harap isi Jenis Sekolah!');
            } else if (sekolah_asal == '') {
                $('*[for="sekolah_asal"] > small').html('Harap diisi!');
                alert('harap isi Sekolah Asal!');
            } else if (alamat == '') {
                $('*[for="alamat"] > small').html('Harap diisi!');
                alert('harap isi alamat!');
            } else if (no_hp == '') {
                $('*[for="no_hp"] > small').html('Harap diisi!');
                alert('harap isi no_hp!');
            } else if (nama_ibu == '') {
                $('*[for="nama_ibu"] > small').html('Harap diisi!');
                alert('harap isi nama ibu!');
            } else if (nama_ayah == '') {
                $('*[for="nama_ayah"] > small').html('Harap diisi!');
                alert('harap isi Nama Ayah!');
            } else if (status == '') {
                $('*[for="status"] > small').html('Harap diisi!');
                alert('harap isi Status!');
            } else if (tanggal_lahir == '') {
                $('*[for="tanggal_lahir"] > small').html('Harap diisi!');
                alert('harap isi tanggal lahir!');
            } else if (kelas == '') {
                $('*[for="kelas"] > small').html('Harap diisi!');
                alert('harap isi kelas!');
            } else {

                $.ajax({
                    url: '<?= $bu ?>siswa/edit_siswa ',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        id_siswa: id_siswa,
                        nama_siswa: nama_siswa,
                        nisn: nisn,
                        no_hp: no_hp,
                        jenis_sekolah: jenis_sekolah,
                        sekolah_asal: sekolah_asal,
                        alamat: alamat,
                        nama_ibu: nama_ibu,
                        nama_ayah: nama_ayah,
                        status: status,
                        tanggal_lahir: tanggal_lahir,
                        tempat_lahir: tempat_lahir,
                        kelas: kelas,

                    }
                }).done(function(e) {
                    console.log('berhasil');
                    // console.log(e);
                    // console.log(e);
                    $('#nama_siswa').val('');
                    $('#nisn').val('');
                    $('#jenis_sekolah').val('');
                    $('#sekolah_asal').val('');
                    $('#alamat').val('');
                    $('#no_hp').val('');
                    $('#nama_ibu').val('');
                    $('#nama_ayah').val('');
                    $('#status').val('');
                    $('#tempat_lahir').val('');
                    $('#kelas').val('');

                    // $('#modalAdmin').modal('hide'); //$('body').removeClass('modal-open');$('.modal-backdrop').remove();
                    var alert = '';
                    if (e.status) {
                        // notifikasi('#alertNotif', e.message, false);
                        $('#modalAdmin').modal('hide');
                        datatable.ajax.reload();
                        // resetForm();
                    } else {
                        // notifikasi('#alertNotifModal', e.message, true);
                        // $.each(e.errorInputs, function(key, val) {
                        // 	console.log(val[0], val[1]);
                        // 	validasi(val[0], false, val[1]);
                        // 	$(val[0])
                        // 		.parent()
                        // 		.find('.input-group-text')
                        // 		.addClass('form-control is-invalid');
                        // });

                    }
                }).fail(function(e) {
                    console.log(e);
                    // resetForm($('#modalAdmin'));
                    $('#modalAdmin').modal('hide');
                    // notifikasi('#alertNotif', 'Terjadi kesalahan!', true);
                });
            }
            return false;
        });


        $('body').on('click', '.btnHapus', function() {
            var id_siswa = $(this).data('id_siswa');
            var nama_siswa = $(this).data('nama_siswa');

            var c = confirm('Apakah anda yakin akan menghapus siswa: "' + nama_siswa + '" ?');
            if (c == true) {
                $.ajax({
                    url: '<?= $bu ?>siswa/hapus_siswa',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        id_siswa: id_siswa
                    }
                }).done(function(e) {
                    console.log(e);
                    // notifikasi('#alertNotif', e.message, !e.status);

                    datatable.ajax.reload();
                }).fail(function(e) {
                    console.log('gagal');
                    console.log(e);
                    datatable.ajax.reload();
                    var message = 'Terjadi Kesalahan. #JSMP01';
                    // notifikasi('#alertNotif', message, true);
                });
            }
            return false;
        });

    });
</script>
<?php
$ci->load->view('_layout/_footer', $obj);
?>