<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pinjam_m extends CI_Model
{
    var $table = "transaksi_pinjam";
    var $primaryKey = "id_pinjam";

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function insertGetId($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function getAll()
    {
        $this->db->select('*,karyawan.nama_karyawan, anggota.nama_anggota')
            ->from('transaksi_pinjam')
            ->join('karyawan', 'karyawan.id_karyawan = transaksi_pinjam.karyawan_id')
            ->join('anggota', 'anggota.id_anggota = transaksi_pinjam.anggota_id')
            ->where('transaksi_pinjam.is_active', 1)
            ->order_by('no_peminjaman', 'desc');
        return $this->db->get()->result();
    }

    public function getJoin($id)
    {
        $this->db->select('*, karyawan.nama_karyawan, anggota.nama_anggota')
            ->from('transaksi_pinjam')
            ->join('karyawan', 'karyawan.id_karyawan = transaksi_pinjam.karyawan_id')
            ->join('anggota', 'anggota.id_anggota = transaksi_pinjam.anggota_id')
            ->where('transaksi_pinjam.id_peminjaman', $id);
        return $this->db->get()->row();
    }

    public function getByPrimaryKey($id)
    {
        $this->db->select('transaksi.*,user.nama as nama_user, pelanggan.nama_pelanggan as pelanggan_nama')
            ->from('transaksi')
            ->join('user', 'user.id_user = transaksi.user_id')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi.pelanggan_id')
            ->where('transaksi.id_transaksi', $id);
        return $this->db->get()->row();
    }


    // delete data
    public function delete($id)
    {
        $this->db->where("transaksi_pinjam.id_peminjaman", $id);
        return $this->db->update("transaksi_pinjam", array("is_active" => 0));
    }
}
