<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_m extends CI_Model
{
    var $table = "karyawan";
    var $primaryKey = "id_karyawan";
    var $user = "user_name";

    public function getAll()
    {
        $this->db->where('karyawan.is_active > 0');
        return $this->db->get($this->table)->result();
    }

    public function getPrimaryKey($id)
    {
        $this->db->select("*,DATE_FORMAT(date_created, '%d %M %Y') as bergabung")
            ->where($this->primaryKey, $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function getUser($id)
    {
        $this->db->where($this->user, $id);
        return $this->db->get($this->table)->row_array();
    }
    public function getHapus()
    {
        $this->db->where('karyawan.is_active', 0);
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
