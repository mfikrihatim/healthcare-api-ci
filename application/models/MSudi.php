<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MSudi extends CI_Model
{
    function AddData($tabel, $data = array())
    {
        $this->db->insert($tabel, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function UpdateData($tabel, $fieldid, $fieldvalue, $data = array())
    {
        $this->db->where($fieldid, $fieldvalue)->update($tabel, $data);
    }

    function DeleteData($tabel, $fieldid, $fieldvalue)
    {
        $this->db->where($fieldid, $fieldvalue)->delete($tabel);
    }

    function GetData($tabel)
    {
        $query = $this->db->get($tabel);
        return $query->result();
    }

    function GetDataWhere($tabel, $id, $nilai)
    {
        $this->db->where($id, $nilai);
        $query = $this->db->get($tabel);
        return $query;
    }
    function GetDataWhereCount($tabel, $id, $nilai)
    {
        $this->db->where($id, $nilai);
        $query = $this->db->count_all_results($tabel);
        return $query;
    }

    function GetDataWhere2($tabel, $id, $nilai, $id1, $nilai1)
    {
        $this->db->where($id, $nilai);
        $this->db->where($id1, $nilai1);
        $query = $this->db->get($tabel);
        return $query;
    }

    function GetDataWhere3($tabel, $id, $nilai, $id1, $nilai1)
    {
        $this->db->where($id, $nilai);
        $this->db->where($id1, $nilai1);
        $this->db->where('is_active', 1);
        $query = $this->db->get($tabel);
        return $query;
    }

    function GetDataLogin($tabel, $id, $nilai, $id1, $nilai1, $id2, $nilai2)
    {
        $this->db->where($id, $nilai);
        $this->db->where($id1, $nilai1);
        if($nilai2 != "0"){
            $this->db->where($id2, $nilai2);
        }      
        $this->db->where('is_active', 1);
        $query = $this->db->get($tabel);
        return $query;
    }

    function GetDataLike($table, $id, $nilai, $field, $value)
    {
        $this->db->like($id, $nilai);
        $this->db->order_by($field, $value);
        $query = $this->db->get($table);
        return $query;
    }
    function GetDataLike1($table, $id, $nilai)
    {
        $this->db->like($id, $nilai);
        $query = $this->db->get($table);
        return $query;
    }
}
