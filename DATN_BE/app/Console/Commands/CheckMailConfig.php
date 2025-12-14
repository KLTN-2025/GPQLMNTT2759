<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class CheckMailConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check mail configuration settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Checking Mail Configuration...');
        $this->newLine();

        $mailer = config('mail.default');
        $this->line("Default Mailer: <fg=cyan>{$mailer}</>");
        $this->newLine();

        if ($mailer === 'smtp') {
            $this->info('SMTP Configuration:');
            $this->line("  Host: <fg=cyan>" . config('mail.mailers.smtp.host') . "</>");
            $this->line("  Port: <fg=cyan>" . config('mail.mailers.smtp.port') . "</>");
            $this->line("  Encryption: <fg=cyan>" . (config('mail.mailers.smtp.encryption') ?? 'none') . "</>");
            $this->line("  Username: <fg=cyan>" . config('mail.mailers.smtp.username') . "</>");

            $password = config('mail.mailers.smtp.password');
            if ($password) {
                $passwordLength = strlen($password);
                $this->line("  Password: <fg=" . ($passwordLength === 16 ? 'green' : 'yellow') . ">" .
                    str_repeat('*', min($passwordLength, 16)) . " (Length: {$passwordLength})</>");

                if ($passwordLength !== 16) {
                    $this->newLine();
                    $this->warn('⚠️  Warning: Gmail application-specific passwords are exactly 16 characters.');
                    $this->warn('   If you\'re using Gmail with 2FA, make sure you\'re using an app-specific password.');
                }
            } else {
                $this->line("  Password: <fg=red>Not set</>");
            }

            $this->newLine();
            $this->info('From Address Configuration:');
            $this->line("  Address: <fg=cyan>" . config('mail.from.address') . "</>");
            $this->line("  Name: <fg=cyan>" . config('mail.from.name') . "</>");
        } else {
            $this->line("Current mailer is set to: <fg=yellow>{$mailer}</>");
            $this->warn('To use Gmail SMTP, set MAIL_MAILER=smtp in your .env file');
        }

        $this->newLine();
        $this->line('💡 Tip: Run "php artisan config:clear" after updating .env file');

        return 0;
    }
}
