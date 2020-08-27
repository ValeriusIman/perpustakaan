<div class="row">
    <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-book"></i> PERPUSTAKAAN
                        <small class="float-right">Date: <?= $pinjam->tanggal_pinjam ?></small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <strong><?= $pengaturan->nama_kampus ?></strong>
                    <address>
                        <?= $pengaturan->alamat ?><br>
                        Telp: <?= $pengaturan->no_telp ?><br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <b>No. Peminjaman : <?= $pinjam->no_peminjaman ?></b><br>
                    <br>
                    <b>PTG :</b> <?= $pinjam->nama_karyawan ?><br>
                    <b>AGT :</b> <?= $pinjam->nama_anggota ?><br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Jenis</th>
                                <th>Penulis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($item as $it) { ?>
                                <tr>
                                    <th><?= $it->kode_buku ?></th>
                                    <td><?= $it->judul_buku ?></td>
                                    <td><?= $it->jenis_buku ?></td>
                                    <td><?= $it->penulis ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Status:</th>
                                <td>
                                    <?php
                                    $tanggalKembali = (abs(strtotime($pinjam->tanggal_kembali)));
                                    $tanggalSekarang = (abs(strtotime(date('Y-m-d'))));
                                    $asd = (abs(strtotime(date('Y-m-d')) - strtotime($pinjam->tanggal_kembali))) / (60 * 60 * 24);
                                    if ($tanggalSekarang < $tanggalKembali) {
                                        echo "Dipinjam";
                                    } else {
                                        echo "Terlambat " . $asd . " Hari";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-12">
                    <a href="<?= base_url('app/pinjam/dataPeminjam') ?>" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                </div>
            </div>
        </div>
        <!-- /.invoice -->
    </div><!-- /.col -->
</div>