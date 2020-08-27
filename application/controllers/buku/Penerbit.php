<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerbit extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
        $this->load->model(array("Penerbit_m"));
    }
    public function index()
    {
        $userData = userData();
        $list = $this->Penerbit_m->getAll();
        $data = array(
            "title" => "Penerbit",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penerbit/v_penerbit",
            "penerbit" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function edit($id)
    {
        $userData = userData();
        $list = $this->Penerbit_m->getPrimaryKey($id);
        $data = array(
            "title" => "Edit Penerbit",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penerbit/v_penerbit_edit",
            "penerbit" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $penerbit = array(
            "penerbit" => $this->input->post("penerbit", true),
            "telp" => $this->input->post("no_telp", true),
            "email" => $this->input->post("email", true),
            "alamat" => $this->input->post("alamat", true),
        );
        $this->Penerbit_m->insert($penerbit);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Penerbit_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->Penerbit_m->restore($id);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id", true);
        $penerbit = array(
            "penerbit" => $this->input->post("penerbit", true),
            "telp" => $this->input->post("telp", true),
            "email" => $this->input->post("email", true),
            "alamat" => $this->input->post("alamat", true),
        );
        $this->Penerbit_m->update($id, $penerbit);
    }
}
