<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\DoctorModel;

class UserController extends ResourceController
{
    public function register()
    {
        try {
            $userModel = new UserModel();
            $patientModel = new PatientModel();

            // Generate a verification token
            $token = $this->verification(50);

            // Data for the Users table
            $userData = [
                'Username' => $this->request->getVar('username'),
                'PasswordHash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'token' => $token,
                'status' => 'active',
                'role' => 'user',
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

    private function verification($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
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
            return $this->respond(['msg' => 'Invalid credentials'], 401);
        }
    } else {
        return $this->respond(['msg' => 'User not found'], 404);
    }
}



  
}
