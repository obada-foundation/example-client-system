<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ClientHelper\Token;
use App\Models\User;
use Obada\Api\AccountsApi;

class AccountBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client-helper:account:balance {userId}';

    protected $description = 'Display a balance of account by given userId';

    public function handle()
    {
        $userId = $this->argument('userId');
        $user = User::findOrFail($userId);

        $tokenCreator = app(Token::class);

        $token = $tokenCreator->create($user);

        $api = app(AccountsApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $this->info($api->balance());
    }
}