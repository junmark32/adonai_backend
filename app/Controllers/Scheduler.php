<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;
use CodeIgniter\I18n\Time;

class Scheduler extends BaseController
{
    public function index()
    {
        //
    }

    public function updateScheduleStatus()
    {
        $today = date('Y-m-d'); // Get today's date in Y-m-d format

        // Update Status to 'On-Going' where Pref_Date is today
        return $this->where('Pref_Date', $today)
                    ->set('Status', 'On-Going')
                    ->update();

       
    }
}
