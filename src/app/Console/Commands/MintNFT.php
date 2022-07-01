<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ClientHelper\Token;
use App\Models\User;
use Obada\Api\NFTApi;
use Obada\ClientHelper\SendNFTRequest;

class MintNFT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client-helper:nft:mint {userId} {usn}';

    protected $description = 'Minting the NFT';

    public function handle()
    {
        $user = User::findOrFail($this->argument('userId'));

        $tokenCreator = app(Token::class);
        $token = $tokenCreator->create($user);

        $api = app(NFTApi::class);
        $api->getConfig()
            ->setAccessToken($token);

        $this->info($api->mint($this->argument('usn')));
    }
}