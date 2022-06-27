<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ClientHelper\Token;
use App\Models\User;
use Obada\Api\NFTApi;
use Obada\ClientHelper\SendNFTRequest;

class SendNFT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client-helper:nft:send {userId} {usn} {receiver}';

    protected $description = 'Display a balance of account by given userId';

    public function handle()
    {
        $userId = $this->argument('userId');
        $user = User::findOrFail($userId);

        $tokenCreator = app(Token::class);
        $token = $tokenCreator->create($user);

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $req = (new SendNFTRequest)
            ->setReceiver($this->argument('receiver'));

        $this->info($api->send($this->argument('usn'), $req));
    }
}