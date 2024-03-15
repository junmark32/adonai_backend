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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use CodeIgniter\Session\Session;

class UserController extends ResourceController
{
    public function index()
    {
        
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();

      return view('user/index', $data);
    }

    public function login()
    {
    //   $productModel = new ProductModel();
    //   $data['products'] = $productModel->findAll();

      return view('login');
    }

    public function store()
    {
     // Load the ProductModel
     $productModel = new ProductModel();

     // Retrieve all products from the database
     $products = $productModel->findAll();

     // Pass the products data to the view
     $data['products'] = $products;

     return view('user/store', $data);

    }

    public function checkout()
    {
        // Get the doctor ID from the URL parameter
        $doctorID = $this->request->getGet('doctor_id');
    
        // Fetch the doctor's data based on the doctor ID
        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->find($doctorID);

        return view('user/checkout', ['doctor'=>$doctor]);

    }

    public function booking()
    {
        // Get the doctor ID from the URL parameter
        $doctorID = $this->request->getGet('doctor_id');
    
        // Fetch the doctor's data based on the doctor ID
        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->find($doctorID);
    
        // Fetch all schedule timings for the doctor
        $scheduleModel = new ScheduleModel();
        $scheduleTimings = $scheduleModel->where('doctor_id', $doctorID)->where('status', 'Available')->findAll();

        // $data = [
                //     'doctor' => $doctor,
                //     'scheduleTimings' => $scheduleTimings
                // ];

                // // Return JSON response
                // return $this->response->setJSON($data);

    
        // Pass the doctor's data and schedule timings to the view
        return view('user/booking', ['doctor' => $doctor, 'scheduleTimings' => $scheduleTimings]);
    }
    

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

            // Check if the user has a 'DoctorID' key
            if (isset($userData['DoctorID'])) {
                // Retrieve the DoctorID
                $doctorID = $userData['DoctorID'];

                // Fetch doctor's data based on DoctorID
                $doctorModel = new DoctorModel();
                $doctor = $doctorModel->find($doctorID);

                if ($doctor) {
                    // Pass the doctor data to the view
                    $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                    return view('doctor/doctor_dashboard', $data);
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
    public function register()
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
    
                    return $this->respond(['msg' => 'okay', 'token' => $token]);
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

    public function verifyCode($code)
    {
        try {
            // Retrieve the verification code from the request
            // $code = $this->request->getPost('verificationCode');

            // Check if the code exists in the database
            $userModel = new UserModel();
            $user = $userModel->where('verification_code', $code)->first();

            if ($user) {
                // Update user status to 'active' or whatever status you use for verified users
                $userModel->update($user['UserID'], ['status' => 'active']);

                // Optionally, you can log the user in or perform any other action after verification
                // For example, you can log the user in:
                // $this->authenticateUser($user['id']);

                return $this->respond(['msg' => 'okay']);
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

            // Check if the user has a 'DoctorID' key
            if (isset($userData['AdminID'])) {
                // Retrieve the DoctorID
                $adminID = $userData['AdminID'];

                // Fetch doctor's data based on DoctorID
                $adminModel = new AdminModel();
                $admin = $adminModel->find($adminID);

                if ($admin) {
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
            // echo "Patient ID: " . $userData['PatientID'] . "<br>";
            // echo "Doctor ID: " . $userData['DoctorID'] . "<br>";
            echo "Admin ID: " . $userData['AdminID'] . "<br>";

            // You can add more data if needed
        } else {
            echo "No session data found.";
        }
    }

//ordering

public function showProdDetails($productID)
    {
        // Load the product model
        $productModel = new ProductModel();

        // Retrieve the product data based on the product ID
        $product = $productModel->find($productID);

        // Dump the contents and type of the $products variable
        // var_dump($products);


        // Check if the product exists
        // if (!$product) {
        //     // Product not found, redirect or show error message
        //     return redirect()->to('/admin/products')->with('error', 'Product not found');
        // }

        // Pass the product data to the view for editing
        return view('user/show_product', ['product' => $product]);
    }


  
}
