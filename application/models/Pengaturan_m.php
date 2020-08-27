<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_m extends CI_Model
{
    var $table = "pengaturan";
    var $primaryKey = "id_pengaturan";

    public function getPrimaryKey($id)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->get($this->table)->row();
    }

    public function update($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }
}
