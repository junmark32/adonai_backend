<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends ResourceController
{
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

    public function login()
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
    
                    switch ($role) {
                        case 'user':
                            $patientModel = new PatientModel();
                            $patientData = $patientModel->where('UserID', $userData['UserID'])->first();
    
                            if ($patientData) {
                                return $this->respond([
                                    'msg' => 'okay',
                                    'token' => $userData['token'],
                                    'UserID' => $userData['UserID'],
                                    'Username' => $userData['Username'],
                                    'PatientID' => $patientData['PatientID'],
                                    'Role' => $role,
                                ]);
                            } else {
                                return $this->respond(['msg' => 'Patient data not found'], 404);
                            }
                            break;
    
                        case 'doctor':
                            $doctorModel = new DoctorModel();
                            $doctorData = $doctorModel->where('UserID', $userData['UserID'])->first();
    
                            if ($doctorData) {
                                return $this->respond([
                                    'msg' => 'okay',
                                    'token' => $userData['token'],
                                    'UserID' => $userData['UserID'],
                                    'Username' => $userData['Username'],
                                    'DoctorID' => $doctorData['DoctorID'],
                                    'Role' => $role,
                                ]);
                            } else {
                                return $this->respond(['msg' => 'Doctor data not found'], 404);
                            }
                            break;
    
                        case 'admin':
                            return $this->respond([
                                'msg' => 'okay',
                                'token' => $userData['token'],
                                'UserID' => $userData['UserID'],
                                'Username' => $userData['Username'],
                                'Role' => $role,
                            ]);
    
                        default:
                            // Unknown role
                            return $this->respond(['msg' => 'Invalid role'], 401);
                    }
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
    



  
}
