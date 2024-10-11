<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

//user
$routes->get('/login', 'Usercontroller::login');
$routes->get('/', 'Usercontroller::index',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store', 'UserController::store',['filter' => 'authGuard']);
$routes->get('/booking', 'Usercontroller::booking',['filter' => 'authGuard']);
$routes->get('/doctor/getDoctorDetails/(:num)', 'UserController::getDoctorDetails/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/booking/checkout', 'UserController::checkout',['filter' => 'authGuard']);
$routes->match(['post','get'],'/dashboard', 'UserController::user_db',['filter' => 'authGuard']);
$routes->match(['post','get'],'/profile-settings', 'UserController::user_prof_setting',['filter' => 'authGuard']);
$routes->match(['post','get'],'/user/update_profile_settings', 'UserController::update_prof_setting',['filter' => 'authGuard']);
$routes->match(['post','get'],'/change-password', 'UserController::user_change_password',['filter' => 'authGuard']);
$routes->match(['post','get'],'/user/update-password', 'UserController::update_change_password',['filter' => 'authGuard']);
$routes->match(['post','get'],'/doctor-profile/(:num)', 'UserController::doctorProfile/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/user/generatePres/(:num)/(:num)', 'UserController::gen_prescript/$1/$2',['filter' => 'authGuard']);
$routes->match(['post','get'],'/tryon', 'UserController::tryon',['filter' => 'authGuard']);

//prod
$routes->match(['post','get'],'/store/product/(:num)', 'UserController::showProdDetails/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store/cart/addToCart', 'UserController::addToCart',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store/cart', 'UserController::viewCart',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store/cart/remove/(:num)', 'UserController::removeItem/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store/cart/checkout', 'UserController::item_checkout',['filter' => 'authGuard']);
$routes->match(['post','get'],'/store/orders', 'UserController::user_orders',['filter' => 'authGuard']);
$routes->match(['post','get'],'/purchase/cancel/(:num)', 'UserController::cancelPurchase/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/purchase/getBill/(:num)', 'UserController::getBill/$1',['filter' => 'authGuard']);




///
$routes->get('/register', 'Usercontroller::register');
$routes->match(['post','get'],'/register-user', 'UserController::register_user');
$routes->get('/verify-user', 'UserController::verify');
$routes->match(['post','get'],'/verify-code', 'UserController::verifyCode');
$routes->match(['post','get'],'/fn_login', 'UserController::fn_login');
$routes->match(['post','get'],'/forgot-password', 'UserController::forgot_pass');
$routes->post('verify-email', 'UserController::checkEmail');

$routes->get('reset-password', 'UserController::resetPasswordForm');
$routes->post('reset-password', 'UserController::resetPassword');

//patient
$routes->match(['post','get'],'patient/insertBooking', 'PatientController::insertBooking',['filter' => 'authGuard']);
$routes->match(['post','get'],'feedback/addReview', 'UserController::addReview',['filter' => 'authGuard']);
//appointmet
$routes->match(['post','get'],'booking/booked-dates', 'PatientController::getBookedDates',['filter' => 'authGuard']);
$routes->match(['post','get'],'available-time-slots', 'PatientController::getAvailableTimeSlots',['filter' => 'authGuard']);
$routes->match(['post','get'],'appointments/cancel/(:num)', 'PatientController::cancelAppointment/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'appointments/print/(:num)', 'PatientController::printAppt/$1',['filter' => 'authGuard']);


// doctor
$routes->get('/Doctor/Dashboard', 'UserController::db_doctor',['filter' => 'authGuard']);
$routes->get('/Doctor/Products', 'UserController::product',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Schedule', 'Doctorcontroller::schedule_timings',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Appointments', 'Doctorcontroller::appointments',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Patients', 'Doctorcontroller::patients',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Reviews', 'Doctorcontroller::reviews',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Prof-Settings', 'Doctorcontroller::prof_settings',['filter' => 'authGuard']);
$routes->get('/Doctor/Dashboard/Change-password', 'Doctorcontroller::change_password',['filter' => 'authGuard']);
$routes->get('/session', 'Usercontroller::checkSessionData');
$routes->get('/logout', 'Usercontroller::logout',['filter' => 'authGuard']);
$routes->match(['post','get'],'doctor/update_prof_settings', 'DoctorController::update_prof_settings',['filter' => 'authGuard']);
$routes->match(['post','get'],'doctor/update_password', 'DoctorController::update_password',['filter' => 'authGuard']);
$routes->match(['post','get'],'schedule/insert', 'DoctorController::insertSchedule',['filter' => 'authGuard']);
$routes->match(['post','get'],'schedule/delete/(:num)', 'DoctorController::deleteSchedule/$1',['filter' => 'authGuard']);

//register doctor
// Route for user registration
$routes->post('admin/doc-register', 'AdminController::register_doctor');

// Route for email verification
$routes->get('/doctor/verifyEmail/(:any)', 'AdminController::verifyEmail/$1');

//
$routes->match(['post','get'],'/getDoctorsData', 'DoctorController::getDoctorsData',['filter' => 'authGuard']);
$routes->match(['post','get'],'getPatients', 'DoctorController::getPatients',['filter' => 'authGuard']);
$routes->match(['post','get'],'getAppointmentsByDoctorUsername/(:any)', 'DoctorController::getAppointmentsByDoctorUsername/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'approveAppointment/(:any)/(:any)', 'DoctorController::approveAppointment/$1/$2',['filter' => 'authGuard']);
$routes->match(['post','get'],'sendApprovalEmail', 'DoctorController::sendApprovalEmail',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Patients-Profile/(:num)', 'DoctorController::getPatients_Profile/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Add-Prescription/Patients-Profile/(:num)', 'DoctorController::show_prof_pres/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Insert-Prescription/Patients-Profile/(:num)', 'DoctorController::insert_prof_pres/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Edit-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::edit_prof_pres/$1/$2',['filter' => 'authGuard']);
$routes->match(['post','get'],'/report/generatePres/(:num)/Patients-Profile/(:num)', 'DoctorController::generatePres/$1/$2',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Update-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::update_prof_pres/$1/$2',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Insert-Recent-Prescription/Patients-Profile/(:num)', 'DoctorController::insert_recent_prof_pres/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Doctor/Dashboard/Delete-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::delete_prof_pres/$1/$2',['filter' => 'authGuard']);
//
$routes->post('send-notification', 'NotificationController::send');


//admin//
$routes->get('/Admin/Dashboard', 'UserController::db_admin',['filter' => 'authGuard']);
//products
$routes->match(['post','get'],'/Admin/Products', 'AdminController::showProducts',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Products/Add_Product', 'AdminController::addProduct',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Products/insert_Product', 'AdminController::insertProduct',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Products/Edit_Product/(:num)', 'AdminController::editProduct/$1',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Products/update_Product', 'AdminController::updateProduct',['filter' => 'authGuard']);

$routes->match(['post','get'],'/Admin/Appointments', 'AdminController::showAppt',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Doctors', 'AdminController::showDoctors',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Patients', 'AdminController::showPatients',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Reviews', 'AdminController::showReviews',['filter' => 'authGuard']);
$routes->match(['post','get'],'/Admin/Profile', 'AdminController::showProfile',['filter' => 'authGuard']);
$routes->match(['post','get'],'admin/update_profile_settings', 'AdminController::updateProfile',['filter' => 'authGuard']);
$routes->match(['post','get'],'admin/update-password', 'AdminController::updateAdminPass',['filter' => 'authGuard']);

$routes->post('report/generateReport', 'AdminController::generateReport');
//
// app/Config/Routes.php
$routes->get('/scheduler/update-status', 'AdminController::updateScheduleStatus');


//
$routes->post('purchase/updateStatus', 'AdminController::updateStatus');
