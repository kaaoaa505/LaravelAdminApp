<?php

namespace App\Console\Commands;

use App\Models\User;
use Auth;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class TokenCommand extends Command
{
    protected $signature = 'token:generate {id}';

    public function handle(): void
    {
        $id = $this->argument('id');

        $user = User::find($id);

        Auth::setUser($user);

        $console = new ConsoleOutput();
        $console->writeln($user->createToken('admin')->accessToken);

    }
}
