<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Penulis</h3>
            </div>
            <div class="card-body">
                <table id="data-penulis" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penulis</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($penulis as $pn) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $pn->penulis ?></td>
                                <td><?= $pn->email ?></td>
                                <td><?= $pn->alamat ?></td>
                                <td>
                                    <a href="<?= base_url('buku/penulis/edit/' . $pn->id_penulis) ?>" class="btn btn-sm btn-success edit"><i class="fas fa=fw fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $pn->id_penulis ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Penulis</h3>
            </div>
            <div class="card-body">
                <form id="form-penulis" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Penulis">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
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
        var data = $("#data-penulis").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-penulis").valid();
            if (validate) {
                $("#form-penulis");
                prosesTambah();
            }
        });
        $("#form-penulis").validate({
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
            var penulis = $('#penulis').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/penulis/tambah") ?>",
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
                    alamat: alamat
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Penulis',
                        text: penulis,
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-penulis').on('click', '.hapus', function() {
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
                        url: "<?= base_url('buku/penulis/delete') ?>",
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