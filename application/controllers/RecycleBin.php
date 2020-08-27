<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecycleBin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
    }

    public function hapusAnggota()
    {
        $this->load->model("Anggota_m");
        $list = $this->Anggota_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Anggota",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/anggota/v_anggota_hapus",
            "anggota" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusKaryawan()
    {
        $this->load->model("Karyawan_m");
        $list = $this->Karyawan_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Karyawan",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/karyawan/v_karyawan_hapus",
            "karyawan" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusJenis()
    {
        $this->load->model("Penerbit_m");
        $list = $this->JenisBuku_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Jenis Buku",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/jenis/v_jenis_hapus",
            "jenis" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusPenerbit()
    {
        $this->load->model("JenisBuku_m");
        $list = $this->Penerbit_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Penerbit",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penerbit/v_penerbit_hapus",
            "penerbit" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusPenulis()
    {
        $this->load->model("Penulis_m");
        $list = $this->Penulis_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Penulis",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penulis/v_penulis_hapus",
            "penulis" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusRak()
    {
        $this->load->model("Rak_m");
        $list = $this->Rak_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Rak",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/rak/v_rak_hapus",
            "rak" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function hapusBuku()
    {
        $this->load->model("Buku_m");
        $list = $this->Buku_m->getHapus();
        $userData = userData(); //fungsi_helper
        $data = array(
            "title" => "Recycle Bin Buku",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/buku/v_buku_hapus",
            "buku" => $list,
        );
        $this->load->view('template/main', $data);
    }
}
