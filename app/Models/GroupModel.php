<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'users_groups';

    public function returnGroup($name)
    {
        $query = $this->db->table($this->table)
            ->where('name', $name)
            ->get();

        return $query->getRow();
    }

    public function returnGroupId($id)
    {
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->get();

        return $query->getRow();
    }

    public function returnDuplicateGroup($id, $name)
    {
        $query = $this->db->table($this->table)
            ->where('id !=', $id)
            ->where('name', $name)
            ->get();

        return $query->getRow();
    }

    public function newGroup($groupData)
    {
        $existingGroup = $this->returnGroup($groupData['name']);

        if (!$existingGroup) {
            $this->db->table($this->table)->insert($groupData);

            return true;
        }

        return false;
    }

    public function updateGroup($groupData)
    {

        $this->db->table($this->table)
            ->where('id', $groupData['id'])
            ->update($groupData['update']);

        return $this->db->affectedRows() > 0;
    }

    public function removeGroup($id)
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->delete();

        return true;
    }

    public function getGroups($columns)
    {
        return $this->db->table($this->table . ' T0')
            ->select($columns)
            ->join('users T1', 'T1.group = T0.id', 'left')
            ->orderBy('T0.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAllGroups($columns)
    {
        return $this->db->table($this->table)
        ->select($columns)
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();
    }

    public function getGroupById($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }
}
