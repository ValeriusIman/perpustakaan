<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_m extends CI_Model
{
    var $table = "anggota";
    var $primaryKey = "id_anggota";

    public function getAll()
    {
        $this->db->where('anggota.is_active', 1);
        return $this->db->get($this->table)->result();
    }

    public function getHapus()
    {
        $this->db->where('anggota.is_active', 0);
        return $this->db->get($this->table)->result();
    }

    public function getPrimaryKey($id)
    {
        $this->db->select("*,DATE_FORMAT(date_created, '%d %M %Y') as bergabung")
            ->from("anggota")
            ->where('anggota.id_anggota', $id);
        return $this->db->get()->row();
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
