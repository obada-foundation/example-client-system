<?php

declare(strict_types=1);

namespace Tests;

use Obada\Exceptions\PropertyValidationException;
use Obada\Properties\Manufacturer;
use Obada\Properties\ObitId;
use Obada\Properties\PartNumber;
use Obada\Properties\SerialNumberHash;
use PHPUnit\Framework\TestCase;
use Throwable;

class ObitIdTest extends TestCase {
	public function testItCreatesObitIdFromFactoryMethod() {
		$obitId = ObitId::make([
			'serial_number_hash' => hash('sha256', "serial_number"),
			'manufacturer'       => 'manufacturer',
			'part_number'        => 'part number'
		]);

		$this->assertInstanceOf(ObitId::class, $obitId);
	}

	public function testItReturnsCorrectUsn(): void {
		$serialHash = hash('sha256', "serial_number");

		$obitId = new ObitId(
			new SerialNumberHash($serialHash),
			new Manufacturer('manufacturer'),
			new PartNumber('part number')
		);

		$this->assertEquals(
			'2y5zjyCj',
			$obitId->toUsn()
		);
	}

	public function testItReturnsCorrectDid(): void {
		$serialHash = hash('sha256', "serial_number");

		$obitId = new ObitId(
			new SerialNumberHash($serialHash),
			new Manufacturer('manufacturer'),
			new PartNumber('part number')
		);

		$this->assertEquals(
			'did:obada:bb00c8da8424d0af25cbef87968f3784bc829671ff208c5dc9505ab2976a369f',
			$obitId->toDid()
		);
	}
}