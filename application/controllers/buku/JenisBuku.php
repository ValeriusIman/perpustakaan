<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisBuku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
        $this->load->model(array("JenisBuku_m"));
    }
    public function index()
    {
        $userData = userData();
        $list = $this->JenisBuku_m->getAll();
        $data = array(
            "title" => "Jenis Buku",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/jenis/v_jenis",
            "jenis" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $jenis = array(
            "jenis_buku" => $this->input->post("jenis_buku", true)
        );
        $this->JenisBuku_m->insert($jenis);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->JenisBuku_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->JenisBuku_m->restore($id);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id", true);
        $jenis = array(
            "jenis_buku" => $this->input->post("jenis_buku", true),
        );
        $this->JenisBuku_m->update($id, $jenis);
    }
}
