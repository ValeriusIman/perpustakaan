<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Print Nota</title>
    <style type="text/css">
        html {
            font-family: "verdana, arial";
        }

        .content {
            width: 80mm;
            font-size: 12px;
            padding: 5px
        }

        .title {
            text-align: center;
            font-size: 13px;
            padding-bottom: 5px;
            border-bottom: 1px dashed;
        }

        .head {
            margin-top: 5px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        .thanks {
            margin-top: 10px;
            padding-top: 10px;
            text-align: center;
            border-top: 1px dashed;
        }

        @media print {
            @page {
                width: 80px;
                margin: 0mm;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="content">
        <div class="title">
            PERPUSTAKAAN
            <br>
            <b><?= $pengaturan->nama_kampus ?></b><br>
            <?= $pengaturan->alamat ?><br>
            No.Telp : <?= $pengaturan->no_telp ?><br>
        </div>

        <div class="head">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td>PTG</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $kembali->nama_karyawan ?></td>
                    <td style="text-align: right"><?= $kembali->no_pengembalian ?></td>
                </tr>
                <tr>
                    <td>AGT</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $kembali->nama_anggota ?></td>
                    <td style="text-align: right"><?= $kembali->tanggal ?></td>
                </tr>
            </table>
        </div>
        <div class="transaction">
            <table class="transaction-table" cellspacing="0" cellpadding="0">
                <?php
                foreach ($item as $it) { ?>
                    <tr>
                        <td style="width: 50px"><?= $it->kode_buku ?></td>
                        <td style="width: 50px"><?= $it->judul_buku ?> </td>
                        <td style="width: 50px"><?= $it->jenis_buku ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="thanks">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td>Terlambat</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td style="text-align: right"><?= $kembali->terlambat ?> Hari</td>
                </tr>
                <tr>
                    <td>Denda</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td style="text-align: right"><?= formatRupiah($kembali->denda) ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td style="text-align: right"><?= formatRupiah($kembali->total) ?></td>
                </tr>
                <tr>
                    <td>Tunai</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td style="text-align: right"><?= formatRupiah($kembali->bayar) ?></td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td style="text-align: right"><?= formatRupiah($kembali->kembalian) ?></td>
                </tr>
            </table>
        </div>
        <div class="thanks">
            ***Trimakasih sudah membaca***
        </div>
    </div>

</body>

</html>