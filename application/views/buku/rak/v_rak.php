<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Rak</h3>
            </div>
            <div class="card-body">
                <table id="data-rak" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Rak</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($rak as $rk) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $rk->kode_rak ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success edit" data-id="<?= $rk->id_rak ?>" data-rak="<?= $rk->kode_rak ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa=fw fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $rk->id_rak ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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
                <h3 class="card-title">Tambah Rak</h3>
            </div>
            <div class="card-body">
                <form id="form-rak" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="rak" name="rak" placeholder="Kode Rak">
                    </div>
                    <div class="form-group">
                        <button id="btn-simpan" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Rak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-rak">
                    <div class="form-group">
                        <input type="text" class="form-control" id="rakEdit" name="rakEdit">
                        <input type="hidden" id="idRak" name="idRak">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn-edit">Ubah</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var data = $("#data-rak").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        $(".edit").on('click', function() {
            $('#idRak').val($(this).data('id'));
            $('#rakEdit').val($(this).data('rak'));
        });

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-rak").valid();
            if (validate) {
                $("#form-rak");
                prosesTambah();
            }
        });

        $("#btn-edit").on('click', function() {
            let validate = $("#form-edit-rak").valid();
            if (validate) {
                $("#form-edit-rak");
                prosesEdit();
            }
        });

        $("#form-edit-rak").validate({
            rules: {
                rakEdit: {
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

        $("#form-rak").validate({
            rules: {
                rak: {
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
            var kodeRak = $('#rak').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/rak/tambah") ?>",
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
                    kode_rak: kodeRak
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Rak',
                        text: kodeRak,
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        function prosesEdit() {
            var kodeRak = $('#rakEdit').val();
            var idRak = $('#idRak').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/rak/prosesEdit") ?>",
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
                    kode_rak: kodeRak,
                    id: idRak
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Rak',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-rak').on('click', '.hapus', function() {
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
                        url: "<?= base_url('buku/rak/delete') ?>",
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