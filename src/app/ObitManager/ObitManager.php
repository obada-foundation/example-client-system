<?php
namespace App\ObitManager;
use Tuupola\Base58;

class ObitManager{

    public function GenerateHash($data) {
        $string = hash('sha256',$data);
        return $string;
    }

    public function GenerateObitID($serial_number) {
        $serial_hash = $this->GenerateHash($serial_number);
        $obit_id = $this->GenerateHash($serial_hash);
        return $obit_id;
    }

    public function GenerateObit($manufacturer, $part_number, $serial_number)
    {
        $serial_hash = $this->GenerateHash($serial_number);
        $obit = $this->GenerateHash($manufacturer.$part_number.$serial_hash);
        return [
            'obit'=>$obit,
            'serial_hash'=>$serial_hash
        ];
    }

    public function GenerateUSN($manufacturer, $part_number, $serial_number)
    {

        $obit = $this->GenerateObit($manufacturer,$part_number,$serial_number);
        $base58_encoder = new Base58(["characters" => Base58::BITCOIN]);
        $usn_base58 = $base58_encoder->encode($obit['obit']);
        $usn = substr($usn_base58, 0, 8);
        return [
            'serial_hash'=>$obit['serial_hash'],
            'usn'=>$usn,
            'obit'=>$obit['obit'],
            'usn_base58'=>$usn_base58
        ];
    }

}
