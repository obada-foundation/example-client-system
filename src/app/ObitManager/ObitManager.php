<?php
namespace App\ObitManager;
use App\Models\ClientObit;
use App\Models\Device;
use Tuupola\Base58;
use Obada\Exceptions\PropertyValidationException;
use Obada\Obit;
use Obada\Properties\ObitId;
use Obada\Mappers\Output\Api\ObitMapper;
use Log;

/**
 * Class ObitManager
 * @package App\ObitManager
 */
class ObitManager{

    /**
     * Returns the SHA256 hash of a string
     * @param string $str
     * @return string
     */
    public function GenerateHash(string $str) {
        $string = hash('sha256',$str);
        return $string;
    }

    /**
     * Returns an array containing serial_hash, usn, obit, usn_base58
     * @param string $manufacturer
     * @param string $part_number
     * @param string $serial_number
     * @return array|string[]
     */
    public function GenerateUSN(string $manufacturer, string $part_number, string $serial_number)
    {
        try {
            $serial_hash = $this->GenerateHash($serial_number);
            $obitId = ObitId::make([
                'serial_number_hash' => $serial_hash,
                'part_number'        => $part_number,
                'manufacturer'       => $manufacturer,
            ]);

            $usn = $obitId->toUsn();
            $obit_id = $obitId->toDid();
            $obit_hash = $obitId->toHash();

            /* Should this be returned from Obit API */
            $base58_encoder = new Base58(["characters" => Base58::BITCOIN]);

            return [
                'serial_hash'=>$serial_hash,
                'usn'=>$usn,
                'obit'=>$obit_id,
                'usn_base58'=> $base58_encoder->encode($obit_hash)
            ];

        } catch(PropertyValidationException $e) {
            Log::info($e->getMessage());
            return [
                'serial_hash'=>'invalid',
                'usn'=>'invalid',
                'obit'=>'invalid',
                'usn_base58'=>'invalid',
            ];
        } catch(Throwable $e) {
            return [
                'serial_hash'=>'exception',
                'usn'=>'exception',
                'obit'=>'exception',
                'usn_base58'=>'exception',
            ];
        }
    }

    /**
     * @param ClientObit $client_obit
     * @return \string|null
     * @throws \Exception
     */
    public function GenerateRootHash(ClientObit $client_obit) {

        try {
            /** @var $serial_hash - temporarily Client Obit stores unhashed serial number */
            $serial_hash = $this->GenerateHash($client_obit->serial_number_hash);
            $obit = Obit::make([
                'serial_number_hash' => $serial_hash,
                'part_number'        => $client_obit->part_number,
                'manufacturer'       => $client_obit->manufacturer,
                'owner_did'          => $client_obit->owner_did,
                'obd_did'            => $client_obit->obd_did,
                'obit_status'        => $client_obit->obit_status,
                'modified_at'        => new \DateTime($client_obit->device?$client_obit->device->updated_at:$client_obit->updated_at),
                'metadata'           => $client_obit->getMetadataRecords(),
                'structured_data'    => $client_obit->getStructuredDataRecords(),
                'documents'          => $client_obit->getDocumentRecords()
            ]);

            return (string)$obit->rootHash();

        } catch(PropertyValidationException $e) {
            Log::info($e->getMessage());
            return null;

        } catch(Throwable | Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }

    /**
     * @param Device $device
     * @return string|null
     * @throws \Exception
     */
    public function GenerateDeviceRootHash(Device $device) {

        try {
            $serial_hash = $this->GenerateHash($device->serial_number);
            $obit = Obit::make([
                'serial_number_hash' => $serial_hash,
                'part_number'        => $device->part_number,
                'manufacturer'       => $device->manufacturer,
                'owner_did'          => $device->owner,
                'obd_did'            => '',
                'obit_status'        => $device->status,
                'modified_at'        => new \DateTime($device->updated_at),
                'metadata'           => $device->getMetadataRecords(),
                'structured_data'    => $device->getStructuredDataRecords(),
                'documents'          => $device->getDocumentsRecords()
            ]);

            return (string)$obit->rootHash();

        } catch(PropertyValidationException $e) {
            Log::info($e->getMessage());
            return null;

        } catch(Throwable $e) {
            Log::info($e->getMessage());
            return null;
        }

    }

    /**
     * @param ClientObit $client_obit
     * @return mixed|\Obada\Entities\Obit|null
     * @throws \Exception
     */
    public function GetMappedObit(ClientObit $client_obit) {

        try {
            $serial_hash = $this->GenerateHash($client_obit->serial_number_hash);
            $obit = Obit::make([
                'serial_number_hash' => $serial_hash,
                'part_number'        => $client_obit->part_number,
                'manufacturer'       => $client_obit->manufacturer,
                'owner_did'          => $client_obit->owner_did,
                'obd_did'            => $client_obit->obd_did,
                'obit_status'        => $client_obit->obit_status,
                'modified_at'        => new \DateTime($client_obit->device?$client_obit->device->updated_at:$client_obit->updated_at),
                'metadata'           => $client_obit->getMetadataRecords(),
                'structured_data'    => $client_obit->getStructuredDataRecords(),
                'documents'          => $client_obit->getDocumentRecords()
            ]);

            return (new ObitMapper)->map($obit);

        } catch(PropertyValidationException $e) {
            Log::info($e->getMessage());
            return null;

        } catch(Throwable | Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }

}
