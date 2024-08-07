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
use App\Models\PrescriptionModel;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\DocAboutModel;
use App\Models\DocAwardsModel;
use App\Models\DocEducModel;
use App\Models\DocExpModel;
use App\Models\DocServModel;
use App\Models\DocSpecModel;
use App\Models\DocFeedModel;
use CodeIgniter\I18n\Time;

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
    $prescriptModel = new PrescriptionModel();
    $appointments = [];
    $prescript = [];

    if (!empty($userData['PatientID'])) {
        // Fetch appointments associated with the user's session PatientID
        $appointments = $appointmentModel
        ->where('PatientID', $userData['PatientID'])
        ->orderBy('AppointmentID', 'DESC')
        ->findAll();

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

    if (!empty($userData['PatientID'])) {
        // Fetch appointments associated with the user's session PatientID
        $prescript = $prescriptModel
        ->where('PatientID', $userData['PatientID'])
        ->orderBy('PrescriptionID', 'DESC')  // Replace 'id' with the appropriate field for sorting
        ->findAll();

        // If appointments are found, fetch doctor data for each appointment
        if (!empty($prescript)) {
            // Load Doctor model
            $doctorModel = new DoctorModel();

            // Loop through appointments to fetch doctor data for each appointment
            foreach ($prescript as &$pres) {
                // Fetch doctor data based on the DoctorID from the appointment
                $doctor = $doctorModel->find($pres['DoctorID']);

                // If doctor data is found, assign it to the appointment
                if (!empty($doctor)) {
                    $pres['doctor_data'] = $doctor;
                }
            }
        }
    }

    // echo '<pre>';
                // print_r($user);
                // echo '</pre>';



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
    $data['prescript'] = $prescript;

     // Pass the products data to the view
     $data['products'] = $products;

     // Pass the cart count to the view
     $data['cartCount'] = $cartCount;

     return view('user/user_dashboard', ['token' => $token] + $data);

    }

    public function user_prof_setting()
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

    // echo '<pre>';
                // print_r($user);
                // echo '</pre>';

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

     return view('user/user_prof_setting', ['token' => $token] + $data);

    }

    public function update_prof_setting()
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

    // echo '<pre>';
                // print_r($user);
                // echo '</pre>';

    // Load Patients Data
    $patientModel = new PatientModel();
    $patients = [];
    if (!empty($userData['PatientID'])) {
        // Fetch only the patient associated with the user's session ID
        $patients = $patientModel->where('PatientID', $userData['PatientID'])->findAll();
    }

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
    $user_data = [
        'FirstName' => $this->request->getPost('first_name'),
        'LastName' => $this->request->getPost('last_name'),
        'Phone' => $this->request->getPost('phone'),
        'Gender' => $this->request->getPost('gender'),
        'DateOfBirth' => $this->request->getPost('dateofbirth'),
        'Age' => $this->request->getPost('age'),
        'Blood_type' => $this->request->getPost('blood_type'),
        'Email' => $this->request->getPost('email'),
        'Address' => $this->request->getPost('address'),
        'City' => $this->request->getPost('city'),
        'State' => $this->request->getPost('state'),
        'Zipcode' => $this->request->getPost('zipcode'),
        'Country' => $this->request->getPost('country'),
    ];

    // If a new image was uploaded, include it in the data array
    if (!empty($imageName)) {
        $user_data['Profile_url'] = $imageName;
    }

    // Update doctor data in the database
    $patientModel->update($userData['PatientID'], $user_data);


    return redirect()->to('/profile-settings')->with('success', 'Profile updated successfully');

    }

    public function user_change_password()
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

    // echo '<pre>';
                // print_r($user);
                // echo '</pre>';

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

     return view('user/user_change_password', ['token' => $token] + $data);

    }

    public function update_change_password()
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

    // echo '<pre>';
                // print_r($user);
                // echo '</pre>';
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
    $user = $userModel->find($userData['UserID']);

    // Verify the old password
    if (!password_verify($oldPassword, $user['PasswordHash'])) {
        return redirect('/')->back()->withInput()->with('error', 'The old password is incorrect.');
    }

    // Hash the new password
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $userModel->update($userData['UserID'], ['PasswordHash' => $newPasswordHash]);

    return redirect()->to('/login')->with('status', 'Password changed successfully. Please login with your new password.');

    }


    public function gen_prescript($presID, $doctorID)
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
    //
    // Load the PrescriptionModel
    $prescriptionModel = new PrescriptionModel();
    // Fetch prescription data based on PatientID, DoctorID, and PrescriptionID
    $prescriptions = $prescriptionModel->where('PatientID', $userData['PatientID'])
                                        ->where('DoctorID', $doctorID)
                                        ->where('PrescriptionID', $presID)
                                        ->findAll();
    
                                  
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

    public function user_orders()
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

    

    $patientModel = new PatientModel();
    $purchaseModel = new PurchaseModel();
    $productModel = new ProductModel();
    $lensModel = new LensModel();

    $patient = $patientModel->where('PatientID', $userData['PatientID'])->first();
    $userId = $patient['UserID'];
    $purchases = $purchaseModel->where('UserID', $userId)->findAll();

    // Initialize arrays to store EyeWearData and LensData
    $productData = [];
    $lensData = [];

    // Fetch EyeWearData and LensData based on the purchase records
    foreach ($purchases as $purchase) {
        if (isset($purchase['EyewearID'])) {
            $product = $productModel->find($purchase['EyewearID']);
            if ($product) {
                $productData[] = $product;
            }
        }

        if (isset($purchase['LensID'])) {
            $lens = $lensModel->find($purchase['LensID']);
            if ($lens) {
                $lensData[] = $lens;
            }
        }
    }



    // echo '<pre>';
    // print_r($purchases);
    // print_r($productData);
    // print_r($lensData);
    // echo '</pre>';




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
    $data['purchases'] = $purchases;
    $data['productData'] = $productData;
    $data['lensData'] = $lensData;
    
    $data['loggedIn'] = $loggedIn;
    $data['role'] = $role;
    $data['patients'] = $patients;

     // Pass the products data to the view
     $data['products'] = $products;

     // Pass the cart count to the view
     $data['cartCount'] = $cartCount;

     return view('user/user_orders', ['token' => $token] + $data);

    }

    public function cancelPurchase($id)
    {
        // Load the PurchaseModel
        $purchaseModel = new PurchaseModel();

        // Update the status to 'Cancelled'
        $data = [
            'Status' => 'Cancelled'
        ];

        // Check if the update is successful
        if ($purchaseModel->update($id, $data)) {
            return redirect()->to('/store/orders')->with('message', 'Purchase cancelled successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to cancel the purchase.');
        }
    }

    public function getBill($id)
{
    // Load the PurchaseModel
    $purchaseModel = new PurchaseModel();
    $productModel = new ProductModel();
    $lensModel = new LensModel();

    // Fetch the receipt data using the provided ID
    $purchase = $purchaseModel->find($id);

    if (!$purchase) {
        // Handle the case where no purchase record is found
        return $this->response->setStatusCode(404)->setBody('Receipt not found');
    }

    // Initialize arrays to hold product and lens data
    $productData = [];
    $lensData = [];

    // Fetch EyeWearData and LensData based on the purchase record
    if (isset($purchase['EyewearID'])) {
        $product = $productModel->find($purchase['EyewearID']);
        if ($product) {
            $productData[] = $product;
        }
    }

    if (isset($purchase['LensID'])) {
        $lens = $lensModel->find($purchase['LensID']);
        if ($lens) {
            $lensData[] = $lens;
        }
    }

    // Debug output
    // echo '<pre>';
    // print_r($purchase);
    // print_r($productData);
    // print_r($lensData);
    // echo '</pre>';

    // Prepare the receipt HTML
    $data = [
        'purchase' => $purchase,
        'products' => $productData,
        'lenses' => $lensData
    ];
   // Load view and render HTML
   $html = view('reports/bill_template', $data);

   // Initialize DOMPDF
   $options = new Options();
   $options->set('defaultFont', 'Courier');
   $dompdf = new Dompdf($options);
   $dompdf->loadHtml($html);
   $dompdf->setPaper('A5', 'portrait');
   $dompdf->render();

   // Output the generated PDF to Browser
   $dompdf->stream("adonai_reciept.pdf", ["Attachment" => 1]);
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
    // Prepare events data
$events = [];
foreach ($scheduleTimings as $timing) {
    // Merge start_time and end_time
    $startDateTime = $timing['date'] . ' ' . $timing['start_time'];
    $endDateTime = $timing['date'] . ' ' . $timing['end_time'];

    $events[] = [
        'id' => $timing['id'],
        'name' => date('g:i A', strtotime($timing['start_time'])) . ' - ' . date('g:i A', strtotime($timing['end_time'])),
        'date' => $timing['date'], // Use date in yyyy-mm-dd format
        'color' => ($timing['status'] === 'Available') ? '#00ff00' : '#ff0000'
    ];
}

$data['scheduleTimings'] = json_encode($events);

    // print_r($data);

    // Pass the doctor's data, schedule timings, and user-related data to the view
    return view('user/booking', [
        'doctor' => $doctor,
        
        'loggedIn' => $loggedIn,
        'role' => $role,
        'patients' => $patients,
        'cartCount' => $cartCount
    ] + $data );

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

                    $appointmentCount = $appointmentModel->where('DoctorID', $doctorID)->countAllResults();

                    date_default_timezone_set('Asia/Manila'); // Adjust according to your location
                    // Get the current date
                    $currentDate = date('d, M Y');
                    // Get the current date in MySQL-compatible format
                    $currentDates = date('Y-m-d'); // Example output: '2024-06-17'

                    // Initialize an array to hold appointment and patient data
                    $appointmentData = [];

                    // Fetch patient data for each appointment
                    $patientModel = new PatientModel();
                    $patientCount = $patientModel->countAll();
                    // Query to count patients created on the current date
                    $patientToday = $patientModel
                    ->where('DATE(created_at)', $currentDates)
                    ->countAllResults();

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

                    
                    // Assuming $appointmentData is an array of appointment details
                    $upcomingCount = 0;
                    $todayCount = 0;

                    foreach ($appointmentData as $data) {
                        $appointmentDate = date('Y-m-d', strtotime($data['appointment']['Pref_Date']));
                        if ($appointmentDate > $currentDates) {
                            $upcomingCount++;
                        } elseif ($appointmentDate == $currentDates) {
                            $todayCount++;
                        }
                    }
                    
                    $purchaseModel = new PurchaseModel();
                    // Join tables 1
                    $builder1 = $purchaseModel->builder();
                    $builder1->select('purchases.PurchaseID, patients.FirstName, patients.LastName, patients.Email, p1.Name as ProductName, purchases.Status, purchases.Quantity, purchases.TotalAmount, purchases.PurchaseDate');
                    $builder1->join('patients', 'patients.UserID = purchases.UserID');
                    $builder1->join('products p1', 'p1.ProductID = purchases.EyewearID');
                    $builder1->orderBy('purchases.PurchaseDate', 'DESC');
                    $data['purchases'] = $builder1->get()->getResult();


                            // Pass loggedIn status, role, and doctor data to the view
                    $data['loggedIn'] = $loggedIn;
                    $data['role'] = $role;
                    // Pass the doctor data to the view
                    $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                    $data['appointmentData'] = $appointmentData;
                    $data['appointmentCount'] = $appointmentCount;
                    $data['patientCount'] = $patientCount;
                    $data['patientToday'] = $patientToday;
                    $data['currentDate'] = $currentDate;
                    // Pass these counts to your view
                    $data['upcomingCount'] = $upcomingCount;
                    $data['todayCount'] = $todayCount;

                    // print_r($token);
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

    public function product()
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

                    $appointmentCount = $appointmentModel->where('DoctorID', $doctorID)->countAllResults();

                    date_default_timezone_set('Asia/Manila'); // Adjust according to your location
                    // Get the current date
                    $currentDate = date('d, M Y');
                    // Get the current date in MySQL-compatible format
                    $currentDates = date('Y-m-d'); // Example output: '2024-06-17'

                    // Initialize an array to hold appointment and patient data
                    $appointmentData = [];

                    // Fetch patient data for each appointment
                    $patientModel = new PatientModel();
                    $patientCount = $patientModel->countAll();
                    // Query to count patients created on the current date
                    $patientToday = $patientModel
                    ->where('DATE(created_at)', $currentDates)
                    ->countAllResults();

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

                    
                    // Assuming $appointmentData is an array of appointment details
                    $upcomingCount = 0;
                    $todayCount = 0;

                    foreach ($appointmentData as $data) {
                        $appointmentDate = date('Y-m-d', strtotime($data['appointment']['Pref_Date']));
                        if ($appointmentDate > $currentDates) {
                            $upcomingCount++;
                        } elseif ($appointmentDate == $currentDates) {
                            $todayCount++;
                        }
                    }
                    
                    $purchaseModel = new PurchaseModel();
                    // Join tables 1
                    $builder1 = $purchaseModel->builder();
                    $builder1->select('purchases.PurchaseID, patients.FirstName, patients.LastName, patients.Email, p1.Name as ProductName, purchases.Status, purchases.Quantity, purchases.TotalAmount, purchases.PurchaseDate');
                    $builder1->join('patients', 'patients.UserID = purchases.UserID');
                    $builder1->join('products p1', 'p1.ProductID = purchases.EyewearID');
                    $builder1->orderBy('purchases.PurchaseDate', 'DESC');
                    $data['purchases'] = $builder1->get()->getResult();

                    // Count purchases where Status is 'Pending'
                    $purchaseCount = $purchaseModel->where('Status', 'Pending')->countAllResults();

                    // Count purchases where Status is 'On-Process'
                    $onprocessCount = $purchaseModel->where('Status', 'On-Process')->countAllResults();

                    // Count purchases where Status is 'Returned'
                    $returnedCount = $purchaseModel->where('Status', 'Returned')->countAllResults();

                    $completeCount = $purchaseModel->where('Status', 'Completed')->countAllResults();

                    $cancelCount = $purchaseModel->where('Status', 'Cancelled')->countAllResults();
            // Assign counts to data array
                    $data['purchaseCount'] = $purchaseCount;
                    $data['onprocessCount'] = $onprocessCount;
                    $data['returnedCount'] = $returnedCount;
                    $data['completeCount'] = $completeCount;
                    $data['cancelCount'] = $cancelCount;


                            // Pass loggedIn status, role, and doctor data to the view
                    $data['loggedIn'] = $loggedIn;
                    $data['role'] = $role;
                    // Pass the doctor data to the view
                    $data['doctors'] = [$doctor]; // Make sure $doctors is an array
                    $data['appointmentData'] = $appointmentData;
                    $data['appointmentCount'] = $appointmentCount;
                    $data['patientCount'] = $patientCount;
                    $data['patientToday'] = $patientToday;
                    $data['currentDate'] = $currentDate;
                    // Pass these counts to your view
                    $data['upcomingCount'] = $upcomingCount;
                    $data['todayCount'] = $todayCount;
                    return view('doctor/doctor_products', ['token' => $token] + $data);
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

    public function doctorProfile($DoctorID)
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
            $token = $userData['token'];
            $patientID = $userData['PatientID'];
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


        // Fetch the doctor's data based on the doctor ID
        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->find($DoctorID);

        //pangisahan
        $docaboutModel = new DocAboutModel();
        $docabout = $docaboutModel->find($DoctorID);

        //pangmaramihan
        $docawardsModel = new DocAwardsModel();
        $docawards = $docawardsModel->where('DoctorID', $DoctorID)->findAll();

        $doceducModel = new DocEducModel();
        $doceduc = $doceducModel->where('DoctorID', $DoctorID)->findAll();

        $docexpModel = new DocExpModel();
        $docexp = $docexpModel->where('DoctorID', $DoctorID)->findAll();

        $docservModel = new DocServModel();
        $docserv = $docservModel->where('DoctorID', $DoctorID)->findAll();
        
        $docspecModel = new DocSpecModel();
        $docspec = $docspecModel->where('DoctorID', $DoctorID)->findAll();

        $docFeedModel = new DocFeedModel();
        $builder = $docFeedModel->builder();
        $builder->select('patients.FirstName, patients.LastName, patients.Profile_url, doc_feedback.Rating, doc_feedback.Review, doc_feedback.created_at');
        $builder->join('patients', 'patients.PatientID = doc_feedback.PatientID');
        $builder->where('doc_feedback.DoctorID', $DoctorID);
        $data['reviews'] = $builder->get()->getResult();
        // Pass the current time to the view
        $data['currentTime'] = Time::now();
        // Debugging: Check the structure of $doceduc
        // echo '<pre>';
        // print_r($data['reviews']);
        // echo '</pre>';
        // Perform the join query
        

        // Fetch all schedule timings for the doctor
        $scheduleModel = new ScheduleModel();
        $scheduleTimings = $scheduleModel->where('doctor_id', $DoctorID)->findAll();


        // Calculate the count of items in the cart
        $cartCount = count($cartItems);

        $data['docabout'] = $docabout;
        $data['docawards'] = $docawards;
        $data['doceduc'] = $doceduc;
        $data['docexp'] = $docexp;
        $data['docserv'] = $docserv;
        $data['docspec'] = $docspec;


        $data['doctor'] = $doctor;
        $data['loggedIn'] = $loggedIn;
        $data['role'] = $role;
        $data['patients'] = $patients;
        $data['userData'] = $userData;
        // Pass the cart count to the view
        $data['cartCount'] = $cartCount;
        return view('user/doctor_profile', ['token' => $token] + $data);

    }

    public function addReview()
    {
        $docFeedModel = new DocFeedModel();

        // Get data from the request
        $data = [
            'DoctorID' => $this->request->getPost('doctor_id'), // Ensure this input exists in the form
            'PatientID' => $this->request->getPost('patient_id'), // Ensure this input exists in the form
            'Rating' => $this->request->getPost('rating'),
            'Review' => $this->request->getPost('review_desc'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert data into the database
        if ($docFeedModel->insert($data)) {
            return redirect()->to('/'); // Redirect to a success page or other route
        } else {
            return redirect()->to('/feedback/error'); // Redirect to an error page or other route
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

                    $doctorModel = new DoctorModel();
                    $patientModel = new PatientModel();
                    $appointmentModel = new AppointmentModel();
                    $productModel = new ProductModel();
                    $purchaseModel = new PurchaseModel();

                    // $patientCount = $patientModel->countAll();
                    $doctorCount = $doctorModel->countAll();
                    $patientCount = $patientModel->countAll();
                    $appointmentCount = $appointmentModel->countAll();
                    $productCount = $productModel->countAll();

                    $data['doctorCount'] = $doctorCount;
                    $data['patientCount'] = $patientCount;
                    $data['appointmentCount'] = $appointmentCount;
                    $data['productCount'] = $productCount;

                    //
                    // Fetch patient data
                    $dailyData = $patientModel->select('DATE(created_at) as y, COUNT(PatientID) as a')
                    ->groupBy('DATE(created_at)')
                    ->findAll();

                    $monthlyData = $patientModel->select('DATE_FORMAT(created_at, "%Y-%m") as y, COUNT(PatientID) as a')
                    ->groupBy('DATE_FORMAT(created_at, "%Y-%m")')
                    ->findAll();

                    $yearlyData = $patientModel->select('YEAR(created_at) as y, COUNT(PatientID) as a')
                    ->groupBy('YEAR(created_at)')
                    ->findAll();

                    $data['dailyData'] = $dailyData;
                    $data['monthlyData'] = $monthlyData;
                    $data['yearlyData'] = $yearlyData;

                    // Fetch appointment data
                    $appointmentDailyData = $appointmentModel->select('DATE(created_at) as y, COUNT(AppointmentID) as b')
                    ->groupBy('DATE(created_at)')
                    ->findAll();

                    $appointmentMonthlyData = $appointmentModel->select('DATE_FORMAT(created_at, "%Y-%m") as y, COUNT(AppointmentID) as b')
                    ->groupBy('DATE_FORMAT(created_at, "%Y-%m")')
                    ->findAll();

                    $appointmentYearlyData = $appointmentModel->select('YEAR(created_at) as y, COUNT(AppointmentID) as b')
                    ->groupBy('YEAR(created_at)')
                    ->findAll();

                    $data['appointmentDailyData'] = $appointmentDailyData;
                    $data['appointmentMonthlyData'] = $appointmentMonthlyData;
                    $data['appointmentYearlyData'] = $appointmentYearlyData;

                    //
                    // Get the current year
                    $currentYear = date('Y');


                    $purchaseDailyData = $purchaseModel->select('DATE_FORMAT(PurchaseDate, "%Y-%m-%d") as y, COUNT(PurchaseID) as a')
                    ->where('YEAR(PurchaseDate)', $currentYear)
                    ->where('Status', 'Completed')
                    ->groupBy('DATE_FORMAT(PurchaseDate, "%Y-%m-%d")')
                    ->findAll();

                    $data['purchaseDailyData'] = $purchaseDailyData;

                    // // Format datetime fields to ISO 8601 format for Morris.js compatibility
                    // function formatDataForMorris($data) {
                    // foreach ($data as &$entry) {
                    // $entry['y'] = date('Y-m-d', strtotime($entry['y'])); // Adjust format as needed
                    // }
                    // return $data;
                    // }

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

    public function logout()
{
    // Load the session library
    $session = session();

    // Destroy the session data
    $session->destroy();

    // Optionally, you can redirect to the login page or another page
    return redirect()->to('/login');
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

    // Initialize cart items array and cart count
    $cartItems = [];
    $cartCount = 0; // Initialize cartCount to avoid undefined variable error
    
    // Check if the user is logged in and has a valid UserID
    if ($loggedIn && isset($userData['UserID'])) {
        $cartModel = new CartModel();
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
        }
        
        // Calculate the count of items in the cart
        $cartCount = count($cartItems);
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
