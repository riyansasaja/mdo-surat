<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('countinbox', 'CountData::countInbox');
$routes->get('countoutbox', 'CountData::countOutbox');
$routes->get('profile', 'Home::profile');
$routes->get('logact', 'SuratKeluar::index');
$routes->post('password', 'Home::updatePassword');

$routes->group('menej', ['filter' => 'role:admin,operator'], function ($routes) {
    $routes->get('kodesurat', 'Manajemen::kodesurat');
    $routes->post('addkodesurat', 'Manajemen::addKodeSurat');
    $routes->get('deletekodesurat/(:num)', 'Manajemen::deleteKodesurat/$1');
    $routes->get('jabatan', 'Manajemen::showjabatan');
    $routes->get('deletejabatan/(:num)', 'Manajemen::deleteJabatan/$1');
    $routes->post('addjabatan/', 'Manajemen::addJabatan');
});

$routes->group('users', function ($routes) {
    $routes->get('/', 'Home::usersManajemen', ['filter' => 'permission:manage-users']);
    $routes->get('user/(:num)', 'Home::userDetil/$1', ['filter' => 'permission:manage-users']);
    $routes->post('addUser', 'Home::addUser', ['filter' => 'permission:manage-users']);
    $routes->post('editUser', 'Home::editUser', ['filter' => 'role:user, manager, admin, operator']);
    $routes->post('addusertogroup', 'Home::addusertoGroup', ['filter' => 'permission:manage-users']);
    $routes->get('removefromgroup/(:num)/(:num)', 'Home::removefromGroup/$1/$2', ['filter' => 'permission:manage-users']);
});

$routes->group('regsm', ['filter' => 'permission:manage-users, manage-regist'], function ($routes) {
    $routes->get('/', 'Registrasi::suratMasuk');
    $routes->get('regsmdetil/(:any)', 'Registrasi::detilSuratMasuk/$1');
    $routes->post('add', 'Registrasi::addSM');
    $routes->post('edit', 'Registrasi::editSuratMasuk');
    $routes->post('despoted', 'Registrasi::despoted');
    $routes->get('redespoted/(:num)', 'Registrasi::redespoted/$1');
    $routes->get('delete/(:num)', 'Registrasi::deleteSuratMasuk/$1');
    $routes->post('inattach', 'Registrasi::addinmailAttachment');
    $routes->get('dellattach/(:any)/(:any)/(:num)', 'Registrasi::delinmailAttachment/$1/$2/$3');
});

$routes->group('regso', ['filter' => 'role:user, manager, admin, operator'], function ($routes) {
    $routes->get('/', 'SuratKeluar::index');
});

//routes untuk proses management mail terusan
$routes->group('inmailmanage', ['filter' => 'role:manager'], function ($routes) {
    $routes->get('/', 'MailManager::index');
});

//untuk User / processinmail
$routes->group('inmail', ['filter' => 'role:user, manager, admin, operator'], function ($routes) {
    $routes->get('/', 'InmailController::index');
    $routes->get('showdespoted', 'InmailController::showDespoted');
    $routes->get('/despoted', 'InmailController::index');
    $routes->get('detilmail/(:num)', 'InmailController::getbyid/$1');
    $routes->post('despoted', 'InmailController::despoted');
    $routes->post('eviden', 'InmailController::addEviden');
    $routes->get('deldispo/(:num)', 'InmailController::delDispo/$1');
});
