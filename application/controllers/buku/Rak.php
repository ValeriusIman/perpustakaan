<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
        $this->load->model(array("Rak_m"));
    }

    public function index()
    {
        $userData = userData();
        $list = $this->Rak_m->getAll();
        $data = array(
            "title" => "Rak",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/rak/v_rak",
            "rak" => $list
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $fakultas = array(
            "kode_rak" => $this->input->post("kode_rak", true)
        );
        $this->Rak_m->insert($fakultas);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Rak_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->Rak_m->restore($id);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id", true);
        $fakultas = array(
            "kode_rak" => $this->input->post("kode_rak", true),
        );
        $this->Rak_m->update($id, $fakultas);
    }
}
