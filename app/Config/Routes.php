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
$routes->match(['post','get'],'/profile-settings', 'UserController::user_prof_setting');
$routes->match(['post','get'],'/user/update_profile_settings', 'UserController::update_prof_setting');
$routes->match(['post','get'],'/change-password', 'UserController::user_change_password');
$routes->match(['post','get'],'/user/update-password', 'UserController::update_change_password');
$routes->match(['post','get'],'/doctor-profile/(:num)', 'UserController::doctorProfile/$1');
$routes->match(['post','get'],'/user/generatePres/(:num)/(:num)', 'UserController::gen_prescript/$1/$2');

//prod
$routes->match(['post','get'],'/store/product/(:num)', 'UserController::showProdDetails/$1');
$routes->match(['post','get'],'/store/cart/addToCart', 'UserController::addToCart');
$routes->match(['post','get'],'/store/cart', 'UserController::viewCart');
$routes->match(['post','get'],'/store/cart/remove/(:num)', 'UserController::removeItem/$1');
$routes->match(['post','get'],'/store/cart/checkout', 'UserController::item_checkout');
$routes->match(['post','get'],'/store/orders', 'UserController::user_orders');
$routes->match(['post','get'],'/purchase/cancel/(:num)', 'UserController::cancelPurchase/$1');
$routes->match(['post','get'],'/purchase/getBill/(:num)', 'UserController::getBill/$1');




///
$routes->get('/register', 'Usercontroller::register');
$routes->match(['post','get'],'/register-user', 'UserController::register_user');
$routes->get('/verify-user', 'UserController::verify');
$routes->match(['post','get'],'/verify-code', 'UserController::verifyCode');
$routes->match(['post','get'],'/fn_login', 'UserController::fn_login');


//patient
$routes->match(['post','get'],'patient/insertBooking', 'PatientController::insertBooking');
$routes->match(['post','get'],'feedback/addReview', 'UserController::addReview');
//appointmet
$routes->match(['post','get'],'booking/booked-dates', 'PatientController::getBookedDates');
$routes->match(['post','get'],'available-time-slots', 'PatientController::getAvailableTimeSlots');
$routes->match(['post','get'],'appointments/cancel/(:num)', 'PatientController::cancelAppointment/$1');
$routes->match(['post','get'],'appointments/print/(:num)', 'PatientController::printAppt/$1');


// doctor
$routes->get('/Doctor/Dashboard', 'UserController::db_doctor');
$routes->get('/Doctor/Products', 'UserController::product');
$routes->get('/Doctor/Dashboard/Schedule', 'Doctorcontroller::schedule_timings');
$routes->get('/Doctor/Dashboard/Appointments', 'Doctorcontroller::appointments');
$routes->get('/Doctor/Dashboard/Patients', 'Doctorcontroller::patients');
$routes->get('/Doctor/Dashboard/Reviews', 'Doctorcontroller::reviews');
$routes->get('/Doctor/Dashboard/Prof-Settings', 'Doctorcontroller::prof_settings');
$routes->get('/Doctor/Dashboard/Change-password', 'Doctorcontroller::change_password');
$routes->get('/session', 'Usercontroller::checkSessionData');
$routes->get('/logout', 'Usercontroller::logout');
$routes->match(['post','get'],'doctor/update_prof_settings', 'DoctorController::update_prof_settings');
$routes->match(['post','get'],'doctor/update_password', 'DoctorController::update_password');
$routes->match(['post','get'],'schedule/insert', 'DoctorController::insertSchedule');
$routes->match(['post','get'],'schedule/delete/(:num)', 'DoctorController::deleteSchedule/$1');

//
$routes->match(['post','get'],'/getDoctorsData', 'DoctorController::getDoctorsData');
$routes->match(['post','get'],'getPatients', 'DoctorController::getPatients');
$routes->match(['post','get'],'getAppointmentsByDoctorUsername/(:any)', 'DoctorController::getAppointmentsByDoctorUsername/$1');
$routes->match(['post','get'],'approveAppointment/(:any)/(:any)', 'DoctorController::approveAppointment/$1/$2');
$routes->match(['post','get'],'sendApprovalEmail', 'DoctorController::sendApprovalEmail');
$routes->match(['post','get'],'/Doctor/Dashboard/Patients-Profile/(:num)', 'DoctorController::getPatients_Profile/$1');
$routes->match(['post','get'],'/Doctor/Dashboard/Add-Prescription/Patients-Profile/(:num)', 'DoctorController::show_prof_pres/$1');
$routes->match(['post','get'],'/Doctor/Dashboard/Insert-Prescription/Patients-Profile/(:num)', 'DoctorController::insert_prof_pres/$1');
$routes->match(['post','get'],'/Doctor/Dashboard/Edit-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::edit_prof_pres/$1/$2');
$routes->match(['post','get'],'/report/generatePres/(:num)/Patients-Profile/(:num)', 'DoctorController::generatePres/$1/$2');
$routes->match(['post','get'],'/Doctor/Dashboard/Update-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::update_prof_pres/$1/$2');
$routes->match(['post','get'],'/Doctor/Dashboard/Insert-Recent-Prescription/Patients-Profile/(:num)', 'DoctorController::insert_recent_prof_pres/$1');
$routes->match(['post','get'],'/Doctor/Dashboard/Delete-Prescription/(:num)/Patients-Profile/(:num)', 'DoctorController::delete_prof_pres/$1/$2');
//
$routes->post('send-notification', 'NotificationController::send');


//admin//
$routes->get('/Admin/Dashboard', 'UserController::db_admin');
//products
$routes->match(['post','get'],'/Admin/Products', 'AdminController::showProducts');
$routes->match(['post','get'],'/Admin/Products/Add_Product', 'AdminController::addProduct');
$routes->match(['post','get'],'/Admin/Products/insert_Product', 'AdminController::insertProduct');
$routes->match(['post','get'],'/Admin/Products/Edit_Product/(:num)', 'AdminController::editProduct/$1');
$routes->match(['post','get'],'/Admin/Products/update_Product', 'AdminController::updateProduct');

$routes->match(['post','get'],'/Admin/Appointments', 'AdminController::showAppt');
$routes->match(['post','get'],'/Admin/Doctors', 'AdminController::showDoctors');
$routes->match(['post','get'],'/Admin/Patients', 'AdminController::showPatients');
$routes->match(['post','get'],'/Admin/Reviews', 'AdminController::showReviews');
$routes->match(['post','get'],'/Admin/Profile', 'AdminController::showProfile');
$routes->match(['post','get'],'admin/update_profile_settings', 'AdminController::updateProfile');
$routes->match(['post','get'],'admin/update-password', 'AdminController::updateAdminPass');

$routes->post('report/generateReport', 'AdminController::generateReport');
//
// app/Config/Routes.php
$routes->get('/scheduler/update-status', 'AdminController::updateScheduleStatus');


//
$routes->post('purchase/updateStatus', 'AdminController::updateStatus');
