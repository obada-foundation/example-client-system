<?php

declare(strict_types=1);

namespace Tests;

use Obada\Obit;
use Obada\Properties\DocumentsCollection;
use Obada\Properties\Manufacturer;
use Obada\Properties\MetadataCollection;
use Obada\Properties\ObitId;
use Obada\Properties\PartNumber;
use Obada\Properties\SerialNumberHash;
use Obada\Properties\StructuredDataCollection;
use PHPUnit\Framework\TestCase;

class ObitTest extends TestCase {
	public function testItCreatesRootHash(): void {
		$serialNumberHash = hash('sha256', 'SN123456');
		$manufacturer     = 'Sony';
		$partNumber       = 'PN123456';
		$ownerDid         = 'did:obada:owner:123456';
		$modifiedAt       = new \DateTime('now');

		$obitId = new ObitId(
			new SerialNumberHash($serialNumberHash),
			new Manufacturer($manufacturer),
			new PartNumber($partNumber)
		);

		$obit = Obit::make([
			'manufacturer'       => $manufacturer,
			'serial_number_hash' => $serialNumberHash,
			'part_number'        => $partNumber,
			'owner_did'          => $ownerDid,
			'modified_at'        => $modifiedAt
		]);

		$expectedHash = hash('sha256', dechex(
			(new DocumentsCollection)->toHash()->toDecimal() +
			(new StructuredDataCollection)->toHash()->toDecimal() +
			(new MetadataCollection)->toHash()->toDecimal() +
			$obitId->toHash()->toDecimal() +
			hexdec(substr(hash('sha256', $serialNumberHash), 0, 8)) +
			hexdec(substr(hash('sha256', $manufacturer), 0, 8)) +
			hexdec(substr(hash('sha256', $partNumber), 0, 8)) +
			hexdec(substr(hash('sha256', $ownerDid), 0, 8)) +
			hexdec(substr(hash('sha256', (string) $modifiedAt->getTimestamp()), 0, 8)) +
			hexdec(substr(hash('sha256', ''), 0, 8)) + // Obit status
			hexdec(substr(hash('sha256', ''), 0, 8)) // Obd status
		));

		$this->assertEquals($expectedHash, (string) $obit->rootHash());
	}
}