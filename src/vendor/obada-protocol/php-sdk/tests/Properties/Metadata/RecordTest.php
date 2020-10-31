<?php

declare(strict_types=1);

namespace Tests\Metadata;

use Obada\Exceptions\PropertyValidationException;
use Obada\Properties\Metadata\Key;
use Obada\Properties\Metadata\Record;
use Obada\Properties\Metadata\Value;
use PHPUnit\Framework\TestCase;
use Throwable;

class RecordTest extends TestCase {

	public function testItCreatesMetadataKeyProperty(): void {
		$key   = new Key('color');
		$value = new Value('red');

		$record = new Record($key, $value);

		$this->assertEquals($key, $record->getKey());
		$this->assertEquals($value, $record->getValue());
	}
}