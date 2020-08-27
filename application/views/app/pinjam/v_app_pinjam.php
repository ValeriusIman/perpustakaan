<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-sm-5">
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-4 col-form-label">Tanggal Pinjam</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="tanggalPinjam" name="tanggalPinjam" value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-4 col-form-label">Tanggal Kembali</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="tanggalKembali" name="tanggalKembali">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kasir" class="col-sm-4 col-form-label">Penjaga</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" value="<?= $this->session->userdata('nama') ?>" readonly>
                                    <input type="hidden" id="penjaga" name="penjaga" class="form-control" value="<?= $this->session->userdata('karyawan_id') ?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="supplier" class="col-sm-3 col-form-label">Anggota</label>
                                <div class="col-7">
                                    <select id="anggota" name="anggota" class="form-control select2" style="width: 100%;">
                                        <option value=""></option>
                                        <?php
                                        foreach ($anggota as $ag) {
                                            echo "<option value='$ag->id_anggota'> $ag->nama_anggota </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" id="btn-sup" class="btn btn-primary">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="barang" class="col-sm-3 col-form-label">Buku</label>
                                <div class="col-7">
                                    <select id="buku" name="buku" class="form-control select2" style="width: 100%;">
                                        <option value=""></option>
                                        <?php
                                        foreach ($buku as $bk) {
                                            echo "<option data-judul='$bk->judul_buku' "
                                                . "data-kode='$bk->kode_buku'"
                                                . "data-jenis='$bk->jenis_buku'"
                                                . "data-jumlah='$bk->jumlah_buku'"
                                                . "data-penulis='$bk->penulis'"
                                                . "data-buku='$bk->jenis_id'"
                                                . "value='$bk->id_buku'> $bk->kode_buku/$bk->judul_buku </option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" id="judul" name="judul">
                                    <input type="hidden" id="kode" name="kode">
                                    <input type="hidden" id="jenis" name="jenis">
                                    <input type="hidden" id="jumlah" name="jumlah">
                                    <input type="hidden" id="penulis" name="penulis">
                                    <input type="hidden" id="jenisId" name="jenisId">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-10">
                                    <button type="button" id="btn-add-item" class="btn btn-primary">
                                        Tambah Buku
                                    </button>
                                    <button type="button" id="proses" class="btn btn-success">
                                        Proses
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-item" class="table">
                    <thead>
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Penulis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {

        $('#tanggalKembali').datepicker({
            format: "yyyy-mm-dd",
            startDate: '+d'
            // endDate: '-17y'
        });

        $('#anggota').select2({
            placeholder: "Pilih Anggota"
        }).on("change", function() {
            $('#anggota').prop("disabled", true);
        });

        $("#btn-sup").click(function() {
            $('#anggota').prop("disabled", false);
        })

        $('#buku')
            .select2({
                placeholder: "Pilih Buku"
            })
            .on("change", function() {
                var optionSelected = $(this).children("option:selected");
                $("#judul").val(optionSelected.data("judul"));
                $("#kode").val(optionSelected.data("kode"));
                $("#jenis").val(optionSelected.data("jenis"));
                $("#jumlah").val(optionSelected.data("jumlah"));
                $("#penulis").val(optionSelected.data("penulis"));
                $("#jenisId").val(optionSelected.data("buku"));
            });


        function addItem() {

            let kodeBuku = $("#kode").val();
            let judul = $("#judul").val();
            let penulis = $("#penulis").val();
            let jenis = $("#jenis").val();
            let jumlah = $("#jumlah").val();
            let idBuku = $("#buku").val();
            let jenisId = $("#jenisId").val();
            if (kodeBuku == "") {
                swal({
                    text: 'Buku Belum Di Pilih',
                    type: 'error'
                })
            } else {
                if (jumlah < 5) {
                    swal({
                        text: 'Stock Buku kurang Dari 5, Buku Tidak Boleh Di Pinjam',
                        type: 'error'
                    })
                } else {
                    let tr = `<tr data-buku="${idBuku}">`;
                    tr += `<td id="kode">${kodeBuku}</td>`;
                    tr += `<td>${judul}</td>`; //1
                    tr += `<td>${jenis}</td>`;
                    tr += `<td>${penulis}</td>`;
                    tr += `<td>`;
                    tr += `<button class="btn btn-xs btn-del-item btn-danger"> <i class="fas fa-trash"></i></button>`;
                    tr += `</td>`;
                    tr += `<td>`;
                    tr += `<input type='hidden' name='id' id='asd' class='cari-id' value='${idBuku}'/>`;
                    tr += `</td>`;
                    tr += `</tr>`;
                    $("#table-item tbody").append(tr);
                    $("#buku").val("").trigger("change");
                    $("#kode").val("");
                    $("#juduk").val("");
                    $("#penulis").val("");
                    $("#jenis").val("");
                    $("#jenisId").val("");
                    $(".btn-del-item").on("click", function() {
                        $(this).parent().parent().remove();
                    });
                }
            }
        }
        $("#btn-add-item").on("click", function(event) {
            event.preventDefault();
            // addItem();
            var bolehTambah = true;
            $('.cari-id').each(function() {
                var cariId = $(this).val();
                let idBuku = $("#buku").val();
                if (parseInt(cariId) === parseInt(idBuku)) {
                    bolehTambah = false;
                    swal({
                        text: 'Buku Tidak Boleh Lebih Dari 1',
                        type: 'error'
                    })
                }
            })

            if (bolehTambah) {
                addItem();
            }
        });

        $("#proses").on('click', function() {
            // prosesTransaksi();
            let idKaryawan = $("#penjaga").val();
            let tanggalPinjam = $("#tanggalPinjam").val();
            let tanggalKembali = $('#tanggalKembali').val();
            let idAnggota = $('#anggota').val();
            let rows = $("#table-item tbody tr");
            let itemPinjam = [];
            rows.each(function() {
                let row = $(this);
                let item = {
                    buku_id: row.data("buku"),
                };
                itemPinjam.push(item);
            });
            let dataKirim = JSON.stringify(itemPinjam);
            if (itemPinjam == false) {
                swal({
                    title: 'Buku belum dipilih',
                    type: 'error'
                })
            } else {
                $.ajax({
                    url: "<?= base_url("app/Pinjam/prosesPinjam") ?>",
                    type: "POST",
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
                        item_pinjam: dataKirim,
                        id_karyawan: idKaryawan,
                        id_anggota: idAnggota,
                        tanggal_pinjam: tanggalPinjam,
                        tanggal_kembali: tanggalKembali,
                        proses: true
                    },
                    dataType: "JSON",
                    success: function(result) {

                        if (result.success) {
                            //success
                            swal({
                                title: 'Transaksi Berhasil',
                                type: 'success'
                            })
                            window.open("<?= base_url('app/pinjam/print/') ?>" + result.id_pinjam + "_blank");
                            window.location.replace("<?= base_url("app/pinjam") ?>");
                        } else {
                            //error
                            alert("Error proses Transaksi");
                        }

                    }
                });
            }
        });

    });
</script>