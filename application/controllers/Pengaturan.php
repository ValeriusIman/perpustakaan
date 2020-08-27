<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Pengaturan_m"));
    }

    public function pengaturan($id)
    {
        $userData = userData();
        $pengaturan = $this->Pengaturan_m->getPrimaryKey($id);
        $data = array(
            "title" => "Pengaturan",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "pengaturan/v_pengaturan",
            "pengaturan" => $pengaturan,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id_pengaturan", true);
        $data = array(
            "nama_kampus" => $this->input->post("nama", true),
            "no_telp" => $this->input->post("no_telp", true),
            "alamat" => $this->input->post("alamat", true),
        );
        $this->Pengaturan_m->update($id, $data);
    }
}
