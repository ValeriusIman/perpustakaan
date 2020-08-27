<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{
    public function karyawan()
    {
        $this->db->select('*')
            ->from('karyawan')
            ->where('is_active', 1);
        return $this->db->get()->num_rows();
    }

    public function anggota()
    {
        $this->db->select('*')
            ->from('anggota')
            ->where('is_active', 1);
        return $this->db->get()->num_rows();
    }

    public function pinjam()
    {
        $this->db->select('*')
            ->from('transaksi_pinjam')
            ->where('is_active', 1);
        return $this->db->get()->num_rows();
    }

    public function kembali()
    {
        $this->db->where('DATE(tanggal)=DATE(NOW())');
        return $this->db->get('transaksi_kembali')->num_rows();
    }
}
