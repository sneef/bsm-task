<?php

namespace App\Console\Commands;

use App\Models\Account;
use Illuminate\Console\Command;

class createAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-account
                            {host : The name of the user}
                            {port : The email for access}
                            {encryption : Type of encryption}
                            {username : Your Email}
                            {password : Your Password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->argument('host');
        $port = $this->argument('port');
        $encryption = $this->argument('encryption');
        $username = $this->argument('username');
        $password = $this->argument('password');

        $account = Account::create([
            'host' => $host,
            'port' => $port,
            'encryption' => $encryption,
            'username' => $username,
            'password' => $password
        ]);

        if ($account) {
            $this->info("Account successfully created with ID: #{$account->id}");
        } else {
            $this->info("Account creating failed");
        }
    }
}
