<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSendEmailCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-send-email-cmd {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending a test email to the indicated email address. Use: php artisan app:test-send-email-cmd mail@example.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Run: sail artisan app:test-send-email-cmd mail@example.com
        $email = $this->argument('email');
        $name = "John Doe";
        Mail::to($email)->queue(new TestEmail($name));
    }
}
