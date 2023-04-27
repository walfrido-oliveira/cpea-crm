<?php

namespace Database\Seeders;

use App\Models\TemplateEmail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template_emails')->truncate();

        TemplateEmail::create([
            'name' => 'new_user_created',
            'subject' => 'Novo Cadastro - CPEA',
            'description' => '',
            'notification' => 'App\Notifications\NewUserNotification',
            'tags' => '{$user_first_name},{$create_account_url},{$signature}',
            'value' => '',
        ]);
    }
}
