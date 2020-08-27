<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Buku</h3>
            </div>
            <div class="card-body">
                <table id="data-buku" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($buku as $bk) { ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= $bk->kode_buku ?></td>
                                <td><?= $bk->judul_buku ?></td>
                                <td><?= $bk->jumlah_buku ?></td>
                                <td>
                                    <a href="<?= base_url('buku/buku/detail/' . $bk->id_buku) ?>" class="btn btn-sm btn-success"><i class="fas fa=fw fa-eye"></i></a>
                                    <button class="btn btn-sm btn-danger hapus" data-id="<?= $bk->id_buku ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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
                <h3 class="card-title">Tambah Buku</h3>
            </div>
            <div class="card-body">
                <form id="form-buku" class="form-horizontal">
                    <div class="form-group">
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Buku">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Buku">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah buku">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tahun" name="tahun" placeholder="Tahun Terbit">
                    </div>
                    <div class="form-group">
                        <select id="penerbit" name="penerbit" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($penerbit as $pn) {
                                echo "<option value='$pn->id_penerbit'> $pn->penerbit </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="penulis" name="penulis" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($penulis as $pl) {
                                echo "<option value='$pl->id_penulis'> $pl->penulis </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="jenis" name="jenis" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($jenis as $jn) {
                                echo "<option value='$jn->id_jenis'> $jn->jenis_buku </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="rak" name="rak" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($rak as $rk) {
                                echo "<option value='$rk->id_rak'> $rk->kode_rak </option>";
                            }
                            ?>
                        </select>
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
        var data = $("#data-buku").DataTable({
            "responsive": true,
            "autoWidth": false
        });
        $('#penerbit').select2({
            placeholder: "Pilih Penerbit"
        });
        $('#penulis').select2({
            placeholder: "Pilih Penulis"
        });
        $('#jenis').select2({
            placeholder: "Pilih Jenis Buku"
        });
        $('#rak').select2({
            placeholder: "Pilih Rak"
        });

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-buku").valid();
            if (validate) {
                $("#form-buku");
                prosesTambah();
            }
        });
        $("#form-buku").validate({
            rules: {
                kode: {
                    required: true
                },
                judul: {
                    required: true
                },
                jumlah: {
                    required: true,
                    digits: true
                },
                tahun: {
                    required: true,
                    digits: true
                },
                penerbit: {
                    required: true
                },
                penulis: {
                    required: true
                },
                jenis: {
                    required: true
                },
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
            var judul = $('#judul').val();
            var kode = $('#kode').val();
            var jumlah = $('#jumlah').val();
            var tahun = $('#tahun').val();
            var penerbit = $('#penerbit').val();
            var penulis = $('#penulis').val();
            var jenis = $('#jenis').val();
            var rak = $('#rak').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/buku/tambah") ?>",
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
                    kode_buku: kode,
                    judul_buku: judul,
                    jumlah_buku: jumlah,
                    tahun_terbit: tahun,
                    penerbit_id: penerbit,
                    penulis_id: penulis,
                    jenis_id: jenis,
                    rak_id: rak,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Menambah Buku',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }

        $('#data-buku').on('click', '.hapus', function() {
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
                        url: "<?= base_url('buku/buku/delete') ?>",
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