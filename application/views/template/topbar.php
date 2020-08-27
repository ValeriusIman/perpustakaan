<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user"></i> <?= $userData['nama_karyawan'] ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('master/karyawan/detail/' . $userData['id_karyawan']) ?>" class="dropdown-item">
                <i class="fas fa-fw fa-user mr-2"></i>My Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#staticBackdrop">
                <i class="fas fa-fw fa-power-off mr-2"></i>Keluar
            </a>
    </li>
</ul>