<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Anggota</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">No Anggota</th>
                                    <td><?= $anggota->no_anggota ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Nama Anggota</th>
                                    <td><?= $anggota->nama_anggota ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">No Mahasiswa</th>
                                    <td><?= $anggota->no_mahasiswa ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Telp</th>
                                    <td><?= $anggota->telp ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Tanggal Lahir</th>
                                    <td><?= $anggota->tanggal_lahir ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Jenis Kelamin</th>
                                    <td><?= $anggota->jenis_kelamin ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Alamat</th>
                                    <td><?= $anggota->alamat ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Bergabung</th>
                                    <td><?= $anggota->bergabung ?></td>
                                </tr>
                            </table>
                            <a href="<?= base_url("master/anggota") ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            <a href="<?= base_url('master/anggota/print/') . $anggota->id_anggota ?>" target="_blank" id="cetak" class="btn btn-success"><i class="fas fa-print"></i> Cetak Kartu Anggota</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Anggota</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-Anggota">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $anggota->nama_anggota ?>" id="namaAnggota" name="namaAnggota">
                        <input type="hidden" value="<?= $anggota->id_anggota ?>" id="idAnggota" name="idAnggota">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $anggota->no_mahasiswa ?>" id="noMahasiswa" name="noMahasiswa">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $anggota->telp ?>" id="telp" name="telp" data-inputmask='"mask": "9999-9999-9999"' data-mask>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $anggota->tanggal_lahir ?>" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <select id="jenisKelamin" name="jenisKelamin" class="form-control select2" style="width: 100%;">
                            <option <?= $anggota->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' ?> value="Laki-Laki">Laki-Laki</option>
                            <option <?= $anggota->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat"><?= $anggota->alamat ?></textarea>
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
        $('#prodi').select2();
        $('#jenisKelamin').select2();
        $('[data-mask]').inputmask();
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit-Anggota").valid();
            if (validate) {
                $("#form-edit-Anggota");
                prosesEdit();
            }
        });
        $("#form-edit-Anggota").validate({
            rules: {
                namaAnggota: {
                    required: true
                },
                noMahasiswa: {
                    required: true,
                    digits: true
                },
                prodi: {
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
            var namaAnggota = $('#namaAnggota').val();
            var noMahasiswa = $('#noMahasiswa').val();
            var prodi = $('#prodi').val();
            var tanggal = $('#tanggal').val();
            var telp = $('#telp').val();
            var jenisKelamin = $('#jenisKelamin').val();
            var alamat = $('#alamat').val();
            var idAnggota = $('#idAnggota').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("master/anggota/prosesEdit") ?>",
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
                    nama_anggota: namaAnggota,
                    no_mahasiswa: noMahasiswa,
                    prodi: prodi,
                    telp: telp,
                    jenis_kelamin: jenisKelamin,
                    alamat: alamat,
                    tanggal_lahir: tanggal,
                    id_anggota: idAnggota,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Anggota',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        };
    });
</script>