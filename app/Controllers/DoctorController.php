<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;

//
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DoctorController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getAppointmentsByDoctorUsername($doctorUsername)
    {
        // Assuming you have a model for appointments, adjust accordingly
        $appointmentsModel = new AppointmentModel();

        // Fetch appointments based on DoctorID
        $appointments = $appointmentsModel->like('Pref_Doctor', $doctorUsername)->findAll();

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
            $mail->Body    = 'Your appointment has been approved.';

            $mail->send();
        } catch (Exception $e) {
            // Handle email sending errors
            log_message('error', 'Email error: ' . $mail->ErrorInfo);
        }
    }

    //mailer

    

}
