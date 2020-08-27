<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kembali_m extends CI_Model
{
    var $table = "transaksi_kembali";
    var $pinjam = "transaksi_pinjam";
    var $primaryKeyPinjam = "id_peminjaman";
    var $primaryKey = "id_kembali";

    public function getAll()
    {
        $this->db->select("*, karyawan.nama_karyawan,anggota.nama_anggota")
            ->from("transaksi_kembali")
            ->join('karyawan', 'karyawan.id_karyawan = transaksi_kembali.karyawan_id')
            ->join('anggota', 'anggota.id_anggota = transaksi_kembali.anggota_id');
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function insertGetId($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function get_item_buku_bykode($id)
    {
        $this->db->select('*');
        $this->db->from('item_pinjam');
        $this->db->where('pinjam_id', $id);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function delete($id)
    {
        //hanya mengupdate is_active dari 1 menjadi 0
        $this->db->where($this->primaryKeyPinjam, $id);
        return $this->db->update($this->pinjam, array("is_active" => 0));
    }

    public function getJoin($id)
    {
        $this->db->select('*, karyawan.nama_karyawan, anggota.nama_anggota')
            ->from('transaksi_kembali')
            ->join('karyawan', 'karyawan.id_karyawan = transaksi_kembali.karyawan_id')
            ->join('anggota', 'anggota.id_anggota = transaksi_kembali.anggota_id')
            ->where('transaksi_kembali.id_kembali', $id);
        return $this->db->get()->row();
    }


    public function joinTanggal($awal, $akhir)
    {
        $query = "SELECT *, karyawan.nama_karyawan FROM transaksi_kembali JOIN karyawan ON karyawan.id_karyawan = transaksi_kembali.karyawan_id "
            . "JOIN anggota ON anggota.id_anggota = transaksi_kembali.anggota_id "
            . "WHERE tanggal BETWEEN '$awal' AND '$akhir' ORDER BY no_pengembalian ASC";
        $as = $this->db->query($query);
        return $as->result();
    }

    public function joinItemPengembalian($awal, $akhir)
    {
        $query = "SELECT *, buku.kode_buku, buku.judul_buku ,jenis.jenis_buku ,penulis.penulis "
            . "FROM transaksi_kembali "
            . "JOIN item_kembali ON item_kembali.kembali_id=transaksi_kembali.id_kembali "
            . "JOIN buku ON buku.id_buku=item_kembali.buku_id "
            . "JOIN jenis ON jenis.id_jenis=buku.jenis_id "
            . "JOIN penulis ON penulis.id_penulis=buku.penulis_id "
            . "WHERE tanggal BETWEEN '$awal' AND '$akhir' "
            . "ORDER BY no_pengembalian ASC ";
        $as = $this->db->query($query);
        return $as->result();
    }
}
