<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Dashboard_m"));
    }

    public function index()
    {
        $userData = userData();
        $karyawan = $this->Dashboard_m->karyawan();
        $anggota = $this->Dashboard_m->anggota();
        $pinjam = $this->Dashboard_m->pinjam();
        $kembali = $this->Dashboard_m->kembali();
        $data = array(
            "title" => "Dashboard",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "template/dashboard",
            "karyawan" => $karyawan,
            "anggota" => $anggota,
            "pinjam" => $pinjam,
            "kembali" => $kembali,
        );
        $this->load->view('template/main', $data);
    }
}
