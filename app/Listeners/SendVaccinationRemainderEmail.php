<?php

namespace App\Listeners;

use App\Events\VaccinationRemainder;
use App\Jobs\VaccinationRemainderMailJob;
use Carbon\Carbon;

/**
 * Class SendVaccinationRegisteredEmail
 *
 * This listener handles the sending of an email when a vaccination registration occurs.
 */
class SendVaccinationRemainderEmail
{
    /**
     * Handle the event.
     *
     * @param VaccinationRegistered $event The vaccination registered event.
     * @return void
     */
    public function handle(VaccinationRemainder $event)
    {
        // Get the user from the event
        $user = $event->user;

        // Prepare the mail data
        $mail_data = [
            'to_email' => $user->email,
            'receiver_name' => $user->full_name,
            'subject' => 'Vaccination Reminder: Your Scheduled Appointment',
            'body' => 'Dear ' . $user->full_name . ',<br><br>
                We hope this message finds you well. This is a friendly reminder about your upcoming vaccination appointment. Your decision to get vaccinated is an important step toward protecting your health and supporting the well-being of our community.<br><br>
                Below are the details of your scheduled appointment:<br>
                - <strong>Vaccination Center:</strong> ' . ($user->vaccineCenter->center_name ?? "N/A") . '<br>
                - <strong>Location:</strong> ' . ($user->vaccineCenter->location ?? "N/A") . '<br>
                - <strong>Appointment Date:</strong> ' . Carbon::parse($user->scheduled_vaccination_date)->format('M d, Y') . '<br><br>
                Please ensure you bring a valid ID with you and arrive at least 10 minutes before your scheduled time. If you have any questions or need to reschedule your appointment, feel free to contact us.<br><br>
                Thank you for taking this crucial step in safeguarding your health. We look forward to seeing you at the vaccination center.<br><br>
                Best regards,<br>
                The Vaccination Team',
            'cc_array' => null, // If you have CC emails, set them here
            'attachment_paths' => null // If you have attachments, set them here
        ];
        


        // Dispatch mail job
        dispatch(new VaccinationRemainderMailJob($mail_data));
    }
}
