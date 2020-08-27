<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="post">
                        <p class="lead">Buku</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Kode Buku</th>
                                    <td><?= $buku->kode_buku ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Barcode</th>
                                    <td>
                                        <?php $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                                        echo $generator->getBarcode($buku->kode_buku, $generator::TYPE_CODE_128);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Judul</th>
                                    <td><?= $buku->judul_buku ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Jumlah Buku</th>
                                    <td><?= $buku->jumlah_buku ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Tahun Terbit</th>
                                    <td><?= $buku->tahun_terbit ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Penulis</th>
                                    <td><?= $buku->penulis ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Penerbit</th>
                                    <td><?= $buku->penerbit ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Jenis Buku</th>
                                    <td><?= $buku->jenis_buku ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Rak</th>
                                    <td><?= $buku->kode_rak ?></td>
                                </tr>
                            </table>
                            <a href="<?= base_url("buku/buku") ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            <a href="<?= base_url('buku/buku/print/') . $buku->id_buku ?>" target="_blank" id="cetak" class="btn btn-success"><i class="fas fa-print"></i> Cetak Barcode</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Buku</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-buku">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $buku->judul_buku ?>" id="judul" name="judul">
                        <input type="hidden" value="<?= $buku->id_buku ?>" id="idBuku" name="idBuku">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $buku->jumlah_buku ?>" id="jumlah" name="jumlah">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $buku->tahun_terbit ?>" id="tahun" name="tahun">
                    </div>
                    <div class="form-group">
                        <select id="penulis" name="penulis" class="form-control select2" style="width: 100%;">
                            <?php
                            foreach ($penulis as $pn) { ?>
                                <option value='<?= $pn->id_penulis ?>' <?= $pn->id_penulis == $buku->penulis_id ? "selected" : null ?>> <?= $pn->penulis ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="penerbit" name="penerbit" class="form-control select2" style="width: 100%;">
                            <?php
                            foreach ($penerbit as $pr) { ?>
                                <option value='<?= $pr->id_penerbit ?>' <?= $pr->id_penerbit == $buku->penerbit_id ? "selected" : null ?>> <?= $pr->penerbit ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="jenis" name="jenis" class="form-control select2" style="width: 100%;">
                            <?php
                            foreach ($jenis as $jn) { ?>
                                <option value='<?= $jn->id_jenis ?>' <?= $jn->id_jenis == $buku->jenis_id ? "selected" : null ?>> <?= $jn->jenis_buku ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="rak" name="rak" class="form-control select2" style="width: 100%;">
                            <?php
                            foreach ($rak as $rk) { ?>
                                <option value='<?= $rk->id_rak ?>' <?= $rk->id_rak == $buku->rak_id ? "selected" : null ?>> <?= $rk->kode_rak ?> </option>
                            <?php } ?>
                        </select>
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
        $('#penulis').select2();
        $('#penerbit').select2();
        $('#jenis').select2();
        $('#rak').select2();

        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit-buku").valid();
            if (validate) {
                $("#form-edit-buku");
                prosesEdit();
            }
        });
        $("#form-edit-buku").validate({
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

        function prosesEdit() {
            var judul = $('#judul').val();
            var kode = $('#kode').val();
            var jumlah = $('#jumlah').val();
            var tahun = $('#tahun').val();
            var penerbit = $('#penerbit').val();
            var penulis = $('#penulis').val();
            var jenis = $('#jenis').val();
            var rak = $('#rak').val();
            var idbuku = $('#idBuku').val();
            $.ajax({
                type: "post",
                url: "<?= base_url("buku/buku/prosesEdit") ?>",
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
                    id: idbuku,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Buku',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        };
    });
</script>