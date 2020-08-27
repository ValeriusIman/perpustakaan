<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>Print Barcode</title>
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

        .table {
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

<body>
    <?php $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    for ($i = 1; $i <= 10; $i++) {
        // 
        echo $buku->kode_buku . "<p>";
        echo $generator->getBarcode($buku->kode_buku, $generator::TYPE_CODE_128);
    }

    ?>

</body>

</html>