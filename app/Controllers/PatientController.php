<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\AppointmentModel;

class PatientController extends ResourceController
{
    public function index()
    {
        //
    }

    public function insertBooking($PatientID)
    {
        $appointmentModel = new AppointmentModel(); // Assuming you have a model named AppointmentModel

        $data = [
            'PatientID' => $PatientID,
            'Firstname' => $this->request->getVar('firstname'),
            'Lastname' => $this->request->getVar('lastname'),
            'Email' => $this->request->getVar('email'),
            'Phone' => $this->request->getVar('phone'),
            'Pref_Date' => $this->request->getVar('pref_date'),
            'Pref_Doctor' => $this->request->getVar('pref_doctor'),
            'Purpose' => $this->request->getVar('purpose'),
            'Pref_Location' => $this->request->getVar('pref_location'),
            'Add_message' => $this->request->getVar('add_message'),
            'Status' => 'Pending', // Set the initial status as 'Pending' or adjust as needed
        ];

        $appointment = $appointmentModel->insert($data);

        if ($appointment) {
            return $this->respond(['msg' => 'Appointment added successfully']);
        } else {
            return $this->respond(['msg' => 'Failed to add appointment']);
        }
    }

    //

     // Method to fetch booked dates
     
     public function getBookedDates()
     {
         try {
             // Load the necessary model
             $appointmentModel = new AppointmentModel();
     
             // Fetch the booked dates from the database
             $bookedDates = $appointmentModel->distinct()->findAll();
     
             // Extract the dates from the query result
             $dates = [];
             foreach ($bookedDates as $row) {
                 $dates[] = $row['Pref_Date'];
             }
     
             return $this->respond($dates);
         } catch (\Exception $e) {
             // Handle any errors
             return $this->respond(['error' => 'Failed to fetch booked dates.'], 500);
         }
     }
     
 
     // Method to fetch available time slots based on selected date
     public function getAvailableTimeSlots()
     {
         // Get selected date from the request
         $selectedDate = $this->request->getVar('date');
 
         // Simulated data for available time slots (replace this with actual logic to calculate available time slots)
         $availableTimeSlots = [
             '9:00 - 10:00',
             '10:00 - 11:00',
             '11:00 - 12:00',
             // Add more time slots as needed
         ];
 
         // Return available time slots
         return $this->respond($availableTimeSlots);
     }

    //  public function getAvailableTimeSlots()
    //  {
    //      // Get selected date from the request
    //      $selectedDate = $this->request->getVar('date');
 
    //      // Simulated data for available time slots (replace this with actual logic to calculate available time slots)
    //      $availableTimeSlots = [
    //          '9:00 - 10:00',
    //          '10:00 - 11:00',
    //          '11:00 - 12:00',
    //          // Add more time slots as needed
    //      ];
 
    //      // Return available time slots
    //      return $this->respond($availableTimeSlots);
    //  }
}
