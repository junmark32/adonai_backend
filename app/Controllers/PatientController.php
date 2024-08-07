<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;
use App\Models\DoctorModel;
use App\Controllers\NotificationController;
use Config\Pusher;

use Dompdf\Dompdf;
use Dompdf\Options;

class PatientController extends ResourceController
{
    public function index()
    {
        //
    }

    // public function insertBooking($PatientID)
    // {
        
    //     $appointmentModel = new AppointmentModel(); // Assuming you have a model named AppointmentModel

    //     $data = [
    //         'PatientID' => $PatientID,
    //         'Firstname' => $this->request->getVar('firstname'),
    //         'Lastname' => $this->request->getVar('lastname'),
    //         'Email' => $this->request->getVar('email'),
    //         'Phone' => $this->request->getVar('phone'),
    //         'Pref_Date' => $this->request->getVar('pref_date'),
    //         'Pref_Time_Start' => $this->request->getVar('pref_time_start'),
    //         'Pref_Time_End' => $this->request->getVar('pref_time_end'),
    //         'Pref_Doctor' => 'Dra. Ashley Cabudsan',
    //         'Purpose' => $this->request->getVar('purpose'),
    //         'Pref_Location' => $this->request->getVar('pref_location'),
    //         'Add_message' => $this->request->getVar('add_message'),
    //         'Status' => 'Pending', // Set the initial status as 'Pending' or adjust as needed
    //     ];

    //     $appointment = $appointmentModel->insert($data);

    //     if ($appointment) {
    //         return $this->respond(['msg' => 'Appointment added successfully']);
    //     } else {
    //         return $this->respond(['msg' => 'Failed to add appointment']);
    //     }
    // }

    public function insertBooking()
    {
        // Load necessary models and libraries
        $session = session();
        $appointmentModel = new AppointmentModel();
        $scheduleModel = new ScheduleModel();
        $patientModel = new PatientModel();
        $pusherConfig = new Pusher();
        $pusher = new \Pusher\Pusher(
            $pusherConfig->key,
            $pusherConfig->secret,
            $pusherConfig->app_id,
            [
                'cluster' => $pusherConfig->cluster,
                'useTLS' => $pusherConfig->useTLS
            ]
        );
    

        // Check if 'user_data' exists in the session
        if ($session->has('user_data')) {
            // Retrieve user data from session
            $userData = $session->get('user_data');
            

            // Check if the user has a 'PatientID' key
            if (isset($userData['PatientID'])) {
                // Retrieve the PatientID
                $patientID = $userData['PatientID'];

                  // Retrieve patient details from the database
                  $patient = $patientModel->find($patientID);

                // Retrieve data from the request
                $requestData = [
                    'DoctorID' => $this->request->getVar('doctor_id'),
                    'PatientID' => $patientID,
                    'Firstname' => $this->request->getVar('firstname'),
                    'Lastname' => $this->request->getVar('lastname'),
                    'Email' => $this->request->getVar('email'),
                    'Phone' => $this->request->getVar('phone'),
                    'Pref_Date' => $this->request->getVar('pref_date'),
                    'Pref_Time_Start' => $this->request->getVar('pref_time_start'),
                    'Pref_Time_End' => $this->request->getVar('pref_time_end'),
                    'Pref_Timeslot_ID' => $this->request->getVar('pref_timeslot_id'),
                    'Pref_Doctor' => 'Dra. Ashley Cabudsan',
                    'Purpose' => $this->request->getVar('purpose'),
                    'Pref_Location' => $this->request->getVar('pref_location'),
                    'Add_message' => $this->request->getVar('add_message'),
                    'Status' => 'Scheduled', // Set the initial status as 'Pending' or adjust as needed
                ];

                // Insert appointment data
                $appointment = $appointmentModel->insert($requestData);

                
                // Check if the appointment was successfully inserted
                if ($appointment) {
                    // Update the ScheduleModel status to 'Reserved'
                    $scheduleID = $this->request->getVar('pref_timeslot_id');
                    $scheduleModel->update($scheduleID, ['status' => 'Reserved']);

                    // Fetch user's token using UserID
                    $userModel = new UserModel();
                    $doctorModel = new DoctorModel();

                    // Retrieve the doctor data based on the doctorId
                    $doctorData = $doctorModel->find($this->request->getVar('doctor_id'));
                    // Retrieve the UserID from the doctor data
                    $userID = $doctorData['UserID'];

                    // Fetch user's token using UserID
                    $user = $userModel->find($userID);
                    $token = $user['token'];

                    // Send notification using Pusher to specific user based on token
                    $data['message'] = 'A new booking has been made by ' . $patient['FirstName'] . '.';
                    $pusher->trigger('user-token-' . $token, 'booking-notification', $data);

                    

                    // Redirect to a success view
                    return redirect()->to('/');
                } else {
                    // Handle insertion failure
                    return $this->respond(['error' => 'Failed to add appointment']);
                }
            } else {
                // Handle missing PatientID
                return $this->respond(['error' => 'PatientID not found']);
            }
        } else {
            // Handle missing user data in session
            return $this->respond(['error' => 'User data not found in session']);
        }
    }

    ////
    public function cancelAppointment($appointmentId)
{
    $appointmentModel = new AppointmentModel();
    $scheduleModel = new ScheduleModel();

    // Fetch the appointment from the database
    $appointment = $appointmentModel->find($appointmentId);

    if ($appointment) {
        // Update the status to "Cancelled"
        $appointmentModel->update($appointmentId, ['Status' => 'Cancelled']);
        
        // Find the corresponding schedule timing
        $timeslotId = $appointment['Pref_Timeslot_ID'];
        $scheduleTiming = $scheduleModel->find($timeslotId);

        if ($scheduleTiming) {
            // Update the status of the schedule timing to "Available"
            $scheduleModel->update($timeslotId, ['status' => 'Available']);
        }

        // Optionally, you can redirect the user back to the appointments page
        return redirect()->to('/dashboard')->with('success', 'Appointment cancelled successfully');
    } else {
        // Appointment not found, you can handle this case accordingly
        return redirect()->back()->with('error', 'Appointment not found');
    }
}

public function printAppt($id)
{
    $appointmentModel = new AppointmentModel();
    $patientModel = new PatientModel();

    // Fetch the receipt data using the provided ID
    $appt = $appointmentModel->find($id);

    if (!$appt) {
        // Handle the case where no purchase record is found
        return $this->response->setStatusCode(404)->setBody('Receipt not found');
    }

    $patientDatas = [];
    // Fetch EyeWearData and LensData based on the purchase record
       if (isset($appt['PatientID'])) {
           $patient = $patientModel->find($appt['PatientID']);
           if ($patient) {
               $patientData = $patient;
           }
       }

    

    // Debug output
    // echo '<pre>';
    // print_r($appt);
    // print_r($patientData);
    // // print_r($lensData);
    // echo '</pre>';

    // Prepare the receipt HTML
    $data = [
        'appt' => [
            'appt_id' => $appt['AppointmentID'],
            'appt_first_name' => $appt['Firstname'],
            'appt_last_name' => $appt['Lastname'],
            'appt_email' => $appt['Email'],
            'appt_date' => $appt['Pref_Date'],
            'appt_start_time' => $appt['Pref_Time_Start'],
            'appt_end_time' => $appt['Pref_Time_End'],
            'appt_doctor' => $appt['Pref_Doctor'],
            'appt_purpose' => $appt['Purpose'],
            'appt_location' => $appt['Pref_Location'],
            'appt_message' => $appt['Add_message'],
        ],
        'patientData' => [
            'patient_ID' => $patientData['PatientID'],
            'patient_first_name' => $patientData['FirstName'],
            'patient_last_name' => $patientData['LastName'],
        ],
    ];

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
//    Load view and render HTML
   $html = view('reports/appt_slip', $data);

   // Initialize DOMPDF
   $options = new Options();
   $options->set('defaultFont', 'Courier');
   $dompdf = new Dompdf($options);
   $dompdf->loadHtml($html);
   $dompdf->setPaper('A4', 'portrait');
   $dompdf->render();

   // Output the generated PDF to Browser
   $dompdf->stream("adonai_appt_slip.pdf", ["Attachment" => 1]);
}

///


    

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
