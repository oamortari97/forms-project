<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\GroupController;
use App\Models\GroupModel;

use App\Models\FormModel;

class UserController extends BaseController
{
    private $userModel;
    private $groupModel;
    private $formModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->formModel = new FormModel();
    }

    public function isLoggedIn()
    {
        $usuario = $this->session()->get('usuario');

        if (!isset($usuario) || empty($usuario)) {
            return false;
        }

        return true;
    }

    public function isAdmin()
    {
        $usuario = $this->session()->get('usuario');

        if (!isset($usuario['admin']) || $usuario['admin'] != 1) {
            $this->setDangerAlert('Você não tem permissão para acessar essa página.');
            return false;
        }

        return true;
    }

    public function login()
    {
        return $this->returnTemplateLogin();
    }

    public function checkLogin($api = false)
    {
        $postData = [
            'username' => $this->returnPost('usuario'),
            'password' => $this->returnPost('senha'),
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
            return redirect()->route('login');
        }

        $checkUser = $this->userModel->returnUser($postData['username']);

        if (empty($checkUser)) {
            $msg = 'Usuário informado inválido.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        if ($postData['password'] !== decrypt($checkUser->password, getenv('MAIN_KEY'))) {
            $msg = 'Senha informada inválida.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        if ($checkUser->active === '0') {
            $msg = 'O usuário não está ativo.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }
            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        if ($api) {
            return $this->returnSuccessResponse($checkUser);
        }

        $groups = $this->groupModel->getGroupById($checkUser->group);

        $loggedArray = [
            'usuario' => [
                'loggedIn' => true,
                'user_id' => $checkUser->id,
                'username' => $checkUser->username,
                'name' => $checkUser->name,
                'surname' =>  $checkUser->surname,
                'group' =>  $groups,
                'admin' =>  $checkUser->admin == 1 ? true : false,
            ]
        ];

        $this->session()->set($loggedArray);

        return redirect()->route('inicio');
    }

    public function doLogout()
    {
        $this->session()->destroy('usuario');
        return redirect()->route('login');
    }

    public function newUser($api = false)
    {
        $postData = [
            'username' => $this->returnPost('usuario'),
            'name' => $this->returnPost('nome'),
            'surname' => $this->returnPost('sobrenome'),
            'password' =>  $this->returnPost('senha'),
            'email' => $this->returnPost('email'),
            'group' => $this->returnPost('grupo'),
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
            return redirect()->route('admin/usuarios');
        }

        $postData['password'] = encrypt($postData['password'], getenv('MAIN_KEY'));

        $postData['active'] = empty($this->returnPost('ativo')) ? 0 : 1;
        $postData['admin'] = empty($this->returnPost('admin')) ? 0 : 1;

        if (!$this->userModel->newUser($postData)) {
            $msg = 'O usuário informado já existe.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Usuário cadastrado com sucesso.');
        return redirect()->route('admin/usuarios');
    }

    public function editUser($api = false)
    {
        $postData = [
            'id' => $this->returnPost('usuario_id')
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
            return redirect()->route('admin/usuarios');
        }

        if (!$this->userModel->returnUserId($postData['id'])) {
            $msg = 'O usuário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        $editableFields = [
            'username' => $this->returnPost('usuario'),
            'name' => $this->returnPost('nome'),
            'surname' => $this->returnPost('sobrenome'),
            'password' =>  $this->returnPost('senha'),
            'email' => $this->returnPost('email'),
            'group' => $this->returnPost('grupo'),
            'password' => encrypt($this->returnPost('senha'), getenv('MAIN_KEY')),
            'active' => $this->returnPost('ativo') ?? 0,
            'admin' => $this->returnPost('admin') ?? 0,
        ];

        foreach ($editableFields as $key => $fieldValue) {
            if (!empty($fieldValue) || $fieldValue == '0') {
                $postData['update'][$key] = $fieldValue;
            }
        }

        if (isset($postData['update']['username']) && !empty($postData['update']['username'])) {
            if ($this->userModel->returnDuplicateUser($postData['id'], $postData['update']['username'])) {
                $msg = 'O usuário informado já está em uso.';

                if ($api) {
                    return $this->returnErrorResponse($msg, 400);
                }

                $this->setDangerAlert($msg);
                return redirect()->route('admin/usuarios');
            }
        }

        if (isset($postData['update']['email']) && !empty($postData['update']['email'])) {
            if ($this->userModel->returnDuplicateEmail($postData['id'], $postData['update']['email'])) {
                $msg = 'O e-mail informado já está em uso.';

                if ($api) {
                    return $this->returnErrorResponse($msg, 400);
                }

                $this->setDangerAlert($msg);
                return redirect()->route('admin/usuarios');
            }
        }

        $this->userModel->updateUser($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Usuário atualizado com sucesso.');
        return redirect()->route('admin/usuarios');
    }

    public function deleteUser($api = false)
    {
        $postData = [
            'id' => $this->returnPost('usuario_id')
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
            return redirect()->route('admin/usuarios');
        }

        if (!$this->userModel->returnUserId($postData['id'])) {
            $msg = 'O usuário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        $this->userModel->removeUser($postData['id']);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Usuário removido com sucesso.');
        return redirect()->route('admin/usuarios');
    }


    public function toggleUser($api = false)
    {
        $postData = [
            'id' => $this->returnPost('usuario_id')
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
            return redirect()->route('admin/usuarios');
        }

        if (!$this->userModel->returnUserId($postData['id'])) {
            $msg = 'O usuário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        $postData['update']['active'] = $this->returnPost('valor') ?? 0;

        $this->userModel->updateUser($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Usuário atualizado com sucesso.');
        return redirect()->route('admin/usuarios');
    }

    public function mainUserView()
    {
        $columns = 'T0.id, T0.username, T0.name, T0.surname, T0.email, T0.group, T0.active, T0.admin, T1.name as group_name';

        $users = $this->userModel->getUsers($columns);

        return $this->returnDefaultTemplate('Admin/Users/usuarios', ['usuarios' => $users], [base_url('assets/js/users.js')]);
    }

    public function addUserView()
    {
        $groups = $this->groupModel->getAllGroups('id, name');

        return view('Admin/Users/novo', ['grupos' => $groups]);
    }

    public function editUserView()
    {
        $postData = [
            'id' => $this->returnPost('usuario_id')
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
            return redirect()->route('admin/usuarios');
        }

        $user = $this->userModel->getUserById($postData['id']);

        if (empty($user)) {
            $msg = 'Usuário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        $groups = $this->groupModel->getAllGroups('id as group_id, name as group_name');

        return view('Admin/Users/editar', ['usuario' => $user, 'grupos' => $groups]);
    }

    public function deleteUserView()
    {
        $postData = [
            'id' => $this->returnPost('usuario_id')
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
            return redirect()->route('admin/usuarios');
        }

        $user = $this->userModel->getUserById($postData['id']);

        if (empty($user)) {
            $msg = 'Usuário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        return view('Admin/Users/apagar', ['usuario' => $user]);
    }

    public function toggleUserView()
    {
        $postData = [
            'id' => $this->returnPost('usuario_id'),
        ];

        $toggleValue = $this->returnPost('valor') ?? 0;

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        $user = $this->userModel->getUserById($postData['id']);

        if (empty($user)) {
            $msg = 'Usuário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('admin/usuarios');
        }

        return view('Admin/Users/toggle', ['usuario' => $user, 'valor' => $toggleValue]);
    }

    public function mainExternalView()
    {
        $postData = [
            'id' => $this->returnPost('form_id')
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
            return redirect()->back();
        }

        return view('External/novo.php', ['formulario' => $postData['id']]);
    }

    public function newExternal()
    {
        $postData = [
            'username' => $this->returnPost('usuario'),
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
            return redirect()->back();
        }

        if ($newUser = $this->userModel->addExternalUser([
            'username' => $this->returnPost('usuario'),
            'name' => $this->returnPost('nome'),
            'surname' => $this->returnPost('sobrenome')
        ])) {

            $data = [
                'form_id' => $this->returnPost('form_id'),
                'external_user_id' => $newUser,
                'access_hash' => uniqid()
            ];

            $this->formModel->addExternalShare($data);

            $msg = 'Usuário externo cadastrado com sucesso.';

            $this->setSuccessAlert($msg);
            return redirect()->back();
        } else {
            $msg = 'O usuário já existe.';

            $this->setDangerAlert($msg);
            return redirect()->back();
        }
    }

    public function changePasswordView()
    {
        return view('Account/nova-senha');
    }

    public function changePassword()
    {
        $postData = [
            'password' => $this->returnPost('senha'),
            'newPassword' => $this->returnPost('nova-senha'),
            'renewPassword' => $this->returnPost('re-nova-senha')
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
            return redirect()->back();
        }

        if ($postData['newPassword'] !== $postData['renewPassword']) {
            $msg = 'As senhas não são iguais.';

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        $checkUser = $this->userModel->getUserById($this->session()->get('usuario')['user_id']);

        if (decrypt($checkUser['password'], getenv('MAIN_KEY')) !== $postData['password']) {
            $msg = 'A senha atual está incorreta.';

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        $userData = [
            'id' => $this->session()->get('usuario')['user_id'],
            'update' => [
                'password' => encrypt($postData['newPassword'], getenv('MAIN_KEY'))
            ]
        ];

        if ($this->userModel->updateUser($userData)) {
            $msg = 'Senha alterada com sucesso.';

            $this->setSuccessAlert($msg);
            return redirect()->back();
        }

        $msg = 'Não foi possível concluir a operação.';

        $this->setDangerAlert($msg);
        return redirect()->back();
    }
}
