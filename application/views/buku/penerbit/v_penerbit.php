<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Penerbit</h3>
            </div>
            <div class="card-body">
                <table id="data-penerbit" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penerbit</th>
                            <th>Telp</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($penerbit as $pr) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $pr->penerbit ?></td>
                                <td><?= $pr->telp ?></td>
                                <td><?= $pr->email ?></td>
                                <td><?= $pr->alamat ?></td>
                                <td>
                                    <a href="<?= base_url('buku/penerbit/edit/' . $pr->id_penerbit) ?>" class="btn btn-sm btn-success edit"><i class="fas fa=fw fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $pr->id_penerbit ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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
                <h3 class="card-title">Tambah Penerbit</h3>
            </div>
            <div class="card-body">
                <form id="form-penerbit" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="No.Telp" id="noTelp" name="noTelp" data-inputmask='"mask": "9999-9999-9999"' data-mask>
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
        var data = $("#data-penerbit").DataTable({
            "responsive": true,
            "autoWidth": false
        });

        $('[data-mask]').inputmask()


        $("#btn-simpan").on('click', function() {
            let validate = $("#form-penerbit").valid();
            if (validate) {
                $("#form-penerbit");
                prosesTambah();
            }
        });
        $("#form-penerbit").validate({
            rules: {
                penerbit: {
                    required: true
                },
                email: {
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
            var penerbit = $('#penerbit').val();
            var noTelp = $('#noTelp').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/penerbit/tambah") ?>",
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
                    no_telp: noTelp,
                    email: email,
                    alamat: alamat
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Penerbit',
                        text: penerbit,
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-penerbit').on('click', '.hapus', function() {
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
                        url: "<?= base_url('buku/penerbit/delete') ?>",
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