<?php

namespace App\ClientHelper;

use App\Models\User;
use Exception;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Support\Facades\File;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Eddsa;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\UnixTimestampDates;
use phpseclib3\Crypt\EC;

class Token 
{
    private readonly Configuration $configuration;

    public function __construct(private readonly string $kid, string $privateKeyPath)
    {
        if (! File::exists($privateKeyPath)) {
            throw new Exception("Cannot find a key with path: {$privateKeyPath}");
        }
        // Load PEM file and constrcut PKSC8
        $ec = EC::load(file_get_contents($privateKeyPath));

        // Get private key bytes, should be 64 bytes long
        $privateKeyBytes = $ec->withPassword()->toString('libsodium');

        // Create key that understandable to Lcobucci\JWT
        $privateKey = InMemory::plainText($privateKeyBytes);

        $this->configuration = Configuration::forAsymmetricSigner(
            new Eddsa(),
            $privateKey,
            $privateKey,
        );
    }

    public function create(User $user): string {
        $now = new DateTimeImmutable();

        return $this
            ->configuration->builder(new UnixTimestampDates)
            ->issuedAt($now)
            ->withClaim('uid', (string) $user->id)
            ->withHeader('kid', $this->kid)
            ->getToken($this->configuration->signer(), $this->configuration->signingKey())
            ->toString();
    }
}