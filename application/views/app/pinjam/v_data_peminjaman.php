<section class="content">
    <div class="card">
        <div class="card-body">
            <table id="data-pinjam" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:1px;">No</th>
                        <th>No Peminjaman</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Petugas</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th style="text-align:center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($pinjam as $pj) {
                    ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $pj->no_peminjaman ?></td>
                            <td><?= $pj->tanggal_pinjam ?></td>
                            <td><?= $pj->tanggal_kembali ?></td>
                            <td><?= $pj->nama_karyawan ?></td>
                            <td><?= $pj->nama_anggota ?></td>
                            <td><?php
                                $tanggalKembali = (abs(strtotime($pj->tanggal_kembali)));
                                $tanggalSekarang = (abs(strtotime(date('Y-m-d'))));
                                $asd = (abs(strtotime(date('Y-m-d')) - strtotime($pj->tanggal_kembali))) / (60 * 60 * 24);
                                if ($tanggalSekarang <= $tanggalKembali) {
                                    echo "Dipinjam";
                                } else {
                                    echo "Terlambat " . $asd . " Hari";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('app/pinjam/detail/') . $pj->id_peminjaman ?>" class="btn btn-success">
                                    <i class="fas fa=fw fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    $(function() {
        var data = $("#data-pinjam").DataTable({
            "responsive": true,
            "autoWidth": false
        });
    })
</script>