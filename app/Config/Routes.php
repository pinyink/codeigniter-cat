<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth:Y']);
$routes->get('/home', 'Home::index', ['filter' => 'auth:Y']);
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('auth', 'Login::loginAksi');

$routes->get('/setting', 'SettingController::index', ['filter' => 'admin', 'namespace' => 'App\Controllers']);
$routes->get('/setting/profil', 'Profil::index', ['filter' => 'auth:Y', 'namespace' => 'App\Controllers\Setting']);
$routes->get('/setting/profil/getData', 'Profil::getData', ['filter' => 'auth:N' , 'namespace' => 'App\Controllers\Setting']);
$routes->post('/setting/profil/update', 'Profil::update', ['filter' => 'auth:N', 'namespace' => 'App\Controllers\Setting']);
$routes->post('/setting/profil/updateFoto', 'Profil::updateFoto', ['filter' => 'auth:N', 'namespace' => 'App\Controllers\Setting']);
$routes->post('/setting/profil/updatePassword', 'Profil::updatePassword', ['filter' => 'auth:N', 'namespace' => 'App\Controllers\Setting']);

$routes->group('crud', ['namespace' => 'App\Controllers', 'filter' => 'admin'], static function($routes) {
    $routes->get('/', 'CrudController::index');
    $routes->post('table', 'CrudController::table');
    $routes->post('result', 'CrudController::result');
});

$routes->group('/crid', ['namespace' => 'App\Controllers', 'filter' => 'admin'], static function($routes) {
    $routes->get('/', 'CridController::index');
    $routes->post('ajax_list', 'CridController::ajaxList');
    $routes->post('save_data', 'CridController::saveData');
    $routes->post('update_data', 'CridController::saveData');
    $routes->get('(:num)/get_data', 'CridController::getData/$1');
    $routes->delete('(:num)/delete_data', 'CridController::deleteData/$1');
	$routes->post('table_exist', 'CridController::tableExist');

    $routes->get('(:num)/generate_crud', 'CridController::generateCrud/$1');
});

$routes->group('/criddetail', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('/', 'CridDetailController::index', ['filter' => 'admin']);
    $routes->post('ajax_list', 'CridDetailController::ajaxList', ['filter' => 'admin']);
    $routes->post('save_data', 'CridDetailController::saveData', ['filter' => 'admin']);
    $routes->post('update_data', 'CridDetailController::saveData', ['filter' => 'admin']);
    $routes->get('(:num)/get_data', 'CridDetailController::getData/$1', ['filter' => 'admin']);
    $routes->delete('(:num)/delete_data', 'CridDetailController::deleteData/$1', ['filter' => 'admin']);
	$routes->post('name_field_exist', 'CridDetailController::namefieldExist', ['filter' => 'admin']);
    $routes->get('(:num)/by_crid_id', 'CridDetailController::byCridId/$1', ['filter' => 'admin']);
});

/**
 * Admin
 */
$routes->group('/admin/user', ['namespace' => 'App\Controllers\Admin'], static function($routes) {
    $routes->get('/', 'UserController::index', ['filter' => 'admin']);
    $routes->post('ajax_list', 'UserController::ajaxList', ['filter' => 'adminjson']);
    $routes->post('save_data', 'UserController::saveData', ['filter' => 'adminjson']);
    $routes->get('get_data/(:num)', 'UserController::getData/$1', ['filter' => 'adminjson']);
    $routes->delete('delete_data/(:num)', 'UserController::deleteData/$1', ['filter' => 'adminjson']);
	$routes->post('user_username_exist', 'UserController::userusernameExist', ['filter' => 'adminjson']);
});

$routes->group('/admin/policy', ['namespace' => 'App\Controllers\Admin'], static function($routes) {
    $routes->get('/', 'PolicyController::index', ['filter' => 'admin']);
    $routes->post('ajax_list', 'PolicyController::ajaxList', ['filter' => 'adminjson']);
    $routes->post('save_data', 'PolicyController::saveData', ['filter' => 'adminjson']);
    $routes->post('update_data', 'PolicyController::saveData', ['filter' => 'adminjson']);
    $routes->get('(:any)/get_data', 'PolicyController::getData/$1', ['filter' => 'adminjson']);
    $routes->delete('(:any)/delete_data', 'PolicyController::deleteData/$1', ['filter' => 'adminjson']);
	$routes->post('policy_id_exist', 'PolicyController::policyidExist', ['filter' => 'adminjson']);
    $routes->get('menuList/(:any)', 'PolicyController::menuList/$1', ['filter' => 'adminjson']);
    $routes->post('saveSubMenu', 'PolicyController::saveSubMenu', ['filter' => 'adminjson', 'namespace' => 'App\Controllers\Admin']);
    $routes->post('addPolicy', 'PolicyController::addPolicy', ['filter' => 'adminjson']);
    $routes->post('removePolicy', 'PolicyController::removePolicy', ['filter' => 'adminjson']);
});

$routes->group('/admin/menu', ['namespace' => 'App\Controllers\Admin'], static function($routes) {
    $routes->get('/', 'MenuController::index', ['filter' => 'admin']);
    $routes->post('ajax_list', 'MenuController::ajaxList', ['filter' => 'adminjson']);
    $routes->post('save_data', 'MenuController::saveData', ['filter' => 'adminjson']);
    $routes->get('get_data/(:num)', 'MenuController::getData/$1', ['filter' => 'adminjson']);
    $routes->delete('delete_data/(:num)', 'MenuController::deleteData/$1', ['filter' => 'adminjson']);
	$routes->post('menu_desc_exist', 'MenuController::menudescExist', ['filter' => 'adminjson']);
});
$routes->group('/admin/menuakses', ['namespace' => 'App\Controllers\Admin'], static function($routes) {
    $routes->post('save_data', 'MenuAksesController::saveData', ['filter' => 'adminjson']);
    $routes->get('get_data/(:num)', 'MenuAksesController::getData/$1', ['filter' => 'adminjson']);
    $routes->delete('delete_data/(:num)', 'MenuAksesController::deleteData/$1', ['filter' => 'adminjson']);
});

$routes->group('statistic', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('/', 'StatisticController::index', ['filter' => 'admin']);
    $routes->post('permonth', 'StatisticController::permonth', ['filter' => 'admin']);
});
/**
 * Menu Content
 */
$routes->get('/menu_dua', 'Menu_dua::index', ['namespace' => 'App\Controllers']);
$routes->get('/menu_dua_db', 'Menu_dua::createDb', ['namespace' => 'App\Controllers']);
$routes->get('/menu_satu', 'Menu_satu::index', ['filter' => 'auth:N, 1, 1', 'namespace' => 'App\Controllers']);

$routes->group('ref_jenis_soal', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('index', 'RefJenisSoalController::index', ['filter' => 'auth:Y,1,1']);
    $routes->post('ajax_list', 'RefJenisSoalController::ajaxList', ['filter' => 'auth:N,1,1']);
    $routes->get('tambah', 'RefJenisSoalController::tambahData', ['filter' => 'auth:N,1,2']);
    $routes->post('save', 'RefJenisSoalController::saveData', ['filter' => 'auth:N,1,2']);
    $routes->get('(:num)/detail', 'RefJenisSoalController::detailData/$1', ['filter' => 'auth:Y,1,1']);
    $routes->get('(:num)/edit', 'RefJenisSoalController::editData/$1', ['filter' => 'auth:N,1,3']);
    $routes->post('update', 'RefJenisSoalController::saveData', ['filter' => 'auth:N,1,3']);
    $routes->delete('(:num)/delete', 'RefJenisSoalController::deleteData/$1', ['filter' => 'auth:N,1,4']);
});

$routes->group('ref_soal', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('index', 'RefSoalController::index', ['filter' => 'auth:Y,2,1']);
    $routes->post('ajax_list', 'RefSoalController::ajaxList', ['filter' => 'auth:N,2,1']);
    $routes->get('tambah', 'RefSoalController::tambahData', ['filter' => 'auth:N,2,2']);
    $routes->post('save', 'RefSoalController::saveData', ['filter' => 'auth:N,2,2']);
    $routes->get('(:num)/detail', 'RefSoalController::detailData/$1', ['filter' => 'auth:Y,2,1']);
    $routes->get('(:num)/edit', 'RefSoalController::editData/$1', ['filter' => 'auth:N,2,3']);
    $routes->post('update', 'RefSoalController::saveData', ['filter' => 'auth:N,2,3']);
    $routes->delete('(:num)/delete', 'RefSoalController::deleteData/$1', ['filter' => 'auth:N,2,4']);
});

$routes->group('images', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('index', 'ImagesController::index', ['filter' => 'auth:Y,3,1']);
    $routes->post('ajax_list', 'ImagesController::ajaxList', ['filter' => 'auth:N,3,1']);
    $routes->get('tambah', 'ImagesController::tambahData', ['filter' => 'auth:N,3,2']);
    $routes->post('save', 'ImagesController::saveData', ['filter' => 'auth:N,3,2']);
    $routes->get('(:num)/detail', 'ImagesController::detailData/$1', ['filter' => 'auth:Y,3,1']);
    $routes->get('(:num)/edit', 'ImagesController::editData/$1', ['filter' => 'auth:N,3,3']);
    $routes->post('update', 'ImagesController::saveData', ['filter' => 'auth:N,3,3']);
    $routes->delete('(:num)/delete', 'ImagesController::deleteData/$1', ['filter' => 'auth:N,3,4']);
});

$routes->group('ref_formasi', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('index', 'RefFormasiController::index', ['filter' => 'auth:Y,4,1']);
    $routes->post('ajax_list', 'RefFormasiController::ajaxList', ['filter' => 'auth:N,4,1']);
    $routes->get('tambah', 'RefFormasiController::tambahData', ['filter' => 'auth:N,4,2']);
    $routes->post('save', 'RefFormasiController::saveData', ['filter' => 'auth:N,4,2']);
    $routes->get('(:num)/detail', 'RefFormasiController::detailData/$1', ['filter' => 'auth:Y,4,1']);
    $routes->get('(:num)/edit', 'RefFormasiController::editData/$1', ['filter' => 'auth:N,4,3']);
    $routes->post('update', 'RefFormasiController::saveData', ['filter' => 'auth:N,4,3']);
    $routes->delete('(:num)/delete', 'RefFormasiController::deleteData/$1', ['filter' => 'auth:N,4,4']);
});

$routes->group('ref_formasi_soal', ['namespace' => 'App\Controllers'], static function($routes) {
    $routes->get('index', 'RefFormasiSoalController::index', ['filter' => 'auth:Y,4,1']);
    $routes->post('ajax_list', 'RefFormasiSoalController::ajaxList', ['filter' => 'auth:N,4,1']);
    $routes->get('tambah', 'RefFormasiSoalController::tambahData', ['filter' => 'auth:N,4,2']);
    $routes->post('save', 'RefFormasiSoalController::saveData', ['filter' => 'auth:N,4,2']);
    $routes->get('(:num)/detail', 'RefFormasiSoalController::detailData/$1', ['filter' => 'auth:Y,4,1']);
    $routes->get('(:num)/edit', 'RefFormasiSoalController::editData/$1', ['filter' => 'auth:N,4,3']);
    $routes->post('update', 'RefFormasiSoalController::saveData', ['filter' => 'auth:N,4,3']);
    $routes->delete('(:num)/delete', 'RefFormasiSoalController::deleteData/$1', ['filter' => 'auth:N,4,4']);
});