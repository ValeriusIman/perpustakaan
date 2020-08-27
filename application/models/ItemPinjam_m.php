<?php


class ItemPinjam_m extends CI_Model
{
    var $table = "item_pinjam";
    var $primaryKey = "id_item";

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function insertBatch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    public function getAll($id)
    {

        $this->db->select('item_transaksi.*')
            ->from('item_transaksi')
            ->where('item_transaksi.transaksi_id', $id);
        return $this->db->get()->result();
        // return $this->db->get($this->table)->result();
    }

    public function getByPrimaryKey($id)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->get($this->table)->row();
    }

    public function update($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }

    // delete data
    public function delete($id)
    {
        //hanya mengupdate is_active dari 1 menjadi 0
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, array("is_active" => 0));
    }

    public function joinLengkap($id)
    {
        $this->db->select('*,buku.kode_buku, buku.judul_buku,jenis.jenis_buku,penulis.penulis')
            ->from('item_pinjam')
            ->join('buku', 'buku.id_buku = item_pinjam.buku_id')
            ->join('penulis', 'penulis.id_penulis = buku.penulis_id')
            ->join('jenis', 'jenis.id_jenis = buku.jenis_id')
            ->where('item_pinjam.pinjam_id', $id);
        return $this->db->get()->result();
    }


    public function filter($filter)
    {
        $query = "SELECT *,buku.kode_buku, buku.judul_buku, jenis.jenis_buku, penulis.penulis, transaksi_pinjam.tanggal_kembali FROM item_pinjam "
            . "JOIN buku ON buku.id_buku = item_pinjam.buku_id "
            . "JOIN jenis ON jenis.id_jenis = buku.jenis_id "
            . "JOIN penulis ON penulis.id_penulis = buku.penulis_id "
            . "JOIN transaksi_pinjam ON transaksi_pinjam.id_peminjaman = item_pinjam.pinjam_id "
            . "WHERE item_pinjam.pinjam_id = '$filter'";
        $as = $this->db->query($query);
        return $as->result();
    }
}
