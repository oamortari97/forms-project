<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('/login', static function ($routes) {
    $routes->get('', 'UserController::login');
    $routes->post('', 'UserController::checkLogin');
});

$routes->group('/responder', static function ($routes) {
    $routes->get('autenticado/(:any)', 'FormController::answerAuthForm/$1');
    $routes->get('externo/(:any)', 'FormController::externalLogin/$1');
    $routes->post('validar', 'FormController::answerExternalForm');
    $routes->get('(:any)', 'FormController::answerForm/$1');
    $routes->post('responder-data', 'FormController::saveResponses');
});

$routes->group('/', ['filter' => \App\Filters\UserAuth::class], static function ($routes) {
    $routes->get('', 'Home::index');
    $routes->get('inicio', 'Home::index');
    $routes->get('logout', 'UserController::doLogout');

    $routes->group('formularios', static function ($routes) {
        $routes->get('', 'FormController::mainFormsView');
        $routes->get('novo', 'FormController::addFormView');
        $routes->post('novo-data', 'FormController::newForm');
        $routes->post('editar', 'FormController::editFormView');
        $routes->post('editar-data', 'FormController::editForm');
        $routes->post('atualizar-data', 'FormController::updateForm');
        $routes->post('apagar', 'FormController::deleteFormView');
        $routes->post('apagar-data', 'FormController::deleteForm');

        $routes->post('publicar', 'FormController::postFormView');
        $routes->post('publicar-data', 'FormController::postForm');

        $routes->get('modelar', 'FormController::mainFormsView');
        $routes->get('modelar/(:num)', 'FormController::modellingFormView/$1');
        $routes->post('modelar-data', 'FormController::modellingForm');

        $routes->get('respostas', 'FormController::mainFormsView');
        $routes->get('respostas/(:num)', 'FormController::answersView/$1');
        $routes->post('respostas/detalhe', 'FormController::answersDetailedView');

        $routes->post('resumo', 'FormController::answersSummaryView');

        $routes->get('compartilhar/(:num)', 'FormController::shareFormView/$1');
        $routes->post('compartilhar-form', 'FormController::newShareFormView');
        $routes->post('compartilhar-data', 'FormController::shareForm');
        $routes->post('compartilhar-apagar', 'FormController::deleteShareFormView');
        $routes->post('compartilhar-apagar-data', 'FormController::deleteShare');
    });

    $routes->post('externo', 'UserController::mainExternalView');
    $routes->post('externo-data', 'UserController::newExternal');

    $routes->get('alterar-senha', 'UserController::changePasswordView');
    $routes->post('alterar-data', 'UserController::changePassword');

    $routes->get('relatorios', 'ReportsController::reports');
    $routes->get('relatorio/fechamento/(:num)/pdf', 'ReportsController::reportDetail/$1');
    $routes->get('ajustes', 'Home::settings');
});

$routes->group('admin', ['filter' => \App\Filters\AdminAuth::class], static function ($routes) {
    $routes->group('usuarios', static function ($routes) {
        $routes->get('', 'UserController::mainUserView');
        $routes->get('novo', 'UserController::addUserView');
        $routes->post('novo-data', 'UserController::newUser');
        $routes->post('editar', 'UserController::editUserView');
        $routes->post('editar-data', 'UserController::editUser');
        $routes->post('apagar', 'UserController::deleteUserView');
        $routes->post('apagar-data', 'UserController::deleteUser');

        $routes->post('toggle', 'UserController::toggleUserView');
        $routes->post('toggle-data', 'UserController::toggleUser');
    });

    $routes->group('grupos', static function ($routes) {
        $routes->get('', 'GroupController::mainGroupsView');
        $routes->get('novo', 'GroupController::addGroupView');
        $routes->post('novo-data', 'GroupController::newGroup');
        $routes->post('editar', 'GroupController::editGroupView');
        $routes->post('editar-data', 'GroupController::editGroup');
        $routes->post('apagar', 'GroupController::deleteGroupView');
        $routes->post('apagar-data', 'GroupController::deleteGroup');
    });


});

$routes->group('api', ['filter' => \App\Filters\ApiAuth::class], static function ($routes) {
    $routes->post('login', 'ApiController::login');
    $routes->post('listar-usuario', 'ApiController::removeUser');
    $routes->get('listar-usuarios', 'ApiController::removeUser');
    $routes->post('cadastrar-usuario', 'ApiController::newUser');
    $routes->post('alterar-usuario', 'ApiController::updateUser');
    $routes->post('apagar-usuario', 'ApiController::removeUser');
    $routes->get('respostas/(:num)', 'ApiController::getSummaryResponses/$1');
});
