<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AppointmentModel;
use App\Models\ScheduleModel;

class UpdateAppointmentStatus extends BaseCommand
{
    protected $group = 'Cronjobs';
    protected $name = 'cron:update-appointment-status';
    protected $description = 'Update appointment status based on current time';

    public function run(array $params)
    {
        $appointmentModel = new AppointmentModel();
        $scheduleTimingsModel = new ScheduleModel();

        $today = date('Y-m-d');
        $currentTime = date('H:i:s');

        // Update status to 'On-Going'
        $appointments = $appointmentModel->where('Pref_Date', $today)->findAll();
        foreach ($appointments as $appointment) {
            $schedule = $scheduleTimingsModel->find($appointment['Pref_Timeslot_ID']);
            if ($schedule) {
                if ($currentTime >= $schedule['start_time'] && $currentTime <= $schedule['end_time']) {
                    $scheduleTimingsModel->update($appointment['Pref_Timeslot_ID'], ['status' => 'On-Going']);
                }
            }
        }

        // Update status to 'Available' by 9:00 PM
        $scheduleTimingsModel->where('status', 'On-Going')->where('end_time <=', '21:00:00')->update(['status' => 'Available']);
    }
}
