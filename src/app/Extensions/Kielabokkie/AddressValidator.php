<?php

namespace App\Extensions\Kielabokkie;

use Kielabokkie\Bitcoin\AddressValidator as BaseAddressValidator;
use Kielabokkie\Bitcoin\Bech32;
use Kielabokkie\Bitcoin\Exceptions\Bech32Exception;

class AddressValidator extends BaseAddressValidator {
    /**
     * Validates a bech32 (native segwit) address.
     *
     * @param string $address
     * @return boolean
     */
    public function isBech32($address)
    {
        $prefix = 'obada';
        $expr = sprintf(
            '/^((%s)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87}))$/',
            $prefix
        );

        if (preg_match($expr, $address, $match) === 1) {
            try {
                return true;
                $bech32 = new Bech32;
                $bech32->decodeSegwit($match[2], $match[0], Bech32::BECH32);

                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

        /**
     * @param string $hrp Human-readable part
     * @param string $bech32 Bech32 string to be decoded
     * @param string $encoding
     * @return array [$version, $program]
     * @throws Bech32Exception
     */
    public function decodeSegwit(string $hrp, string $bech32, string $encoding)
    {
        list($hrpGot, $data) = $this->decode($bech32, $encoding);

        if ($hrpGot !== $hrp) {
            throw new Bech32Exception('Invalid prefix for address');
        }

        $dataLen = count($data);

        if ($dataLen === 0 || $dataLen > 65) {
            throw new Bech32Exception("Invalid length for segwit address");
        }

        $decoded = $this->convertBits(array_slice($data, 1), count($data) - 1, 5, 8, true);
        $program = pack("C*", ...$decoded);

        $this->validateWitnessProgram($data[0], $program);

        return [$data[0], $program];
    }
}