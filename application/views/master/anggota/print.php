<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Print Kartu Anggota</title>
    <style type="text/css">
        html {
            font-family: "verdana, arial";
        }

        .content {
            width: 100mm;
            font-size: 12px;
            padding: 5px;
            border: 1px solid black;
        }

        .title {
            text-align: center;
            font-size: 13px;
            padding-bottom: 5px;
            border-bottom: 1px solid;
        }

        .head {
            margin-top: 5px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            /* border-bottom: 1px solid; */
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

        table {
            border-collapse: collapse;
            width: 100%;
            /* border: 1px solid black; */
        }
    </style>
</head>

<body onload="window.print()">
    <div class="content">
        <div class="title">
            KARTU ANGGOTA PERPUSTAKAAN
            <br>
            <b><?= $pengaturan->nama_kampus ?></b><br>
        </div>

        <div class="head">
            <table class="">
                <tr>
                    <td style="width: 150px;">No. Anggota</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $anggota->no_anggota ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $anggota->nama_anggota ?></td>
                </tr>
                <tr>
                    <td>No. Mahasiswa</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $anggota->no_mahasiswa ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td style="text-align: center; width: 10px">:</td>
                    <td><?= $anggota->alamat ?></td>
                </tr>
            </table>
            <br>
            <?php $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            echo $generator->getBarcode($anggota->no_anggota, $generator::TYPE_CODE_128);
            ?>
        </div>
    </div>

</body>

</html>