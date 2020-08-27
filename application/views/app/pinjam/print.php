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
                    <td><?= $pinjam->no_peminjaman ?></td>
                </tr>
                <tr>
                    <td>PTG </td>
                    <td>:</td>
                    <td><?= $pinjam->nama_karyawan ?></td>
                    <td>Pinjam </td>
                    <td>:</td>
                    <td><?= $pinjam->tanggal_pinjam ?></td>
                </tr>
                <tr>
                    <td>AGT </td>
                    <td>:</td>
                    <td><?= $pinjam->nama_anggota ?></td>
                    <td>Kembali </td>
                    <td>:</td>
                    <td><?= $pinjam->tanggal_kembali ?></td>
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
            Mohon periksa kembali buku yang dipinjam.
            <br>
            ***Trimakasih atas kunjungannya***
        </div>
    </div>

</body>

</html>