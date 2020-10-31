<?php

declare(strict_types=1);

namespace Tests\Mappers\Output\Api;

use Obada\Obit;
use Obada\Properties\Metadata\Key;
use Obada\Properties\Metadata\Record;
use Obada\Properties\Metadata\Value;
use Obada\Properties\MetadataCollection;
use PHPUnit\Framework\TestCase;
use Obada\Mappers\Output\Api\ObitMapper;

class ObitMapperTest extends TestCase {
	public function testItDoesMappingFromObitToApiObit() {
		$serialNumberHash = hash('sha256', 'SN123456');
		$manufacturer     = 'Sony';
		$partNumber       = 'PN123456';
		$ownerDid         = 'did:obada:owner:123456';
		$modifiedAt       = new \DateTime('now');
		$metadata         = [['key' => 'color', 'value' => 'red']];

		$obit = Obit::make([
			'manufacturer'       => $manufacturer,
			'serial_number_hash' => $serialNumberHash,
			'part_number'        => $partNumber,
			'owner_did'          => $ownerDid,
			'modified_at'        => $modifiedAt,
			'metadata'           => $metadata
		]);

		$apiObit = (new ObitMapper)->map($obit);

		$this->assertEquals($obit->getObitId()->toHash(), $apiObit->getObitDid());
		// TODO: complete test and check all mappings
	}
}