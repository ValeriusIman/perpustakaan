<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Karyawan_m"));
    }
    public function index()
    {
        check_admin();
        $userData = userData();
        $list = $this->Karyawan_m->getAll();
        $data = array(
            "title" => "Karyawan",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/karyawan/v_karyawan",
            "karyawan" => $list,
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $prodi = array(
            "user_name" => $this->input->post("user_name", true),
            "password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
            "nama_karyawan" => $this->input->post("nama", true),
            "no_telp" => $this->input->post("no_telp", true),
            "jenis_kelamin" => $this->input->post("jenis_kelamin", true),
            "tanggal_lahir" => $this->input->post("tanggal", true),
            "alamat" => $this->input->post("alamat", true),
            "level" => $this->input->post("level", true),
            "date_created" => $this->input->post("tanggal_buat", true),
        );
        $this->Karyawan_m->insert($prodi);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Karyawan_m->delete($id);
    }

    public function restore()
    {

        $id = $this->input->post("id");
        $this->Karyawan_m->restore($id);
    }

    public function detail($id)
    {
        $userData = userData();
        $karyawan = $this->Karyawan_m->getPrimaryKey($id);
        $data = array(
            "title" => "Detail Karyawan",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/karyawan/v_detail_karyawan",
            "karyawan" => $karyawan,
        );
        $this->load->view('template/main', $data);
    }

    public function ubahPassword($id)
    {
        $userData = userData();
        $karyawan = $this->Karyawan_m->getPrimaryKey($id);
        $data = array(
            "title" => "Ubah Password",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/karyawan/v_ubah_password",
            "karyawan" => $karyawan,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id_karyawan", true);
        $karyawan = array(
            "nama_karyawan" => $this->input->post("nama_karyawan", true),
            "no_telp" => $this->input->post("telp", true),
            "jenis_kelamin" => $this->input->post("jenis_kelamin", true),
            "alamat" => $this->input->post("alamat", true),
            "tanggal_lahir" => $this->input->post("tanggal_lahir", true),
        );
        $this->Karyawan_m->update($id, $karyawan);
    }

    public function prosesEditPassword()
    {
        $id = $this->input->post("id", true);
        $karyawan = array(
            "user_name" =>  $this->input->post("user_name", true),
            "password" => password_hash($this->input->post("password", true), PASSWORD_DEFAULT),
        );
        $this->Karyawan_m->update($id, $karyawan);
    }
}
