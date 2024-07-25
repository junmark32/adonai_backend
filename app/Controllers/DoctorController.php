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
use App\Models\DocFeedModel;
use App\Models\DocAboutModel;
use App\Models\DocContModel;
use App\Models\DocServModel;
use App\Models\DocSpecModel;
use App\Models\DocEducModel;
use App\Models\DocExpModel;
use App\Models\DocAwardsModel;

use Dompdf\Dompdf;
use Dompdf\Options;
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
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];

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
                
                    $data['loggedIn'] = $loggedIn;
                    $data['role'] = $role;
                    // Pass the doctor data to the view
                    $data['doctors'] = [$doctor]; // Make sure $doctors is an array
    

                // Pass the doctor's data and schedule timings to the view
                return view('doctor/schedule_timings', array_merge(['doctor' => $doctor, 'scheduleTimings' => $scheduleTimings], $data));


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
                
                // Fetch user's token using UserID
                $userModel = new UserModel();
                                // Load the PatientModel
                $patientModel = new PatientModel();

                // Retrieve the patient data based on the patientId
                $patientData = $patientModel->find($patientID);
                 // Retrieve the UserID from the patient data
                 $userID = $patientData['UserID'];
                // Fetch user's token using UserID
                $user = $userModel->find($userID);
                $token = $user['token'];

                // // Output the token for debugging
                // var_dump($token);

                // Send notification using Pusher to specific user based on token
                $data['message'] = 'A new Prescription has been made by ' . $doctor['FirstName'] . '.';
                $pusher->trigger('user-token-' . $token, 'prescription-notification', $data);
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

    public function generatePres($presID, $patientID)
{
    // Start session
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $role = $userData['Role'] ?? null; // Assuming 'role' is stored in the session

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

                // Check if the patient data is found
                if ($patientData) {
                    // Load the PrescriptionModel
                    $prescriptionModel = new PrescriptionModel();
                    // Fetch prescription data based on PatientID, DoctorID, and PrescriptionID
                    $prescriptions = $prescriptionModel->where('PatientID', $patientID)
                                                        ->where('DoctorID', $doctorID)
                                                        ->where('PrescriptionID', $presID)
                                                        ->findAll();
                    
                    $data['patient_data'] = [$patientData];                                   
                    // Prepare data for the view
                    $data['prescription_data'] = $prescriptions;

                    // Load view and render HTML
                    $html = view('reports/pres_report_view', $data);

                    // Initialize DOMPDF
                    $options = new Options();
                    $options->set('defaultFont', 'Courier');
                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();

                    // Output the generated PDF to Browser
                    $dompdf->stream("report.pdf", ["Attachment" => 0]);
                } else {
                    // Handle case where patient data is not found
                    throw new \Exception("Patient data not found.");
                }
            } else {
                // Handle case where doctor data is not found
                throw new \Exception("Doctor data not found.");
            }
        } else {
            // Handle case where DoctorID is not set in user data
            throw new \Exception("DoctorID not set in user data.");
        }
    } else {
        // Handle case where user_data is not found in session
        throw new \Exception("User data not found in session.");
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

public function delete_prof_pres($presID, $patientID)
{
    // Start session
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true; // Assume logged in if 'user_data' exists
        $role = $userData['Role']; // Assuming 'Role' is stored in the session

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // Check if the doctor data is found
            if ($doctor) {
                // Load the PrescriptionModel
                $prescriptionModel = new PrescriptionModel();
                // Check if a prescription exists for the given PatientID, DoctorID, and PrescriptionID
                $existingPrescription = $prescriptionModel->where('PatientID', $patientID)
                                                          ->where('DoctorID', $doctorID)
                                                          ->where('PrescriptionID', $presID)
                                                          ->first();

                // If the prescription exists, delete it; otherwise, handle the error
                if ($existingPrescription) {
                    $prescriptionModel->delete($existingPrescription['PrescriptionID']);

                    return redirect()->to('/Doctor/Dashboard/Patients-Profile/' . $patientID)->with('success', 'Prescription deleted successfully.');
                } else {
                    // Handle the case when no existing prescription is found
                    return redirect()->to('/Doctor/Dashboard/Patients-Profile/' . $patientID)->with('error', 'No existing prescription found to delete.');
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

    
public function appointments()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
                // Fetch appointments based on DoctorID
                $appointmentModel = new AppointmentModel();
                $appointments = $appointmentModel->where('DoctorID', $doctorID)->findAll();

                // Sort appointments by Pref_Date and Pref_Time_Start in descending order
                usort($appointments, function($a, $b) {
                    $dateTimeA = strtotime($a['Pref_Date'] . ' ' . $a['Pref_Time_Start']);
                    $dateTimeB = strtotime($b['Pref_Date'] . ' ' . $b['Pref_Time_Start']);
                    return $dateTimeB - $dateTimeA;
                });

                $appointmentCount = $appointmentModel->where('DoctorID', $doctorID)->countAllResults();

                // Initialize an array to hold appointment and patient data
                $appointmentData = [];

                // Fetch patient data for each appointment
                $patientModel = new PatientModel();

                foreach ($appointments as $appointment) {
                    $patient = $patientModel->find($appointment['PatientID']);
                    if ($patient) {
                        // Combine appointment and patient data
                        $appointmentData[] = [
                            'appointment' => $appointment,
                            'patient' => $patient,
                        ];
                    }
                }

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                $data['appointmentData'] = $appointmentData;
                return view('doctor/appointments', ['token' => $token] + $data);
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

public function patients()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
               
                $patientModel = new PatientModel();
                $allPatients = $patientModel->findAll();

                
               

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                $data['allPatients'] = $allPatients;
                return view('doctor/patients', ['token' => $token] + $data);
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

public function reviews()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
               
                $docfeedModel = new DocFeedModel();
        $docfeeds = $docfeedModel->where('DoctorID', $doctorID)->orderBy('created_at', 'DESC')->findAll();

        // Initialize an array to hold docfeed and patient data
        $docfeedData = [];

        // Fetch patient data for each docfeed
        $patientModel = new PatientModel();

        foreach ($docfeeds as $docfeed) {
            $patient = $patientModel->find($docfeed['PatientID']);
            if ($patient) {
                // Combine docfeed and patient data
                $docfeedData[] = [
                    'docfeed' => $docfeed,
                    'patient' => $patient,
                ];
            }
        }
                

                // var_dump($docfeedData);
               

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                $data['docfeedData'] = $docfeedData;

               
                return view('doctor/reviews', ['token' => $token] + $data);
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

public function prof_settings()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // $doctorData = [];

            if ($doctor) {
               
                $docaboutModel = new DocAboutModel();
                $doc_about = $docaboutModel->find($doctor['DoctorID']);

                $doccontModel = new DocContModel();
                $doc_cont = $doccontModel->find($doctor['DoctorID']);

                $docservModel = new DocServModel();
                $doc_serv = $docservModel->where('DoctorID', $doctor['DoctorID'])->findAll();

                $docspecModel = new DocSpecModel();
                $doc_spec = $docspecModel->where('DoctorID', $doctor['DoctorID'])->findAll();

                $doceducModel = new DocEducModel();
                $doc_educ = $doceducModel->where('DoctorID', $doctor['DoctorID'])->findAll();

                $docexpModel = new DocExpModel();
                $doc_exp = $docexpModel->where('DoctorID', $doctor['DoctorID'])->findAll();

                $docawardsModel = new DocAwardsModel();
                $doc_awards = $docawardsModel->where('DoctorID', $doctor['DoctorID'])->findAll();

                $docuserModel = new UserModel();
                $doc_user = $docuserModel->find($doctor['UserID']);

                

                
                // Combine doctor and doc_about data
                $doctorData = [
                    'doctor_data' => $doctor,
                    'doc_about' => $doc_about,
                    'doc_cont' => $doc_cont,
                    'doc_serv' => $doc_serv,
                    'doc_spec' => $doc_spec,
                    'doc_educ' => $doc_educ,
                    'doc_exp' => $doc_exp,
                    'doc_awards' => $doc_awards,
                    'doc_user' => $doc_user,
                ];
                

                // echo '<pre>';
                // print_r($doctorData);
                // echo '</pre>';
               

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                $data['doctorData'] = $doctorData;

                

               
                return view('doctor/prof_settings', ['token' => $token] + $data);
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

public function update_prof_settings()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'Role' is stored in the session
        $token = $userData['token'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            if ($doctor) {
                // Process image upload
                $image = $this->request->getFile('profile_photo'); // Assuming you're uploading an image via a form with name 'profile_photo'

                // Initialize the variable to hold the image URL
                $imageName = '';

                // Check if image was uploaded successfully
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    // Generate a unique filename
                    $imageName = $image->getRandomName();

                    // Move uploaded image to the uploads directory
                    $image->move(ROOTPATH . 'public/uploads', $imageName);
                }

                // Define updated doctor data
                $doctor_data = [
                    'FirstName' => $this->request->getPost('first_name'),
                    'LastName' => $this->request->getPost('last_name'),
                    'Phone' => $this->request->getPost('phone'),
                    'Gender' => $this->request->getPost('gender'),
                    'BirthDate' => $this->request->getPost('birth_date'),
                ];

                // If a new image was uploaded, include it in the data array
                if (!empty($imageName)) {
                    $doctor_data['Profile_url'] = $imageName;
                }

                // Update doctor data in the database
                $doctorModel->update($doctorID, $doctor_data);

                // Update doctor's biography
                $docaboutModel = new DocAboutModel();

                $doctor_about = [
                    'Biography' => $this->request->getPost('biography'),
                ];

                $docaboutModel->update($doctorID, $doctor_about);

                //
                $doccontModel = new DocContModel();

                $doctor_cont = [
                    'Address1' => $this->request->getPost('address1'),
                    'Address2' => $this->request->getPost('address2'),
                    'City' => $this->request->getPost('city'),
                    'Province' => $this->request->getPost('province'),
                    'Country' => $this->request->getPost('country'),
                    'PostalCode' => $this->request->getPost('postal_code'),
                ];

                $doccontModel->update($doctorID, $doctor_cont);

                //
               // Update doctor's services
               $docservModel = new DocServModel();

               // Convert the comma-separated services into an array
               $services = explode(',', $this->request->getPost('services'));

               // Delete existing services for the doctor
               $docservModel->where('DoctorID', $doctorID)->delete();

               // Insert new services
               foreach ($services as $service) {
                   $docservModel->insert([
                       'DoctorID' => $doctorID,
                       'Services' => trim($service),
                   ]);
               }

               // Update doctor's specializations
               $docspecModel = new DocSpecModel();

               // Convert the comma-separated specializations into an array
               $specializations = explode(',', $this->request->getPost('specialization'));

               // Delete existing specializations for the doctor
               $docspecModel->where('DoctorID', $doctorID)->delete();

               // Insert new specializations
               foreach ($specializations as $specialization) {
                   $docspecModel->insert([
                       'DoctorID' => $doctorID,
                       'Specialization' => trim($specialization),
                   ]);
               }

             // Assuming you have a model for education like DocEducModel
                $doceducModel = new DocEducModel();

                // Retrieve the posted education data
                $degrees = $this->request->getPost('education_degree');
                $colleges = $this->request->getPost('education_college');
                $years = $this->request->getPost('education_year');

                // Validate and sanitize inputs
                $degrees = array_map('trim', $degrees);
                $colleges = array_map('trim', $colleges);
                $years = array_map('trim', $years);

                // Delete existing education records for the doctor
                $doceducModel->where('DoctorID', $doctorID)->delete();

                // Prepare data for insertion
                $educationData = [];
                for ($i = 0; $i < count($degrees); $i++) {
                    // Ensure each array has the same length and skip empty entries
                    if (!empty($degrees[$i]) && !empty($colleges[$i]) && !empty($years[$i])) {
                        $educationData[] = [
                            'DoctorID' => $doctorID,
                            'Degree' => htmlspecialchars($degrees[$i]),
                            'College' => htmlspecialchars($colleges[$i]),
                            'Year' => htmlspecialchars($years[$i]),
                        ];
                    }
                }

                // Insert new education records
                if (!empty($educationData)) {
                    $doceducModel->insertBatch($educationData);
                }

                // Assuming you have a model for expereince
                $docexpModel = new DocExpModel();

                // Retrieve the posted education data
                $hosp_name = $this->request->getPost('experience_hospital');
                $from_where = $this->request->getPost('experience_from');
                $to_where = $this->request->getPost('experience_to');
                $designation = $this->request->getPost('experience_designation');

                // Validate and sanitize inputs
                $hosp_name = array_map('trim', $hosp_name);
                $from_where = array_map('trim', $from_where);
                $to_where = array_map('trim', $to_where);
                $designation = array_map('trim', $designation);

                // Delete existing education records for the doctor
                $docexpModel->where('DoctorID', $doctorID)->delete();

                // Prepare data for insertion
                $expData = [];
                for ($i = 0; $i < count($hosp_name); $i++) {
                    // Ensure each array has the same length and skip empty entries
                    if (!empty($hosp_name[$i]) && !empty($from_where[$i]) && !empty($to_where[$i]) && !empty($designation[$i])) {
                        $expData[] = [
                            'DoctorID' => $doctorID,
                            'Hosp_name' => htmlspecialchars($hosp_name[$i]),
                            'From_where' => htmlspecialchars($from_where[$i]),
                            'To_where' => htmlspecialchars($to_where[$i]),
                            'Designation' => htmlspecialchars($designation[$i]),
                        ];
                    }
                }

                // Insert new education records
                if (!empty($expData)) {
                    $docexpModel->insertBatch($expData);
                }

                // Assuming you have a model for awards
                $docawardsModel = new DocAwardsModel();

                // Retrieve the posted education data
                $awards = $this->request->getPost('awards');
                $awards_year = $this->request->getPost('awards_year');

                // Validate and sanitize inputs
                $awards = array_map('trim', $awards);
                $awards_year = array_map('trim', $awards_year);

                // Delete existing education records for the doctor
                $docawardsModel->where('DoctorID', $doctorID)->delete();

                // Prepare data for insertion
                $awardsData = [];
                for ($i = 0; $i < count($awards); $i++) {
                    // Ensure each array has the same length and skip empty entries
                    if (!empty($awards[$i]) && !empty($awards_year[$i])) {
                        $awardsData[] = [
                            'DoctorID' => $doctorID,
                            'Awards' => htmlspecialchars($awards[$i]),
                            'Year' => htmlspecialchars($awards_year[$i]),
                        ];
                    }
                }

                // Insert new education records
                if (!empty($awardsData)) {
                    $docawardsModel->insertBatch($awardsData);
                }



                return redirect()->to('/Doctor/Dashboard/Prof-Settings')->with('success', 'Profile updated successfully');
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

public function change_password()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];
        $userID = $userData['UserID'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // $doctorData = [];

            if ($doctor) {
               
               

                $userModel = new UserModel();
                $user = $userModel->find($userID);

               
                // echo '<pre>';
                // print_r($user);
                // echo '</pre>';

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                

                

               
                return view('doctor/change_password', ['token' => $token] + $data);
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

public function update_password()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];
        $userID = $userData['UserID'];

        // Check if the user has a 'DoctorID' key
        if (isset($userData['DoctorID'])) {
            // Retrieve the DoctorID
            $doctorID = $userData['DoctorID'];

            // Fetch doctor's data based on DoctorID
            $doctorModel = new DoctorModel();
            $doctor = $doctorModel->find($doctorID);

            // $doctorData = [];

            if ($doctor) {
               
               

                // Load the user model
                $userModel = new UserModel();

                // Get the form data
                $oldPassword = $this->request->getPost('old_password');
                $newPassword = $this->request->getPost('new_password');
                $confirmPassword = $this->request->getPost('confirm_password');

                // Validation
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'old_password' => 'required',
                    'new_password' => 'required|min_length[4]',
                    'confirm_password' => 'required|matches[new_password]'
                ]);

                if (!$validation->withRequest($this->request)->run()) {
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }

                // Fetch the user from the database
                $user = $userModel->find($userID);

                // Verify the old password
                if (!password_verify($oldPassword, $user['PasswordHash'])) {
                    return redirect('/')->back()->withInput()->with('error', 'The old password is incorrect.');
                }

                // Hash the new password
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $userModel->update($userID, ['PasswordHash' => $newPasswordHash]);

               
                // echo '<pre>';
                // print_r($user);
                // echo '</pre>';

                // Pass loggedIn status, role, and doctor data to the view
                $data['loggedIn'] = $loggedIn;
                $data['role'] = $role;
                // Pass the doctor data to the view
                $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                

                

                return redirect('/Doctor/Dashboard/Change-password', ['token' => $token] + $data)->back()->with('success', 'Password updated successfully.');
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
