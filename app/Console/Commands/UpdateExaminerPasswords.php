<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Examiner;
use Illuminate\Support\Facades\Hash;

class UpdateExaminerPasswords extends Command
{
    protected $signature = 'examiners:update-passwords';

    protected $description = 'Update examiners without passwords and set a default password.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Define a default password (you can later ask them to change it)
        $defaultPassword = 'password';

        // Fetch all examiners where password is null or empty
        $examiners = Examiner::whereNull('password')->orWhere('password', '')->get();

        foreach ($examiners as $examiner) {
            $examiner->password = Hash::make($defaultPassword); // Hash the default password
            $examiner->save();

            $this->info('Updated password for examiner: ' . $examiner->name);
        }

        $this->info('Passwords updated successfully.');
    }
}
