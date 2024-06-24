<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class ChartsComponent extends Component
{
    public $chart = '';
    public $earningTotal = 0;
    public $earningCount = 0;
    public $earningChart = [
        'title' => ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
        'value' => [0, 0, 0, 0, 0, 0, 0],
    ];

    public function mount()
    {
        $this->chart = 'Select One';
        //$this->setEarningChartWeek();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('renderChart', $this->earningChart);
    }

    public function render()
    {
        return view('livewire.dashboard.charts-component');
    }

    private function setEarningChartWeek()
    {
        $this->chart = 'This Week';
        $this->earningTotal = 0;
        $this->earningCount = 0;
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $daysOfWeek = [];

        // Generate the days of the week labels
        for ($date = $startOfWeek; $date <= $endOfWeek; $date = $date->addDay()) {
            $daysOfWeek[] = $date->format('D');
        }

        // Retrieve invoice statistics for the current week
        $invoiceStats = Invoice::whereDate('created_at', '>=', now()->startOfWeek())
            ->whereDate('created_at', '<=', $endOfWeek)
            ->where(['payment_status' => '1'])
            ->get();

        // Initialize the values array with zeros
        $values = array_fill(0, 7, 0);

        // Update the values array with the earnings for each day
        foreach ($invoiceStats as $stat) {
            $dayOfWeekIndex = $stat->created_at->format('w');
            $values[$dayOfWeekIndex] += $stat->totalPrice;
            $this->earningTotal += $stat->totalPrice;
            $this->earningCount += 1;
        }

        $this->earningChart = [
            'title' => $daysOfWeek,
            'value' => $values,
        ];
    }

    public function week()
    {
        $this->setEarningChartWeek();
        $this->dispatchBrowserEvent('renderChart', $this->earningChart);
    }
    public function setEarningChartMonth()
    {
        $this->chart = 'This Month';
        $this->earningTotal = 0;
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $values = [];

        // Calculate the number of days in the month
        $daysInMonth = $endOfMonth->day;

        // Calculate the number of days per week
        $daysPerWeek = 7;

        // Calculate the number of weeks
        $weeks = ceil($daysInMonth / $daysPerWeek);

        // Retrieve invoice statistics for each week of the current month
        $currentDate = $startOfMonth->copy(); // Clone the start date to avoid modification

        for ($week = 1; $week <= $weeks; $week++) {
            $weekStartDate = $currentDate->copy();
            $weekEndDate = $currentDate
                ->copy()
                ->addDays($daysPerWeek - 1)
                ->endOfDay();

            // If it's the last week, adjust the end date to the end of the month
            if ($week == $weeks) {
                $weekEndDate = $endOfMonth;
            }

           //dd($weekStartDate, $weekEndDate);

            $weekEarnings = Invoice::whereDate('created_at', '>=', $weekStartDate)
                ->whereDate('created_at', '<=', $weekEndDate)
                ->where(['payment_status' => '1'])
                ->sum('price');

            $this->earningTotal += $weekEarnings;

            $values[] = $weekEarnings;

            // Move to the next week for the next iteration
            $currentDate->addDays($daysPerWeek);
        }

        $this->earningChart = [
            'title' => $this->generateWeekLabels($weeks, $daysInMonth),
            'value' => $values,
        ];
    }

    public function generateWeekLabels($weeks, $daysInMonth)
    {
        $labels = [];

        for ($week = 1; $week <= $weeks; $week++) {
            $labels[] = 'Week ' . $week . ': Day ' . ($week - 1) * 7 + 1 . ' - Day ' . min($week * 7, $daysInMonth);
        }

        return $labels;
    }

    public function month()
    {
        $startOfMonth = now()
            ->startOfMonth()
            ->toDateString();
        $endOfMonth = now()
            ->endOfMonth()
            ->toDateString();
        $this->earningCount = Invoice::whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $endOfMonth)
            ->where(['payment_status' => '1'])
            ->count();
        $this->setEarningChartMonth();
        $this->dispatchBrowserEvent('renderChart', $this->earningChart);
    }
}
