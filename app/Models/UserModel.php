<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $externalTable = 'users_share';

    public function returnUser($username)
    {
        $query = $this->db->table($this->table)
            ->where('username', $username)
            ->get();

        return $query->getRow();
    }

    public function returnExternalUser($username)
    {
        $query = $this->db->table($this->externalTable)
            ->where('username', $username)
            ->get();

        return $query->getRowArray();
    }

    public function returnUserId($id)
    {
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->get();

        return $query->getRow();
    }

    public function returnDuplicateUser($id, $username)
    {
        $query = $this->db->table($this->table)
            ->where('id !=', $id)
            ->where('username', $username)
            ->get();

        return $query->getRow();
    }

    public function returnDuplicateEmail($id, $email)
    {
        $query = $this->db->table($this->table)
            ->where('id !=', $id)
            ->where('email', $email)
            ->get();

        return $query->getRow();
    }

    public function newUser($userData)
    {
        $existingUser = $this->returnUser($userData['username']);

        if (!$existingUser) {
            $this->db->table($this->table)->insert($userData);

            return true;
        }

        return false;
    }

    public function updateUser($userData)
    {

        $this->db->table($this->table)
            ->where('id', $userData['id'])
            ->update($userData['update']);

        return $this->db->affectedRows() > 0;
    }

    public function removeUser($id)
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->delete();

        return true;
    }

    public function getUsers($columns)
    {
        return $this->db->table($this->table . ' T0')
            ->select($columns . ', COUNT(T2.id) AS form_count')
            ->join('users_groups T1', 'T1.id = T0.group', 'left')
            ->join('form T2', 'T2.author_id = T0.id', 'left')
            ->groupBy('T0.id, T0.name, T0.email')
            ->orderBy('T0.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getUserById($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    public function addExternalUser($userData)
    {
        $existingExternalUser = $this->returnExternalUser($userData['username']);

        if (!$existingExternalUser) {
            $this->db->table($this->externalTable)->insert($userData);

            return $this->db->insertID();
        } else {
            return $existingExternalUser['id'];
        }
    }
}
