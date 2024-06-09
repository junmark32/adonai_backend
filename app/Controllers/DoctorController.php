<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;
use App\Models\PrescriptionModel;

//
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//
use Config\Pusher;
class DoctorController extends ResourceController
{
    public function index()
    {
        //
    }

    //
    public function insertSchedule()
    {
        $session = session();
        
        if ($session->has('user_data')) {
            $userData = $session->get('user_data');
    
            if (isset($userData['DoctorID'])) {
                $doctorId = $userData['DoctorID'];
    
                // Get doctor_id from session storage
                $model = new ScheduleModel();
    
                $data = [
                    'doctor_id' => $doctorId,
                    'day' => $this->request->getVar('day'),
                    // 'slot_duration' => $this->request->getVar('slot_duration'),
                    'start_time' => $this->request->getVar('start_time'),
                    'end_time' => $this->request->getVar('end_time'),
                    'status' => 'Available',
                ];
    
                $model->insert($data);
    
                return redirect()->to('/Doctor/Dashboard/Schedule'); // Redirect to a success page after insertion.
            } else {
                // Handle case where DoctorID is not set
                // You might want to log an error or redirect to an error page
                return redirect()->to('error_page');
            }
        } else {
            // Handle case where session data is not set
            // You might want to log an error or redirect to an error page
            return redirect()->to('error_page');
        }
    }
    

    //

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
                    ->select('id, day, slot_duration, start_time, end_time')
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

    public function getPatients_Profile($patientID)
    {
        // Start session
        $session = session();
        
        // Check if 'user_data' exists in the session
        if ($session->has('user_data')) {
            // Retrieve user data from session
            $userData = $session->get('user_data');
            $loggedIn = true; // Assume logged in if 'user_data' exists
            // var_dump($userData);
            $role = $userData['Role']; // Assuming 'role' is stored in the session
    
            // Check if the user has a 'DoctorID' key
            if (isset($userData['DoctorID'])) {
                // Retrieve the DoctorID
                $doctorID = $userData['DoctorID'];
    
                // Fetch doctor's data based on DoctorID
                $doctorModel = new DoctorModel();
                $doctor = $doctorModel->find($doctorID);
    
                // Check if the doctor data is found
                if ($doctor) {
                    // Load the PatientModel
                    $patientModel = new PatientModel();
                    // Fetch patient data based on the patientId
                    $patientData = $patientModel->find($patientID);
    
                    // Load the AppointmentModel
                    $appointmentModel = new AppointmentModel();
                    // Fetch appointment data based on PatientID and DoctorID
                    $appointments = $appointmentModel->where('PatientID', $patientID)
                                                      ->where('DoctorID', $doctorID)
                                                      ->findAll();
                    
                    // Load the AppointmentModel
                    $prescriptionModel = new PrescriptionModel();
                    // Fetch appointment data based on PatientID and DoctorID
                    $prescriptions = $prescriptionModel->where('PatientID', $patientID)
                                                      ->where('DoctorID', $doctorID)
                                                      ->findAll();
                    

    
                    $data['loggedIn'] = $loggedIn;
                    $data['role'] = $role;
                    $data['doctors'] = [$doctor]; // Make sure $doctors is an 
                    $data['patient_data'] = [$patientData];
                    
                    // Merge doctor and appointment data
                    $mergedData = [];
                    foreach ($appointments as $appointment) {
                        $mergedData[] = [
                            'doctor' => $doctor,
                            'appointment' => $appointment
                        ];
                    }

                    $mergedDatas = [];
                    foreach ($prescriptions as $prescription) {
                        $mergedDatas[] = [
                            'doctor' => $doctor,
                            'prescription' => $prescription
                        ];
                    }
    
                    // Pass the merged data to the view
                    $data['merged_data'] = $mergedData;
                    $data['merged_datas'] = $mergedDatas;
                    // Pass the $data array to the view
                    return view('doctor/patients_profile', $data);
                } else {
                    // Handle the case when no data is found (optional)
                    return redirect()->to('/Doctor/Dashboard')->with('error', 'Patient not found.');
                }
            } else {
                // Handle the case when 'DoctorID' is not set in user data
                return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor ID not found in session.');
            }
        } else {
            // User is not logged in
            $loggedIn = false;
            // Handle the case when 'user_data' is not in session
            return redirect()->to('/Doctor/Dashboard')->with('error', 'User data not found in session.');
        }
    }

    public function show_prof_pres($patientID)
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      
      // Start session
      $session = session();
        
      // Check if 'user_data' exists in the session
      if ($session->has('user_data')) {
          // Retrieve user data from session
          $userData = $session->get('user_data');
          $loggedIn = true; // Assume logged in if 'user_data' exists
          // var_dump($userData);
          $role = $userData['Role']; // Assuming 'role' is stored in the session
  
          // Check if the user has a 'DoctorID' key
          if (isset($userData['DoctorID'])) {
              // Retrieve the DoctorID
              $doctorID = $userData['DoctorID'];
  
              // Fetch doctor's data based on DoctorID
              $doctorModel = new DoctorModel();
              $doctor = $doctorModel->find($doctorID);
  
              // Check if the doctor data is found
              if ($doctor) {
                  // Load the PatientModel
                  $patientModel = new PatientModel();
                  // Fetch patient data based on the patientId
                  $patientData = $patientModel->find($patientID);
  
                  // Load the AppointmentModel
                  $appointmentModel = new AppointmentModel();
                  // Fetch appointment data based on PatientID and DoctorID
                  $appointments = $appointmentModel->where('PatientID', $patientID)
                                                    ->where('DoctorID', $doctorID)
                                                    ->findAll();
  
                  $data['loggedIn'] = $loggedIn;
                  $data['role'] = $role;
                  $data['doctors'] = [$doctor]; // Make sure $doctors is an 
                  $data['patient_data'] = [$patientData];
                  
                  // Pass the $data array to the view
                  return view('doctor/add_prescription', $data);
              } else {
                  // Handle the case when no data is found (optional)
                  return redirect()->to('/Doctor/Dashboard')->with('error', 'Patient not found.');
              }
          } else {
              // Handle the case when 'DoctorID' is not set in user data
              return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor ID not found in session.');
          }
      } else {
          // User is not logged in
          $loggedIn = false;
          // Handle the case when 'user_data' is not in session
          return redirect()->to('/Doctor/Dashboard')->with('error', 'User data not found in session.');
      }
    }

    public function insert_prof_pres($patientID)
{
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
    // Start session
    $session = session();
    
    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true; // Assume logged in if 'user_data' exists
        $role = $userData['Role']; // Assuming 'role' is stored in the session

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // Check if the doctor data is found
            if ($doctor) {
                // Load the PatientModel
                $patientModel = new PatientModel();
                // Fetch patient data based on the patientId
                $patientData = $patientModel->find($patientID);

                // Load the AppointmentModel
                $appointmentModel = new AppointmentModel();
                // Fetch appointment data based on PatientID and DoctorID
                $appointments = $appointmentModel->where('PatientID', $patientID)
                                                  ->where('DoctorID', $doctorID)
                                                  ->findAll();

                // Gather data for insertion
                $postData = [
                    'DoctorID' => $doctorID,
                    'PatientID' => $patientID,
                    'Name' => $this->request->getVar('name'),
                    'Gender' => $this->request->getVar('sex'),
                    'Date' => $this->request->getVar('date'),
                    'Address' => $this->request->getVar('address'),
                    'Age' => $this->request->getVar('age'),
                    'DateOfBirth' => $this->request->getVar('birthday'),
                    'Occupation' => $this->request->getVar('occupation'),
                    'Phone' => $this->request->getVar('cp'),
                    'B_OD_SPH' => $this->request->getVar('bc_od_sph'),
                    'B_OD_CYL' => $this->request->getVar('bc_od_cyl'),
                    'B_OD_AX' => $this->request->getVar('bc_od_ax'),
                    'B_OD_ADD' => $this->request->getVar('bc_od_add'),
                    'B_OD_VA' => $this->request->getVar('bc_od_va'),
                    'B_OD_PD' => $this->request->getVar('bc_od_pd'),
                    'B_OS_SPH' => $this->request->getVar('bc_os_sph'),
                    'B_OS_CYL' => $this->request->getVar('bc_os_cyl'),
                    'B_OS_AX' => $this->request->getVar('bc_os_ax'),
                    'B_OS_ADD' => $this->request->getVar('bc_os_add'),
                    'B_OS_VA' => $this->request->getVar('bc_os_va'),
                    'B_OS_PD' => $this->request->getVar('bc_os_pd'),
                    'Ocular_History' => $this->request->getVar('ocular_history'),
                    'L_OD_SPH' => $this->request->getVar('lp_od_sph'),
                    'L_OD_CYL' => $this->request->getVar('lp_od_cyl'),
                    'L_OD_AX' => $this->request->getVar('lp_od_ax'),
                    'L_OD_ADD' => $this->request->getVar('lp_od_add'),
                    'L_OD_PD' => $this->request->getVar('lp_od_pd'),
                    'L_OS_SPH' => $this->request->getVar('lp_os_sph'),
                    'L_OS_CYL' => $this->request->getVar('lp_os_cyl'),
                    'L_OS_AX' => $this->request->getVar('lp_os_ax'),
                    'L_OS_ADD' => $this->request->getVar('lp_os_add'),
                    'L_OS_PD' => $this->request->getVar('lp_os_pd'),
                    'Frame' => $this->request->getVar('frame'),
                    'Lens' => $this->request->getVar('lens'),
                    'Total' => $this->request->getVar('total'),
                    'Diagnosis' => $this->request->getVar('diagnosis'),
                    'Remarks' => $this->request->getVar('remarks'),
                    'Management' => $this->request->getVar('management'),
                    'Follow_Up' => $this->request->getVar('follow_up'),
                ];

                // Insert data into PrescriptionModel
                $prescriptionModel = new PrescriptionModel();
                $prescriptionModel->insert($postData);

                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                $data['doctors'] = [$doctor];
                $data['patient_data'] = [$patientData];
                
                // Send notification using Pusher
                $data['message'] = 'A new Precription has been made by ' . $doctor['FirstName'] . '.';
                $pusher->trigger('my-channel', 'my-event', $data);
                // Pass the $data array to the view
                return redirect()->to('/Doctor/Dashboard/Patients-Profile/' . $patientID)->with('success', 'Prescription added successfully.');
            } else {
                // Handle the case when no doctor data is found
                return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor not found.');
            }
        } else {
            // Handle the case when 'DoctorID' is not set in user data
            return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor ID not found in session.');
        }
    } else {
        // User is not logged in
        return redirect()->to('/Doctor/Dashboard')->with('error', 'User data not found in session.');
    }
}


public function edit_prof_pres($presID, $patientID)
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      
      // Start session
      $session = session();
        
      // Check if 'user_data' exists in the session
      if ($session->has('user_data')) {
          // Retrieve user data from session
          $userData = $session->get('user_data');
          $loggedIn = true; // Assume logged in if 'user_data' exists
          // var_dump($userData);
          $role = $userData['Role']; // Assuming 'role' is stored in the session
  
          // Check if the user has a 'DoctorID' key
          if (isset($userData['DoctorID'])) {
              // Retrieve the DoctorID
              $doctorID = $userData['DoctorID'];
  
              // Fetch doctor's data based on DoctorID
              $doctorModel = new DoctorModel();
              $doctor = $doctorModel->find($doctorID);
  
              // Check if the doctor data is found
              if ($doctor) {
                  // Load the PatientModel
                  $patientModel = new PatientModel();
                  // Fetch patient data based on the patientId
                  $patientData = $patientModel->find($patientID);
                
                                                     // Load the AppointmentModel
                  $prescriptionModel = new PrescriptionModel();
                  // Fetch appointment data based on PatientID and DoctorID
                  $prescriptions = $prescriptionModel->where('PatientID', $patientID)
                                                    ->where('DoctorID', $doctorID)
                                                    ->where('PrescriptionID', $presID)
                                                    ->findAll();
  
                  $data['loggedIn'] = $loggedIn;
                  $data['role'] = $role;
                  $data['doctors'] = [$doctor]; // Make sure $doctors is an 
                  $data['patient_data'] = [$patientData];
                  $data['prescription_data'] = $prescriptions;
                  
                  // Pass the $data array to the view
                  return view('doctor/edit_prescription', $data);
              } else {
                  // Handle the case when no data is found (optional)
                  return redirect()->to('/Doctor/Dashboard')->with('error', 'Patient not found.');
              }
          } else {
              // Handle the case when 'DoctorID' is not set in user data
              return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor ID not found in session.');
          }
      } else {
          // User is not logged in
          $loggedIn = false;
          // Handle the case when 'user_data' is not in session
          return redirect()->to('/Doctor/Dashboard')->with('error', 'User data not found in session.');
      }
    }



public function update_prof_pres($presID, $patientID)
{
    // Start session
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true; // Assume logged in if 'user_data' exists
        $role = $userData['Role']; // Assuming 'role' is stored in the session

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // Check if the doctor data is found
            if ($doctor) {
                // Load the PatientModel
                $patientModel = new PatientModel();
                // Fetch patient data based on the patientId
                $patientData = $patientModel->find($patientID);

                // Load the PrescriptionModel
                $prescriptionModel = new PrescriptionModel();
                // Check if a prescription exists for the given PatientID and DoctorID
                $existingPrescription = $prescriptionModel->where('PatientID', $patientID)
                                                          ->where('DoctorID', $doctorID)
                                                          ->where('PrescriptionID', $presID)
                                                          ->first();

                // Gather data for update
                $postData = [
                    'DoctorID' => $doctorID,
                    'PatientID' => $patientID,
                    'Name' => $this->request->getVar('name'),
                    'Gender' => $this->request->getVar('sex'),
                    'Date' => $this->request->getVar('date'),
                    'Address' => $this->request->getVar('address'),
                    'Age' => $this->request->getVar('age'),
                    'DateOfBirth' => $this->request->getVar('birthday'),
                    'Occupation' => $this->request->getVar('occupation'),
                    'Phone' => $this->request->getVar('cp'),
                    'B_OD_SPH' => $this->request->getVar('bc_od_sph'),
                    'B_OD_CYL' => $this->request->getVar('bc_od_cyl'),
                    'B_OD_AX' => $this->request->getVar('bc_od_ax'),
                    'B_OD_ADD' => $this->request->getVar('bc_od_add'),
                    'B_OD_VA' => $this->request->getVar('bc_od_va'),
                    'B_OD_PD' => $this->request->getVar('bc_od_pd'),
                    'B_OS_SPH' => $this->request->getVar('bc_os_sph'),
                    'B_OS_CYL' => $this->request->getVar('bc_os_cyl'),
                    'B_OS_AX' => $this->request->getVar('bc_os_ax'),
                    'B_OS_ADD' => $this->request->getVar('bc_os_add'),
                    'B_OS_VA' => $this->request->getVar('bc_os_va'),
                    'B_OS_PD' => $this->request->getVar('bc_os_pd'),
                    'Ocular_History' => $this->request->getVar('ocular_history'),
                    'L_OD_SPH' => $this->request->getVar('lp_od_sph'),
                    'L_OD_CYL' => $this->request->getVar('lp_od_cyl'),
                    'L_OD_AX' => $this->request->getVar('lp_od_ax'),
                    'L_OD_ADD' => $this->request->getVar('lp_od_add'),
                    'L_OD_PD' => $this->request->getVar('lp_od_pd'),
                    'L_OS_SPH' => $this->request->getVar('lp_os_sph'),
                    'L_OS_CYL' => $this->request->getVar('lp_os_cyl'),
                    'L_OS_AX' => $this->request->getVar('lp_os_ax'),
                    'L_OS_ADD' => $this->request->getVar('lp_os_add'),
                    'L_OS_PD' => $this->request->getVar('lp_os_pd'),
                    'Frame' => $this->request->getVar('frame'),
                    'Lens' => $this->request->getVar('lens'),
                    'Total' => $this->request->getVar('total'),
                    'Diagnosis' => $this->request->getVar('diagnosis'),
                    'Remarks' => $this->request->getVar('remarks'),
                    'Management' => $this->request->getVar('management'),
                    'Follow_Up' => $this->request->getVar('follow_up'),
                ];

                // If the prescription exists, update it; otherwise, handle the error
                if ($existingPrescription) {
                    $prescriptionModel->update($existingPrescription['PrescriptionID'], $postData);

                    $data['loggedIn'] = $loggedIn;
                    $data['role'] = $role;
                    $data['doctors'] = [$doctor];
                    $data['patient_data'] = [$patientData];
                    
                    // Pass the $data array to the view
                    return redirect()->to('/Doctor/Dashboard/Edit-Prescription/'. $presID . '/Patients-Profile/' . $patientID)->with('success', 'Prescription updated successfully.');
                } else {
                    // Handle the case when no existing prescription is found
                    return redirect()->to('/Doctor/Dashboard/Patients-Profile/' . $patientID)->with('error', 'No existing prescription found to update.');
                }
            } else {
                // Handle the case when no doctor data is found
                return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor not found.');
            }
        } else {
            // Handle the case when 'DoctorID' is not set in user data
            return redirect()->to('/Doctor/Dashboard')->with('error', 'Doctor ID not found in session.');
        }
    } else {
        // User is not logged in
        return redirect()->to('/Doctor/Dashboard')->with('error', 'User data not found in session.');
    }
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
