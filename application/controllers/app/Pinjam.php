<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Buku_m", "Anggota_m", "Pinjam_m", "ItemPinjam_m", "Pengaturan_m"));
    }
    public function index()
    {
        $userData = userData();
        $buku = $this->Buku_m->getJoin();
        $anggota = $this->Anggota_m->getAll();
        $data = array(
            "title" => "Aplikasi Pinjam",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/pinjam/v_app_pinjam",
            "buku" => $buku,
            "anggota" => $anggota,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesPinjam()
    {
        $str_item_pinjam = $this->input->post("item_pinjam");
        $itemPinjam = json_decode($str_item_pinjam);

        //1.cari dulu nilai terbesar dari id yang terakhir
        $queryMaxId = "select ifnull(max(nomor),0) as max from transaksi_pinjam "
            . "WHERE MONTH(tanggal_pinjam) = MONTH(NOW()) AND YEAR(tanggal_pinjam)=YEAR(NOW())";
        $max = $this->db->query($queryMaxId)->row()->max;
        $max = (int) $max;
        // "TRX/2020/04/0120"
        $strPad = str_pad($max + 1, 4, "0", STR_PAD_LEFT);
        $noPeminjaman = "PMJ/" . date("ymd") . $strPad;

        $dataPinjam = array(
            "no_peminjaman" => $noPeminjaman,
            "karyawan_id" => $this->input->post("id_karyawan"),
            "anggota_id" => $this->input->post("id_anggota"),
            "tanggal_pinjam" => $this->input->post("tanggal_pinjam"),
            "tanggal_kembali" => $this->input->post("tanggal_kembali"),
            "nomor" => ($max + 1)
        );
        if (isset($_POST['proses'])) {
            $idPinjam = $this->Pinjam_m->insertGetId($dataPinjam);
            $index = 0;
            foreach ($itemPinjam as $item) {
                $itemPinjam[$index++]->pinjam_id = $idPinjam;
            }
            $this->ItemPinjam_m->insertBatch($itemPinjam);

            if ($this->db->affected_rows() > 0) {
                $pinjam = array("success" => true, "id_pinjam" => $idPinjam);
            } else {
                $pinjam = array("success" => false);
            }
            echo json_encode($pinjam);
        }
    }

    public function print($id)
    {
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $pinjam = $this->Pinjam_m->getJoin($id);
        $item = $this->ItemPinjam_m->joinLengkap($id);
        $data = array(
            "pinjam" => $pinjam,
            "item" => $item,
            "pengaturan" => $pengaturan
        );
        $this->load->view('app/pinjam/print', $data);
    }

    public function detail($id)
    {
        $userData = userData();
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $pinjam = $this->Pinjam_m->getJoin($id);
        $item = $this->ItemPinjam_m->joinLengkap($id);
        $data = array(
            "title" => "Detail Peminjaman",
            "userData" =>  $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/pinjam/v_detail_pinjam",
            "pinjam" => $pinjam,
            "item" => $item,
            "pengaturan" => $pengaturan
        );
        $this->load->view('template/main', $data);
    }

    public function dataPeminjam()
    {
        $userData = userData();
        $pinjam = $this->Pinjam_m->getAll();
        $data = array(
            "title" => "Data Peminjam",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/pinjam/v_data_peminjaman",
            "pinjam" => $pinjam,
        );
        $this->load->view('template/main', $data);
    }
}
