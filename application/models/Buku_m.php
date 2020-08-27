<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_m extends CI_Model
{
    var $table = "buku";
    var $primaryKey = "id_buku";

    public function getAll()
    {
        $this->db->where('buku.is_active', 1);
        return $this->db->get($this->table)->result();
    }

    public function getHapus()
    {
        $this->db->where('buku.is_active', 0);
        return $this->db->get($this->table)->result();
    }

    public function getPrimaryKey($id)
    {
        $this->db->select("*, jenis.jenis_buku, penerbit.penerbit,rak.kode_rak,penulis.penulis")
            ->from("buku")
            ->join("jenis", "jenis.id_jenis = buku.jenis_id")
            ->join("penerbit", "penerbit.id_penerbit = buku.penerbit_id")
            ->join("penulis", "penulis.id_penulis = buku.penulis_id")
            ->join("rak", "rak.id_rak = buku.rak_id")
            ->where('buku.id_buku', $id);
        return $this->db->get()->row();
    }

    public function getJoin()
    {
        $this->db->select("*, jenis.jenis_buku, penerbit.penerbit,rak.kode_rak,penulis.penulis")
            ->from("buku")
            ->join("jenis", "jenis.id_jenis = buku.jenis_id")
            ->join("penerbit", "penerbit.id_penerbit = buku.penerbit_id")
            ->join("penulis", "penulis.id_penulis = buku.penulis_id")
            ->join("rak", "rak.id_rak = buku.rak_id");
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, array("is_active" => 0));
    }

    public function restore($id)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, array("is_active" => 1));
    }

    public function update($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }
}
