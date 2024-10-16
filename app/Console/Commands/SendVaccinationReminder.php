<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; 
use App\Events\VaccinationRemainder; 
use Carbon\Carbon;

class SendVaccinationReminder extends Command
{
    protected $signature = 'vaccination:remind';
    protected $description = 'Send vaccination reminder email to users scheduled for tomorrow.';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $users = User::whereDate('scheduled_vaccination_date', $tomorrow)->with('vaccineCenter')->get();

        foreach ($users as $user) {
            event(new VaccinationRemainder($user));
        }

        $this->info('Vaccination reminders sent for ' . $tomorrow);
    }
}
