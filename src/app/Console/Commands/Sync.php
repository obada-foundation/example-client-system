<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ClientHelper\Token;
use App\Models\User;
use App\Models\Device;
use App\Models\Document;
use Obada\Api\AccountsApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\DeviceImported;

use Throwable;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    protected $description = 'Send NFTs with client helper';

    public function handle()
    { 
        $users = User::all();

        $users->each(function (User $user) {
            try {
                $tokenCreator = app(Token::class);

                $token = $tokenCreator->create($user);                

                $accApi = app(AccountsApi::class);
                $accApi->getConfig()
                    ->setAccessToken($token);

                $accounts = $accApi->accounts();

                $allAccounts = array_merge($accounts->getHdAccounts(), $accounts->getImportedAccounts());

                foreach ($allAccounts as $account) {
                    $nfts = json_decode(
                        file_get_contents('http://node.alpha.obada.io:1317/obada-foundation/fullcore/nfts/' . $account->getAddress()), 
                        true
                    );

                    foreach ($nfts['NFT'] as $nft) {
                        $device = Device::byUsn($nft['data']['usn'])->first();

                        if (! $device) {
                            $documents = $nft['data']['documents'];

                            $assetIdentifierDoc = collect($documents)
                                ->filter(fn ($document) => $document['name'] === 'physicalAssetIdentifiers')
                                ->first();

                            if (! $assetIdentifierDoc) {
                                    continue;
                            }

                            $cidParts = explode('://', $assetIdentifierDoc['uri']);
                            $cid = $cidParts[1];

                            $assetIdentifierDocContent = json_decode(
                                file_get_contents(config('ipfs.gateway') . $cid), 
                                true
                            );

                            DB::transaction(function () use ($user, $nft, $assetIdentifierDocContent, $documents, $account) {
                                $device = Device::create([
                                    'user_id'       => $user->id,
                                    'usn'           => $nft['data']['usn'],
                                    'manufacturer'  => $assetIdentifierDocContent['manufacturer'],
                                    'part_number'   => $assetIdentifierDocContent['part_number'],
                                    'serial_number' => $assetIdentifierDocContent['serial_number'],
                                    'obit_did'      => $nft['id'],
                                    'obit_checksum' => $nft['data']['checksum'],
                                    'address'       => $account->getAddress(),
                                ]);

                                foreach ($documents as $document) {
                                    Document::create([
                                        'device_id' => $device->id,
                                        'name'      => $document['name'],
                                        'data_hash' => $document['hash'],
                                        'path'      => $document['uri']
                                    ]);
                                }

                                DeviceImported::dispatch($device, $user);

                                $this->info(sprintf("Obit with USN %s was imported", $nft['data']['usn']));
                            });
                        }
                    }
                }
            } catch (Throwable $t) {
                report($t);

                $this->error($t->getMessage());
                $this->error($t->getTraceAsString());
            }
        });

        sleep(60);
    }
}