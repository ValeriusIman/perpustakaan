<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Karyawan</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Nama Karyawan</th>
                                    <td><?= $karyawan->nama_karyawan ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Telp</th>
                                    <td><?= $karyawan->no_telp ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Tanggal Lahir</th>
                                    <td><?= $karyawan->tanggal_lahir ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Jenis Kelamin</th>
                                    <td><?= $karyawan->jenis_kelamin ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Alamat</th>
                                    <td><?= $karyawan->alamat ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Bergabung</th>
                                    <td><?= $karyawan->bergabung ?></td>
                                </tr>
                            </table>
                            <?php if ($userData['level'] == 1) { ?>
                                <a href="<?= base_url("master/karyawan") ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            <?php } ?>
                            <a href="<?= base_url('master/karyawan/ubahPassword/' . $karyawan->id_karyawan) ?>" class="btn btn-success"><i class="fas fa=fw fa-edit"></i> Ubah Username dan Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Karyawan</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-karyawan">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $karyawan->nama_karyawan  ?>" id="namaKaryawan" name="namaKaryawan">
                        <input type="hidden" value="<?= $karyawan->id_karyawan ?>" id="idKaryawan" name="idKaryawan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $karyawan->no_telp ?>" id="telp" name="telp" data-inputmask='"mask": "9999-9999-9999"' data-mask>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $karyawan->tanggal_lahir ?>" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <select id="jenisKelamin" name="jenisKelamin" class="form-control select2" style="width: 100%;">
                            <option <?= $karyawan->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' ?> value="Laki-Laki">Laki-Laki</option>
                            <option <?= $karyawan->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat"><?= $karyawan->alamat ?></textarea>
                    </div>
                    <div class="form-group">
                        <button id="btn-simpan" type="button" class="btn btn-success edit"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#jenisKelamin').select2();
        $('[data-mask]').inputmask();
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });



        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit-karyawan").valid();
            if (validate) {
                $("#form-edit-karyawan");
                prosesEdit();
            }
        });

        $("#form-edit-karyawan").validate({
            rules: {
                namaKaryawan: {
                    required: true
                },
                telp: {
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

        function prosesEdit() {
            var namaKaryawan = $('#namaKaryawan').val();
            var tanggal = $('#tanggal').val();
            var telp = $('#telp').val();
            var jenisKelamin = $('#jenisKelamin').val();
            var alamat = $('#alamat').val();
            var idKaryawan = $('#idKaryawan').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("master/karyawan/prosesEdit") ?>",
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
                    nama_karyawan: namaKaryawan,
                    tanggal_lahir: tanggal,
                    telp: telp,
                    jenis_kelamin: jenisKelamin,
                    alamat: alamat,
                    id_karyawan: idKaryawan,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Karyawan',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        };

    });
</script>