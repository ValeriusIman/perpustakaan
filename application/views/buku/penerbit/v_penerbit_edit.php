<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Detail Penerbit</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Penerbit</th>
                                    <td><?= $penerbit->penerbit ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Telp</th>
                                    <td><?= $penerbit->telp ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Email</th>
                                    <td><?= $penerbit->email ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Alamat</th>
                                    <td><?= $penerbit->alamat ?></td>
                                </tr>
                            </table>
                            <a href="<?= base_url("buku/penerbit") ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Penerbit</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-penerbit">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $penerbit->penerbit ?>" id="penerbit" name="penerbit">
                        <input type="hidden" value="<?= $penerbit->id_penerbit ?>" id="idPenerbit" name="idPenerbit">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $penerbit->telp ?>" id="telp" name="telp" data-inputmask='"mask": "9999-9999-9999"' data-mask>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $penerbit->email ?>" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat"><?= $penerbit->alamat ?></textarea>
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
        $('[data-mask]').inputmask();
        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit-penerbit").valid();
            if (validate) {
                $("#form-edit-penerbit");
                prosesEdit();
            }
        });
        $("#form-edit-penerbit").validate({
            rules: {
                penerbit: {
                    required: true
                },
                email: {
                    email: true
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
            var penerbit = $('#penerbit').val();
            var telp = $('#telp').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            var id = $('#idPenerbit').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/penerbit/prosesEdit") ?>",
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
                    penerbit: penerbit,
                    telp: telp,
                    email: email,
                    alamat: alamat,
                    id: id
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Penerbit',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        };
    });
</script>