<?php

declare(strict_types=1);

namespace Tests\Properties;

use Obada\Properties\Metadata\Key;
use Obada\Properties\Metadata\Record;
use Obada\Properties\Metadata\Value;
use Obada\Properties\MetadataCollection;
use PHPUnit\Framework\TestCase;

class MetadataCollectionTest extends TestCase {
	public function testItCreatesMetadataCollection(): void {
		$collection = new MetadataCollection(new Record(new Key("color"), new Value("red")));

		$this->assertCount(1, $collection);

		$collection->add(new Record(new Key("type"), new Value("phone")));

		$collection->toHash();

		$this->assertCount(2, $collection);
	}
}