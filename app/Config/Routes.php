<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('menej', ['filter' => 'role:admin,operator'], function($routes) {
   $routes->get('kodesurat', 'Manajemen::kodesurat');
   $routes->post('addkodesurat', 'Manajemen::addKodeSurat');
   $routes->get('deletekodesurat/(:num)', 'Manajemen::deleteKodesurat/$1');
   $routes->get('jabatan', 'Manajemen::showjabatan');
   $routes->get('deletejabatan/(:num)', 'Manajemen::deleteJabatan/$1');
   $routes->post('addjabatan/', 'Manajemen::addJabatan');
});

$routes->group('users', ['filter' => 'permission:manage-users'], function ($routes) {
    $routes->get('/', 'Home::usersManajemen');
    $routes->get('user/(:num)', 'Home::userDetil/$1');
    $routes->post('addUser', 'Home::addUser');
    $routes->post('editUser', 'Home::editUser');
    $routes->post('addusertogroup', 'Home::addusertoGroup');
    $routes->get('removefromgroup/(:num)/(:num)', 'Home::removefromGroup/$1/$2');
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


//untuk User / processinmail
$routes->group('inmail', ['filter' => 'permission:process_inmail'], function ($routes) {
    $routes->get('/', 'InmailController::index');
    $routes->get('showdespoted', 'InmailController::showDespoted');
    $routes->get('/despoted', 'InmailController::index');
    $routes->get('detilmail/(:num)', 'InmailController::getbyid/$1');
    $routes->post('despoted', 'InmailController::despoted');
    $routes->post('eviden', 'InmailController::addEviden');

});




##sebelum dilakukan grouping
//Managemen Users
// $routes->get('/users', 'Home::usersManajemen', ['filter' => 'permission:manage-users']);
// $routes->get('/user/(:num)', 'Home::userDetil/$1', ['filter' => 'permission:manage-users']);
// $routes->get('/regsm', 'Registrasi::suratMasuk', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->get('/regsmdetil/(:any)', 'Registrasi::detilSuratMasuk/$1', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->post('/regsm/add', 'Registrasi::addSM', ['filter' => 'permission:manage-users']);
// $routes->post('/regsm/edit', 'Registrasi::editSuratMasuk', ['filter' => 'permission:manage-users']);
// $routes->post('/regsm/despoted', 'Registrasi::despoted', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->get('/regsm/redespoted/(:num)', 'Registrasi::redespoted/$1', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->get('/regsm/delete/(:num)', 'Registrasi::deleteSuratMasuk/$1', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->post('/regsm/inattach', 'Registrasi::addinmailAttachment', ['filter' => 'permission:manage-users']);
// $routes->get('/regsm/dellattach/(:any)/(:any)/(:num)', 'Registrasi::delinmailAttachment/$1/$2/$3', ['filter' => 'permission:manage-users, manage-regist']);
// $routes->post('/addUser', 'Home::addUser', ['filter' => 'permission:manage-users']);
// $routes->post('/editUser', 'Home::editUser', ['filter' => 'permission:manage-users']);
##end ##########################################