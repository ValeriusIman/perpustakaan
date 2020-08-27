<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Anggota</h3>
            </div>
            <div class="card-body">
                <table id="data-anggota" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Anggota</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>No Telp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($anggota as $ag) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $ag->no_anggota ?></td>
                                <td><?= $ag->nama_anggota ?></td>
                                <td><?= $ag->no_mahasiswa ?></td>
                                <td><?= $ag->telp ?></td>
                                <td>
                                    <a href="<?= base_url('master/anggota/detail/' . $ag->id_anggota) ?>" class="btn btn-sm btn-success"><i class="fas fa=fw fa-eye"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $ag->id_anggota ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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
                <h3 class="card-title">Tambah Anggota</h3>
            </div>
            <div class="card-body">
                <form id="form-anggota" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="noAnggota" value="<?= $noAnggota ?>" name="noAnggota" placeholder="No. Anggota" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="No. Mahasiswa">
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
        var data = $("#data-anggota").DataTable({
            "responsive": true,
            "autoWidth": false
        });
        $('#prodi').select2({
            placeholder: "Pilih Prodi"
        });
        $('#jenisKelamin').select2({
            placeholder: "Pilih Jenis Kelamin"
        });
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
        $('[data-mask]').inputmask()

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-anggota").valid();
            if (validate) {
                $("#form-anggota");
                prosesTambah();
            }
        });
        $("#form-anggota").validate({
            rules: {
                nama: {
                    required: true
                },
                nim: {
                    required: true,
                    digits: true
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
            var noAnggota = $('#noAnggota').val();
            var nama = $('#nama').val();
            var nim = $('#nim').val();
            var noTelp = $('#noTelp').val();
            var tanggal = $('#tanggal').val();
            var jenisKelamin = $('#jenisKelamin').val();
            var alamat = $('#alamat').val();
            var tanggalBuat = $('#tanggalBuat').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("master/anggota/tambah") ?>",
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
                    no_anggota: noAnggota,
                    nama: nama,
                    nim: nim,
                    no_telp: noTelp,
                    tanggal: tanggal,
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

        $('#data-anggota').on('click', '.hapus', function() {
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
                        url: "<?= base_url('master/anggota/delete') ?>",
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