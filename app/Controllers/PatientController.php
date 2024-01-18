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
            'Fullname' => $this->request->getVar('fullname'),
            'Email' => $this->request->getVar('email'),
            'Phone' => $this->request->getVar('phone'),
            'Pref_Date' => $this->request->getVar('pref_date'),
            'Pref_Doctor' => $this->request->getVar('pref_doctor'),
            'Purpose' => $this->request->getVar('purpose'),
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

}
