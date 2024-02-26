<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;

//
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//

class DoctorController extends ResourceController
{
    public function index()
    {
        //
    }

    public function schedule_timings()
{
    // Load necessary models and libraries
    $session = session();
    $scheduleModel = new ScheduleModel();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
                // Fetch schedule timings for the doctor
                $scheduleTimings = $scheduleModel
                    ->select('day, slot_duration, start_time, end_time')
                    ->where('doctor_id', $doctorID)
                    ->findAll();

                // Pass the doctor's data and schedule timings to the view
                return view('doctor/schedule_timings', ['doctor' => $doctor, 'scheduleTimings' => $scheduleTimings]);

                // // // Prepare data array
                // $data = [
                //     'doctor' => $doctor,
                //     'scheduleTimings' => $scheduleTimings
                // ];

                // // Return JSON response
                // return $this->response->setJSON($data);

            } else {
                return view('error', ['error' => 'Doctor not found']);
            }
        } else {
            return view('error', ['error' => 'DoctorID not found in session data']);
        }
    } else {
        return view('error', ['error' => 'User data not found in session']);
    }
}




    //get doctors data using DOCtorID
    public function getDoctorsData()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
                return $this->respond($doctor, 200);
            } else {
                return $this->respond(['msg' => 'Doctor not found'], 404);
            }
        } else {
            return $this->respond(['msg' => 'DoctorID not found in session data'], 404);
        }
    } else {
        return $this->respond(['msg' => 'User data not found in session'], 404);
    }
}




    public function getPatients()
    {
        // Load the PatientModel
        $patientModel = new PatientModel();

        // Fetch all patients from the database
        $patients = $patientModel->findAll();

        foreach ($patients as &$patient) {
            $patient['DateOfBirth'] = date('F j, Y', strtotime($patient['DateOfBirth']));
        }

        // Return the patients as JSON
        return $this->response->setJSON($patients);
    }

    public function getAppointmentsByDoctorUsername($doctorUsername)
    {
        // Assuming you have a model for appointments, adjust accordingly
        $appointmentsModel = new AppointmentModel();

        // Fetch appointments based on DoctorID
        $appointments = $appointmentsModel->like('Pref_Doctor', $doctorUsername)->findAll();

        // Format the Pref_Date column to word format
        foreach ($appointments as &$appointment) {
            $appointment['Pref_Date'] = date('F j, Y', strtotime($appointment['Pref_Date']));
        }

        // Sort appointments in descending order based on Pref_Date
        usort($appointments, function ($a, $b) {
            return strtotime($b['Pref_Date']) - strtotime($a['Pref_Date']);
        });

        return $this->respond($appointments);
    }


    public function approveAppointment($doctorID, $appointmentID)
    {
        $model = new AppointmentModel();
        $appointment = $model->find($appointmentID);

        if (!$appointment) {
            return $this->failNotFound('Appointment not found');
        }

        // Ensure that the appointment belongs to the specified doctor
        // if ($appointment['DoctorID'] != $doctorID) {
        //     return $this->failForbidden('You do not have permission to approve this appointment');
        // }

        // Check if the appointment is already approved
        if ($appointment['Status'] === 'Approved') {
            return $this->failNotFound('Appointment is already approved');
        }

        // Update the appointment status to 'Approved'
        $model->update($appointmentID, ['Status' => 'Approved', 'DoctorID' => $doctorID]);

        // Send email to the user
        $this->sendApprovalEmail($appointment);

        return $this->respond(['message' => 'Appointment approved successfully']);
    }

        //mailer
        private function sendApprovalEmail($appointment)
        {
            // Initialize PHPMailer
            $mail = new PHPMailer(true);
        
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'adonaieyecare@gmail.com'; //gmail email
                $mail->Password   = 'suxqojbojluggurs'; //gmail app password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
        
                // Recipients
                $mail->setFrom('adonaieyecare@gmail.com', 'Adonai-EyeCare');
                $mail->addAddress($appointment['Email'], $appointment['Fullname']);
        
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Appointment Approved';
        
                // HTML email body with design
                $mail->Body = '
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                color: #333;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 20px auto;
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                color: #007BFF;
                            }
                            strong {
                                color: #555;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1>Dear ' . $appointment['Fullname'] . ',</h1>
                            <p>Your appointment has been approved.</p>
                            <p><strong>Appointment Details:</strong></p>
                            <ul>
                                <li>Patient ID: ' . $appointment['PatientID'] . '</li>
                                <li>Appointment ID: ' . $appointment['AppointmentID'] . '</li>
                                <li>Email: ' . $appointment['Email'] . '</li>
                                <li>Date: ' . date('F j, Y', strtotime($appointment['Pref_Date'])) . '</li>
                                <li>Doctor: ' . $appointment['Pref_Doctor'] . '</li>
                                <li>Purpose: ' . $appointment['Purpose'] . '</li>
                                <li>Location: ' . $appointment['Pref_Location'] . '</li>
                                <li>Message: ' . $appointment['Add_message'] . '</li>
                            </ul>
                        </div>
                    </body>
                    </html>
                ';
        
                $mail->send();
            } catch (Exception $e) {
                // Handle email sending errors
                log_message('error', 'Email error: ' . $mail->ErrorInfo);
            }
        }
        



    

}
