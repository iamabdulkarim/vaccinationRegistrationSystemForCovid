<?php

namespace App\Http\Controllers\Frontend;

use App\Events\VaccinationRemainder;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
{
    try {
        
        $vaccineCenters = VaccineCenter::select('id', 'center_name', 'location')->get();
        
        return view('covid.registration', compact('vaccineCenters'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Unable to load vaccine centers at this time. Please try again later.');
    }
}

   
    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'user_nid' => 'required|string|unique:users,nid', 
        'vaccine_center_id' => 'required|exists:vaccine_centers,id', 
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email', 
        'phone_number' => 'required|string|max:20|unique:users,phone_number', 
    ]);

 
    $vaccineCenter = VaccineCenter::findOrFail($request->vaccine_center_id);

    
    $scheduledDate = $this->calculateScheduleDate($vaccineCenter);


    
    try {
        DB::transaction(function () use ($request, $scheduledDate) {
           
            User::create([
                'vaccine_center_id' => $request->vaccine_center_id,
                'full_name' => $request->full_name,
                'nid' => $request->user_nid,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'status' => 'Scheduled',
                'scheduled_vaccination_date' => $scheduledDate,
            ]);
        });

        
        return redirect()->back()->with('success', 'Registration successful!');

    } catch (\Exception $e) {
        
        \Log::error('Error during user registration: ' . $e->getMessage(), [
            'user_nid' => $request->user_nid,
            'exception' => $e
        ]);

        
        return redirect()->back()->withErrors('Registration failed. Please try again.');
    }
}


    private function calculateScheduleDate(VaccineCenter $vaccineCenter)
    {
        
        $nextWorkingDay = $this->getNextAvailableWeekday(Carbon::now());

        
        $latestScheduledDate = User::where('vaccine_center_id', $vaccineCenter->id)
            ->max('scheduled_vaccination_date');

    
        $latestScheduledDate = $latestScheduledDate ? Carbon::parse($latestScheduledDate) : $nextWorkingDay;

        
        $scheduledUsersCount = User::where('vaccine_center_id', $vaccineCenter->id)
            ->whereDate('scheduled_vaccination_date', $latestScheduledDate)
            ->count();

        if ($scheduledUsersCount < $vaccineCenter->daily_limit) {
            return $latestScheduledDate;
        }
        return $this->getNextAvailableWeekday($latestScheduledDate);
    }

    private function getNextAvailableWeekday(Carbon $date)
    {
        
        $daysOff = [Carbon::FRIDAY, Carbon::SATURDAY];
    
        
        while (in_array($date->dayOfWeek, $daysOff)) {
            $date->addDay();
        }
    
        return $date;
    }
    
}
