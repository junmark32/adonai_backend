<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

//user
$routes->get('/login', 'Usercontroller::login');
$routes->get('/', 'Usercontroller::index');
$routes->match(['post','get'],'/store', 'UserController::store');
$routes->get('/booking', 'Usercontroller::booking');
$routes->get('/doctor/getDoctorDetails/(:num)', 'UserController::getDoctorDetails/$1');
$routes->match(['post','get'],'/booking/checkout', 'UserController::checkout');
$routes->match(['post','get'],'/dashboard', 'UserController::user_db');

//prod
$routes->match(['post','get'],'/store/product/(:num)', 'UserController::showProdDetails/$1');
$routes->match(['post','get'],'/store/cart/addToCart', 'UserController::addToCart');
$routes->match(['post','get'],'/store/cart', 'UserController::viewCart');
$routes->match(['post','get'],'/store/cart/remove/(:num)', 'UserController::removeItem/$1');
$routes->match(['post','get'],'/store/cart/checkout', 'UserController::item_checkout');


///
$routes->get('/register', 'Usercontroller::register');
$routes->match(['post','get'],'/register-user', 'UserController::register_user');
$routes->get('/verify-user', 'UserController::verify');
$routes->match(['post','get'],'/verify-code', 'UserController::verifyCode');
$routes->match(['post','get'],'/fn_login', 'UserController::fn_login');


//patient
$routes->match(['post','get'],'patient/insertBooking', 'PatientController::insertBooking');
//appointmet
$routes->match(['post','get'],'booking/booked-dates', 'PatientController::getBookedDates');
$routes->match(['post','get'],'available-time-slots', 'PatientController::getAvailableTimeSlots');
$routes->match(['post','get'],'appointments/cancel/(:num)', 'PatientController::cancelAppointment/$1');


// doctor
$routes->get('/Doctor/Dashboard', 'UserController::db_doctor');
$routes->get('/Doctor/Dashboard/Schedule', 'Doctorcontroller::schedule_timings');
$routes->get('/session', 'Usercontroller::checkSessionData');
$routes->match(['post','get'],'schedule/insert', 'DoctorController::insertSchedule');
//
$routes->match(['post','get'],'/getDoctorsData', 'DoctorController::getDoctorsData');
$routes->match(['post','get'],'getPatients', 'DoctorController::getPatients');
$routes->match(['post','get'],'getAppointmentsByDoctorUsername/(:any)', 'DoctorController::getAppointmentsByDoctorUsername/$1');
$routes->match(['post','get'],'approveAppointment/(:any)/(:any)', 'DoctorController::approveAppointment/$1/$2');
$routes->match(['post','get'],'sendApprovalEmail', 'DoctorController::sendApprovalEmail');

//admin//
$routes->get('/Admin/Dashboard', 'UserController::db_admin');
//products
$routes->match(['post','get'],'/Admin/Products', 'AdminController::showProducts');
$routes->match(['post','get'],'/Admin/Products/Add_Product', 'AdminController::addProduct');
$routes->match(['post','get'],'/Admin/Products/insert_Product', 'AdminController::insertProduct');
$routes->match(['post','get'],'/Admin/Products/Edit_Product/(:num)', 'AdminController::editProduct/$1');
$routes->match(['post','get'],'/Admin/Products/update_Product', 'AdminController::updateProduct');