<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rak_m extends CI_Model
{
    var $table = "rak";
    var $primaryKey = "id_rak";

    public function getAll()
    {
        $this->db->where('rak.is_active', 1);
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function getHapus()
    {
        $this->db->where('rak.is_active', 0);
        return $this->db->get($this->table)->result();
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
