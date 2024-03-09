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
///
$routes->match(['post','get'],'/register', 'UserController::register');
$routes->match(['post','get'],'/verify-code/(:num)', 'UserController::verifyCode/$1');
$routes->match(['post','get'],'/fn_login', 'UserController::fn_login');


//patient
$routes->match(['post','get'],'patient/insertBooking', 'PatientController::insertBooking');
//appointmet
$routes->match(['post','get'],'booking/booked-dates', 'PatientController::getBookedDates');
$routes->match(['post','get'],'available-time-slots', 'PatientController::getAvailableTimeSlots');

//doctor
$routes->get('/Doctor/Dashboard', 'Usercontroller::db_doctor');
$routes->get('/Doctor/Dashboard/Schedule', 'Doctorcontroller::schedule_timings');
$routes->get('/session', 'Usercontroller::checkSessionData');
$routes->match(['post','get'],'schedule/insert', 'DoctorController::insertSchedule');
//
$routes->match(['post','get'],'/getDoctorsData', 'DoctorController::getDoctorsData');
$routes->match(['post','get'],'getPatients', 'DoctorController::getPatients');
$routes->match(['post','get'],'getAppointmentsByDoctorUsername/(:any)', 'DoctorController::getAppointmentsByDoctorUsername/$1');
$routes->match(['post','get'],'approveAppointment/(:any)/(:any)', 'DoctorController::approveAppointment/$1/$2');
$routes->match(['post','get'],'sendApprovalEmail', 'DoctorController::sendApprovalEmail');