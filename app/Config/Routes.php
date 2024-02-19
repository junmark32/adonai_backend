<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

//user
$routes->match(['post','get'],'/register', 'UserController::register');
$routes->match(['post','get'],'/verify-code/(:num)', 'UserController::verifyCode/$1');
$routes->match(['post','get'],'/login', 'UserController::login');


//patient
$routes->match(['post','get'],'patient/insertBooking/(:num)', 'PatientController::insertBooking/$1');
//appointmet
$routes->match(['post','get'],'booked-dates', 'PatientController::getBookedDates');
$routes->match(['post','get'],'available-time-slots', 'PatientController::getAvailableTimeSlots');

//doctor
$routes->match(['post','get'],'getDoctorsData/(:num)', 'DoctorController::getDoctorsData/$1');
$routes->match(['post','get'],'getPatients', 'DoctorController::getPatients');
$routes->match(['post','get'],'getAppointmentsByDoctorUsername/(:any)', 'DoctorController::getAppointmentsByDoctorUsername/$1');
$routes->match(['post','get'],'approveAppointment/(:any)/(:any)', 'DoctorController::approveAppointment/$1/$2');
$routes->match(['post','get'],'sendApprovalEmail', 'DoctorController::sendApprovalEmail');