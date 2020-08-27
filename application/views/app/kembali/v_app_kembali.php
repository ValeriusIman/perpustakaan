<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kasir" class="col-sm-4 col-form-label">Anggota</label>
                                <div class="col-8">
                                    <select id="anggota" name="anggota" class="form-control select2" style="width: 100%;">
                                        <option value=""></option>
                                        <?php
                                        foreach ($anggota as $ag) { ?>
                                            <option value='<?= $ag->id_anggota ?>'> <?= $ag->no_anggota ?>/<?= $ag->nama_anggota ?> </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="supplier" class="col-sm-4 col-form-label">No. PMJ</label>
                                <div class="col-6">
                                    <select id="pinjam" name="pinjam" class="form-control select2" style="width: 100%;">
                                        <option value=""></option>
                                        <?php
                                        foreach ($pinjam as $pj) { ?>
                                            <option data-tanggal='<?= (abs(strtotime($pj->tanggal_kembali))) ?>' value='<?= $pj->id_peminjaman ?>'> <?= $pj->no_peminjaman ?> </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" id="btn-cek" class="btn btn-primary">
                                        Cek
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-5 col-form-label">Terlambat/Hari</label>
                                <div class="col-lg">
                                    <input type="hidden" id="terlambat" name="terlambat">
                                    <input type="text" class="form-control" id="selisih" name="selisih" readonly>
                                    <!-- <input type="text" class="form-control" id="coba" name="coba"> -->
                                    <input type="hidden" id="sekarang" name="sekarang" value="<?= (abs(strtotime(date('Y-m-d'))))  ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-5 col-form-label">Denda</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="denda" name="denda">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-5 col-form-label">Total</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-5 col-form-label">Bayar</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="bayar" name="bayar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-5 col-form-label">Kembalian</label>
                                <div class="col-lg">
                                    <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-5 col-sm-8">
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
                            <th>No.</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Penulis</th>
                        </tr>
                    </thead>
                    <tbody id="keranjang">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {

        $('#anggota').select2({
            placeholder: "Pilih Anggota"
        });
        $('#pinjam').select2({
            placeholder: "No. Peminjaman"
        }).on("change", function() {
            var optionSelected = $(this).children("option:selected");
            var sekarang = $('#sekarang').val()
            $("#terlambat").val(optionSelected.data("tanggal"));
        });

        $(document).ready(function() {
            calculate();
        })
        $(document).on('keyup mouseup', '#denda', function() {
            calculate();
        })
        $(document).on('keyup mouseup', '#bayar', function() {
            var total = $('#total').val()
            if (total == 0) {
                $('#kembalian').val(0)
            } else {
                calculate();
            }
        })

        $("#btn-cek").click('click', function(event) {
            event.preventDefault();
            var filter = $('#pinjam').val();
            var c = $('#terlambat').val()
            var sekarang = $('#sekarang').val()
            var selisihWaktu = (parseInt(sekarang) - parseInt(c)) / (60 * 60 * 24)

            calculate();

            $.ajax({
                url: "<?= base_url('app/kembali/filter') ?>",
                type: "post",
                data: {
                    filter: filter,
                    proses: true
                },
                dataType: "JSON",
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        var no = i + 1;
                        baris += '<tr>' +
                            '<td>' + no + '</td>' +
                            '<td class="hidden">' + data[i].id_buku + '</td>' +
                            '<td>' + data[i].kode_buku + '</td>' +
                            '<td>' + data[i].judul_buku + '</td>' +
                            '<td>' + data[i].jenis_buku + '</td>' +
                            '<td>' + data[i].penulis + '</td>' +
                            '<td class="hidden">' + data[i].qty + '</td>' +
                            '</tr>';
                    }
                    $('#keranjang').html(baris);
                    $('.hidden').hide();

                    if (baris == '') {
                        swal({
                            title: 'Data Tidak Ada',
                            type: 'error'
                        })
                    }
                }
            })
        })

        function calculate() {

            var c = $('#terlambat').val()
            var sekarang = $('#sekarang').val()
            var selisihWaktu = (parseInt(sekarang) - parseInt(c)) / (60 * 60 * 24)
            if (selisihWaktu > 0) {
                $('#selisih').val(selisihWaktu)
            } else {
                $('#selisih').val(0)
                $('#denda').val(0)
            }
            var denda = $('#denda').val()
            var total = selisihWaktu * denda
            if (isNaN(total)) {
                $('#total').val(0)
            } else {
                $('#total').val(total)
            }

            var cash = $('#bayar').val()
            var uangKembali = cash - total
            cash != 0 ? $('#kembalian').val(uangKembali) : $('#kembalian').val(0)
        }


        $("#proses").on('click', function() {
            let tanggal = $("#tanggal").val();
            let idAnggota = $("#anggota").val();
            let pinjam = $('#pinjam').val();
            let terlambat = $('#selisih').val();
            let denda = $('#denda').val();
            let total = $('#total').val();
            let bayar = $('#bayar').val();
            let kembalian = $('#kembalian').val();
            let rows = $("#table-item tbody tr");
            let itemKembali = [];
            rows.each(function() {
                let row = $(this);
                let item = {
                    buku_id: row.children().eq(1).text(),
                    qty: row.children().eq(6).text(),
                };
                itemKembali.push(item);
            });
            let dataKirim = JSON.stringify(itemKembali);
            if (itemKembali == false) {
                swal({
                    text: 'Tidak Ada Data',
                    type: 'error'
                })
            } else if (idAnggota == "") {
                swal({
                    text: 'Anggota Peminjam Belum Di Pilih',
                    type: 'error'
                })
            } else if (terlambat < denda) {
                swal({
                    text: 'Biaya Denda Minimal 500',
                    type: 'error'
                })
            } else if (bayar == "") {
                swal({
                    text: 'Masukan Uang Pembyaran',
                    type: 'error'
                })
            } else if (bayar <= total && bayar <= 0) {
                swal({
                    text: 'Uang Pembyaran Kurang',
                    type: 'error'
                })
            } else {
                $.ajax({
                    url: "<?= base_url("app/kembali/prosesKembali") ?>",
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
                        id_pinjam: pinjam,
                        tanggal: tanggal,
                        terlambat: terlambat,
                        id_anggota: idAnggota,
                        denda: denda,
                        total: total,
                        bayar: bayar,
                        kembalian: kembalian,
                        proses: true,
                        item_kembali: dataKirim
                    },
                    dataType: "JSON",
                    success: function(result) {

                        if (result.success) {
                            //success
                            swal({
                                title: 'Transaksi Berhasil',
                                type: 'success'
                            })
                            window.open("<?= base_url('app/kembali/print/') ?>" + result.id_kembali + "_blank");
                            window.location.replace("<?= base_url("app/kembali") ?>");
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