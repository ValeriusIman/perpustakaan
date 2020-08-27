<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Anggota_m", "Pengaturan_m"));
    }
    public function index()
    {
        $queryMaxId = "select ifnull(max(nomor),0) as max from anggota "
            . "WHERE MONTH(date_created) = MONTH(NOW()) AND YEAR(date_created)=YEAR(NOW())";
        $max = $this->db->query($queryMaxId)->row()->max;
        $max = (int) $max;
        // "TRX/2020/04/0120"
        $strPad = str_pad($max + 1, 4, "0", STR_PAD_LEFT);
        $noAnggota = date("ymd") . $strPad;

        $userData = userData();
        $list = $this->Anggota_m->getAll();
        $data = array(
            "title" => "Anggota",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/anggota/v_anggota",
            "anggota" => $list,
            "noAnggota" => $noAnggota
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $queryMaxId = "select ifnull(max(nomor),0) as max from anggota "
            . "WHERE MONTH(date_created) = MONTH(NOW()) AND YEAR(date_created)=YEAR(NOW())";
        $max = $this->db->query($queryMaxId)->row()->max;
        $max = (int) $max;
        // $strPad = str_pad($max + 1, 4, "0", STR_PAD_LEFT);
        // $noAnggota = date("ymd") . $strPad;
        $data = array(
            "no_anggota" => $this->input->post("no_anggota", true),
            "nama_anggota" => $this->input->post("nama", true),
            "no_mahasiswa" => $this->input->post("nim", true),
            "telp" => $this->input->post("no_telp", true),
            "tanggal_lahir" => $this->input->post("tanggal"),
            "jenis_kelamin" => $this->input->post("jenis_kelamin", true),
            "alamat" => $this->input->post("alamat", true),
            "nomor" => ($max + 1),
            "date_created" => $this->input->post("tanggal_buat", true),
        );

        $this->Anggota_m->insert($data);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Anggota_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->Anggota_m->restore($id);
    }

    public function detail($id)
    {
        $userData = userData();
        $anggota = $this->Anggota_m->getPrimaryKey($id);
        $data = array(
            "title" => "Detail Anggota",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "master/anggota/v_detail_anggota",
            "anggota" => $anggota,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id_anggota", true);
        $anggota = array(
            "nama_anggota" => $this->input->post("nama_anggota", true),
            "no_mahasiswa" => $this->input->post("no_mahasiswa", true),
            "telp" => $this->input->post("telp", true),
            "jenis_kelamin" => $this->input->post("jenis_kelamin", true),
            "alamat" => $this->input->post("alamat", true),
            "tanggal_lahir" => $this->input->post("tanggal_lahir", true),
        );
        $this->Anggota_m->update($id, $anggota);
    }

    public function print($id)
    {
        // $userData = userData();
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $anggota = $this->Anggota_m->getPrimaryKey($id);
        $data = array(
            "anggota" => $anggota,
            "pengaturan" => $pengaturan
        );
        $html = $this->load->view('master/anggota/print', $data, true);
        $this->fungsi->pdfGenerator($html, 'Kartu Anggota', 'A4', 'portrait');
    }
}
