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
                    <h5 class="card-title">Siswa List</h5>

                    <!-- /$role = $this->AdminModel->getRoleAll($this->session->userdata('id_admin'))->row();			 -->
                    <!-- var_dump($role); -->
                    <!-- if($role->tambah_admin == 1){ -->
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalAdmin" class="btn m-t-20 btn-info waves-effect waves-light btnTambahAdmin">
                        <i class="ti-plus"></i> Tambah Siswa Baru
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
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Email</th>
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
                <h4 class="modal-title modalProdukTitleTambah"><strong>Tambah</strong> Siswa Baru</h4>
                <h4 class="modal-title modalProdukTitleUbah  style=" display: none"><strong>Ubah</strong> Admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-bodys">
                <p id="alertNotifModal" class="mt-2"></p>
                <input id="id_admin" name="id_admin" value="" type="hidden">
                <div class="row ">
                    <div class="col p-6">
                        <div class="row">
                            <div class="col form-group">
                                <label for="nama_siswa">Nama Lengkap </label>
                                <input id="nama_siswa" name="nama_siswa" placeholder="Masukan Nama Lengkap" required type="text" class="form-control">

                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="nisn">Nisn</label>
                                <input id="nisn" name="nisn" name="nisn" placeholder="Masukan Nisn" required type="number" class="form-control">

                                <small></small>
                            </div>

                            <div class="col form-group">
                                <label for="jenis_sekolah">Jenis Sekolah Asal</label>
                                <select name="jenis_sekolah" id="jenis_sekolah" class="form-control form-control-lg">
                                    <option value="">Pilih Jenis</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="Negri">Negri</option>
                                </select>
                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="sekolah_asal">Sekolah Asal</label>
                                <input id="sekolah_asal" name="sekolah_asal" name="sekolah_asal" placeholder="Masukan Sekolah Asal" require type="text" class="form-control">

                                <small></small>
                            </div>

                            <div class="col form-group">
                                <label for="alamat">Alamat Siswa</label>
                                <textarea class="form-control" id="alamat" rows="3"></textarea>
                            </div>

                            <div class="col form-group">
                                <label for="no_hp">No HP</label>
                                <input id="no_hp" name="no_hp" name="no_hp" placeholder="Masukan No Hp" require type="text" class="form-control">

                                <small></small>
                            </div>

                            <div class="col form-group">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input id="nama_ibu" name="nama_ibu" name="nama_ibu" placeholder="Masukan Nama Ibu" require type="text" class="form-control">

                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input id="nama_ayah" name="nama_ayah" name="nama_ayah" placeholder="Masukan Nama Ayah" require type="text" class="form-control">

                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control form-control-lg">
                                    <option value="">Pilih Status</option>
                                    <option value="3">Di Tunggu</option>
                                    <option value="1">Di Terima</option>
                                    <option value="0">Di Tolak</option>
                                </select>
                                <small></small>
                            </div>

                            <div class="col form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" name="tanggal_lahir" placeholder="Masukan No Hp" require type="date" class="form-control">

                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input id="tempat_lahir" name="tempat_lahir" name="tempat_lahir" placeholder="Masukan Tempat Lahir" require type="text" class="form-control">

                                <small></small>
                            </div>
                            <div class="col form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control form-control-lg">
                                    <option value="">Pilih Kelas</option>
                                    <option value="0">Belum Milih</option>
                                    <option value="1">Kelas 7</option>
                                    <option value="2">Kelas 8</option>
                                    <option value="3">Kelas 9</option>
                                </select>
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
                    "className": "dt-body-center dt-head-center"
                },
                {
                    "targets": 3,
                    "className": "dt-body-center dt-head-center"
                },
                {
                    "targets": 4,
                    "className": "dt-body-center dt-head-center",
                    "orderable": false
                },
            ],
            "order": [
                [2, "asc"]
            ],
            'ajax': {
                url: '<?= base_url('siswa/getAllSiswa'); ?>',
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
            var nama = $('#nama_siswa').val();
            var nisn = $('#nisn').val();
            var jenis_sekolah = $('#jenis_sekolah option:selected').val();
            // console.log(nama, nisn);
            // return (false);
            var sekolah_asal = $('#sekolah_asal').val();

            var alamat = $('#alamat').val();
            var no_hp = $('#no_hp').val();
            var nama_ibu = $('#nama_ibu').val();

            var nama_ayah = $('#nama_ayah').val();
            var status = $('#status').val();
            var tanggal_lahir = $('#tanggal_lahir').val();
            var tempat_lahir = $('#tempat_lahir').val();

            var kelas = $('#kelas option:selected').val();


            if (nama == '') {
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
                    url: '<?= $bu ?>siswa/tambah_siswa ',
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

            var id_admin = $(this).data('id_admin');
            var nama = $(this).data('nama');
            var username = $(this).data('username');
            var password = $(this).data('password');
            var email = $(this).data('email');
            var all_admin = $(this).data('role-all_admin');
            var tambah_admin = $(this).data('role-tambah_admin');
            var all_user = $(this).data('role-all_user');
            var all_produk = $(this).data('role-all_produk');
            var tambah_produk = $(this).data('role-tambah_produk');

            var transaksi = $(this).data('role-transaksi');
            var bundling = $(this).data('role-bundling');
            var grade = $(this).data('role-grade');
            var spek_hp = $(this).data('role-spek_hp');
            var spek_smartwatch = $(this).data('role-spek_smartwatch');
            var spek_laptop = $(this).data('role-spek_laptop');
            var waktu = $(this).data('role-waktu');


            $('#btnEditAdmin').show();
            $('#btnTambahAdmin').hide();
            $('.modalProdukTitleTambah').hide();
            $('#modalProdukTitleUbah').show();
            $('#tambahUser').hide();
            $('#modalEditUserTitle').hide();
            $('#editUser').show();
            $('#modalAdmin').modal('show');

            // $('.btnEditAdmin').on('click', function() {

            $('#id_admin').val(id_admin);
            $('#username').val(username);
            $('#password').val(password);
            $('#email').val(email);
            $('#nama').val(nama);

            var noRoleSelected = true;
            if (all_admin || tambah_admin || all_user ||
                all_produk || tambah_produk ||
                transaksi || bundling || grade ||
                spek_hp || spek_smartwatch || spek_laptop || waktu
            )
                noRoleSelected = false;
            if (all_admin == "1") $('#role-all_admin').prop('checked', true);
            if (tambah_admin == "1") $('#role-tambah_admin').prop('checked', true);
            if (all_user == "1") $('#role-all_user').prop('checked', true);
            if (all_produk == "1") $('#role-all_produk').prop('checked', true);
            if (tambah_produk == "1") $('#role-tambah_produk').prop('checked', true);

            if (transaksi == "1") $('#role-transaksi').prop('checked', true);
            if (bundling == "1") $('#role-bundling').prop('checked', true);
            if (grade == "1") $('#role-grade').prop('checked', true);
            if (spek_hp == "1") $('#role-spek_hp').prop('checked', true);
            if (spek_smartwatch == "1") $('#role-spek_smartwatch').prop('checked', true);
            if (spek_laptop == "1") $('#role-spek_laptop').prop('checked', true);
            if (waktu == "1") $('#role-waktu').prop('checked', true);


            // return false;
        });

        $('#btnEditAdmin').on('click', function() {
            console.log("ter");
            // return false;

            $('small.text-danger').html('');
            var nama = $('#nama').val();
            var id_admin = $('#id_admin').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var email = $('#email').val();
            var all_admin = $('#role-all_admin').prop('checked');
            var tambah_admin = $('#role-tambah_admin').prop('checked');
            var all_user = $('#role-all_user').prop('checked');
            var all_produk = $('#role-all_produk').prop('checked');
            var tambah_produk = $('#role-tambah_produk').prop('checked');

            var transaksi = $('#role-transaksi').prop('checked');
            var bundling = $('#role-bundling').prop('checked');
            var grade = $('#role-grade').prop('checked');
            var spek_hp = $('#role-spek_hp').prop('checked');
            var spek_smartwatch = $('#role-spek_smartwatch').prop('checked');
            var spek_laptop = $('#role-spek_laptop').prop('checked');
            var waktu = $('#role-waktu').prop('checked');
            var noRoleSelected = true;
            if (all_admin || tambah_admin || all_user ||
                all_produk || tambah_produk ||
                transaksi || bundling || grade ||
                spek_hp || spek_smartwatch || spek_laptop || waktu
            ) noRoleSelected = false;

            if (username == '') {
                $('*[for="username"] > small').html('Harap diisi!');
                alert('harap isi username!');
            } else if (password == '') {
                $('*[for="Password"] > small').html('Harap diisi!');
                alert('harap isi password!');
            } else if (email == '') {
                $('*[for="email"] > small').html('Harap diisi!');
                alert('harap isi Email!');
            } else if (noRoleSelected) {
                $('*[for="inputRole"] > small').html('Harap pilih minimal 1 Role!');
                alert('harap isi Role!');
            } else {

                $.ajax({
                    url: '<?= $bu ?>admin/edit_admin ',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        id_admin: id_admin,
                        nama: nama,
                        username: username,
                        password: password,
                        email: email,
                        all_admin: all_admin,
                        tambah_admin: tambah_admin,
                        all_user: all_user,
                        all_produk: all_produk,
                        tambah_produk: tambah_produk,
                        transaksi: transaksi,
                        bundling: bundling,
                        grade: grade,
                        spek_hp: spek_hp,
                        spek_smartwatch: spek_smartwatch,
                        spek_laptop: spek_laptop,
                        waktu: waktu,

                    }
                }).done(function(e) {
                    console.log('berhasil');
                    // console.log(e);
                    $('#nama').val('');
                    $('#username').val('');
                    $('#Password').val('');
                    $('#email').val('');
                    $(':checkbox').prop('checked', false);
                    // $('#modalAdmin').modal('hide'); //$('body').removeClass('modal-open');$('.modal-backdrop').remove();
                    var alert = '';
                    if (e.status) {
                        notifikasi('#alertNotif', e.message, false);
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
                    resetForm($('#modalAdmin'));
                    $('#modalAdmin').modal('hide');
                    notifikasi('#alertNotif', 'Terjadi kesalahan!', true);
                });
            }
            return false;
        });




    });
</script>
<?php
$ci->load->view('_layout/_footer', $obj);
?>