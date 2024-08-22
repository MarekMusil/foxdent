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
//$routes->setDefaultController('LoginController');
//$routes->setDefaultMethod('index');
//$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Error\ErrorController::index405');

$routes->post('/accounts/check_login/app', 'Account\AccountController::checkLogin');
$routes->post('/accounts/login/app', 'Account\AccountController::login');
//$routes->post('/accounts/singleLogin', 'Account\AccountController::singleLogin');
$routes->post('/accounts/passwords/reset', 'Account\AccountController::resetPassword');
$routes->post('/accounts/passwords/new', 'Account\AccountController::newPassword');
$routes->post('/accounts/update_password', 'Account\AccountController::updatePassword');
$routes->post('/accounts/activate', 'Account\AccountController::activateAccount');
$routes->put('/accounts/me', 'Account\AccountMeController::update');
$routes->put('/accounts/me/passwords', 'Account\AccountMeController::updatePassword');

$routes->get('/users', 'User\UserController::get');
$routes->get('/users/(:num)', 'User\UserController::detail/$1');
$routes->post('/users', 'User\UserController::create');
$routes->put('/users/(:num)', 'User\UserController::update/$1');
$routes->post('/users/(:num)/upload/signature', 'User\UserController::uploadSignature/$1');

$routes->get('/employees', 'Employee\EmployeeController::get');
$routes->get('/employees/(:num)', 'Employee\EmployeeController::detail/$1');
$routes->post('/employees', 'Employee\EmployeeController::create');
$routes->put('/employees/(:num)', 'Employee\EmployeeController::update/$1');
$routes->post('/employees/(:num)/upload/photo', 'Employee\EmployeeController::uploadPhoto/$1');
$routes->post('/employees/upload/photo', 'Employee\EmployeeController::uploadPhoto');

$routes->get('/texts', 'Text\TextController::get');
$routes->get('/texts/(:num)', 'Text\TextController::detail/$1');
$routes->put('/texts/(:num)', 'Text\TextController::update/$1');
$routes->post('/texts', 'Text\TextController::create');

$routes->get('/texts/services', 'Text\TextController::getServices');
$routes->get('/texts/technologies', 'Text\TextController::getTechnologies');
$routes->put('/texts/services', 'Text\TextController::updateServices');
$routes->put('/texts/technologies', 'Text\TextController::updateTechnologies');

$routes->get('/pricelists', 'Pricelist\PricelistController::get');
//$routes->get('/pricelists/(:num)', 'Pricelist\PricelistController::detail/$1');
$routes->put('/pricelists', 'Pricelist\PricelistController::update');

$routes->get('/content', 'Content\ContentController::get');
$routes->get('/content/check', 'Content\ContentController::check');

$routes->get('/insurances', 'Insurance\InsuranceController::get');
$routes->put('/insurances', 'Insurance\InsuranceController::update');

$routes->get('/contact/data', 'ContactData\ContactDataController::get');
$routes->put('/contact/data', 'ContactData\ContactDataController::update');

$routes->get('/important_messages', 'ImportantMessage\ImportantMessageController::get');
$routes->put('/important_messages', 'ImportantMessage\ImportantMessageController::update');

$routes->get('/ratings', 'Rating\RatingController::get');
$routes->put('/ratings', 'Rating\RatingController::update');

$routes->get('/slides', 'Slide\SlideController::get');
$routes->get('/slides/(:num)', 'Slide\SlideController::detail/$1');
$routes->post('/slides', 'Slide\SlideController::create');
$routes->put('/slides/(:num)', 'Slide\SlideController::update/$1');
$routes->post('/slides/(:num)/upload/photo', 'Slide\SlideController::uploadPhoto/$1');
$routes->post('/slides/upload/photo', 'Slide\SlideController::uploadPhoto');

$routes->get('/systems/options', 'System\SystemOptionController::get');

$routes->get('test', 'Test\TestController::index');

$routes->options('/(:any)', 'Request\RequestController::index');

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}