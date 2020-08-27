<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kembali extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        not_login();
        $this->load->model(array("Buku_m", "Anggota_m", "Pinjam_m", "Kembali_m", "Pengaturan_m", "ItemKembali_m", "Pinjam_m", "ItemPinjam_m"));
    }

    public function index()
    {
        $userData = userData();
        $buku = $this->Buku_m->getJoin();
        $pinjam = $this->Pinjam_m->getAll();
        $anggota = $this->Anggota_m->getAll();
        $data = array(
            "title" => "Aplikasi Kembali",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/kembali/v_app_kembali",
            "buku" => $buku,
            "pinjam" => $pinjam,
            "anggota" => $anggota,
        );
        $this->load->view('template/main', $data);
    }

    public function prosesKembali()
    {
        $str_item_kembali = $this->input->post("item_kembali");
        $idPinjam = $this->input->post("id_pinjam");
        $itemKembali = json_decode($str_item_kembali);
        $this->Kembali_m->delete($idPinjam);

        //1.cari dulu nilai terbesar dari id yang terakhir
        $queryMaxId = "select ifnull(max(nomor),0) as max from transaksi_kembali "
            . "WHERE MONTH(tanggal) = MONTH(NOW()) AND YEAR(tanggal)=YEAR(NOW())";
        $max = $this->db->query($queryMaxId)->row()->max;
        $max = (int) $max;
        // "TRX/2020/04/0120"
        $strPad = str_pad($max + 1, 4, "0", STR_PAD_LEFT);
        $noKembali = "KMB/" . date("ymd") . $strPad;

        $dataKembali = array(
            "no_pengembalian" => $noKembali,
            "karyawan_id" =>  $this->session->userdata('karyawan_id'),
            "anggota_id" => $this->input->post("id_anggota"),
            "tanggal" => $this->input->post("tanggal"),
            "terlambat" => $this->input->post("terlambat"),
            "denda" => $this->input->post("denda"),
            "total" => $this->input->post("total"),
            "bayar" => $this->input->post("bayar"),
            "kembalian" => $this->input->post("kembalian"),
            "nomor" => ($max + 1)
        );
        if (isset($_POST['proses'])) {
            $idKembali = $this->Kembali_m->insertGetId($dataKembali);
            $index = 0;
            foreach ($itemKembali as $item) {
                $itemKembali[$index++]->kembali_id = $idKembali;
            }
            $this->ItemKembali_m->insertBatch($itemKembali);

            if ($this->db->affected_rows() > 0) {
                $kembali = array("success" => true, "id_kembali" => $idKembali);
            } else {
                $kembali = array("success" => false);
            }
            echo json_encode($kembali);
        }
    }

    public function filter()
    {
        $filter = $this->input->post("filter");
        if (isset($_POST['proses'])) {
            $data = $this->ItemPinjam_m->filter($filter);
            echo json_encode($data);
        };
    }

    public function print($id)
    {
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $kembali = $this->Kembali_m->getJoin($id);
        $item = $this->ItemKembali_m->joinLengkap($id);
        $data = array(
            "kembali" => $kembali,
            "item" => $item,
            "pengaturan" => $pengaturan
        );
        $this->load->view('app/kembali/print', $data);
    }

    public function dataKembali()
    {
        $userData = userData();
        $kembali = $this->Kembali_m->getAll();
        $data = array(
            "title" => "Data Kembali",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/kembali/v_data_kembali",
            "kembali" => $kembali,
        );
        $this->load->view('template/main', $data);
    }

    public function detail($id)
    {
        $userData = userData();
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $kembali = $this->Kembali_m->getJoin($id);
        $item = $this->ItemKembali_m->joinLengkap($id);
        $data = array(
            "title" => "Detail Pengembalian",
            "userData" =>  $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/kembali/v_detail_kembali",
            "kembali" => $kembali,
            "item" => $item,
            "pengaturan" => $pengaturan

        );
        $this->load->view('template/main', $data);
    }


    public function report()
    {
        $userData = userData();
        $data = array(
            "title" => "Laporan Kembali",
            "userData" => $userData['karyawan'],
            "topbar" => "template/topbar",
            "sidebar" => "template/sidebar",
            "page" => "app/laporan/laporan_kembali",
        );
        $this->load->view('template/main', $data);
    }

    public function getReport()
    {
        $awal = $this->input->post("tanggal_awal");
        $akhir = $this->input->post("tanggal_akhir");
        if (isset($_POST['proses'])) {
            $join = $this->Kembali_m->joinTanggal($awal, $akhir);
            echo json_encode($join);
        };
    }

    public function downloadReport()
    {
        $awal = $this->input->post("tanggalAwal");
        $akhir = $this->input->post("tanggalAkhir");
        $pengaturan = $this->Pengaturan_m->getPrimaryKey(1);
        $kembali = $this->Kembali_m->joinTanggal($awal, $akhir);
        $item = $this->Kembali_m->joinItemPengembalian($awal, $akhir);
        $data = array(
            "kembali" => $kembali,
            "items" => $item,
            "awal" => $awal,
            "akhir" => $akhir,
            "pengaturan" => $pengaturan
        );
        $html = $this->load->view('app/laporan/print', $data, true);
        $this->fungsi->pdfGenerator($html, 'Pengembalian Priode ' . $awal . ' s/d ' . $akhir, 'A4', 'portrait');
    }
}
