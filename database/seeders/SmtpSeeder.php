<?php

namespace Database\Seeders;

use App\Models\SmtpSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SmtpSetting::firstOrCreate([], [
           'mail_transport' => 'smtp',
           'mail_host' => 'smtp.mailtrap.io',
           'mail_port' => 2525,
           'mail_username' => 'username',
           'mail_password' => 'password',
           'mail_encryption' => 'tls',
           'mail_from' => 'no-reply@example.com',
         ]);
    }
}
