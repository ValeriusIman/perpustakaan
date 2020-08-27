<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penulis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
        $this->load->model(array("Penulis_m"));
    }
    public function index()
    {
        $userData = userData();
        $list = $this->Penulis_m->getAll();
        $data = array(
            "title" => "Penulis",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penulis/v_penulis",
            "penulis" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function edit($id)
    {
        $userData = userData();
        $list = $this->Penulis_m->getPrimaryKey($id);
        $data = array(
            "title" => "Edit Penulis",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/penulis/v_penulis_edit",
            "penulis" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $penerbit = array(
            "penulis" => $this->input->post("penulis", true),
            "email" => $this->input->post("email", true),
            "alamat" => $this->input->post("alamat", true),
        );
        $this->Penulis_m->insert($penerbit);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Penulis_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->Penulis_m->restore($id);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id", true);
        $penerbit = array(
            "penulis" => $this->input->post("penulis", true),
            "email" => $this->input->post("email", true),
            "alamat" => $this->input->post("alamat", true),
        );
        $this->Penulis_m->update($id, $penerbit);
    }
}
