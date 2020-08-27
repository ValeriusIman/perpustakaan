<html moznomarginboxes mozdisallowselectionprint>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PENGEMBALIAN</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .line-title {
            border: 0;
            border-style: inset;
            border-top: 1px solid #000;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>
            <td align="center">
                <span style="line-height: 1.6; font-weight: bold;">
                    LAPORAN PENGEMBALIAN PRIODE <?= $awal ?> s/d <?= $akhir ?>
                    <br>PERPUSTAKAAN
                    <br><?= $pengaturan->nama_kampus ?>
                    <br><?= $pengaturan->alamat ?>
                    <br>Telp : <?= $pengaturan->no_telp ?>
                </span>
            </td>
        </tr>
    </table>
    <hr class="line-title">

    <?php
    foreach ($kembali as $km) {
        // for ($i = $km->id_transaksi; $i <= $km->transaksi_id; $i++) {
    ?>
        No.Pengembalian :<?= $km->no_pengembalian ?><br>
        Petugas :<?= $km->nama_karyawan ?><br>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Jenis</th>
                    <th>Penulis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) {
                    if ($item->kembali_id == $km->id_kembali) { ?>
                        <tr>
                            <td><?= $item->kode_buku ?></td>
                            <td><?= $item->judul_buku ?></td>
                            <td><?= $item->jenis_buku ?></td>
                            <td><?= $item->penulis ?></td>
                        </tr>
                <?php }
                } ?>
                <tr>
                    <td colspan="3" align="center">Terlambat</td>
                    <td><?= $km->terlambat ?> Hari</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">Denda</td>
                    <td><?= formatRupiah($km->denda) ?></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">Total</td>
                    <td><?= formatRupiah($km->total) ?></td>
                </tr>
            </tbody>
            <br>
        </table>
    <?php } ?>
</body>
<!-- <script type="text/javascript">
    window.addEventListener("load", window.print());
</script> -->

</html>