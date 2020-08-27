<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Karyawan</h3>
            </div>
            <div class="card-body">
                <table id="data-karyawan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($karyawan as $kr) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $kr->nama_karyawan ?></td>
                                <td><?= $kr->no_telp ?></td>
                                <td><?= $kr->alamat ?></td>
                                <td>
                                    <a href="<?= base_url('master/karyawan/detail/' . $kr->id_karyawan) ?>" class="btn btn-sm btn-success"><i class="fas fa=fw fa-eye"></i></a>
                                    <?php if ($kr->id_karyawan != $userData['id_karyawan'] && $kr->level != 1) { ?>
                                        <button class="btn btn-sm btn-danger hapus" data-id="<?= $kr->id_karyawan ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Karyawan</h3>
            </div>
            <div class="card-body">
                <form id="form-karyawan" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="userName" name="userName" placeholder="User Name">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="No.Telp" id="noTelp" name="noTelp" data-inputmask='"mask": "9999-9999-9999"' data-mask>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder='Tanggal Lahir' id="tanggal" name="tanggal">
                        <input type="hidden" id="tanggalBuat" value="<?= date('Y-m-d') ?>" name="tanggalBuat">
                    </div>
                    <div class="form-group">
                        <select id="jenisKelamin" name="jenisKelamin" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="level" name="level" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <option value="1">Admin</option>
                            <option value="2">Pegawai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <button id="btn-simpan" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var data = $("#data-karyawan").DataTable({
            "responsive": true,
            "autoWidth": false
        });
        $('#jenisKelamin').select2({
            placeholder: "Pilih Jenis Kelamin"
        });
        $('#level').select2({
            placeholder: "Pilih Level"
        });
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
        $('[data-mask]').inputmask()

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-karyawan").valid();
            if (validate) {
                $("#form-karyawan");
                prosesTambah();
            }
        });
        $("#form-karyawan").validate({
            rules: {
                userName: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                nama: {
                    required: true
                },
                noTelp: {
                    required: true
                },
                tanggal: {
                    required: true
                },
                jenisKelamin: {
                    required: true
                },
                alamat: {
                    required: true
                },
                level: {
                    required: true
                }
            },
            messages: {
                password: {
                    minlength: "Password minimal 6 karakter"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        function prosesTambah() {
            var userName = $('#userName').val();
            var password = $('#password').val();
            var nama = $('#nama').val();
            var noTelp = $('#noTelp').val();
            var tanggal = $('#tanggal').val();
            var jenisKelamin = $('#jenisKelamin').val();
            var alamat = $('#alamat').val();
            var tanggalBuat = $('#tanggalBuat').val();
            var level = $('#level').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("master/karyawan/tambah") ?>",
                beforeSend: function() {
                    swal({
                        title: 'Menunggu',
                        html: 'Memproses data',
                        onOpen: () => {
                            swal.showLoading()
                        }
                    })
                },
                data: {
                    user_name: userName,
                    password: password,
                    nama: nama,
                    no_telp: noTelp,
                    tanggal: tanggal,
                    level: level,
                    jenis_kelamin: jenisKelamin,
                    alamat: alamat,
                    tanggal_buat: tanggalBuat
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Anggota',
                        text: nama,
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-karyawan').on('click', '.hapus', function() {
            var id = $(this).data('id');
            swal({
                title: 'Konfirmasi',
                text: "Anda ingin menghapus",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?= base_url('master/karyawan/delete') ?>",
                        method: "post",
                        beforeSend: function() {
                            swal({
                                title: 'Menunggu',
                                html: 'Memproses data',
                                onOpen: () => {
                                    swal.showLoading()
                                }
                            })
                        },
                        data: {
                            id: id
                        },
                        success: function(data) {
                            swal({
                                title: 'Hapus',
                                text: 'Berhasil Terhapus',
                                type: 'success'
                            }).then(function() {
                                location.reload();
                            })
                        }
                    })
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal(
                        'Batal',
                        'Anda membatalkan penghapusan',
                        'error'
                    )
                }
            })
        });
    });
</script>