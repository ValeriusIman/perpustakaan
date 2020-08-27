<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Detail Penulis</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Penulis</th>
                                    <td><?= $penulis->penulis ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Email</th>
                                    <td><?= $penulis->email ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Alamat</th>
                                    <td><?= $penulis->alamat ?></td>
                                </tr>
                            </table>
                            <a href="<?= base_url("buku/penulis") ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Penulis</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-penulis">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $penulis->penulis ?>" id="penulis" name="penulis">
                        <input type="hidden" value="<?= $penulis->id_penulis ?>" id="idPenulis" name="idPenulis">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $penulis->email ?>" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="alamat" name="alamat"><?= $penulis->alamat ?></textarea>
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
            let validate = $("#form-edit-penulis").valid();
            if (validate) {
                $("#form-edit-penulis");
                prosesEdit();
            }
        });
        $("#form-edit-penulis").validate({
            rules: {
                penulis: {
                    required: true
                },
                email: {
                    required: true,
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
            var penulis = $('#penulis').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            var id = $('#idPenulis').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/penulis/prosesEdit") ?>",
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
                    penulis: penulis,
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