<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Jenis Buku</h3>
            </div>
            <div class="card-body">
                <table id="data-jenis-buku" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jenis Buku</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($jenis as $jn) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $jn->jenis_buku ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success edit" data-id="<?= $jn->id_jenis ?>" data-jenis="<?= $jn->jenis_buku ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa=fw fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $jn->id_jenis ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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
                <h3 class="card-title">Tambah Jenis Buku</h3>
            </div>
            <div class="card-body">
                <form id="form-jenis-buku" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis Buku">
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
                <h5 class="modal-title" id="staticBackdropLabel">Edit Jenis Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <div class="form-group">
                        <input type="text" class="form-control" id="jenisEdit" name="jenisEdit">
                        <input type="hidden" id="idJenis" name="idJenis">
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
        var data = $("#data-jenis-buku").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        $(".edit").on('click', function() {
            $('#idJenis').val($(this).data('id'));
            $('#jenisEdit').val($(this).data('jenis'));
        });

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-jenis-buku").valid();
            if (validate) {
                $("#form-jenis-buku");
                prosesTambah();
            }
        });

        $("#btn-edit").on('click', function() {
            let validate = $("#form-edit").valid();
            if (validate) {
                $("#form-edit");
                prosesEdit();
            }
        });

        $("#form-edit").validate({
            rules: {
                jenisEdit: {
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

        $("#form-jenis-buku").validate({
            rules: {
                jenis: {
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
            var jenis = $('#jenis').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/JenisBuku/tambah") ?>",
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
                    jenis_buku: jenis
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Jenis Buku',
                        text: jenis,
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        function prosesEdit() {
            var jenisBuku = $('#jenisEdit').val();
            var idJenis = $('#idJenis').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/jenisBuku/prosesEdit") ?>",
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
                    jenis_buku: jenisBuku,
                    id: idJenis
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Jenis Buku',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-jenis-buku').on('click', '.hapus', function() {
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
                        url: "<?= base_url('buku/jenisBuku/delete') ?>",
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