<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        check_admin();
        $this->load->model(array("Buku_m", "Penulis_m", "Penerbit_m", "Rak_m", "JenisBuku_m"));
    }
    public function index()
    {
        $userData = userData();
        $list = $this->Buku_m->getAll();
        $penulis = $this->Penulis_m->getAll();
        $penerbit = $this->Penerbit_m->getAll();
        $jenis = $this->JenisBuku_m->getAll();
        $rak = $this->Rak_m->getAll();
        $data = array(
            "title" => "Buku",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/buku/v_buku",
            "buku" => $list,
            "penulis" => $penulis,
            "penerbit" => $penerbit,
            "rak" => $rak,
            "jenis" => $jenis,
        );
        $this->load->view('template/main', $data);
    }

    public function tambah()
    {
        $data = array(
            "kode_buku" => $this->input->post("kode_buku", true),
            "judul_buku" => $this->input->post("judul_buku", true),
            "jumlah_buku" => $this->input->post("jumlah_buku", true),
            "tahun_terbit" => $this->input->post("tahun_terbit", true),
            "penerbit_id" => $this->input->post("penerbit_id"),
            "penulis_id" => $this->input->post("penulis_id", true),
            "rak_id" => $this->input->post("rak_id", true),
            "jenis_id" => $this->input->post("jenis_id", true),
        );

        $this->Buku_m->insert($data);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $this->Buku_m->delete($id);
    }

    public function restore()
    {
        $id = $this->input->post("id");
        $this->Buku_m->restore($id);
    }

    public function detail($id)
    {
        $userData = userData();
        $buku = $this->Buku_m->getPrimaryKey($id);
        $penulis = $this->Penulis_m->getAll();
        $penerbit = $this->Penerbit_m->getAll();
        $jenis = $this->JenisBuku_m->getAll();
        $rak = $this->Rak_m->getAll();
        $data = array(
            "title" => "Detail Buku",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "buku/buku/v_detail_buku",
            "buku" => $buku,
            "penulis" => $penulis,
            "penerbit" => $penerbit,
            "rak" => $rak,
            "jenis" => $jenis,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesEdit()
    {
        $id = $this->input->post("id", true);
        $buku = array(
            "judul_buku" => $this->input->post("judul_buku", true),
            "jumlah_buku" => $this->input->post("jumlah_buku", true),
            "tahun_terbit" => $this->input->post("tahun_terbit", true),
            "penerbit_id" => $this->input->post("penerbit_id"),
            "penulis_id" => $this->input->post("penulis_id", true),
            "rak_id" => $this->input->post("rak_id", true),
            "jenis_id" => $this->input->post("jenis_id", true),
        );
        $this->Buku_m->update($id, $buku);
    }

    public function print($id)
    {
        // $userData = userData();
        $buku = $this->Buku_m->getPrimaryKey($id);
        $data = array(
            "buku" => $buku
        );
        $html = $this->load->view('buku/buku/print', $data, true);
        $this->fungsi->pdfGenerator($html, 'Barcode', 'C7', 'portrait');
    }
}
