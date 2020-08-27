<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Pengaturan</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Nama Kampus</th>
                                    <td><?= $pengaturan->nama_kampus ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">No. Telp</th>
                                    <td><?= $pengaturan->no_telp ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Alamat</th>
                                    <td><?= $pengaturan->alamat ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit</h3>
            </div>
            <div class="card-body">
                <form id="form-edit">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $pengaturan->nama_kampus ?>" id="nama" name="nama">
                        <input type="hidden" value="<?= $pengaturan->id_pengaturan ?>" id="idPengaturan" name="idPengaturan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $pengaturan->no_telp ?>" id="noTelp" name="noTelp">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat"><?= $pengaturan->alamat ?></textarea>
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
        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit").valid();
            if (validate) {
                $("#form-edit");
                prosesEdit();
            }
        });
        $("#form-edit").validate({
            rules: {
                nama: {
                    required: true
                },
                noTelp: {
                    required: true,
                    digits: true
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
            var nama = $('#nama').val();
            var noTelp = $('#noTelp').val();
            var alamat = $('#alamat').val();
            var idPengaturan = $('#idPengaturan').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("pengaturan/prosesEdit") ?>",
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
                    nama: nama,
                    no_telp: noTelp,
                    alamat: alamat,
                    id_pengaturan: idPengaturan,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        };
    });
</script>