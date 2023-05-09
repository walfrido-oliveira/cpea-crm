<?php

namespace Database\Seeders;

use App\Models\TemplateEmail;
use Illuminate\Database\Seeder;

class TemplateEmailScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TemplateEmail::create([
            'name' => 'new_schedule',
            'subject' => 'Notificação de Reunião - CPEA CRM',
            'description' => '',
            'notification' => 'App\Notifications\NewScheduleNotification',
            'tags' =>
            '{$user_first_name},{$signature},{$item_type},{$interaction_at},{$schedule_at},{$additive},{$cpea_linked_id},{$schedule_type},{$schedule_name},{$addressees},{$optional_addressees},
            {$schedule_details},{$item_details},{$project_status},{$proposed_status},{$prospecting_status},{$detailed_contact},{$organizer}',
            'value' => '',
        ]);
    }
}
