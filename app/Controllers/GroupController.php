<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupModel;

class GroupController extends BaseController
{
    private $groupModel;

    public function __construct()
    {
        $this->groupModel = new GroupModel();
    }

    public function mainGroupsView()
    {
        $groups = $this->groupModel->getGroups('T0.*, T1.username');

        $returnData = [];

        foreach ($groups as $group) {

            if (!isset($returnData[$group['id']])) {
                $returnData[$group['id']] = [];
            }

            foreach ($group as $key => $groupData) {
                if (!is_numeric($key)) {
                    if ($key !== 'username') {
                        $returnData[$group['id']][$key] = $groupData;
                    }
                }
            }

            if (isset($group['username']) && !empty($group['username'])) {
                $returnData[$group['id']]['usuarios'][] = $group['username'];
            }
        }

        return $this->returnDefaultTemplate('Admin/Groups/grupos', ['grupos' => $returnData], [base_url('assets/js/groups.js')]);
    }

    public function addGroupView()
    {
        return view('Admin/Groups/novo');
    }

    public function newGroup($api = false)
    {
        $postData = [
            'name' => $this->returnPost('nome'),
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        $actions = [
            'read' => $this->returnPost('ver'),
            'create' => $this->returnPost('criar'),
            'edit' => $this->returnPost('editar'),
            'delete' => $this->returnPost('apagar'),
        ];

        foreach ($actions as $key => $action) {
            $postData[$key] = $action == '1' ? '1' : '0';
        }

        $newGroup = $this->groupModel->newGroup($postData);

        if (!$newGroup) {
            $msg = 'O grupo informado já existe.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Grupo cadastrado com sucesso.');

        return redirect()->route('admin/grupos');
    }

    public function editGroup($api = false)
    {
        $postData = [
            'id' => $this->returnPost('grupo_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        if (!$this->groupModel->returnGroupId($postData['id'])) {
            $msg = 'O grupo informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        $editableFields = [
            'name' => $this->returnPost('nome') ?? 0,
            'read' => $this->returnPost('ver') ?? 0,
            'create' => $this->returnPost('criar') ?? 0,
            'edit' => $this->returnPost('editar') ?? 0,
            'delete' => $this->returnPost('apagar') ?? 0,
        ];

        foreach ($editableFields as $key => $fieldValue) {
            if (!empty($fieldValue) || $fieldValue == '0') {
                $postData['update'][$key] = $fieldValue;
            }
        }

        if (isset($postData['update']['name']) && !empty($postData['update']['name'])) {
            if ($this->groupModel->returnDuplicateGroup($postData['id'], $postData['update']['name'])) {
                $msg = 'O grupo informado já está em uso.';

                if ($api) {
                    return $this->returnErrorResponse($msg, 400);
                }

                $this->setDangerAlert($msg);
                return redirect()->route('admin/grupos');
            }
        }

        $this->groupModel->updateGroup($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Grupo atualizado com sucesso.');
        return redirect()->route('admin/grupos');
    }

    public function editGroupView()
    {
        $postData = [
            'id' => $this->returnPost('grupo_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        $group = $this->groupModel->getGroupById($postData['id']);

        if (empty($group)) {
            $msg = 'Grupo não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        return view('Admin/Groups/editar', ['grupo' => $group]);
    }

    public function deleteGroup($api = false)
    {
        $postData = [
            'id' => $this->returnPost('grupo_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        if (!$this->groupModel->returnGroupId($postData['id'])) {
            $msg = 'O grupo informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        $this->groupModel->removeGroup($postData['id']);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Grupo removido com sucesso.');
        return redirect()->route('admin/grupos');
    }

    public function deleteGroupView()
    {
        $postData = [
            'id' => $this->returnPost('grupo_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        $group = $this->groupModel->getGroupById($postData['id']);

        if (empty($group)) {
            $msg = 'O grupo informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/grupos');
        }

        return view('Admin/Groups/apagar', ['grupo' => $group]);
    }
}
