<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;
use App\Models\ScheduleModel;
use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\LensModel;
use App\Models\CartModel;
use App\Models\PurchaseModel;
use App\Models\AppointmentModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use CodeIgniter\Session\Session;

class UserController extends ResourceController
{
    
    public function index()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];
    }

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }

    // Load doctor data
    $doctorModel = new DoctorModel();
    $data['doctors'] = $doctorModel->findAll();

    // Load Cart Data for the logged-in user
    $cartModel = new CartModel();
    $cartItems = [];
    if ($loggedIn && isset($userData['UserID'])) {
        $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
    }

    // Calculate the count of items in the cart
    $cartCount = count($cartItems);

    // Pass loggedIn status, role, and patient data to the view
    $data['loggedIn'] = $loggedIn;
    $data['role'] = $role;
    $data['patients'] = $patients;
     // Pass the cart count to the view
     $data['cartCount'] = $cartCount;

    return view('user/index',['token' => $token] + $data);
}


    public function login()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      return view('login');
    }

    public function register()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      return view('register');
    }

    public function verify()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      return view('verify');
    }

    public function user_db()
    {
       // Load the session service
    $session = session();
    
    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
        $token = $userData['token'];
    }

    // Load Appointments Data
    $appointmentModel = new AppointmentModel();
    $appointments = [];

    if (!empty($userData['PatientID'])) {
        // Fetch appointments associated with the user's session PatientID
        $appointments = $appointmentModel->where('PatientID', $userData['PatientID'])->findAll();

        // If appointments are found, fetch doctor data for each appointment
        if (!empty($appointments)) {
            // Load Doctor model
            $doctorModel = new DoctorModel();

            // Loop through appointments to fetch doctor data for each appointment
            foreach ($appointments as &$appointment) {
                // Fetch doctor data based on the DoctorID from the appointment
                $doctor = $doctorModel->find($appointment['DoctorID']);

                // If doctor data is found, assign it to the appointment
                if (!empty($doctor)) {
                    $appointment['doctor_data'] = $doctor;
                }
            }
        }
    }



    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }
     // Load the ProductModel
     $productModel = new ProductModel();

     // Retrieve all products from the database
     $products = $productModel->findAll();

     // Load Cart Data for the logged-in user
    $cartModel = new CartModel();
    $cartItems = [];
    if ($loggedIn && isset($userData['UserID'])) {
        $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
    }

    // Calculate the count of items in the cart
    $cartCount = count($cartItems);

     // Pass loggedIn status, role, and patient data to the view
    $data['loggedIn'] = $loggedIn;
    $data['role'] = $role;
    $data['patients'] = $patients;
    $data['appointments'] = $appointments;

     // Pass the products data to the view
     $data['products'] = $products;

     // Pass the cart count to the view
     $data['cartCount'] = $cartCount;

     return view('user/user_dashboard', ['token' => $token] + $data);

    }

    public function store()
    {
    // Load the session service
    $session = session();
    
    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
    }

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }
     // Load the ProductModel
     $productModel = new ProductModel();

     // Retrieve all products from the database
     $products = $productModel->findAll();

     // Load Cart Data for the logged-in user
    $cartModel = new CartModel();
    $cartItems = [];
    if ($loggedIn && isset($userData['UserID'])) {
        $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
    }

    // Calculate the count of items in the cart
    $cartCount = count($cartItems);

     // Pass loggedIn status, role, and patient data to the view
    $data['loggedIn'] = $loggedIn;
    $data['role'] = $role;
    $data['patients'] = $patients;

     // Pass the products data to the view
     $data['products'] = $products;

     // Pass the cart count to the view
     $data['cartCount'] = $cartCount;

     return view('user/store', $data);

    }

    public function checkout()
    {
        // Load the session service
        $session = session();
    
        // Check if 'user_data' exists in the session
        $loggedIn = false;
        $role = null;
        $userData = [];
        if ($session->has('user_data')) {
            // Retrieve user data from session
            $userData = $session->get('user_data');
            $loggedIn = true;
            $role = $userData['Role']; // Assuming 'role' is stored in the session
        }
    
        // Load Patients Data
        $patientModel = new PatientModel();
        $patients = [];
        if (!empty($userData['PatientID'])) {
            // Fetch only the patient associated with the user's session ID
            $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
        }

         // Load Cart Data for the logged-in user
        $cartModel = new CartModel();
        $cartItems = [];
        if ($loggedIn && isset($userData['UserID'])) {
            $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
        }

        // Calculate the count of items in the cart
        $cartCount = count($cartItems);
    
        // Get the doctor ID from the URL parameter
        $doctorID = $this->request->getGet('doctor_id');
    
        // Fetch the doctor's data based on the doctor ID
        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->find($doctorID);
    
        // Pass the doctor's data, user-related data, and patient data to the view
        return view('user/checkout', [
            'doctor' => $doctor,
            'loggedIn' => $loggedIn,
            'role' => $role,
            'patients' => $patients,
            'cartCount' => $cartCount
        ]);
    }


    

    public function booking()
{
    // Load the session service
    $session = session();

    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
    }

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }

     // Load Cart Data for the logged-in user
     $cartModel = new CartModel();
     $cartItems = [];
     if ($loggedIn && isset($userData['UserID'])) {
         $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
     }

         // Calculate the count of items in the cart
    $cartCount = count($cartItems);


    // Get the doctor ID from the URL parameter
    $doctorID = $this->request->getGet('doctor_id');

    // Fetch the doctor's data based on the doctor ID
    $doctorModel = new DoctorModel();
    $doctor = $doctorModel->find($doctorID);

    // Fetch all schedule timings for the doctor
    $scheduleModel = new ScheduleModel();
    $scheduleTimings = $scheduleModel->where('doctor_id', $doctorID)->findAll();


    // Pass the doctor's data, schedule timings, and user-related data to the view
    return view('user/booking', [
        'doctor' => $doctor,
        'scheduleTimings' => $scheduleTimings,
        'loggedIn' => $loggedIn,
        'role' => $role,
        'patients' => $patients,
        'cartCount' => $cartCount
    ]);

}

///
// public function updateStatusBasedOnSchedule()
// {
//     // Load AppointmentModel and ScheduleModel
//     $appointmentModel = new AppointmentModel();
//     $scheduleModel = new ScheduleModel();

//     // Get the current date and time
//     $currentDate = date('Y-m-d');
//     $currentTime = date('H:i:s');

//     // Fetch appointments where Pref_Date matches start_time
//     $appointmentsToUpdate = $appointmentModel
//         ->where('Pref_Date', $currentDate)
//         ->join('schedule_timings', 'appointments.Pref_Timeslot_ID = schedule_timings.id')
//         ->where('schedule_timings.start_time', '<=', $currentTime)
//         ->where('schedule_timings.end_time', '>', $currentTime)
//         ->findAll();

//     // If appointments are found, update their status to "Running"
//     if ($appointmentsToUpdate) {
//         foreach ($appointmentsToUpdate as $appointment) {
//             $appointmentModel->update($appointment['id'], ['Status' => 'Running']);
//         }
//     }

//     // Update the status of schedule timings where end_time has passed
//     $scheduleModel->where('end_time <=', $currentTime)
//         ->update(['Status' => 'Finished']);

        
// }


///

    

    public function db_doctor()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

    //   return view('doctor/doctor_dashboard');

        // Load the session service
        $session = session();

        // Check if 'user_data' exists in the session
        if ($session->has('user_data')) {
            // Retrieve user data from session
            $userData = $session->get('user_data');
            $loggedIn = true;
            // var_dump($userData);
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
                    return view('doctor/doctor_dashboard', ['token' => $token] + $data);
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


    public function getDoctorDetails($DoctorID)
    {
      // Load the ProductModel (adjust the model name accordingly)
          $model = new DoctorModel();

          // Fetch product details from the model based on the product_id
          $doctor = $model->find($DoctorID);

          // Check if the product exists
          if ($doctor) {
              // Return the product details as JSON response
              return $this->response->setJSON($doctor);
          } else {
              // Handle the case where the product is not found (return a suitable response)
              return $this->response->setStatusCode(404)->setJSON(['message' => 'Product not found']);
          }
    }

    ///

    public function register_user()
    {
        try {
            $userModel = new UserModel();
            $patientModel = new PatientModel();
    
            // Generate a verification token
            $token = $this->verification(50);
    
            // Generate a verification code
            $verificationCode = $this->generateVerificationCode();
    
            // Data for the Users table
            $userData = [
                'Username' => $this->request->getVar('username'),
                'PasswordHash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'token' => $token,
                'status' => 'pending', // Set status to pending until verification is complete
                'role' => 'user',
                'verification_code' => $verificationCode, // Add verification code to user data
            ];
    
            // Save user data
            $userSaved = $userModel->save($userData);
    
            if ($userSaved) {
                // Data for the patients table
                $patientData = [
                    'UserID' => $userModel->insertID(),
                    'FirstName' => $this->request->getVar('firstname'),
                    'LastName' => $this->request->getVar('lastname'),
                    'Email' => $this->request->getVar('email'),
                    'Phone' => $this->request->getVar('phone'),
                    'DateOfBirth' => $this->request->getVar('dateOfBirth'),
                    'Gender' => $this->request->getVar('gender'),
                    'Address' => $this->request->getVar('address'),
                ];
    
                // Save patient data
                $patientSaved = $patientModel->save($patientData);
    
                if ($patientSaved) {
                    // Send verification email
                    $this->sendVerificationEmail($this->request->getVar('email'), $verificationCode);
    
                                    // Redirect to a page informing the user to check their email for the verification code
                return redirect()->to('/verify-user');
                } else {
                    // If patient data saving fails
                    return $this->respond(['msg' => 'failed to save patient data'], 500);
                }
            } else {
                // If user data saving fails
                return $this->respond(['msg' => 'failed to save user data'], 500);
            }
        } catch (\Exception $e) {
            return $this->respond(['msg' => 'server error', 'error' => $e->getMessage()], 500);
        }
    }
    
    private function generateVerificationCode()
    {
        return mt_rand(100000, 999999); // Generate a random 6-digit verification code
    }
    
    private function sendVerificationEmail($email, $verificationCode)
    {
        $mail = new PHPMailer(true);
    
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'adonaieyecare@gmail.com'; // Your Gmail address
            $mail->Password   = 'suxqojbojluggurs';        // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
    
            //Recipients
            $mail->setFrom('adonaieyecare@gmail.com', 'Adonai-EyeCare'); // Your Name and your email address
            $mail->addAddress($email); // Recipient's email
    
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is: ' . $verificationCode;
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    

    private function verification($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }

    public function verifyCode()
    {
        try {
            // Retrieve the verification code from the request
            // $code = $this->request->getPost('verificationCode');

            // Check if the code exists in the database
            $userModel = new UserModel();
            $code = $this->request->getVar('verificationCode');
            $user = $userModel->where('verification_code', $code)->first();

            if ($user) {
                // Update user status to 'active' or whatever status you use for verified users
                $userModel->update($user['UserID'], ['status' => 'active']);

                // Optionally, you can log the user in or perform any other action after verification
                // For example, you can log the user in:
                // $this->authenticateUser($user['id']);

                return redirect()->to('/login');
            } else {
                // Verification failed
                return $this->respond(['msg' => 'Verification failed'], 400);
            }
        } catch (\Exception $e) {
            // Handle any errors that occurred during the verification process
            return $this->respond(['msg' => 'Error during verification', 'error' => $e->getMessage()], 500);
        }
    }

    /// login

    public function fn_login()
{
    $user = new UserModel();
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $onesignal = $this->request->getVar('onesignal_subscription_id');
    $userData = $user->where('Username', $username)->first();

    if ($userData) {
        $hashedPassword = $userData['PasswordHash'];
        $authenticatePassword = password_verify($password, $hashedPassword);

        if ($authenticatePassword) {
            $status = $userData['status']; // Get the status of the user

            if ($status === 'active') {
                // User is active, proceed with login
                $role = $userData['role']; // Adjust column name based on your database schema
                $response = [];

                 // Check if OneSignal subscription ID exists
                 if (empty($userData['onesignal_subscription_id'])) {
                    // Insert new OneSignal subscription ID
                    $userData['onesignal_subscription_id'] = $onesignal;
                    $user->update($userData['UserID'], $userData);
                } else {
                    // Update existing OneSignal subscription ID
                    $user->where('UserID', $userData['UserID'])->set('onesignal_subscription_id', $onesignal)->update();
                }

                switch ($role) {
                    case 'user':
                        $patientModel = new PatientModel();
                        $patientData = $patientModel->where('UserID', $userData['UserID'])->first();
                        $response = [
                            'msg' => 'okay',
                            'token' => $userData['token'],
                            'UserID' => $userData['UserID'],
                            'Username' => $userData['Username'],
                            'PatientID' =>  $patientData['PatientID'],
                            'Role' => $role,
                        ];
                        $redirectURL = '/';
                        break;

                    case 'doctor':
                        $doctorModel = new DoctorModel();
                        $doctorData = $doctorModel->where('UserID', $userData['UserID'])->first();
    
                        $response = [
                            'msg' => 'okay',
                            'token' => $userData['token'],
                            'UserID' => $userData['UserID'],
                            'Username' => $userData['Username'],
                            'DoctorID' => $doctorData['DoctorID'],
                            'Role' => $role,
                        ];
                        $redirectURL = '/Doctor/Dashboard';
                        
                        break;

                    case 'admin':
                        $adminModel = new AdminModel();
                        $adminData = $adminModel->where('UserID', $userData['UserID'])->first();

                        $response = [
                            'msg' => 'okay',
                            'token' => $userData['token'],
                            'UserID' => $userData['UserID'],
                            'Username' => $userData['Username'],
                            'AdminID' => $adminData['AdminID'],
                            'Role' => $role,
                        ];
                        $redirectURL = '/Admin/Dashboard';
                        break;

                    default:
                        // Unknown role
                        return $this->respond(['msg' => 'Invalid role'], 401);
                }

                // Store the response data into session storage
                $session = session();
                $session->set('user_data', $response);

                // Redirect based on the role
                return redirect()->to($redirectURL);
            } else {
                // User is not active (status is pending or something else)
                return $this->respond(['msg' => 'User is not active'], 401);
            }
        } else {
            return $this->respond(['msg' => 'Invalid credentials'], 401);
        }
    } else {
        return $this->respond(['msg' => 'User not found'], 404);
    }
}

//admin

public function db_admin()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

    //   return view('doctor/doctor_dashboard');

        // Load the session service
        $session = session();

        // Check if 'user_data' exists in the session
        if ($session->has('user_data')) {
            // Retrieve user data from session
            $userData = $session->get('user_data');
            $loggedIn = true;
            // var_dump($userData);
            $role = $userData['Role']; // Assuming 'role' is stored in the session

            // Check if the user has a 'DoctorID' key
            if (isset($userData['AdminID'])) {
                // Retrieve the DoctorID
                $adminID = $userData['AdminID'];

                // Fetch doctor's data based on DoctorID
                $adminModel = new AdminModel();
                $admin = $adminModel->find($adminID);

                if ($admin) {
                     // Pass loggedIn status, role, and doctor data to the view
                     $data['loggedIn'] = $loggedIn;
                     $data['role'] = $role;
                    // Pass the doctor data to the view
                    $data['admins'] = [$admin]; // Make sure $doctors is an array
                    return view('admin/admin_dashboard', $data);
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


    
public function checkSessionData()
    {
        // Load the session library
        $session = session();

        // Check if session data exists
        if ($session->has('user_data')) {
            // Retrieve session data
            $userData = $session->get('user_data');

            // Display session data
            echo "User ID: " . $userData['UserID'] . "<br>";
            echo "Username: " . $userData['Username'] . "<br>";
            echo "Role: " . $userData['Role'] . "<br>";
            echo "Token: " . $userData['token'] . "<br>";
            // echo "Patient ID: " . $userData['PatientID'] . "<br>";
            echo "Doctor ID: " . $userData['DoctorID'] . "<br>";
            // echo "Admin ID: " . $userData['AdminID'] . "<br>";

            // You can add more data if needed
        } else {
            echo "No session data found.";
        }
    }

//ordering

public function showProdDetails($productID)
    {
        // Load the session service
    $session = session();
    
    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
    }

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }

        // Load the product model
        $productModel = new ProductModel();
        $lensModel = new LensModel();

        // Retrieve the product data based on the product ID
        $product = $productModel->find($productID);
        // Retrieve all lenses
        $lens = $lensModel->findAll();
    
        // Load Cart Data for the logged-in user
    $cartModel = new CartModel();
    $cartItems = [];
    if ($loggedIn && isset($userData['UserID'])) {
        $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();
    }

    // Calculate the count of items in the cart
    $cartCount = count($cartItems);

    // // Pass the cart count to the view
    // $data['cartCount'] = $cartCount;


        // Dump the contents and type of the $products variable
        // var_dump($products);


        // Check if the product exists
        // if (!$product) {
        //     // Product not found, redirect or show error message
        //     return redirect()->to('/admin/products')->with('error', 'Product not found');
        // }

        // Pass the product data to the view for editing
        return view('user/show_product', [
            'product' => $product,
            'lens' => $lens,
            'loggedIn' => $loggedIn,
            'role' => $role,
            'patients' => $patients,
            'cartCount' => $cartCount
        ]);
    }


    public function addToCart()
{
    // Load the session service
    $session = session();

    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Check if the user has a 'UserID' key
        if (isset($userData['UserID'])) {
            // Retrieve the UserID
            $userID = $userData['UserID'];

            // Retrieve data from POST request
            $productID = $this->request->getPost('productID');
            $lensID = $this->request->getPost('lensID');
            $quantity = $this->request->getPost('quantity');

            // Check if all required data is provided
            if ($productID && $lensID && $quantity) {
                // Create an instance of CartModel
                $cartModel = new CartModel();

                // Insert data into the cart table
                $data = [
                    'UserID' => $userID,
                    'ProductID' => $productID,
                    'LensID' => $lensID,
                    'Quantity' => $quantity
                ];

                $cartModel->insert($data);

                // Redirect the user to a different page after adding to the cart
                return redirect()->to('/store');
            } else {
                return view('error', ['error' => 'Incomplete data provided']);
            }
        } else {
            return view('error', ['error' => 'UserID not found in session data']);
        }
    } else {
        return view('error', ['error' => 'User data not found in session']);
    }
}

public function viewCart()
{
    $session = session();
    
    // Check if 'user_data' exists in the session
    $loggedIn = false;
    $role = null;
    $userData = [];
    if ($session->has('user_data')) {
        // Retrieve user data from session
        $userData = $session->get('user_data');
        $loggedIn = true;
        $role = $userData['Role']; // Assuming 'role' is stored in the session
    }

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }

    // Initialize cart items array
    $cartItems = [];
    
    // Check if the user is logged in and has a valid UserID
    if ($loggedIn && isset($userData['UserID'])) {
        $cartModel = new CartModel();
        $cartItems = [];
        $productModel = new ProductModel();
        $lensModel = new LensModel();

         // Fetch cart items based on UserID
         $cartItems = $cartModel->where('UserID', $userData['UserID'])->findAll();

         // Fetch product and lens data for each cart item
         foreach ($cartItems as &$item) {
             // Fetch product data based on ProductID
             $product = $productModel->find($item['ProductID']);
             if ($product) {
                 $item['product'] = $product;
             }
 
             // Fetch lens data based on LensID
             $lens = $lensModel->find($item['LensID']);
             if ($lens) {
                 $item['lens'] = $lens;
             }

                  // Calculate the count of items in the cart
                $cartCount = count($cartItems);
         }
        
    }



    // Pass loggedIn status, role, and patient data to the view
    $data = [
        'loggedIn' => $loggedIn,
        'role' => $role,
        'patients' => $patients,
        'cartItems' => $cartItems,
        'cartCount' => $cartCount
    ];

    return view('user/cart', $data);
}

// Function to remove item from cart
public function removeItem($CartID)
{
    // Load the cart model
    $cartModel = new CartModel();

    // Check if the cart item exists
    $cartItem = $cartModel->find($CartID);

    if ($cartItem) {
        // Delete the cart item
        $cartModel->delete($CartID);
        
        // Redirect back to the cart page or any other desired page
        return redirect()->to(base_url('store/cart'))->with('success', 'Item removed from cart successfully.');
    } else {
        // Redirect back to the cart page or any other desired page with an error message
        return redirect()->to(base_url('cart'))->with('error', 'Item not found in the cart.');
    }
}

public function item_checkout()
{
    // Start session if not already started
    session();

    // Check if the user is logged in
    if (!session()->has('user_data')) {
        // If user is not logged in, redirect to login page or any other appropriate action
        return redirect()->to('login')->with('error', 'Please log in to proceed with checkout.');
    }

    // Get cart items for the user
    $cartModel = new CartModel();
    $cartItems = $cartModel->where('UserID', session('user_data')['UserID'])->findAll();

    if (!empty($cartItems)) {
        // Initialize total amount
        $totalAmount = 0;

        // Process each cart item for purchase
        foreach ($cartItems as $item) {
            // Load the related product and lens data
            $productModel = new ProductModel();
            $product = $productModel->find($item['ProductID']);

            $lensModel = new LensModel();
            $lens = $lensModel->find($item['LensID']);

            if (!$product || !$lens) {
                // Redirect back with error message if product or lens data is missing
                return redirect()->back()->with('error', 'Product or lens data is missing for some cart items.');
            }

            // Calculate total amount for the item
            $productPrice = $product['Price'];
            $lensPrice = $lens['Price'];
            $itemTotalAmount = $item['Quantity'] * ($productPrice + $lensPrice);

            // Update total amount
            $totalAmount += $itemTotalAmount;

            // Insert purchase record for each item
            $purchaseData = [
                'UserID' => session('user_data')['UserID'],
                'EyewearID' => $item['ProductID'],
                'LensID' => $item['LensID'],
                'PurchaseDate' => date('Y-m-d H:i:s'),
                'Quantity' => $item['Quantity'],
                'TotalAmount' => $itemTotalAmount, // Total amount for the item
                'Status' => 'Pending' // Adjust status as needed
            ];
            $purchaseModel = new PurchaseModel();
            $purchaseModel->insert($purchaseData);

            // Update the stock quantity in the ProductModel
            $productModel->update($item['ProductID'], ['StockQuantity' => $product['StockQuantity'] - $item['Quantity']]);

            // Update the stock quantity in the LensModel
            $lensModel->update($item['LensID'], ['StockQuantity' => $lens['StockQuantity'] - $item['Quantity']]);

            // Optionally, you may want to remove the item from the cart after purchase
            $cartModel->delete($item['CartID']);
        }

        // Redirect to a success page or display a success message
        return redirect()->to('success-page')->with('totalAmount', $totalAmount);
    } else {
        // If cart is empty, display an error message or redirect to cart page
        return redirect()->to('cart-page')->with('error', 'Your cart is empty.');
    }
}




}
