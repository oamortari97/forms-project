<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $formTable = 'form';
    protected $questionsTable = 'form_questions';
    protected $optionsTable = 'form_options';
    protected $shareTable = 'form_share';
    protected $usersShareTable = 'users_share';

    protected $responsesTable = 'response';
    protected $answersTable = 'response_answers';

    public function returnFormId($id)
    {
        $query = $this->db->table($this->formTable)
            ->where('id', $id)
            ->get();

        return $query->getRowArray();
    }

    public function newForm($formData)
    {
        $this->db->table($this->formTable)->insert($formData);

        return $this->db->insertID();
    }

    public function updateForm($formData)
    {

        $this->db->table($this->formTable)
            ->where('id', $formData['id'])
            ->update($formData['update']);

        return $this->db->affectedRows() > 0;
    }

    public function removeForm($id)
    {
        $this->db->table($this->formTable)
            ->where('id', $id)
            ->delete();

        return true;
    }

    public function removeQuestions($id)
    {
        $this->db->table($this->questionsTable)
            ->where('form_id', $id)
            ->delete();

        return true;
    }

    public function getForms($id = false)
    {
        if ($id) {
            return $this->db->table($this->formTable . ' T0')
                ->select('T0.*')
                ->select('COUNT(response.id) AS response_count')
                ->join('response', 'response.form_id = T0.id', 'left')
                ->where('T0.id', $id)
                ->orderBy('T0.id')
                ->get()
                ->getRowArray();
        }


        return $this->db->table($this->formTable . ' T0')
            ->select('T0.*')
            ->select('COUNT(response.id) AS response_count')
            ->join('response', 'response.form_id = T0.id', 'left')
            ->groupBy('T0.id, T0.name')
            ->orderBy('T0.id')
            ->get()
            ->getResultArray();
    }

    public function getFormById($id)
    {
        $sql = "SELECT
        T0.id AS form_id,
        T0.name AS form_name,
        T0.description AS form_description,
        T0.starts AS form_starts,
        T0.ends AS form_ends,
        T0.share AS form_share,
        T0.posted AS posted,
        T1.id AS question_id,
        T1.question_type,
        T1.question_text,
        T2.id AS option_id,
        T2.option_text,
        T2.option_true
        FROM form T0
        LEFT JOIN form_questions T1 ON T1.form_id = T0.id
        LEFT JOIN form_options T2 ON T2.question_id = T1.id
        WHERE T0.id = ?
        ORDER BY T1.id ASC, T2.id ASC;";

        $query = $this->db->query($sql, [$id]);

        return $query->getResultArray();
    }

    public function getFormByHash($hash)
    {
        $sql = "SELECT
        T0.id AS form_id,
        T0.name AS form_name,
        T0.description AS form_description,
        T0.starts AS form_starts,
        T0.ends AS form_ends,
        T0.share AS form_share,
        T0.posted AS posted,
        T1.id AS question_id,
        T1.question_type,
        T1.question_text,
        T2.id AS option_id,
        T2.option_text,
        T2.option_true,
        T3.access_hash,
        T4.id AS external_id,
        T4.username AS external_username,
        T4.name AS external_name,
        T4.surname AS external_surname
        FROM form T0
        LEFT JOIN form_questions T1 ON T1.form_id = T0.id
        LEFT JOIN form_options T2 ON T2.question_id = T1.id
        LEFT JOIN form_share T3 ON T3.form_id = T0.id
        LEFT JOIN users_share T4 ON T4.id = T3.external_user_id
        WHERE T3.access_hash = ?
        ORDER BY T1.id ASC, T2.id ASC;";

        $query = $this->db->query($sql, [$hash]);

        return $query->getResultArray();
    }

    public function getExternalByHash($hash)
    {
        $result = $this->db->table($this->shareTable)
            ->select('external_user_id')
            ->where('access_hash', $hash)
            ->get()
            ->getRowArray();

        if ($result) {
            return $result['external_user_id'];
        }

        return false;
    }

    public function getExternalByForm($formId, $exclude = false)
    {
        if ($exclude) {
            $subquery = $this->db->table($this->shareTable . ' T0')
                ->select('T0.external_user_id')
                ->where('T0.form_id', $formId)
                ->getCompiledSelect();

            return $this->db->table($this->usersShareTable . ' T1')
                ->select('T1.id')
                ->select('T1.username')
                ->select('T1.name')
                ->select('T1.surname')
                ->where('T1.id NOT IN (' . $subquery . ')', null, false)
                ->orderBy('T1.id')
                ->get()
                ->getResultArray();
        }

        $builder = $this->db->table($this->responsesTable)
            ->select('external_user_id, COUNT(*) AS response_count')
            ->groupBy('external_user_id');

        $subquery = $builder->getCompiledSelect();

        return $this->db->table($this->shareTable . ' T0')
            ->select('T0.id, T0.access_hash, T1.username, T1.name, T1.surname')
            ->select('COALESCE(T2.response_count, 0) AS response_count')
            ->join('users_share T1', 'T1.id = T0.external_user_id', 'left')
            ->join("($subquery) T2", 'T2.external_user_id = T1.id', 'left')
            ->where('T0.form_id', $formId)
            ->orderBy('T0.id')
            ->get()
            ->getResultArray();
    }

    public function getExternalByUsername($formId = false, $username)
    {
        if ($formId) {
            return $this->db->table($this->shareTable . ' T0')
                ->select('T0.id')
                ->select('T0.access_hash')
                ->select('T1.username')
                ->select('T1.name')
                ->select('T1.surname')
                ->join('users_share T1', 'T1.id = T0.external_user_id', 'left')
                ->where('T0.form_id', $formId)
                ->where('T1.username', $username)
                ->orderBy('T0.id')
                ->get()
                ->getRowArray();
        } else {
            return $this->db->table($this->usersShareTable)
                ->select('*')
                ->where('username', $username)
                ->get()
                ->getRowArray();
        }
    }

    public function getExternalById($shareId)
    {
        return $this->db->table($this->shareTable . ' T0')
            ->select('T0.id')
            ->select('T0.access_hash')
            ->select('T1.username')
            ->select('T1.name')
            ->select('T1.surname')
            ->join('users_share T1', 'T1.id = T0.external_user_id', 'left')
            ->where('T0.id', $shareId)
            ->orderBy('T0.id')
            ->get()
            ->getRowArray();
    }

    public function addExternalShare($formData)
    {
        return $this->db->table($this->shareTable)->insert($formData);
        return $this->db->insertID();
    }

    public function removeShare($id)
    {
        $this->db->table($this->shareTable)
            ->where('id', $id)
            ->delete();

        return true;
    }

    public function addQuestion($formData)
    {
        $this->db->table($this->questionsTable)->insert($formData);
        return $this->db->insertID();
    }

    public function updateQuestion($questionId, $formData)
    {
        $this->db->table($this->questionsTable)
            ->where('id', $questionId)
            ->update($formData);

        return $this->db->affectedRows() > 0;
    }

    public function returnDuplicateQuestion($formId, $questionType, $text)
    {
        return $this->db->table($this->questionsTable)
            ->where('form_id', $formId)
            ->where('question_type', $questionType)
            ->where('question_text', $text)
            ->get()
            ->getRowArray();
    }

    public function addOption($formData)
    {
        $this->db->table($this->optionsTable)->insert($formData);
        return $this->db->insertID();
    }

    public function updateOption($optionId, $formData)
    {
        $this->db->table($this->optionsTable)
            ->where('id', $optionId)
            ->update($formData);

        return $this->db->affectedRows() > 0;
    }

    public function returnDuplicateOption($questionId, $text)
    {
        return $this->db->table($this->optionsTable)
            ->where('question_id', $questionId)
            ->where('option_text', $text)
            ->get()
            ->getRowArray();
    }

    public function returnResponses($id)
    {
        $sql = "SELECT
        T0.name as form_name,
        T0.description,
        T0.ends,
        T0.starts,
        T4.name, 
        T4.surname, 
        T1.id AS question_id,
        T1.question_text,
        T2.id AS option_id,
        T2.option_text,
        T2.option_true,
        COUNT(T3.option_id) AS response_count
        FROM form T0
        LEFT JOIN form_questions T1 ON T1.form_id = T0.id
        LEFT JOIN form_options T2 ON T2.question_id = T1.id
        LEFT JOIN response_answers T3 ON T3.option_id = T2.id
        LEFT JOIN users T4 ON T4.id = T0.author_id
        WHERE T0.id = ?
        GROUP BY T1.id, T2.id
        ORDER BY T1.id, T2.id;
        ";

        $query = $this->db->query($sql, [$id]);

        return $query->getResultArray();
    }

    public function returnDetailedResponse($responseId)
    {
        $sql = "SELECT
        T1.id AS question_id,
        T1.question_text,
        T2.id AS option_id,
        T2.option_text,
        T3.answer_text,
        CASE 
        WHEN T3.option_id = T2.id THEN 'true'
        ELSE 'false'
        END AS checked
        FROM form T0
        LEFT JOIN form_questions T1 ON T1.form_id = T0.id
        LEFT JOIN form_options T2 ON T2.question_id = T1.id
        LEFT JOIN response_answers T3 ON T3.question_id = T1.id
        LEFT JOIN response T4 ON T4.id = T3.response_id 
        WHERE T4.id = ?
        GROUP BY T1.id, T2.id, T3.answer_text
        ORDER BY T1.id, T2.id;
        ";

        $query = $this->db->query($sql, [$responseId]);

        return $query->getResultArray();
    }

    public function addResponse($formData)
    {
        $this->db->table($this->responsesTable)->insert($formData);
        return $this->db->insertID();
    }

    public function addResponseAnswer($formData)
    {
        $this->db->table($this->answersTable)->insert($formData);
        return $this->db->insertID();
    }

    public function getResponses($columns)
    {
        return $this->db->table($this->responsesTable)
            ->select($columns)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getResponsesByForm($formId)
    {
        return $this->db->table($this->responsesTable . ' T0')
            ->select('T0.*, T2.name, T3.username as external_user, T1.name as form_name')
            ->join('form T1', 'T1.id = T0.form_id', 'left')
            ->join('users T2', 'T2.id = T0.user_id', 'left')
            ->join('users_share T3', 'T3.id = T0.external_user_id', 'left')
            ->where('T0.form_id', $formId)
            ->orderBy('T0.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function addExternalUser($formData)
    {
        $this->db->table($this->usersShareTable)->insert($formData);
        return $this->db->insertID();
    }
}
