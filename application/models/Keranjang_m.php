<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang_m extends CI_Model
{
    var $table = "keranjang";
    var $primaryKey = "id_keranjang";

    public function getAll()
    {
        $this->db->select("*, buku.kode_buku, buku.judul_buku,jenis.jenis_buku,penulis.penulis")
            ->from("keranjang")
            ->join('buku', 'buku.id_buku = keranjang.buku_id')
            ->join('jenis', 'jenis.id_jenis = buku.jenis_id')
            ->join('penulis', 'penulis.id_penulis = buku.penulis_id');
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function get_item_buku_bykode($id)
    {
        $this->db->select('*');
        $this->db->from('item_pinjam');
        $this->db->where('pinjam_id', $id);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function insertBatchKeranjang($params)
    {
        $this->db->insert_batch('keranjang', $params);
    }
}
