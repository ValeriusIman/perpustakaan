<section class="content">
    <div class="card">
        <div class="card-body">
            <table id="data-kembali" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:1px;">No</th>
                        <th>No Pengembalian</th>
                        <th>Tanggal Kembali</th>
                        <th>Petugas</th>
                        <th>Anggota</th>
                        <th style="text-align:center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kembali as $km) {
                    ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $km->no_pengembalian ?></td>
                            <td><?= $km->tanggal ?></td>
                            <td><?= $km->nama_karyawan ?></td>
                            <td><?= $km->nama_anggota ?></td>
                            <td>
                                <a href="<?= base_url('app/kembali/detail/') . $km->id_kembali ?>" class="btn btn-success">
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
        var data = $("#data-kembali").DataTable({
            "responsive": true,
            "autoWidth": false
        });
    })
</script>