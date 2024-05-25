<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescriptionModel extends Model
{
    protected $table            = 'prescriptions';
    protected $primaryKey       = 'PrescriptionID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['DoctorID', 'PatientID', 'Name', 'Gender', 'Date', 'Address', 'Age', 'DateOfBirth', 'Occupation', 'Phone',
    'B_OD_SPH', 'B_OD_CYL', 'B_OD_AX', 'B_OD_ADD', 'B_OD_VA', 'B_OD_PD', 'B_OS_SPH', 'B_OS_CYL', 'B_OS_AX', 'B_OS_ADD', 'B_OS_VA', 'B_OS_PD',
    'Ocular_History',
    'L_OD_SPH', 'L_OD_CYL', 'L_OD_AX', 'L_OD_ADD', 'L_OD_PD', 'L_OS_SPH', 'L_OS_CYL', 'L_OS_AX', 'L_OS_ADD', 'L_OS_PD',
    'Frame', 'Lens', 'Total', 'Diagnosis', 'Remarks', 'Management', 'Follow_Up', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
