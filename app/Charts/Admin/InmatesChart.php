<?php

namespace App\Charts\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Prison;
use App\Models\Inmate;
use App\Models\Appointment;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class InmatesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $currentPrison = Auth::user()->admin->prison;
        $activeInmates = $currentPrison->inmates()->where('status', \App\Models\Inmate::ACTIVE)->count();
        $inactiveInmates = $currentPrison->inmates()->where('status', \App\Models\Inmate::INACTIVE)->count();
        $currentPrisonInmates = $currentPrison->inmates()->get();
        $totalAppointments = 0;
        foreach ($currentPrisonInmates as $inmate) {
            $totalAppointments = $totalAppointments + $inmate->appointments()->count();
        }
        return $this->chart->pieChart()
            ->addData([$activeInmates, $inactiveInmates, $totalAppointments])
            ->setLabels(['Inmates', 'Left Inmates', 'total Appointments']);
    }
}
